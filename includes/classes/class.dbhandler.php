<?php

/**
 * @package World of Warcraft Armory
 * @version Release 4.50
 * @revision 457
 * @copyright (c) 2009-2011 Shadez
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
 **/

if(!defined('__ARMORY__')) {
    die('Direct access to this file not allowed!');
}

/** Database Query Types **/
define('SINGLE_CELL',   0x01);
define('SINGLE_ROW',    0x02);
define('MULTIPLY_ROW',  0x03);
define('SQL_QUERY',     0x04);
define('OBJECT_QUERY',  0x05);
define('SQL_RAW_QUERY', 0x06);

Class ArmoryDatabaseHandler {
    private $dbLink = false;
    private $connectionLink = false;
    private $databaseInfo = array();
    private $connected = false;
    
    /** Queries counter **/
    private $queryCount = 0;
    private $queryTimeGeneration = 0.0;
    private $armory_prefix = null;
    
    /** Error messages **/
    private $errmsg = null;
    private $errno = 0;
    private $server_version = null;
    private $disableNextError = false;
    
    /**
     * Connect to DB
     * @category Armory Database Handler
     * @access   public
     * @param    string $host
     * @param    string $user
     * @param    string $password
     * @param    string $dbName
     * @param    string $charset = null
     * @param    string $prefix = null
     * @return   bool
     **/
    public function ArmoryDatabaseHandler($host, $user, $password, $dbName, $charset = null, $prefix = null) {
        $this->connectionLink = @mysql_connect($host, $user, $password, true);
        if(!$this->connectionLink) {
            $this->errmsg = @mysql_error($this->connectionLink);
            $this->errno = @mysql_errno($this->connectionLink);
            Armory::Log()->writeError('%s : unable to connect to MySQL Server (host: "%s", dbName: "%s"). Error: %s. Check your configs.', __METHOD__, $host, $dbName, $this->errmsg ? $this->errmsg : 'none');
            return false;
        }
        $this->dbLink = @mysql_select_db($dbName, $this->connectionLink);
        if(!$this->dbLink) {
            Armory::Log()->writeError('%s : unable to switch to database "%s"!', __METHOD__, $dbName);
            return false;
        }
        if($charset == null) {
            $this->query("SET NAMES UTF8");
        }
        else {
            $this->query("SET NAMES %s", $charset);
        }
        $this->databaseInfo = array(
            'host'     => $host,
            'user'     => $user,
            'password' => $password,
            'name'     => $dbName,
            'charset'  => ($charset == null) ? 'UTF8' : $charset,
        );
        $this->armory_prefix = $prefix;
        $this->server_version = $this->selectCell("SELECT VERSION()");
        $this->connected = true;
        return true;
    }
    
    /**
     * Returns current database info
     * @category Armory Database Handler
     * @access   public
     * @param    string $info
     * @return   mixed
     **/
    public function GetDatabaseInfo($info) {
        return (isset($this->databaseInfo[$info])) ? $this->databaseInfo[$info] : false;
    }
    
    /**
     * Tests conection link
     * @category Armory Database Handler
     * @access   public
     * @return   bool
     **/
    public function TestLink() {
        return $this->connected;
    }
    
    /**
     * Execute SQL query
     * @category Armory Database Handler
     * @access   private
     * @param    string $safe_sql
     * @param    int $queryType
     * @return   mixed
     **/
    private function _query($safe_sql, $queryType) {
        // Execute query and calculate execution time
        $make_array = array();
        $query_start = microtime(true);
        $this->queryCount++;
        $performed_query = @mysql_query($safe_sql, $this->connectionLink);
        $this->errmsg = @mysql_error($this->connectionLink);
        $this->errno = @mysql_errno($this->connectionLink);
        if($performed_query == false) {
            if(!$this->disableNextError) {
                Armory::Log()->writeLog('%s : unable to execute SQL query (%s). MySQL error: %s', __METHOD__, $safe_sql, $this->errmsg ? sprintf('"%s" (Error #%d)', $this->errmsg, $this->errno) : 'none');
            }
            if($this->disableNextError) {
                $this->disableNextError = false;
            }
            return false;
        }
        $result = false;
        switch($queryType) {
            case SINGLE_CELL:
                $result = @mysql_result($performed_query, 0);
                break;
            case SINGLE_ROW:
                $result = @mysql_fetch_array($performed_query);
                if(is_array($result)) {
                    foreach($result as $rKey => $rValue) {
                        if(is_string($rKey)) {
                            $make_array[$rKey] = $rValue;
                        }
                    }
                    $result = $make_array;
                }
                break;
            case MULTIPLY_ROW:
                $result = array();
                while($_result = @mysql_fetch_array($performed_query)) {
                    if(is_array($_result)) {
                        foreach($_result as $rKey => $rValue) {
                            if(is_string($rKey)) {
                                $make_array[$rKey] = $rValue;
                            }
                        }
                        $result[] = $make_array;
                    }
                    else {
                        $result[] = $_result;
                    }
                }
                break;
            case OBJECT_QUERY:
                $result = array();
                while($_result = @mysql_fetch_object($performed_query)) {
                    $result[] = $_result;
                }
                break;
            case SQL_QUERY:
                $result = true;
                break;
            default:
                $result = false;
                break;
        }
        $query_end = microtime(true);
        $queryTime = round($query_end - $query_start, 4);
        //Armory::Log()->writeSql('[%s ms]: %s', $queryTime, $safe_sql);
        $this->queryTimeGeneration += $queryTime;
        return $result;
    }
    
    private function _prepareQuery($funcArgs, $numArgs, $query_type) {
        // funcArgs[0] - SQL query text (with placeholders)
        if($query_type != SQL_RAW_QUERY) {
            for($i = 1; $i < $numArgs; $i++) {
                if(is_string($funcArgs[$i])) {
                    $funcArgs[$i] = addslashes($funcArgs[$i]);
                }
                if(is_array($funcArgs[$i])) {
                    $funcArgs[$i] = $this->ConvertArray($funcArgs[$i]);
                }
            }
        }
        $safe_sql = call_user_func_array('sprintf', $funcArgs);
        if(preg_match('/ARMORYDBPREFIX/', $safe_sql)) {
            if($this->armory_prefix == null) {
                Armory::Log()->writeError('%s : fatal error: armory database prefix is not defined, unable to execute SQL query (%s)!', __METHOD__, $safe_sql);
                return false;
            }
            $safe_sql = str_replace('ARMORYDBPREFIX', $this->armory_prefix, $safe_sql);
        }
        return $this->_query($safe_sql, $query_type);
    }
    
    public function selectCell($query) {
        $funcArgs = func_get_args();
        $numArgs = func_num_args();
        return $this->_prepareQuery($funcArgs, $numArgs, SINGLE_CELL);
    }
    
    public function selectRow($query) {
        $funcArgs = func_get_args();
        $numArgs = func_num_args();
        return $this->_prepareQuery($funcArgs, $numArgs, SINGLE_ROW);
    }
    
    public function select($query) {
        $funcArgs = func_get_args();
        $numArgs = func_num_args();
        return $this->_prepareQuery($funcArgs, $numArgs, MULTIPLY_ROW);
    }
    
    public function query($query) {
        $funcArgs = func_get_args();
        $numArgs = func_num_args();
        return $this->_prepareQuery($funcArgs, $numArgs, SQL_QUERY);
    }
    
    public function RawQuery($query) {
        $funcArgs = func_get_args();
        $numArgs = func_num_args();
        return $this->_prepareQuery($funcArgs, $numArgs, SQL_RAW_QUERY);
    }
    
    public function selectObject($query) {
        $funcArgs = func_get_args();
        $numArgs = func_num_args();
        return $this->_prepareQuery($funcArgs, $numArgs, OBJECT_QUERY);
    }
    
    /**
     * Converts array values to string format (for IN(%s) cases)
     * @category Armory Database Handler
     * @access   private
     * @param    array $source
     * @return   string
     **/
    private function ConvertArray($source) {
        if(!is_array($source)) {
            Armory::Log()->writeError('%s : source must have array type!', __METHOD__);
            return null;
        }
        $returnString = null;
        $count = count($source);
        for($i = 0; $i < $count; $i++) {
            if(!isset($source[$i])) {
                continue;
            }
            if($i) {
                $returnString .= ", '" . addslashes($source[$i]) . "'";
            }
            else {
                $returnString .= "'" . addslashes($source[$i]) . "'";
            }
        }
        return $returnString;
    }
    
    public function __destruct() {
        @mysql_close($this->connectionLink);
        $this->DropLastErrors();
        $this->DropCounters();
        return true;
    }
    
    public function GetServerVersion() {
        return $this->server_version;
    }
    
    public function GetLastErrorMessage() {
        return $this->errmsg;
    }
    
    public function GetLastErrorNum() {
        return $this->errno;
    }
    
    private function DropLastErrors() {
        $this->DropLastErrorMessage();
        $this->DropLastErrorNumber();
    }
    
    public function DropLastErrorMessage() {
        $this->errmsg = null;
    }
    
    public function DropLastErrorNumber() {
        $this->errno = 0;
    }
    
    private function DropCounters() {
        $this->queryCount = 0;
        $this->queryTimeGeneration = 0.0;
    }
    
    public function GetStatistics() {
        return array('queryCount' => $this->queryCount, 'queryTimeGeneration' => $this->queryTimeGeneration);
    }
    
    /**
     * Allows to skip next MySQL error (do not add it to debug log) - spam preventing.
     * @category Armory Database Handler
     * @access   public
     * @return   bool
     **/
    public function SkipNextError() {
        $this->disableNextError = true;
        return true;
    }
}

?>