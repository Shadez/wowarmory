<?php

/**
 * @package World of Warcraft Armory
 * @version Release 4.50
 * @revision 456
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

Class Armory {
    
    /** Armory database handler **/
    public static $aDB = null;
    
    /** Character database hanlder **/
    public static $cDB = null;
    
    /** Realm/accounts database handler **/
    public static $rDB = null;
    
    /** Mangos/world database handler **/
    public static $wDB = null;
    
    /** MySQL connection configs **/
    public static $mysqlconfig = array();
    
    /** Armory configs **/
    public static $armoryconfig = array();
    
    /** Current armory locale (ru_ru or en_gb) **/
    public static $_locale = null;
    
    /** Locale (0 - en_gb, 2 - fr_fr, 3 - de_de, etc.)**/
    public static $_loc = null;
    
    /** Links for multirealm info **/
    public static $realmData;
    public static $connectionData;
    public static $currentRealmInfo;
    
    /** Debug handler **/
    private static $debugHandler;
    
    /**
     * Initialize database handlers, debug handler, sets up sql/site configs
     * @category Armory class
     * @access   public
     * @return   bool
     **/
    public static function InitializeArmory() {
        if(!@include(__ARMORYDIRECTORY__ . '/includes/classes/configuration.php')) {
            die('<b>Error</b>: unable to load configuration file!');
        }
        if(!@require_once(__ARMORYDIRECTORY__ . '/includes/classes/class.dbhandler.php')) {
            die('<b>Error</b>: unable to load database class!');
        }
        if(!@require_once(__ARMORYDIRECTORY__ . '/includes/classes/class.debug.php')) {
            die('<b>Error</b>: unable to load debug class!');
        }
        self::$mysqlconfig  = $ArmoryConfig['mysql'];
        self::$armoryconfig = $ArmoryConfig['settings'];
        self::$debugHandler = new ArmoryDebug(array('useDebug' => self::$armoryconfig['useDebug'], 'logLevel' => self::$armoryconfig['logLevel']));
        self::$realmData    = $ArmoryConfig['multiRealm'];
        if(!defined('SKIP_DB')) {
            self::$aDB = new ArmoryDatabaseHandler(self::$mysqlconfig['host_armory'], self::$mysqlconfig['user_armory'], self::$mysqlconfig['pass_armory'], self::$mysqlconfig['name_armory'], self::$mysqlconfig['charset_armory'], self::$armoryconfig['db_prefix']);
            self::$rDB = new ArmoryDatabaseHandler(self::$mysqlconfig['host_realmd'], self::$mysqlconfig['user_realmd'], self::$mysqlconfig['pass_realmd'], self::$mysqlconfig['name_realmd'], self::$mysqlconfig['charset_realmd']);
            if(isset($_GET['r'])) {
                if(preg_match('/,/', $_GET['r'])) {
                    // Achievements/statistics comparison cases
                    $rData = explode(',', $_GET['r']);
                    $realmName = urldecode($rData[0]);
                }
                else {
                    $realmName = urldecode($_GET['r']);
                }
                $realm_id = self::FindRealm($realmName);
                if(isset(self::$realmData[$realm_id])) {
                    self::$connectionData = self::$realmData[$realm_id];
                    self::$cDB = new ArmoryDatabaseHandler(self::$connectionData['host_characters'], self::$connectionData['user_characters'], self::$connectionData['pass_characters'], self::$connectionData['name_characters'], self::$connectionData['charset_characters']);
                    self::$currentRealmInfo = array('name' => self::$connectionData['name'], 'id' => $realm_id, 'type' => self::$connectionData['type'], 'connected' => true);
                    self::$wDB = new ArmoryDatabaseHandler(self::$connectionData['host_world'], self::$connectionData['user_world'], self::$connectionData['pass_world'], self::$connectionData['name_world'], self::$connectionData['charset_world']);
                }
            }
            $realm_info = self::$realmData[1];
            if(self::$cDB == null) {
                self::$cDB = new ArmoryDatabaseHandler($realm_info['host_characters'], $realm_info['user_characters'], $realm_info['pass_characters'], $realm_info['name_characters'], $realm_info['charset_characters']);
            }
            if(self::$wDB == null) {
                self::$wDB = new ArmoryDatabaseHandler($realm_info['host_world'], $realm_info['user_world'], $realm_info['pass_world'], $realm_info['name_world'], $realm_info['charset_world']);
            }
            if(!self::$currentRealmInfo) {
                self::$currentRealmInfo = array('name' => $realm_info['name'], 'id' => 1, 'type' => $realm_info['type'], 'connected' => true);
            }
            if(!self::$connectionData) {
                self::$connectionData = $realm_info;
            }
        }
        if(isset($_SERVER['HTTP_ACCEPT_LANGUAGE'])) {
            $user_locale = strtolower(substr($_SERVER['HTTP_ACCEPT_LANGUAGE'], 0, 2));
            if($user_locale && $http_locale = self::IsAllowedLocale($user_locale)) {
                self::$_locale = (isset($_SESSION['armoryLocale'])) ? $_SESSION['armoryLocale'] : $http_locale;
            }
        }
        if(!self::$_locale) {
            self::$_locale = (isset($_SESSION['armoryLocale'])) ? $_SESSION['armoryLocale'] : self::$armoryconfig['defaultLocale'];
        }
        switch(self::$_locale) {
            case 'en_gb':
            case 'en_us':
                self::$_loc = 0;
                break;
            case 'fr_fr':
                self::$_loc = 2;
                break;
            case 'de_de':
                self::$_loc = 3;
                break;
            case 'es_es':
                self::$_loc = 6;
                break;
            case 'es_mx':
                self::$_loc = 7;
                break;
            case 'ru_ru':
                self::$_loc = 8;
                break;
        }
    }
    
    /**
     * Checks browser language from HTTP_ACCEPT_LANGUAGE
     * @category Armory class
     * @access   public
     * @return   string
     **/
    private static function IsAllowedLocale($locale) {
        switch($locale) {
            case 'de':
                return 'de_de';
                break;
            case 'en':
                return 'en_gb';
                break;
            case 'es':
                return 'es_es'; //es_mx?
                break;
            case 'fr':
                return 'fr_fr';
                break;
            case 'ru':
                return 'ru_ru';
                break;
            default:
                break;
        }
        return null;
    }
    
    /**
     * Returns debug log handler
     * @category Armory class
     * @access   public
     * @return   object
     **/
    public static function Log() {
        return self::$debugHandler;
    }
    
    /**
     * Returns current locale (en_gb/ru_ru/fr_fr, etc.)
     * @category Armory class
     * @access   public
     * @return   string
     **/
    public static function GetLocale() {
        if(self::$_locale == null) {
            self::Log()->writeLog('%s : locale not defined, return default locale', __METHOD__);
            return self::$armoryconfig['defaultLocale'];
        }
        if(self::$_locale == 'en_us') {
            return 'en_gb'; // For DB compatibility
        }
        elseif(self::$_locale == 'es_mx') {
            return 'es_es'; // For DB compatibility
        }
        return self::$_locale;
    }
    
    /**
     * Returns locale ID (0 for en_gb, etc.)
     * @category Armory class
     * @access   public
     * @return   int
     **/
    public static function GetLoc() {
        return self::$_loc;
    }
    
    /**
     * Sets locale
     * @category Armory class
     * @access   public
     * @return   bool
     **/
    public static function SetLocale($locale, $locale_id) {
        self::$_locale = $locale;
        self::$_loc    = $locale_id;
        return true;
    }
    
    public static function FindRealm($realm_name) {
        $realm_name = urldecode($realm_name);
        foreach(self::$realmData as $realm) {
            if($realm['name'] == $realm_name) {
                return $realm['id'];
            }
        }
        return 0;
    }
}
?>