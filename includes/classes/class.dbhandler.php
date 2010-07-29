<?php

/**
 * @package World of Warcraft Armory
 * @version Release Candidate 1
 * @revision 332
 * @copyright (c) 2009-2010 Shadez
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

/* Database Query Types */
define('SINGLE_CELL',  0x01);
define('SINGLE_ROW',   0x02);
define('MULTIPLY_ROW', 0x03);
define('SQL_QUERY',    0x04);
define('OBJECT_QUERY', 0x05);

Class ArmoryDatabaseHandler {
    private $dbLink = false;
    private $connectionLink = false;
    
    /** Queries counter **/
    private $queryCount = 0;
    private $queryTimeGeneration = 0;
    private $logHandler;
    
    /**
     * Connect to DB
     * @param string host
     * @param string user
     * @param string password
     * @param string dbName
     * @param string charset
     * @return bool
     **/
    public function ArmoryDatabaseHandler($host, $user, $password, $dbName, $charset = false, $logHandler = null) {
        $this->connectionLink = @mysql_connect($host, $user, $password, true);
        $this->dbLink         = @mysql_select_db($dbName, $this->connectionLink);
        if($charset === false) {
            $this->query("SET NAMES UTF8");
        }
        else {
            $this->query("SET NAMES %s", $charset);
        }
        $this->logHandler = $logHandler;
        return true;
    }
    
    /**
     * Tests conection link
     * @return bool
     **/
    public function TestLink() {
        if($this->connectionLink == true) {
            return true;
        }
        return false;
    }
    
    /**
     * Execute SQL query
     * @param string $safe_sql
     * @param int $queryType
     * @return mixed
     **/
    private function _query($safe_sql, $queryType) {
        // Execute query and calculate execution time
        $make_array = array();
        $query_start = microtime(true);
        $perfomed_query = @mysql_query($safe_sql, $this->connectionLink);
        if($perfomed_query === false) {
            if($this->logHandler != null && is_object($this->logHandler)) {
                $this->logHandler->writeLog('%s : unable to execute SQL query (%s). MySQL error: %s', __METHOD__, $safe_sql, mysql_error() ? mysql_error() : 'none');
            }
            return false;
        }
        $result = false;
        switch($queryType) {
            case SINGLE_CELL:
                $result = @mysql_result($perfomed_query, 0);
                break;
            case SINGLE_ROW:
                $result = @mysql_fetch_array($perfomed_query);
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
                while($_result = @mysql_fetch_array($perfomed_query)) {
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
                while($_result = @mysql_fetch_object($perfomed_query)) {
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
        $this->queryCount++;
        $this->queryTimeGeneration += $queryTime;
        return $result;
    }
    
    private function _prepareQuery($funcArgs, $numArgs, $query_type) {
        // funcArgs[0] - SQL query text (with placeholders)
        for($i = 1; $i < $numArgs; $i++) {
            if(is_string($funcArgs[$i])) {
                $funcArgs[$i] = addslashes($funcArgs[$i]);
            }
            if(is_array($funcArgs[$i])) {
                $funcArgs[$i] = $this->ConvertArray($funcArgs[$i]);
            }
        }
        $safe_sql = call_user_func_array('sprintf', $funcArgs);
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
    
    public function selectObject($query) {
        $funcArgs = func_get_args();
        $numArgs = func_num_args();
        return $this->_prepareQuery($funcArgs, $numArgs, OBJECT_QUERY);
    }
    
    /**
     * Converts array values to string format (for IN(%s) cases)
     * @param array $source
     * @return string
     **/
    private function ConvertArray($source) {
        if(!is_array($source)) {
            $this->logHandler->writeError('%s : source must have array type!', __METHOD__);
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
                $returnString .="'" . addslashes($source[$i]) . "'";
            }
        }
        return $returnString;
    }
}

?>