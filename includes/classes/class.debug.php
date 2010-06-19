<?php

/**
 * @package World of Warcraft Armory
 * @version Release Candidate 1
 * @revision 250
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

Class ArmoryDebug {
    
    /**
     * Log config
     **/
    private $config;
    private $file = 'cache/_debug/tmp.dbg';
    
    /**
     * Initializes debugger
     **/
    public function ArmoryDebug($config, $file = false) {
        if($config['useDebug'] == false) {
            return;
        }
        $this->config = $config;
        if($file) {
            $this->file = $file;
        }
    }
    
    public function writeLog($logtext) {
        if($this->config['useDebug'] == false || $this->config['logLevel'] == 1) {
            return;
        }
        $args = func_get_args();
        $debug_log = self::AddStyle('debug');
        $debug_log .= call_user_func_array('sprintf', $args);
        $debug_log .= '<br />
';
        self::__writeFile($debug_log);
        return;
    }
    
    public function writeError($errorText) {
        if($this->config['useDebug'] == false) {
            return;
        }
        $args = func_get_args();
        $error_log = self::AddStyle('error');
        $error_log .= call_user_func_array('sprintf', $args);
        $error_log .= '<br />
';
        self::__writeFile($error_log);
        return;
    }
    
    public function writeSql($sqlText) {
        if($this->config['useDebug'] == false || $this->config['logLevel'] == 1) {
            return;
        }
        $args = func_get_args();
        $error_log = self::AddStyle('sql');
        $error_log .= call_user_func_array('sprintf', $args);
        $error_log .= '<br />
';
        self::__writeFile($error_log);
        return;
    }
    
    private function AddStyle($type) {
        if($this->config['useDebug'] == false) {
            return;
        }
        switch($type) {
            case 'debug':
                $log = sprintf('<strong>DEBUG</strong> [%s]: ', date('d-m-Y H:i:s'));
                break;
            case 'error':
                $log = sprintf('<strong>ERROR</strong> [%s]: ', date('d-m-Y H:i:s'));
                break;
            case 'sql':
                $log = sprintf('<strong>SQL</strong> [%s]: ', date('d-m-Y H:i:s'));
                break;
        }
        return $log;
    }
    
    private function __writeFile($data) {
        @file_put_contents($this->file, $data, FILE_APPEND);
    }
}
?>