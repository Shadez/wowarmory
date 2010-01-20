<?php

/**
 * @package World of Warcraft Armory
 * @version Release Candidate 1
 * @revision 50
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
    
    /** Character classes array (need to be dropped from here) **/
    public $classes;
    
    /** Character races array (need to be dropped from here) **/
    public $races;
    
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
        
        // Test connection
        if(!$this->aDB->selectCell("SELECT `id` FROM `classes` LIMIT 1")) {
            $this->databaseError('Can not execute query to armory database ("<i>%s</i>")!<br />Check you configuration.php for correct values.', $this->mysqlconfig['name_armory']);
        }
        if(!$this->cDB->selectCell("SELECT `guid` FROM `characters` LIMIT 1")) {
            $this->databaseError('Can not execute query to characters database ("<i>%s</i>")!<br />Check you configuration.php for correct values.', $this->mysqlconfig['name_characters']);
        }
        if(!$this->rDB->selectCell("SELECT `name` FROM `realmlist` LIMIT 1")) {
            $this->databaseError('Can not execute query to realmd database ("<i>%s</i>")!<br />Check you configuration.php for correct values.', $this->mysqlconfig['name_realmd']);
        }
        if(!$this->wDB->selectCell("SELECT `entry` FROM `item_template` LIMIT 1")) {
            $this->databaseError('Can not execute query to mangos database ("<i>%s</i>")!<br />Check you configuration.php for correct values.', $this->mysqlconfig['name_mangos']);
        }
        $this->aDB->query("SET NAMES ?", $this->mysqlconfig['charset_armory']);
        $this->cDB->query("SET NAMES ?", $this->mysqlconfig['charset_characters']);
        $this->rDB->query("SET NAMES ?", $this->mysqlconfig['charset_realmd']);
        $this->wDB->query("SET NAMES ?", $this->mysqlconfig['charset_mangos']);
        
        $this->tpl = new Smarty;
        
        /* Need to be removed from this file */
        $this->classes = array (
			'1'=>'Воин|Warrior',
			'2'=>'Паладин|Paladin',
			'3'=>'Охотник|Hunter',
			'4'=>'Разбойник|Rogue',
			'5'=>'Жрец|Priest',
			'6'=>'Рыцарь смерти|Death Knight',
			'7'=>'Шаман|Shaman',
			'8'=>'Маг|Mage',
            '9'=>'Чернокнижник|Warlock',
			'10'=>'unk|unk',
			'11'=>'Друид|Druid'
		);
		
        /* Need to be removed from this file */
		$this->races = array (
			'0'=>'none',
			'1'=>'Человек|Human',
			'2'=>'Орк|Orc',
			'3'=>'Дворф|Dwarf',
			'4'=>'Ночной эльф|Night elf',
			'5'=>'Нежить|Undead',
			'6'=>'Таурен|Tauren',
			'7'=>'Гном|Gnome',
			'8'=>'Тролль|Troll',
			'10'=>'Эльф крови|Blood elf',
			'11'=>'Дреней|Draenei'
        );
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
    
    /**
     * Shows database error
     * @category Main system functions
     * @example Connector::databaseError()
     * @return none
     **/
    public function databaseError() {
        $args = func_get_args();
        $tmpl =& $args[0];
        for ($i=$c=count($args)-1; $i<$c+20; $i++) {
            $args[$i+1] = ''; // if placeholder not defined
        }
        $errorInfo = '<title>Wowarmory :: Internal Server Error</title>';
        $errorInfo .= '<h2 align="center">Internal Server Error:</h2>';
        $errorInfo .= '<h3 align="center">'.call_user_func_array('sprintf', $args).'</h3>';
        die($errorInfo);
    }
}
?>