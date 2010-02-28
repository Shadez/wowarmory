<?php

/**
 * @package World of Warcraft Armory
 * @version Release Candidate 1
 * @revision 95
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

Class Connector {
    
    /** Armory database handler **/
    public $aDB;
    
    /** Character database hanlder **/
    public $cDB;
    
    /** Realm/accounts database handler **/
    public $rDB;
    
    /** Mangos/world database handler **/
    public $wDB;
    
    /** MySQL connection configs **/
    public $mysqlconfig;
    
    /** Armory configs **/
    public $armoryconfig;
    
    /** Template handler (Smarty class) **/
    public $tpl;
    
    /** Current armory locale (ru_ru or en_gb) **/
    public $_locale;
    
    /**
     * Initialize database & template handlers, sets up sql/site configs
     * @category Main system functions
     * @example Connector::__construct()
     * @return bool
     **/
    public function __construct() {
        include('configuration.php');
        require_once('libs/DbSimple/Generic.php');
        require_once('libs/Smarty-2.6.26/Smarty.class.php');
        
        $this->mysqlconfig = $ArmoryConfig['mysql'];
        $this->armoryconfig = $ArmoryConfig['settings'];
        
        $this->aDB = DbSimple_Generic::connect('mysql://'.$this->mysqlconfig['user_armory'].':'.$this->mysqlconfig['pass_armory'].'@'.$this->mysqlconfig['host_armory'].'/'.$this->mysqlconfig['name_armory']);
        $this->cDB = DbSimple_Generic::connect('mysql://'.$this->mysqlconfig['user_characters'].':'.$this->mysqlconfig['pass_characters'].'@'.$this->mysqlconfig['host_characters'].'/'.$this->mysqlconfig['name_characters']);
        $this->rDB = DbSimple_Generic::connect('mysql://'.$this->mysqlconfig['user_realmd'].':'.$this->mysqlconfig['pass_realmd'].'@'.$this->mysqlconfig['host_realmd'].'/'.$this->mysqlconfig['name_realmd']);
        $this->wDB = DbSimple_Generic::connect('mysql://'.$this->mysqlconfig['user_mangos'].':'.$this->mysqlconfig['pass_mangos'].'@'.$this->mysqlconfig['host_mangos'].'/'.$this->mysqlconfig['name_mangos']);

        $this->aDB->query("SET NAMES ?", $this->mysqlconfig['charset_armory']);
        $this->cDB->query("SET NAMES ?", $this->mysqlconfig['charset_characters']);
        $this->rDB->query("SET NAMES ?", $this->mysqlconfig['charset_realmd']);
        $this->wDB->query("SET NAMES ?", $this->mysqlconfig['charset_mangos']);
        
        $this->tpl = new Smarty;
        $this->_locale = (isset($_SESSION['armoryLocale'])) ? $_SESSION['armoryLocale'] : $armory->armoryconfig['defaultLocale'];
        return true;
    }
        
    /**
     * Shows error. If $Error == true, function will show black list with 'Error encountered' text.
     * @category Main system functions
     * @example Connector::ArmoryError('Error Title', 'Error Text', false)
     * @return none
     **/
    public function ArmoryError($title, $text, $Error=false) {
        if($Error == true) {
            $this->tpl->display('error_sheet.tpl');
            die();
        }
        $this->tpl->assign('errorTitle', $title);
        $this->tpl->assign('errorText', $text);
        $this->tpl->assign('addCssSheet', '@import "_css/int.css";');
        $this->tpl->display('overall_header.tpl');
        $this->tpl->display('overall_body_starter.tpl');
        $this->tpl->display('overall_menu_ru_ru.tpl');
        $this->tpl->display('error_page.tpl');
        $this->tpl->display('overall_footer.tpl');
        exit();
    }
}
?>