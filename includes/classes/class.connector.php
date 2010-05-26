<?php

/**
 * @package World of Warcraft Armory
 * @version Release Candidate 1
 * @revision 208
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
    
    /** Current armory locale (ru_ru or en_gb) **/
    public $_locale;
    
    /** Locale (0 - en_gb, 2 - fr_fr, 3 - de_de, etc.)**/
    public $_loc;
    
    /** Links for multirealm info **/
    public $realmData;    
    public $connectionData;
    public $currentRealmInfo;
    
    /** Debug handler **/
    private $debugHandler;        
    
    /**
     * Initialize database handlers, debug handler, sets up sql/site configs
     * @category Main system functions
     * @example Connector::Connector()
     * @return bool
     **/
    public function Connector() {
        if(!@include('configuration.php')) {
            die('<b>Error</b>: unable to load configuration file!');
        }
        if(!@require_once('libs/DbSimple/Generic.php')) {
            die('<b>Error</b>: unable to load database class!');
        }
        if(!@require_once('class.debug.php')) {
            die('<b>Error</b>: unable to load debug class!');
        }
        $this->mysqlconfig  = $ArmoryConfig['mysql'];
        $this->armoryconfig = $ArmoryConfig['settings'];
        $this->debugHandler = new ArmoryDebug(array('useDebug' => $this->armoryconfig['useDebug'], 'logLevel' => $this->armoryconfig['logLevel']));
        $this->realmData    = $ArmoryConfig['multiRealm'];
        $this->aDB = DbSimple_Generic::connect('mysql://'.$this->mysqlconfig['user_armory'].':'.$this->mysqlconfig['pass_armory'].'@'.$this->mysqlconfig['host_armory'].'/'.$this->mysqlconfig['name_armory']);
        $this->aDB->query("SET NAMES ?", $this->mysqlconfig['charset_armory']);
        $this->rDB = DbSimple_Generic::connect('mysql://'.$this->mysqlconfig['user_realmd'].':'.$this->mysqlconfig['pass_realmd'].'@'.$this->mysqlconfig['host_realmd'].'/'.$this->mysqlconfig['name_realmd']);
        if(isset($_GET['r'])) {
            $realmName = urldecode($_GET['r']);
            $realm_info = $this->aDB->selectRow("SELECT `id`, `version` FROM `armory_realm_data` WHERE `name`=?", $realmName);
            if(!$realm_info) {
                $this->cDB = DbSimple_Generic::connect('mysql://'.$this->mysqlconfig['user_characters'].':'.$this->mysqlconfig['pass_characters'].'@'.$this->mysqlconfig['host_characters'].'/'.$this->mysqlconfig['name_characters']);
                $this->wDB = DbSimple_Generic::connect('mysql://'.$this->mysqlconfig['user_mangos'].':'.$this->mysqlconfig['pass_mangos'].'@'.$this->mysqlconfig['host_mangos'].'/'.$this->mysqlconfig['name_mangos']);
                $this->cDB->query("SET NAMES ?", $this->mysqlconfig['charset_characters']);
                $this->wDB->query("SET NAMES ?", $this->mysqlconfig['charset_mangos']);
            }
            elseif(isset($this->realmData[$realm_info['id']])) {
                $this->connectionData = $this->realmData[$realm_info['id']];
                $this->cDB = DbSimple_Generic::connect('mysql://'.$this->connectionData['user_characters'].':'.$this->connectionData['pass_characters'].'@'.$this->connectionData['host_characters'].'/'.$this->connectionData['name_characters']);
                $this->cDB->query("SET NAMES ?", $this->connectionData['charset_characters']);
                $this->currentRealmInfo = array('name' => $this->connectionData['name'], 'id' => $realm_info['id'], 'version' => $realm_info['version'], 'type' => $this->connectionData['type'], 'connected' => true);
                if(isset($this->connectionData['name_mangos'])) {
                    $this->wDB = DbSimple_Generic::connect('mysql://'.$this->connectionData['user_mangos'].':'.$this->connectionData['pass_mangos'].'@'.$this->connectionData['host_mangos'].'/'.$this->connectionData['name_mangos']);
                    $this->wDB->query("SET NAMES ?", $this->connectionData['charset_mangos']);
                }
                else {
                    $this->wDB = DbSimple_Generic::connect('mysql://'.$this->mysqlconfig['user_mangos'].':'.$this->mysqlconfig['pass_mangos'].'@'.$this->mysqlconfig['host_mangos'].'/'.$this->mysqlconfig['name_mangos']);
                    $this->wDB->query("SET NAMES ?", $this->mysqlconfig['charset_mangos']);
                }
            }
            else {
                $this->cDB = DbSimple_Generic::connect('mysql://'.$this->mysqlconfig['user_characters'].':'.$this->mysqlconfig['pass_characters'].'@'.$this->mysqlconfig['host_characters'].'/'.$this->mysqlconfig['name_characters']);
                $this->wDB = DbSimple_Generic::connect('mysql://'.$this->mysqlconfig['user_mangos'].':'.$this->mysqlconfig['pass_mangos'].'@'.$this->mysqlconfig['host_mangos'].'/'.$this->mysqlconfig['name_mangos']);
                $this->cDB->query("SET NAMES ?", $this->mysqlconfig['charset_characters']);
                $this->wDB->query("SET NAMES ?", $this->mysqlconfig['charset_mangos']);
            }
        }
        else {
            $this->cDB = DbSimple_Generic::connect('mysql://'.$this->mysqlconfig['user_characters'].':'.$this->mysqlconfig['pass_characters'].'@'.$this->mysqlconfig['host_characters'].'/'.$this->mysqlconfig['name_characters']);
            $this->wDB = DbSimple_Generic::connect('mysql://'.$this->mysqlconfig['user_mangos'].':'.$this->mysqlconfig['pass_mangos'].'@'.$this->mysqlconfig['host_mangos'].'/'.$this->mysqlconfig['name_mangos']);
            $this->cDB->query("SET NAMES ?", $this->mysqlconfig['charset_characters']);
            $this->wDB->query("SET NAMES ?", $this->mysqlconfig['charset_mangos']);
        }
        if(!$this->currentRealmInfo) {
            $this->currentRealmInfo = array('name' => $this->realmData[1]['name'], 'id' => 1, 'version' => $this->armoryconfig['server_version'], 'type' => $this->realmData[1]['type'], 'connected' => true);
        }
        if(!$this->connectionData) {
            $this->connectionData = $this->realmData[1];
        }
        $this->rDB->query("SET NAMES ?", $this->mysqlconfig['charset_realmd']);
        $user_locale = strtolower(substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2));
        if($user_locale && $http_locale = self::IsAllowedLocale($user_locale)) {
            $this->_locale = (isset($_SESSION['armoryLocale'])) ? $_SESSION['armoryLocale'] : $http_locale;
        }
        else {
            $this->_locale = (isset($_SESSION['armoryLocale'])) ? $_SESSION['armoryLocale'] : $this->armoryconfig['defaultLocale'];
        }
        $this->_locale = (isset($_SESSION['armoryLocale'])) ? $_SESSION['armoryLocale'] : $this->armoryconfig['defaultLocale'];
        switch($this->_locale) {
            case 'en_gb':
            case 'en_us':
                $this->_loc = 0;
                break;
            /*
            case 'ko_kr':
                $this->_loc = 1;
                break;
            */
            case 'fr_fr':
                $this->_loc = 2;
                break;
            case 'de_de':
                $this->_loc = 3;
                break;
            /*
            case 'zh_cn':
                $this->_loc = 4; // China
                break;
            case 'zh_tw':
                $this->_loc = 5; // Taiwan
                break;
            */
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
     * @category Main system functions
     * @example Connector::IsAllowedLocale('ru');
     * @return mixed
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
     **/
    public function Log() {
        return $this->debugHandler;
    }
}
?>