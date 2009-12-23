<?php

/**
 * @package World of Warcraft Armory
 * @version Release Candidate 1
 * @revision 30
 * @copyright (c) 2009 Shadez  
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

Class sLog {
    private $fullLog;
    
    public function __construct() {
        $this->fullLog = '<b>ARMORY:</b> Log system initialized<br /><br />';
        return true;
    }
    
    public function __deconstruct() {
        $this->fullLog .= '<br /><b>ARMORY:</b> Log system finalized';
        return true;
    }
    
    public function error() {
        $args = func_get_args();
        $tmpl =& $args[0];
        for ($i=$c=count($args)-1; $i<$c+20; $i++) {
            $args[$i+1] = ''; // if placeholder not defined
        }
        $this->fullLog .= '<b><font color="red">ERROR: </font></b>'.call_user_func_array("sprintf", $args).'<br />';
    }
    
    public function debug() {
        $args = func_get_args();
        $tmpl =& $args[0];
        for ($i=$c=count($args)-1; $i<$c+20; $i++) {
            $args[$i+1] = ''; // if placeholder not defined
        }
        $this->fullLog .= '<b>DEBUG: </b>'.call_user_func_array("sprintf", $args).'<br />';
    }
    
    public function info() {
        $args = func_get_args();
        $tmpl =& $args[0];
        for ($i=$c=count($args)-1; $i<$c+20; $i++) {
            $args[$i+1] = ''; // if placeholder not defined
        }
        $this->fullLog .= '<b>ARMORY: </b>'.call_user_func_array("sprintf", $args).'<br />';
    }
    
    public function show() {
        echo $this->fullLog;
    }
}

?>