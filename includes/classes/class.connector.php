<?php

/**
 * @package World of Warcraft Armory
 * @version Release Candidate 1
 * @revision 348
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
    public $aDB = null;
    
    /** Character database hanlder **/
    public $cDB = null;
    
    /** Realm/accounts database handler **/
    public $rDB = null;
    
    /** Mangos/world database handler **/
    public $wDB = null;
    
    /** MySQL connection configs **/
    public $mysqlconfig = array();
    
    /** Armory configs **/
    public $armoryconfig = array();
    
    /** Current armory locale (ru_ru or en_gb) **/
    public $_locale = null;
    
    /** Locale (0 - en_gb, 2 - fr_fr, 3 - de_de, etc.)**/
    public $_loc = null;
    
    /** Links for multirealm info **/
    public $realmData;
    public $connectionData;
    public $currentRealmInfo;
    
    /** Debug handler **/
    private $debugHandler;
    
    /**
     * Initialize database handlers, debug handler, sets up sql/site configs
     * @category Core class
     * @access   public
     * @return   bool
     **/
    public function Connector() {
        if(!@include('configuration.php')) {
            die('<b>Error</b>: unable to load configuration file!');
        }
        if(!@require_once('class.dbhandler.php')) {
            die('<b>Error</b>: unable to load database class!');
        }
        if(!@require_once('class.debug.php')) {
            die('<b>Error</b>: unable to load debug class!');
        }
        $this->mysqlconfig  = $ArmoryConfig['mysql'];
        $this->armoryconfig = $ArmoryConfig['settings'];
        $this->debugHandler = new ArmoryDebug(array('useDebug' => $this->armoryconfig['useDebug'], 'logLevel' => $this->armoryconfig['logLevel']));
        $this->realmData    = $ArmoryConfig['multiRealm'];
        $this->aDB = new ArmoryDatabaseHandler($this->mysqlconfig['host_armory'], $this->mysqlconfig['user_armory'], $this->mysqlconfig['pass_armory'], $this->mysqlconfig['name_armory'], $this->mysqlconfig['charset_armory'], $this->Log(), $this->armoryconfig['db_prefix']);
        $this->rDB = new ArmoryDatabaseHandler($this->mysqlconfig['host_realmd'], $this->mysqlconfig['user_realmd'], $this->mysqlconfig['pass_realmd'], $this->mysqlconfig['name_realmd'], $this->mysqlconfig['charset_realmd'], $this->Log());
        if(isset($_GET['r'])) {
            $realmName = urldecode($_GET['r']);
            $realm_info = $this->aDB->selectRow("SELECT `id`, `version` FROM `ARMORYDBPREFIX_realm_data` WHERE `name`='%s'", $realmName);
            if(isset($this->realmData[$realm_info['id']])) {
                $this->connectionData = $this->realmData[$realm_info['id']];
                $this->cDB = new ArmoryDatabaseHandler($this->connectionData['host_characters'], $this->connectionData['user_characters'], $this->connectionData['pass_characters'], $this->connectionData['name_characters'], $this->connectionData['charset_characters'], $this->Log());
                $this->currentRealmInfo = array('name' => $this->connectionData['name'], 'id' => $realm_info['id'], 'type' => $this->connectionData['type'], 'connected' => true);
                if(isset($this->connectionData['name_world'])) {
                    $this->wDB = new ArmoryDatabaseHandler($this->connectionData['host_world'], $this->connectionData['user_world'], $this->connectionData['pass_world'], $this->connectionData['name_world'], $this->connectionData['charset_world'], $this->Log());
                }
            }
        }
        $realm_info = $this->realmData[1];
        if($this->cDB == null) {
            $this->cDB = new ArmoryDatabaseHandler($realm_info['host_characters'], $realm_info['user_characters'], $realm_info['pass_characters'], $realm_info['name_characters'], $realm_info['charset_characters'], $this->Log());
        }
        if($this->wDB == null) {
            $this->wDB = new ArmoryDatabaseHandler($realm_info['host_world'], $realm_info['user_world'], $realm_info['pass_world'], $realm_info['name_world'], $realm_info['charset_world'], $this->Log());
        }
        if(!$this->currentRealmInfo) {
            $this->currentRealmInfo = array('name' => $this->realmData[1]['name'], 'id' => 1, 'type' => $this->realmData[1]['type'], 'connected' => true);
        }
        if(!$this->connectionData) {
            $this->connectionData = $this->realmData[1];
        }
        if(isset($_SERVER['HTTP_ACCEPT_LANGUAGE'])) {
            $user_locale = strtolower(substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2));
            if($user_locale && $http_locale = self::IsAllowedLocale($user_locale)) {
                $this->_locale = (isset($_SESSION['armoryLocale'])) ? $_SESSION['armoryLocale'] : $http_locale;
            }
        }
        if(!$this->_locale) {
            $this->_locale = (isset($_SESSION['armoryLocale'])) ? $_SESSION['armoryLocale'] : $this->armoryconfig['defaultLocale'];
        }
        switch($this->_locale) {
            case 'en_gb':
            case 'en_us':
                $this->_loc = 0;
                break;
            case 'fr_fr':
                $this->_loc = 2;
                break;
            case 'de_de':
                $this->_loc = 3;
                break;
            case 'es_es':
                $this->_loc = 6;
                break;
            case 'es_mx':
                $this->_loc = 7;
                break;
            case 'ru_ru':
                $this->_loc = 8;
                break;
        }
    }
    
    /**
     * Checks browser language from HTTP_ACCEPT_LANGUAGE
     * @category Core class
     * @access   public
     * @return   mixed
     **/
    private function IsAllowedLocale($locale) {
        switch($locale) {
            case 'de':
                return 'de_de';
                break;
            case 'en':
                return 'en_gb';
                break;
            case 'es':
                return 'es_es';
                break;
            case 'fr':
                return 'fr_fr';
                break;
            case 'ru':
                return 'ru_ru';
                break;
            default:
                return false;
                break;
        }
    }
    
    /**
     * Returns debug log handler
     * @category Core class
     * @access   public
     * @return   object
     **/
    public function Log() {
        return $this->debugHandler;
    }
    
    /**
     * Returns current locale (en_gb/ru_ru/fr_fr, etc.)
     * @category Core class
     * @access   public
     * @return   string
     **/
    public function GetLocale() {
        if($this->_locale == null) {
            $this->Log()->writeLog('%s : locale not defined, return default locale', __METHOD__);
            return $this->armoryconfig['defaultLocale'];
        }
        if($this->_locale == 'en_us') {
            return 'en_gb'; // For DB compatibility
        }
        elseif($this->_locale == 'es_mx') {
            return 'es_es'; // For DB compatibility
        }
        return $this->_locale;
    }
    
    /**
     * Returns locale ID (0 for en_gb, etc.)
     * @category Core class
     * @access   public
     * @return   int
     **/
    public function GetLoc() {
        if($this->_loc == null) {
            return 0;
        }
        return $this->_loc;
    }
    
    /**
     * Sets locale
     * @category Core class
     * @access   public
     * @return   int
     **/
    public function SetLocale($locale, $locale_id) {
        $this->_locale = $locale;
        $this->_loc    = $locale_id;
    }
}
?>