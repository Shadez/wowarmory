<?php

/**
 * @package World of Warcraft Armory
 * @version Release 4.50
 * @revision 467
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

Class Admin {
    private static $user_id = 0;
    private static $user_name = null;
    private static $user_pass = null;
    private static $user_hash = null;
    private static $user_rights = 0;
    private static $user_session = array();
    private static $is_logged_in = false;
    private static $db = null;
    private static $db_type = null;
    private static $db_table = null;
    
    public static function IsLoggedIn() {
        return self::$is_logged_in;
    }
    
    public static function InitializeAdmin() {
        if(!isset($_COOKIE['armory_admin'])) {
            self::$is_logged_in = false;
            return false;
        }
        $session_data = explode(';', $_COOKIE['armory_admin']);
        if(!is_array($session_data)) {
            return false;
        }
        $session = '';
        foreach($session_data as $data) {
            $subdata = explode(':', $data);
            if(!is_array($subdata)) {
                continue;
            }
            if(!isset(self::${$subdata[0]}) && !isset($subdata[1])) {
                continue;
            }
            $session .= sprintf('%s:%s;', $subdata[0], $subdata[1]);
            self::${$subdata[0]} = $subdata[1];
        }
        self::$is_logged_in = true;
        return true;
    }
    
    public static function GetAdminUserName() {
        return self::$user_name;
    }
    
    public static function GetAdminUserID() {
        return self::$user_id;
    }
    
    public static function PerformLogin($username, $password) {
        self::$user_name = $username;
        self::$user_pass = $password;
        $user_data = Armory::$rDB->selectRow("SELECT `id`, `username`, `sha_pass_hash` FROM `account` WHERE `username` = '%s' AND `sha_pass_hash` = '%s' LIMIT 1", $username, self::CreateSha());
        if(!$user_data) {
            Armory::Log()->writeError('%s : authentication for user %s was failed.', __METHOD__, $username);
            return false;
        }
        $gm_level = 0;
        switch(Armory::$realmData[1]['type']) {
            default:
            case SERVER_MANGOS:
                $gm_level = Armory::$rDB->selectCell("SELECT `gmlevel` FROM `account` WHERE `id` = %d LIMIT 1", $user_data['id']);
                break;
            case SERVER_TRINITY:
                $gm_level = Armory::$rDB->selectCell("SELECT `gmlevel` FROM `account_access` WHERE `id` = %d LIMIT 1", $user_data['id']);
                break;
        }
        if($gm_level < 3) {
            Armory::Log()->writeError('%s : unable to authorize user %s (ID: %d): only administrators can log in admin panel!', __METHOD__, $username, $user_data['id']);
            return false;
        }
        self::$user_id = $user_data['id'];
        self::$user_rights = $gm_level;
        return self::CreateSessionData();
    }
    
    private static function CreateSha() {
        if(!self::$user_name || !self::$user_pass) {
            return 0;
        }
        self::$user_hash = sha1(strtoupper(self::$user_name) . ':' . strtoupper(self::$user_pass));
        return self::$user_hash;
    }
    
    private static function CreateSessionData() {
        $sess = array(
            'user_id'     => self::$user_id,
            'user_name'   => self::$user_name,
            'user_hash'   => self::$user_hash,
            'user_rights' => self::$user_rights
        );
        self::$user_session = $sess;
        $session = '';
        foreach($sess as $session_key => $value) {
            $session .= $session_key . ':' . $value .';';
        }
        setcookie('armory_admin', $session, time() + 60*60*24*30);
        $_SESSION['armory_admin_name'] = self::$user_name;
        self::$is_logged_in = true;
        return true;
    }
    
    public static function PerformLogout() {
        self::DestroyAccount();
        self::DestroySession();
        return true;
    }
    
    private static function DestroyAccount() {
        self::$user_id = 0;
        self::$user_name = null;
        self::$user_pass = null;
        self::$user_hash = null;
        self::$user_rights = 0;
        self::$user_session = array();
        self::$is_logged_in = false;
        return true;
    }
    
    private static function DestroySession() {
        if(!isset($_COOKIE['armory_admin'])) {
            return true;
        }
        setcookie('armory_admin', '');
        unset($_COOKIE['armory_admin'], $_SESSION['armory_admin_name']);
    }
    
    public static function GetRawVisitorsValue() {
        return Armory::$aDB->select("SELECT `date`, `count` FROM `ARMORYDBPREFIX_visitors`");
    }
    
    public static function GetJSFormattedVisitorsValue() {
        $visitors = self::GetRawVisitorsValue();
        $js_string = 'var d = [%s];';
        $tmpStr = '';
        if(is_array($visitors)) {
            $count = count($visitors);
            for($i = 0; $i < $count; ++$i) {
                $tmpStr .= sprintf('[%d, %d],', $visitors[$i]['date'], $visitors[$i]['count']);
            }
        }
        return sprintf($js_string, $tmpStr);
    }
    
    public static function GetNotifications() {
        /*
        types:
        
        error
        warning
        info
        success
        */
        $notifications = array();
        // Check for icons
        if(!file_exists(__ARMORYDIRECTORY__ . '/wow-icons/_images/21x21/ability_ambush.png')) {
            $notifications[] = array(
                'type' => 'error',
                'message' => 'Icons were not found!'
            );
        }
        // Check for .htaccess files
        $htaccess_files = array(
            '/.htaccess',
            '/_content/.htaccess',
            '/_data/.htaccess',
            '/_layout/.htaccess',
            '/data/.htaccess'
        );
        foreach($htaccess_files as $htaccess) {
            if(!file_exists(__ARMORYDIRECTORY__ . $htaccess)) {
                $notifications[] = array(
                    'type' => 'error',
                    'message' => 'Not all .htaccess files were found!'
                );
                break;
            }
        }
        return $notifications;
    }
    
    public static function UpdateConfigFile($configs) {
        if(!is_array($configs)) {
            Armory::Log()->writeError('%s : unable to update configs: $configs must be an array!', __METHOD__);
            return false;
        }
        $config_template = sprintf("<?php
// WORLD OF WARCRAFT ARMORY CONFIGURATION FILE
// THIS WAS GENERATED AUTOMATICALLY!
// DO NOT CHANGE ANYTHING!

if(!defined('__ARMORY__')) {
    die('Direct access to this file is not allowed!');
}
\$ArmoryConfig = array();
\$ArmoryConfig['mysql'] = array();
\$ArmoryConfig['settings'] = array();
\$ArmoryConfig['multiRealm'] = array();

\$ArmoryConfig['mysql']['host_armory'] = '%s';
\$ArmoryConfig['mysql']['user_armory'] = '%s';
\$ArmoryConfig['mysql']['pass_armory'] = '%s';
\$ArmoryConfig['mysql']['name_armory'] = '%s';
\$ArmoryConfig['mysql']['charset_armory'] = '%s';
\$ArmoryConfig['mysql']['host_realmd'] = '%s';
\$ArmoryConfig['mysql']['user_realmd'] = '%s';
\$ArmoryConfig['mysql']['pass_realmd'] = '%s';
\$ArmoryConfig['mysql']['name_realmd'] = '%s';
\$ArmoryConfig['mysql']['charset_realmd'] = '%s';

\$ArmoryConfig['settings']['useNews'] = %s;
\$ArmoryConfig['settings']['defaultBGName'] = '%s';
\$ArmoryConfig['settings']['useCache'] = %s;
\$ArmoryConfig['settings']['cache_lifetime'] = %d;
\$ArmoryConfig['settings']['db_prefix'] = '%s';
\$ArmoryConfig['settings']['minlevel'] = %d;
\$ArmoryConfig['settings']['minGmLevelToShow'] = %d;
\$ArmoryConfig['settings']['skipBanned'] = %s;
\$ArmoryConfig['settings']['defaultLocale'] = '%s';
\$ArmoryConfig['settings']['maintenance'] = %s;
\$ArmoryConfig['settings']['useDebug'] = %s;
\$ArmoryConfig['settings']['logLevel'] = %d;
\$ArmoryConfig['settings']['configVersion'] = '2001201101';
\$ArmoryConfig['settings']['checkVersionType'] = '%s';
",
        $configs['host_armory'], $configs['user_armory'], $configs['pass_armory'], $configs['name_armory'], $configs['charset_armory'],
        $configs['host_realmd'], $configs['user_realmd'], $configs['pass_realmd'], $configs['name_realmd'], $configs['charset_realmd'],
        $configs['useNews'] == true ? 'true' : 'false',
        $configs['defaultBGName'],
        $configs['useCache'] == true ? 'true' : 'false',
        $configs['cache_lifetime'],
        $configs['db_prefix'],
        $configs['minlevel'],
        $configs['minGmLevelToShow'],
        $configs['skipBanned'] == true ? 'true' : 'false',
        $configs['defaultLocale'],
        $configs['maintenance'],
        $configs['useDebug'] == true ? 'true' : 'false',
        $configs['logLevel'],
        $configs['checkVersionType']
        );
        $realm_config_template = "
\$ArmoryConfig['multiRealm'][%d]['id'] = %d;
\$ArmoryConfig['multiRealm'][%d]['name'] = '%s';
\$ArmoryConfig['multiRealm'][%d]['type'] = %s;
\$ArmoryConfig['multiRealm'][%d]['host_characters'] = '%s';
\$ArmoryConfig['multiRealm'][%d]['user_characters'] = '%s';
\$ArmoryConfig['multiRealm'][%d]['pass_characters'] = '%s';
\$ArmoryConfig['multiRealm'][%d]['name_characters'] = '%s';
\$ArmoryConfig['multiRealm'][%d]['charset_characters'] = '%s';
\$ArmoryConfig['multiRealm'][%d]['host_world'] = '%s';
\$ArmoryConfig['multiRealm'][%d]['user_world'] = '%s';
\$ArmoryConfig['multiRealm'][%d]['pass_world'] = '%s';
\$ArmoryConfig['multiRealm'][%d]['name_world'] = '%s';
\$ArmoryConfig['multiRealm'][%d]['charset_world'] = '%s';
";
        $i = 0;
        $continue_loop = true;
        while($continue_loop) {
            ++$i;
            if(isset($configs['realmid_' . $i])) {
                $realmId = $configs['realmid_' . $i];
                $rsql_info_chars = explode(';', $configs['realmchars_' . $i]);
                $rsql_info_world = explode(';', $configs['realmworld_' . $i]);
                if( (!is_array($rsql_info_chars) || !isset($rsql_info_chars[0])) || (!is_array($rsql_info_world) || !isset($rsql_info_world[0])) ) {
                    $continue_loop = false;
                }
                else {
                    $config_template .= sprintf($realm_config_template, 
                    $realmId, $realmId,
                    $realmId, $configs['realmname_' . $i],
                    $realmId, $configs['realmtype_' . $i] == 1 ? 'SERVER_MANGOS' : 'SERVER_TRINITY',
                    $realmId, $rsql_info_chars[0],
                    $realmId, $rsql_info_chars[1],
                    $realmId, $rsql_info_chars[2],
                    $realmId, $rsql_info_chars[3],
                    $realmId, $rsql_info_chars[4],
                    $realmId, $rsql_info_world[0],
                    $realmId, $rsql_info_world[1],
                    $realmId, $rsql_info_world[2],
                    $realmId, $rsql_info_world[3],
                    $realmId, $rsql_info_world[4]);
                }
            }
            else {
                $continue_loop = false;
            }
        }
        file_put_contents(__ARMORYDIRECTORY__ . '/includes/classes/configuration.php', $config_template);
        return true;
    }
    
    public static function AddNewRealm($configs) {
        if(!is_array($configs)) {
            Armory::Log()->writeError('%s : unable to add new realm: $configs must be an array!', __METHOD__);
            return false;
        }
        $realm_config_template = sprintf("
\$ArmoryConfig['multiRealm'][%d]['id'] = %d;
\$ArmoryConfig['multiRealm'][%d]['name'] = '%s';
\$ArmoryConfig['multiRealm'][%d]['type'] = %s;
\$ArmoryConfig['multiRealm'][%d]['host_characters'] = '%s';
\$ArmoryConfig['multiRealm'][%d]['user_characters'] = '%s';
\$ArmoryConfig['multiRealm'][%d]['pass_characters'] = '%s';
\$ArmoryConfig['multiRealm'][%d]['name_characters'] = '%s';
\$ArmoryConfig['multiRealm'][%d]['charset_characters'] = '%s';
\$ArmoryConfig['multiRealm'][%d]['host_world'] = '%s';
\$ArmoryConfig['multiRealm'][%d]['user_world'] = '%s';
\$ArmoryConfig['multiRealm'][%d]['pass_world'] = '%s';
\$ArmoryConfig['multiRealm'][%d]['name_world'] = '%s';
\$ArmoryConfig['multiRealm'][%d]['charset_world'] = '%s';
",
        $configs['realmID'], $configs['realmID'],
        $configs['realmID'], $configs['realmName'],
        $configs['realmID'], $configs['realmType'] == 1 ? 'SERVER_MANGOS' : 'SERVER_TRINITY',
        $configs['realmID'], $configs['realmCharsHost'],
        $configs['realmID'], $configs['realmCharsUser'],
        $configs['realmID'], $configs['realmCharsPassword'],
        $configs['realmID'], $configs['realmCharsName'],
        $configs['realmID'], $configs['realmCharsCharset'],
        $configs['realmID'], $configs['realmWorldHost'],
        $configs['realmID'], $configs['realmWorldUser'],
        $configs['realmID'], $configs['realmWorldPassword'],
        $configs['realmID'], $configs['realmWorldName'],
        $configs['realmID'], $configs['realmWorldCharset']
        );
        file_put_contents(__ARMORYDIRECTORY__ . '/includes/classes/configuration.php', $realm_config_template, FILE_APPEND);
        return true;
    }
    
    public static function GetAccountsList($offset = 1, $sort_by = 'id', $sort_type = 'ASC', $search = null) {
        $limit = 20 * ($offset - 1);
        $type = SERVER_MANGOS;
        // Detect: trinity or mangos realmd database
        Armory::$rDB->SkipNextError();
        $access_table = Armory::$rDB->selectCell("SELECT 1 FROM `account_access`");
        if($access_table) {
            $type = SERVER_TRINITY;
        }
        switch($type) {
            case SERVER_MANGOS:
                if($search != null) {
                    $accounts = Armory::$rDB->select("SELECT * FROM `account` WHERE `username` LIKE '%%%s%%' ORDER BY `%s` %s LIMIT %d, 20", $search, $sort_by, $sort_type, $limit);
                }
                else {
                    $accounts = Armory::$rDB->select("SELECT * FROM `account` ORDER BY `%s` %s LIMIT %d, 20", $sort_by, $sort_type, $limit);
                }
                break;
            case SERVER_TRINITY:
                if($search != null) {
                    $accounts = Armory::$rDB->select("
                    SELECT
                    `account`.`id`,
                    `account`.`username`,
                    `account`.`sha_pass_hash`,
                    `account`.`email`,
                    `account`.`last_ip`,
                    `account`.`last_login`,
                    `account`.`expansion`,
                    `account_access`.`gmlevel`
                    FROM `account`
                    JOIN `account_access` ON `account_access`.`id` = `account`.`id`
                    WHERE `account`.`username` LIKE '%%%s%%'
                    ORDER BY `account`.`%s` %s
                    LIMIT %d, 20
                    ", $search, $sort_by, $sort_type, $limit);
                }
                else {
                    $accounts = Armory::$rDB->select("
                    SELECT
                    `account`.`id`,
                    `account`.`username`,
                    `account`.`sha_pass_hash`,
                    `account`.`email`,
                    `account`.`last_ip`,
                    `account`.`last_login`,
                    `account`.`expansion`,
                    `account_access`.`gmlevel`
                    FROM `account`
                    JOIN `account_access` ON `account_access`.`id` = `account`.`id`
                    ORDER BY `account`.`%s` %s
                    LIMIT %d, 20
                    ", $sort_by, $sort_type, $limit);
                }
                break;
        }
        return $accounts;
    }
    
    public static function GetAccount($id) {
        if($id <= 0) {
            Armory::Log()->writeError('%s : user id must be > 0 (%d given.)!', __METHOD__, $id);
            return false;
        }
        return Armory::$rDB->selectRow("SELECT * FROM `account` WHERE `id` = %d LIMIT 1", $id);
    }
    
    public static function UpdateAccount($info) {
        if(!is_array($info)) {
            Armory::Log()->writeError('%s : unable to update user: $info must be an array (%s given)!', __METHOD__, gettype($info));
            return false;
        }
        if(!isset($info['gmlevel'])) {
            // Find
            Armory::$rDB->SkipNextError();
            $realms = Armory::$rDB->select("SELECT `RealmID` FROM `account_access` WHERE `id` = %d", $info['id']);
            if(is_array($realms)) {
                foreach($realms as $realm) {
                    if(isset($info['gmlevel_' . $realm['RealmID']])) {
                        Armory::$rDB->query("UPDATE `account_access` SET `gmlevel` = %d WHERE `RealmID` = %d AND `id` = %d", $info['gmlevel_' . $realm['RealmID']], $realm['RealmID'], $info['id']);
                    }
                }
            }
            Armory::$rDB->query("UPDATE `account` SET `username` = '%s', `sha_pass_hash` = '%s', `v` = '', `s` = '', `email` = '%s', `joindate` = '%s', `last_ip` = '%s', `locked` = %d, `last_login` = '%s', `expansion` = %d WHERE `id` = %d LIMIT 1",
                $info['username'], $info['sha_pass_hash'], $info['email'], $info['joindate'], $info['last_ip'], $info['locked'], $info['last_login'], $info['expansion'], $info['id']
            );
        }
        else {
            Armory::$rDB->query("UPDATE `account` SET `username` = '%s', `sha_pass_hash` = '%s', `gmlevel` = %d, `v` = '', `s` = '', `email` = '%s', `joindate` = '%s', `last_ip` = '%s', `locked` = %d, `last_login` = '%s', `expansion` = %d WHERE `id` = %d LIMIT 1",
                $info['username'], $info['sha_pass_hash'], $info['gmlevel'], $info['email'], $info['joindate'], $info['last_ip'], $info['locked'], $info['last_login'], $info['expansion'], $info['id']
            );
        }
        return true;
    }
    
    public static function DeleteAccount($id) {
        if($id <= 0) {
            Armory::Log()->writeError('%s : account id must be > 0 (%d given)!', __METHOD__, $id);
            return false;
        }
        Armory::$rDB->query("DELETE FROM `account` WHERE `id` = %d LIMIT 1", $id);
        return true;
    }
    
    public static function GetDB() {
        return self::$db;
    }
    
    public static function InitDB($realm_id, $db_name, $db_type) {
        
        if(!in_array($db_type, array('characters', 'world', 'realmd', 'armory'))) {
            return false;
        }
        if(!isset(Armory::$realmData[$realm_id]) && in_array($db_type, array('characters', 'world'))) {
            return false;
        }
        if((Armory::$realmData[$realm_id]['name_' . $db_type] != $db_name || Armory::$realmData[$realm_id]['id'] != $realm_id) && in_array($db_type, array('characters', 'world'))) {
            return false;
        }
        $realm_info = Armory::$realmData[$realm_id];
        self::$db_type = $db_type;
        switch($db_type) {
            case 'characters':
                self::$db = new ArmoryDatabaseHandler($realm_info['host_characters'], $realm_info['user_characters'], $realm_info['pass_characters'], $realm_info['name_characters'], $realm_info['charset_characters']);
                break;
            case 'world':
                self::$db = new ArmoryDatabaseHandler($realm_info['host_world'], $realm_info['user_world'], $realm_info['pass_world'], $realm_info['name_world'], $realm_info['charset_world']);
                break;
            case 'realmd':
                self::$db = Armory::$rDB;
                break;
            case 'armory':
                self::$db = Armory::$aDB;
                break;
            default:
                return false;
                break;
        }
        if(!self::$db->TestLink()) {
            return false;
        }
    }
    
    public static function GetTablesListFromDB() {
        if(!self::$db) {
            Armory::Log()->writeError('%s : DB is not initialized!', __METHOD__);
            return false;
        }
        $tables = self::$db->select("SHOW TABLES");
        if(!$tables) {
            return false;
        }
        $list = array();
        foreach($tables as $tmpTable) {
            if(!is_array($tmpTable)) {
                return false;
            }
            foreach($tmpTable as $tb_name) {
                $list[] = $tb_name;
            }
        }
        return $list;
    }
    
    public static function LoadTableFromDB($table) {
        if(!self::$db) {
            Armory::Log()->writeError('%s : DB is not initialized!', __METHOD__);
            return false;
        }
        self::$db_table = $table;
        $table_data = self::$db->select("DESCRIBE %s", self::$db_table);
        if(!$table_data) {
            return false;
        }
        $td = array();
        $i = 0;
        foreach($table_data as $tbl) {
            $td[] = array(
                'name' => $tbl['Field'],
                'key' => $tbl['Key'] == 'PRI' ? true : false
            );
        }
        return $td;
    }
}
?>