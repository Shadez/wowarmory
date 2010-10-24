<?php

/**
 * @package World of Warcraft Armory
 * @version Release Candidate 1
 * @revision 410
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

Class Utils {
    
    public $armory = null;
    
    /**
     * Account ID
     * @category Utils class
     * @access   public
     **/
    public $accountId;
    
    /**
     * Username
     * @category Utils class
     * @access   public
     **/
    public $username;
    
    /**
     * Password
     * @category Utils class
     * @access   public
     **/
    public $password;
    
    /**
     * Login-password hash (SHA1)
     * @category Utils class
     * @access   public
     **/
    public $shaHash;
    
    public function Utils($armory) {
        if(!is_object($armory)) {
            die('<b>Fatal Error:</b> armory must be instance of Armory class!');
        }
        $this->armory = $armory;
    }
    
    /**
     * User authorization
     * @category Utils class
     * @access   public
     * @return   bool
     **/
    public function AuthUser() {
        if(!$this->username || !$this->password) {
            $this->armory->Log()->writeError('%s : username or password not defined', __METHOD__);
            return false;
        }
        $info = $this->armory->rDB->selectRow("SELECT `id`, `sha_pass_hash` FROM `account` WHERE `username`='%s' LIMIT 1", $this->username);
        if(!$info) {
            $this->armory->Log()->writeError('%s : unable to get data from DB for account %s', __METHOD__, $this->username);
            return false;
        }
        elseif(strtoupper($info['sha_pass_hash']) != $this->GenerateShaHash()) {
            $this->armory->Log()->writeError('%s : sha_pass_hash and generated SHA1 hash are different (%s and %s), unable to auth user.', __METHOD__, strtoupper($info['sha_pass_hash']), $this->GenerateShaHash());
            return false;
        }
        else {
            $this->accountId = $info['id'];
            $_SESSION['wow_login'] = true;
            $_SESSION['accountId'] = $this->accountId;
            $_SESSION['username']  = $this->username;
            return true;
        }
    }
    
    /**
     * Close session for current user
     * @category Utils class
     * @access   public
     * @return   bool
     **/
    public function CloseSession() {
        unset($_SESSION['wow_login']);
        unset($_SESSION['username']);
        unset($_SESSION['accountId']);
        return true;
    }
    
    /**
     * Checks if account have any character that can browse guild bank.
     * @category Utils class
     * @access   public
     * @param    int $guildId
     * @param    int $realmId
     * @return   bool
     * @todo     Add guild bank tab access handling
     **/
    public function IsAllowedToGuildBank($guildId, $realmId) {
        if(!isset($_SESSION['accountId'])) {
            return false;
        }
        if(!isset($this->armory->realmData[$realmId])) {
            $this->armory->Log()->writeError('%s : unable to find connection data for realm %d', __METHOD__, $realmId);
            return false;
        }
        $realm_info = $this->armory->realmData[$realmId];
        $db = new ArmoryDatabaseHandler($realm_info['host_characters'], $realm_info['user_characters'], $realm_info['pass_characters'], $realm_info['name_characters'], $realm_info['charset_characters'], $this->armory->Log());
        if(!$db) {
            return false;
        }
        $chars_data = $db->select("
        SELECT
        `characters`.`guid`,
        `guild_member`.`guildid` AS `guildId`
        FROM `characters` AS `characters`
        LEFT JOIN `guild_member` AS `guild_member` ON `guild_member`.`guid`=`characters`.`guid`
        WHERE `characters`.`account`=%d AND `guild_member`.`guildid`=%d", $_SESSION['accountId'], $guildId);
        if(!$chars_data) {
            $this->armory->Log()->writeLog('%s : account %d does not have any character in %d guild on realm %d', __METHOD__, $_SESSION['accountId'], $guildId, $realmId);
            return false;
        }
        // Account have character in $guildId guild
        return true;
    }
    
    /**
     * Is account have current character? :D
     * @category Utils class
     * @access   public
     * @param    int $guid
     * @param    int $realmId
     * @return   bool
     **/
    public function IsAccountHaveCurrentCharacter($guid, $realmId) {
        if(!isset($_SESSION['accountId'])) {
            return false;
        }
        if(!isset($this->armory->realmData[$realmId])) {
            $this->armory->Log()->writeError('%s : unable to find connection data for realm %d', __METHOD__, $realmId);
            return false;
        }
        $realm_info = $this->armory->realmData[$realmId];
        $db = new ArmoryDatabaseHandler($realm_info['host_characters'], $realm_info['user_characters'], $realm_info['pass_characters'], $realm_info['name_characters'], $realm_info['charset_characters'], $this->armory->Log());
        if(!$db) {
            return false;
        }
        $chars_data = $db->select("SELECT 1 FROM `characters` WHERE `account`=%d AND `guid`=%d", $_SESSION['accountId'], $guid);
        if(!$chars_data) {
            return false;
        }
        // Account $_SESSION['accountId'] have character $guid on $realmId realm
        return true;
    }
    
    /**
     * Counts all selected characters.
     * @category Utils class
     * @access   public
     * @return   int
     **/
    public function CountSelectedCharacters() {
        if(!isset($_SESSION['accountId'])) {
            return false;
        }
        return $this->armory->aDB->selectCell("SELECT COUNT(`guid`) FROM `ARMORYDBPREFIX_login_characters` WHERE `account`=%d", $_SESSION['accountId']);
    }
    
    /**
     * Counts all characters.
     * @category Utils class
     * @access   public
     * @return   int
     **/
    public function CountAllCharacters() {
        if(!isset($_SESSION['accountId'])) {
            return false;
        }
        $count_all = 0;
        foreach($this->armory->realmData as $realm_info) {
            $db = new ArmoryDatabaseHandler($realm_info['host_characters'], $realm_info['user_characters'], $realm_info['pass_characters'], $realm_info['name_characters'], $realm_info['charset_characters'], $this->armory->Log());
            $current = $db->selectCell("SELECT COUNT(`guid`) FROM `characters` WHERE `account`=%d", $_SESSION['accountId']);
            $count_all += $current;
        }
        unset($realm_info, $db);
        return $count_all;
    }
    
    /**
     * Returns array with all characters.
     * @category Utils class
     * @access   public
     * @return   array
     **/
    public function GetAllCharacters() {
        if(!isset($_SESSION['accountId'])) {
            return false;
        }
        $results = array();
        foreach($this->armory->realmData as $realm_info) {
            $db = new ArmoryDatabaseHandler($realm_info['host_characters'], $realm_info['user_characters'], $realm_info['pass_characters'], $realm_info['name_characters'], $realm_info['charset_characters'], $this->armory->Log());
            if(!$db) {
                continue;
            }
            $chars_data = $db->select("
            SELECT
            `characters`.`guid`,
            `characters`.`name`, 
            `characters`.`class` AS `classId`, 
            `characters`.`race` AS `raceId`, 
            `characters`.`gender` AS `genderId`, 
            `characters`.`level`,
            `guild_member`.`guildid` AS `guildId`,
            `guild`.`name` AS `guild`
            FROM `characters` AS `characters`
            LEFT JOIN `guild_member` AS `guild_member` ON `guild_member`.`guid`=`characters`.`guid`
            LEFT JOIN `guild` AS `guild` ON `guild`.`guildid`=`guild_member`.`guildId`
            WHERE `characters`.`account`=%d", $_SESSION['accountId']);
            if(!$chars_data) {
                $this->armory->Log()->writeLog('%s : no characters found for account %d in `%s` database', __METHOD__, $_SESSION['accountId'], $realm_info['name_characters']);
                continue;
            }
            foreach($chars_data as $realm) {
                $realm['account'] = strtoupper($_SESSION['username']);
                $realm['factionId'] = self::GetFactionId($realm['raceId']);
                $realm['realm'] = $realm_info['name'];
                $realm['relevance'] = 100;
                if($realm['level'] < $this->armory->armoryconfig['minlevel']) {
                    $realm['relevance'] = 0;
                }
                elseif($realm['level'] >= $this->armory->armoryconfig['minlevel'] && $realm['level'] <= 79) {
                    $realm['relevance'] = $realm['level'];
                }
                elseif($realm['level'] == 80) {
                    $realm['relevance'] = 100;
                }
                else {
                    $realm['relevance'] = 0; // Unknown
                }
                $realm['url'] = sprintf('r=%s&cn=%s', urlencode($realm['realm']), urlencode($realm['name']));
                $realm['selected'] = $this->armory->aDB->selectCell("SELECT `selected` FROM `ARMORYDBPREFIX_login_characters` WHERE `account`=%d AND `guid`=%d AND `realm_id`=%d LIMIT 1", $_SESSION['accountId'], $realm['guid'], $realm_info['id']);
                if($realm['selected'] > 2) {
                    $realm['selected'] = 2;
                }
                elseif($realm['selected'] == 0) {
                    unset($realm['selected']);
                }
                unset($realm['guid']); // Do not show GUID in XML results
                $results[] = $realm;
            }
        }
        if(is_array($results)) {
            return $results;
        }
        $this->armory->Log()->writeLog('%s : unable to find any character for account %d', __METHOD__, $_SESSION['accountId']);
        return false;
    }
    
    /**
     * Returns active (selected) character info
     * @category Utils class
     * @access   public
     * @return   array
     **/
    public function GetActiveCharacter() {
        if(!isset($_SESSION['accountId'])) {
            return false;
        }
        return $this->armory->aDB->selectRow("
        SELECT
        `armory_login_characters`.`guid`,
        `armory_login_characters`.`name`,
        `armory_login_characters`.`race`,
        `armory_login_characters`.`realm_id`,
        `armory_realm_data`.`name` AS `realmName`
        FROM `ARMORYDBPREFIX_login_characters` AS `armory_login_characters`
        LEFT JOIN `armory_realm_data` AS `armory_realm_data` ON `armory_realm_data`.`id`=`armory_login_characters`.`realm_id`
        WHERE `armory_login_characters`.`account`=%d AND `armory_login_characters`.`selected`=1 LIMIT 1
        ", $_SESSION['accountId']);
    }
    
    /**
     * Returns array with user bookmarks.
     * @category Utils class
     * @access   public
     * @return   array
     **/
    public function GetBookmarks() {
        if(!isset($_SESSION['accountId'])) {
            return false;
        }
        // Bookmarks limit is 60
        $bookmarks_data = $this->armory->aDB->select("SELECT `name`, `classId`, `level`, `realm`, `url` FROM `ARMORYDBPREFIX_bookmarks` WHERE `account`=%d LIMIT 60", $_SESSION['accountId']);
        if(!$bookmarks_data) {
            $this->armory->Log()->writeLog('%s : bookmarks for account %d not found', __METHOD__, $_SESSION['accountId']);
            return false;
        }
        $result = array();
        foreach($bookmarks_data as $bookmark) {
            $realm = $this->armory->aDB->selectRow("SELECT `id`, `name` FROM `ARMORYDBPREFIX_realm_data` WHERE `name`='%s'", $bookmark['realm']);
            if(!$realm) {
                continue;
            }
            elseif(!isset($this->armory->realmData[$realm['id']])) {
                continue;
            }
            $realm_info = $this->armory->realmData[$realm['id']];
            $db = new ArmoryDatabaseHandler($realm_info['host_characters'], $realm_info['user_characters'], $realm_info['pass_characters'], $realm_info['name_characters'], $realm_info['charset_characters'], $this->armory->Log());
            if(!$db) {
                continue;
            }
            $guid = $db->selectCell("SELECT `guid` FROM `characters` WHERE `name`='%s'", $bookmark['name']);
            if(!$guid) {
                continue;
            }
            $bookmark['achPoints'] = $this->armory->aDB->selectCell("SELECT SUM(`points`) FROM `ARMORYDBPREFIX_achievement` WHERE `id` IN (SELECT `achievement` FROM `%s`.`character_achievement` WHERE `guid`=%d)", $realm_info['name_characters'], $guid);
            $result[] = $bookmark;
            unset($db, $realm_info, $achievement_ids, $guid, $realm);
        }
        return $result;
    }
    
    /**
     * Creates new bookmark
     * @category Utils class
     * @access   public
     * @param    string $name
     * @param    string $realmName
     * @return   bool
     **/
    public function AddBookmark($name, $realmName) {
        if(!isset($_SESSION['accountId'])) {
            return false;
        }
        if($this->GetBookmarksCount() >= 60) {
            // Unable to store more than 60 bookmarks for single account
            return false;
        }
        $realm = $this->armory->aDB->selectRow("SELECT `id`, `name` FROM `ARMORYDBPREFIX_realm_data` WHERE `name`='%s'", $realmName);
        if(!$realm) {
            return false;
        }
        elseif(!isset($this->armory->realmData[$realm['id']])) {
            return false;
        }
        $realm_info = $this->armory->realmData[$realm['id']];
        $db = new ArmoryDatabaseHandler($realm_info['host_characters'], $realm_info['user_characters'], $realm_info['pass_characters'], $realm_info['name_characters'], $realm_info['charset_characters'], $this->armory->Log());
        if(!$db) {
            return false;
        }
        $char_data = $db->selectRow("SELECT `name`, `class` AS `classId`, `level` FROM `characters` WHERE `name`='%s' LIMIT 1", $name);
        if(!$char_data) {
            return false;
        }
        $char_data['realmUrl'] = sprintf('r=%s&cn=%s', urlencode($realmName), urlencode($name));
        $this->armory->aDB->query("INSERT IGNORE INTO `armory_bookmarks` VALUES (%d, '%s', %d, %d, '%s', '%s')", $_SESSION['accountId'], $char_data['name'], $char_data['classId'], $char_data['level'], $realmName, $char_data['realmUrl']);
        return true;
    }
    
    /**
     * Delete bookmark.
     * @category Utils class
     * @access   public
     * @param    string $name
     * @param    string $realmName
     * @return   bool
     **/
    public function DeleteBookmark($name, $realmName) {
        if(!isset($_SESSION['accountId'])) {
            return false;
        }
        $this->armory->aDB->query("DELETE FROM `ARMORYDBPREFIX_bookmarks` WHERE `name`='%s' AND `realm`='%s' AND `account`='%d' LIMIT 1", $name, $realmName, $_SESSION['accountId']);
        return true;
    }
    
    /**
     * Returns bookmarks count.
     * @category Utils class
     * @access   public
     * @return   int
     **/
    public function GetBookmarksCount() {
        if(!isset($_SESSION['accountId'])) {
            return false;
        }
        $count = $this->armory->aDB->selectCell("SELECT COUNT(`name`) FROM `ARMORYDBPREFIX_bookmarks` WHERE `account`=%d", $_SESSION['accountId']);
        if($count > 60) {
            return 60;
        }
        return $count;
    }
    
    /**
     * Generates SHA1 hash.
     * @category Utils class
     * @access   public
     * @return   string
     **/
    public function GenerateShaHash() {
        if(!$this->username || !$this->password) {
            $this->armory->Log()->writeError('%s : username or password not defined', __METHOD__);
            return false;
        }
        $this->shaHash = sha1(strtoupper($this->username).':'.strtoupper($this->password));
        return strtoupper($this->shaHash);
    }
    
    /**
     * Calculates pet bonus for some stats.
     * @category Utils class
     * @access   public
     * @param    int $stat
     * @param    int $value
     * @param    int $unitClass
     **/
    public function ComputePetBonus($stat, $value, $unitClass) {
        $hunter_pet_bonus = array(0.22, 0.1287, 0.3, 0.4, 0.35, 0.0, 0.0, 0.0);
        $warlock_pet_bonus = array(0.0, 0.0, 0.3, 0.4, 0.35, 0.15, 0.57, 0.3);
        if($unitClass == CLASS_WARLOCK) {
            if(isset($warlock_pet_bonus[$stat])) {
                return $value * $warlock_pet_bonus[$stat];
            }
            else {
                return 0;
            }
        }
        elseif($unitClass == CLASS_HUNTER) {
            if(isset($hunter_pet_bonus[$stat])) {
                return $value * $hunter_pet_bonus[$stat];
            }
            else {
                return 0;
            }
        }
        return 0;
    }
    
    /**
     * Returns float value.
     * @category Utils class
     * @access   public
     * @param    int $value
     * @param    int $num
     * @return   float
     **/
    public function GetFloatValue($value, $num) {
        $txt = unpack('f', pack('L', $value));
        return round($txt[1], $num);
    }
    
    /**
     * Returns rating coefficient for rating $id.
     * @category Utils class
     * @access   public
     * @param    array $rating
     * @param    int $id
     * @return   int
     **/
    public function GetRatingCoefficient($rating, $id) {
        if(!is_array($rating)) {
            return 1; // Do not return 0 because it will cause division by zero error.
        }
        $ratingkey = array_keys($rating);
        if(!isset($ratingkey[44+$id]) || !isset($rating[$ratingkey[44+$id]])) {
            return 1;
        }
        $c = $rating[$ratingkey[44+$id]];
        if($c == 0) {
            $c = 1;
        }
        return $c;
    }
    
    /**
     * Loads rating info from DB.
     * @category Utils class
     * @access   public
     * @param    int $level
     * @return   array
     **/
    public function GetRating($level) {
        return $this->armory->aDB->selectRow("SELECT * FROM `ARMORYDBPREFIX_rating` WHERE `level`=%d", $level);
    }
    
    /**
     * Add slashes to string.
     * @category Utils class
     * @access   public
     * @param    string $string
     * @return   string
     **/
    public function escape($string) {
        return !get_magic_quotes_gpc() ? addslashes($string) : $string;
    }
    
    /**
     * Returns percent value.
     * @category Utils class
     * @access   public
     * @param    int $max
     * @param    int $min
     * @return   int
     **/
    public function GetPercent($max, $min) {
        $percent = $max / 100;
        if($percent == 0) {
            return 0;
        }
        $progressPercent = $min / $percent;
		if($progressPercent > 100) {
			$progressPercent = 100;
		}
		return $progressPercent;
    }
    
    /**
     * Returns max. array value index.
     * @category Utils class
     * @access   public
     * @param    array $arr
     * @return   array
     **/
    public function GetMaxArray($arr) {
        if(!is_array($arr)) {
            $this->armory->Log()->writeError('%s : arr must be in array', __METHOD__);
            return false;
        }
        $keys = array_keys($arr);
        $cnt = count($arr);
        $min = $max = $arr[$keys[0]];
        $index_min=$index_max=0; 
        for($i = 1; $i < $cnt; $i++) {
            if($arr[$keys[$i]]>$max) {
                $index_max = $i;
                $max = $arr[$keys[$i]];
            }
        }
        return $index_max;
    }
    
    /**
     * Returns spell bonus damage.
     * @category Utils class
     * @access   public
     * @param    int $school
     * @param    int $guid
     * @param    object $db
     * @return   int
     **/
    public function GetSpellBonusDamage($school, $guid, $db) {
        $field_done_pos = PLAYER_FIELD_MOD_DAMAGE_DONE_POS+$school+1;
        $field_done_neg = PLAYER_FIELD_MOD_DAMAGE_DONE_NEG+$school+1;
        $field_done_pct = PLAYER_FIELD_MOD_DAMAGE_DONE_PCT+$school+1;
        $damage_done_pos = $db->selectCell("
        SELECT CAST(SUBSTRING_INDEX(SUBSTRING_INDEX(`data`, ' ', %d), ' ', '-1') AS UNSIGNED)
            FROM `armory_character_stats` 
                WHERE `guid`=%d", $field_done_pos, $guid);
        return $damage_done_pos;
    }
    
    /**
     * Returns array with Realm firsts achievements
     * @category Utils class
     * @access   public
     * @todo     Merge characters who earned same achievement (realm first boss kill) into one group
     * @return   array
     **/
    public function GetRealmFirsts() {
        $achievements_data = $this->armory->cDB->select("
        SELECT
        `character_achievement`.`achievement`,
        `character_achievement`.`date`,
        `character_achievement`.`guid`,
        `characters`.`name` AS `charname`,
        `characters`.`race`,
        `characters`.`class`,
        `characters`.`gender`,
        `guild`.`name` AS `guildname`,
        `guild_member`.`guildid`
        FROM `character_achievement` AS `character_achievement`
        LEFT JOIN `characters` AS `characters` ON `characters`.`guid`=`character_achievement`.`guid`
        LEFT JOIN `guild_member` AS `guild_member` ON `guild_member`.`guid`=`character_achievement`.`guid`
        LEFT JOIN `guild` AS `guild` ON `guild`.`guildid`=`guild_member`.`guildid`
        WHERE `character_achievement`.`achievement` IN 
        (
            457, 458, 459, 460, 461, 462, 463, 464, 465, 466, 
            467, 1404, 1405, 1406, 1407, 1408, 1409, 
            1410, 1411, 1412, 1413, 1414, 1415, 1416, 1417, 1418, 
            1419, 1420, 1421, 1422, 1423, 1424, 1425, 1426, 1427, 
            1463, 3259, 456, 1400, 1402, 3117, 4078, 4576
        )
        ORDER BY `character_achievement`.`date` DESC"); // 3.3.3a IDs
        if(!$achievements_data) {
            $this->armory->Log()->writeLog('%s : unable to get data from DB for achievement firsts (theres no completed achievement firsts?)', __METHOD__);
            return false;
        }
        $countAch = count($achievements_data);
        for($i=0;$i<$countAch;$i++) {
            $tmp_info = $this->armory->aDB->selectRow("SELECT `name_%s` AS `name`, `description_%s` AS `desc`, `iconname` FROM `ARMORYDBPREFIX_achievement` WHERE `id`=%d LIMIT 1", $this->armory->GetLocale(), $this->armory->GetLocale(), $achievements_data[$i]['achievement']);
            $achievements_data[$i]['title'] = $tmp_info['name'];
            $achievements_data[$i]['desc']  = $tmp_info['desc'];
            $achievements_data[$i]['icon']  = $tmp_info['iconname'];
            $achievements_data[$i]['id']    = $achievements_data[$i]['achievement'];
            $achievements_data[$i]['dateCompleted'] = date('Y-m-d\TH:i:s\Z', $achievements_data[$i]['date']);
        }
        /*
        $start_id = $countAch+1;
        //                   Sartharion Malygos Kel'thuzed Yogg-Saron ToGC  The Lich King
        $boss_firsts = array(456,       1400,   1402,      3117,      4078, 4576);
        $bosses = array();
        */
        $boss_firsts = array(456,       1400,   1402,      3117,      4078, 4576);
        /*$i = count($achievements_data)+1;
        foreach($boss_firsts as $rf) {
            $tmp = $this->armory->cDB->select("
            SELECT
            `character_achievement`.`achievement`,
            `character_achievement`.`date`,
            `character_achievement`.`guid`,
            `characters`.`name` AS `charname`,
            `characters`.`race`,
            `characters`.`class`,
            `characters`.`gender`,
            `guild`.`name` AS `guildname`,
            `guild`.`guildid`,
            `guild_member`.`guildid`
            FROM `character_achievement` AS `character_achievement`
            LEFT JOIN `characters` AS `characters` ON `characters`.`guid`=`character_achievement`.`guid`
            LEFT JOIN `guild_member` AS `guild_member` ON `guild_member`.`guid`=`character_achievement`.`guid`
            LEFT JOIN `guild` AS `guild` ON `guild`.`guildid`=`guild_member`.`guildid`
            WHERE `character_achievement`.`achievement`=%d
            ORDER BY `character_achievement`.`date` DESC", $rf);
            if($tmp) {
                foreach($tmp as $ach) {
                    if($ach['guildid'] != null) {
                         $achievements_data[$rf][$ach['guildid']]['info'] = array('guildId' => $ach['guildid'], 'name' => $ach['guildname'], 'achievementId' => $ach['achievement']);
                    }
                    else {
                        $ach['guildid'] = 0;
                    }
                    $achievements_data[$rf][$ach['guildid']]['members'][] = $ach;
                }
            }
        }
        */
        return $achievements_data;
    }
    
    /**
     * Calculates attack power for different classes by stat mods
     * @category Utils class
     * @access   public
     * @param    int $statIndex
     * @param    float $effectiveStat
     * @param    int $class
     * @return   float
     **/
    public function GetAttackPowerForStat($statIndex, $effectiveStat, $class) {
        $ap = 0;
        if($statIndex == STAT_STRENGTH) {
            switch($class) {
                case CLASS_WARRIOR:
                case CLASS_PALADIN:
                case CLASS_DK:
                case CLASS_DRUID:
                    $baseStr = min($effectiveStat,20);
                    $moreStr = $effectiveStat-$baseStr;
                    $ap = $baseStr + 2*$moreStr;
                    break;
                default:
                    $ap = $effectiveStat - 10;
                    break;
            }
        }
        elseif($statIndex == STAT_AGILITY) {
            switch ($class) {
                case CLASS_SHAMAN:
                case CLASS_ROGUE:
                case CLASS_HUNTER:
                    $ap = $effectiveStat - 10;
                    break;
            }
        }
        if($ap < 0) {
            $ap = 0;
        }
        return $ap;
    }
    
    /**
     * Calculates crit chance from agility stat.
     * @category Utils class
     * @access   public
     * @param    array $rating
     * @param    int $class
     * @param    float $agility
     * @return   float
     **/
    public function GetCritChanceFromAgility($rating, $class, $agility) {
        $base = array(3.1891, 3.2685, -1.532, -0.295, 3.1765, 3.1890, 2.922, 3.454, 2.6222, 20, 7.4755);
        $ratingkey = array_keys($rating);
        if(isset($ratingkey[$class]) && isset($rating[$ratingkey[$class]]) && isset($base[$class-1])) {
            return $base[$class-1] + $agility*$rating[$ratingkey[$class]]*100;
        }
    }
    
    /**
     * Calculates spell crit chance from intellect stat.
     * @category Utils class
     * @access   public
     * @param    array $rating
     * @param    int $class
     * @param    float $intellect
     * @return   float
     **/
    public function GetSpellCritChanceFromIntellect($rating, $class, $intellect) {
        $base = array(0, 3.3355, 3.602, 0, 1.2375, 0, 2.201, 0.9075, 1.7, 20, 1.8515);
        $ratingkey = array_keys($rating);
        if(isset($base[$class-1]) && isset($ratingkey[11+$class]) && isset($rating[$ratingkey[11+$class]])) {
            return $base[$class-1] + $intellect*$rating[$ratingkey[11+$class]]*100;
        }
    }
    
    /**
     * Calculates health regeneration coefficient.
     * @category Utils class
     * @access   public
     * @param    array $rating
     * @param    int $class
     * @return   float
     **/
    public function GetHRCoefficient($rating, $class) {
        $ratingkey = array_keys($rating);
        if(!isset($ratingkey[22+$class]) || !isset($rating[$ratingkey[22+$class]])) {
            return 1;
        }
        $c = $rating[$ratingkey[22+$class]];
        if($c == 0) {
            $c = 1;
        }
        return $c;
    }
    
    /**
     * Calculates mana regenerating coefficient
     * @category Utils class
     * @access   public
     * @param    array $rating
     * @param    int $class
     * @return   float
     **/
    public function GetMRCoefficient($rating, $class) {
        $ratingkey = array_keys($rating);
        if(!isset($ratingkey[33+$class]) || !isset($rating[$ratingkey[33+$class]])) {
            return 1;
        }
        $c = $rating[$ratingkey[33+$class]];
        if($c == 0) {
            $c = 1;
        }
        return $c;
    }
    
    /**
     * Returns Skill ID that required for Item $id
     * @category Utils class
     * @access   public
     * @param    int $id
     * @return   int
     **/
    public function GetSkillIDFromItemID($id) {
        if($id == 0) {
            return SKILL_UNARMED;
        }
        $item = $this->armory->wDB->selectRow("SELECT `class`, `subclass` FROM `item_template` WHERE `entry`=%d LIMIT 1", $id);
        if(!$item) {
            return SKILL_UNARMED;
        }
        if($item['class'] != ITEM_CLASS_WEAPON) {
            return SKILL_UNARMED;
        }
        switch ($item['subclass']) {
            case  0: return SKILL_AXES;
            case  1: return SKILL_TWO_HANDED_AXE;
            case  2: return SKILL_BOWS;
            case  3: return SKILL_GUNS;
            case  4: return SKILL_MACES;
            case  5: return SKILL_TWO_HANDED_MACES;
            case  6: return SKILL_POLEARMS;
            case  7: return SKILL_SWORDS;
            case  8: return SKILL_TWO_HANDED_SWORDS;
            case 10: return SKILL_STAVES;
            case 13: return SKILL_FIST_WEAPONS;
            case 15: return SKILL_DAGGERS;
            case 16: return SKILL_THROWN;
            case 18: return SKILL_CROSSBOWS;
            case 19: return SKILL_WANDS;
        }
        return SKILL_UNARMED;
    }
    
    /**
     * Returns skill info for skill $id
     * @category Utils class
     * @access   public
     * @param    int $id
     * @param    array $char_data
     * @return   array
     **/
    public function GetSkillInfo($id, $char_data) {
        $skillInfo = array(0,0,0,0,0,0);
        for ($i=0;$i<128;$i++) {
            if(($char_data[PLAYER_SKILL_INFO_1_1 + $i*3] & 0x0000FFFF) == $id) {
                $data0 = $char_data[PLAYER_SKILL_INFO_1_1 + $i*3];
                $data1 = $char_data[PLAYER_SKILL_INFO_1_1 + $i*3 + 1];
                $data2 = $char_data[PLAYER_SKILL_INFO_1_1 + $i*3 + 2];
                $skillInfo[0]=$data0&0x0000FFFF; // skill id
                $skillInfo[1]=$data0>>16;        // skill flag
                $skillInfo[2]=$data1&0x0000FFFF; // skill
                $skillInfo[3]=$data1>>16;        // max skill
                $skillInfo[4]=$data2&0x0000FFFF; // pos buff
                $skillInfo[5]=$data2>>16;        // neg buff
                break;
            }
        }
        return $skillInfo;
    }
    
    /**
     * Generates cache ID (md5 hash)
     * @category Utils class
     * @access   public
     * @param    string $page
     * @param    int $att1 = 0
     * @param    int $att2 = 0
     * @param    int $att3 = 0
     * @return   string
     **/
    public function GenerateCacheId($page, $att1 = 0, $att2 = 0, $att3 = 0) {
        return md5($page.':'.ARMORY_REVISION.':'.$att1.':'.$att2.':'.$att3.':'.$this->armory->GetLocale());
    }
    
    /**
     * Loads cache by $file_id hash (md5).
     * @category Utils class
     * @access   public
     * @param    string $file_id
     * @param    string $file_dir = 'characters'
     * @return   string
     **/
    public function GetCache($file_id, $file_dir = 'characters') {
        if($this->armory->armoryconfig['useCache'] != true) {
            return false;
        }
        $cache_path = sprintf('cache/%s/%s.cache', $file_dir, $file_id);
        $data_path = sprintf('cache/%s/%s.data', $file_dir, $file_id);
        if(file_exists($data_path)) {
            $data_contents = @file_get_contents($data_path);
            $data_explode = explode(':', $data_contents);
            if(!is_array($data_explode)) {
                $this->armory->Log()->writeError('%s : wrong cache data!', __METHOD__);
                return false;
            }
            $cache_timestamp = $data_explode[0];
            $cache_revision  = $data_explode[1];
            $name_or_itemid  = $data_explode[2];
            $character_guid  = $data_explode[3];
            $cache_locale    = $data_explode[4];
            $file_expire = $cache_timestamp + $this->armory->armoryconfig['cache_lifetime'];
            if($file_expire < time() || $cache_revision != ARMORY_REVISION) {
                self::DeleteCache($file_id, $file_dir); // Remove old cache
                return false;
            }
            else {
                if(file_exists($cache_path)) {
                    $cache_contents = @file_get_contents($cache_path);
                    if($cache_contents != null) {
                        return $cache_contents;
                    }
                    else {
                        self::DeleteCache($file_id, $file_dir); // Remove old cache
                    }
                }
            }
        }
        return false;
    }
    
    /**
     * Delete cache by $file_id hash (md5) from $file_dir directory.
     * @category Utils class
     * @access   private
     * @param    string $file_id
     * @param    string $file_dir
     * @return   bool
     **/
    private function DeleteCache($file_id, $file_dir) {
        $data_path  = sprintf('cache/%s/%s.data', $file_dir, $file_id);
        $cache_path = sprintf('cache/%s/%s.cache', $file_dir, $file_id);
        if(file_exists($data_path)) {
            @unlink($data_path);
        }
        if(file_exists($cache_path)) {
            @unlink($cache_path);
        }
        return;
    }
    
    /**
     * Write data to cache.
     * @category Utils class
     * @access   public
     * @param    string $file_id
     * @param    string $filedata
     * @param    string $filecontents
     * @param    string $filedir = 'characters'
     * @return   bool
     **/
    public function WriteCache($file_id, $filedata, $filecontents, $filedir = 'characters') {
        if($this->armory->armoryconfig['useCache'] != true) {
            return false;
        }
        $data_path  = sprintf('cache/%s/%s.data', $filedir, $file_id);
        $cache_path = sprintf('cache/%s/%s.cache', $filedir, $file_id);
        $error_message = null;
        $cacheData = @fopen($data_path, 'w+');
        if(!@fwrite($cacheData, $filedata)) {
            $this->armory->Log()->writeError('%s : unable to write %s.data', __METHOD__, $file_id);
        }
        @fclose($cacheData);
        $cacheCache = @fopen($cache_path, 'w+');
        if(!@fwrite($cacheCache, $filecontents)) {
            $this->armory->Log()->writeError('%s : unable to write %s.cache', __METHOD__, $file_id);
        }
        @fclose($cacheCache);
        return 0x01;
    }
    
    /**
     * Generates cache data (creation date, revisions, etc.).
     * @category Utils class
     * @access   public
     * @param    string $nameOrItemID
     * @param    int $charGuid
     * @param    $page = null
     * @return   string
     **/
    public function GenerateCacheData($nameOrItemID, $charGuid, $page = null) {
        return sprintf('%d:%d:%s:%d:%s:%s', time(), ARMORY_REVISION, $nameOrItemID, $charGuid, $page, $this->armory->GetLocale());
    }
    
    /**
     * Replace special symbols in $text.
     * @category Utils class
     * @access   public
     * @param    string $text.
     * @return   string
     **/
    public function ValidateSpellText($text) {
        $letter = array("'",'"'     ,"<"   ,">"   ,">"   ,"\r","\n"  , "\n"    , "\n"   );
        $values = array("`",'&quot;',"&lt;","&gt;","&gt;",""  ,"<br>", "<br />", "<br/>");
        return str_replace($letter, $values, $text);
    }
    
    /**
     * Converts seconds to day/hour/minutes format.
     * @category Utils class
     * @access   public
     * @param    int $seconds
     * @return   string
     **/
    public function GetTimeText($seconds) {
        $strings_array = array(
            'en_gb' => array(
                'days', 'hours', 'min', 'sec'
            ),
            'ru_ru' => array(
                'дней', 'часов', 'мин', 'сек'
            )
        );
        if($this->armory->GetLocale() == 'en_gb' || $this->armory->GetLocale() == 'ru_ru') {
            $preferLocale = $strings_array[$this->armory->GetLocale()];
        }
        else {
            $preferLocale = $strings_array['en_gb'];
        }
        $text = null;
        if($seconds >=24*3600) {
            $text .= intval($seconds / (24 * 3600)) . ' ' . $preferLocale[0];
            if($seconds %= 24 * 3600) {
                $text .= ' ';
            }
        }
        if($seconds >= 3600) {
            $text .= intval($seconds / 3600) . ' ' . $preferLocale[1];
            if($seconds %= 3600) {
                $text .= ' ';
            }
        }
        if($seconds >= 60) {
            $text .= intval($seconds / 60).' ' . $preferLocale[2];
            if($seconds %= 60) {
                $text .= ' ';
            }
        }
        if($seconds > 0) {
            $text .= $seconds.' '.  $preferLocale[3];
        }
        return $text;
    }
    
    /**
     * Returns spell radius.
     * @category Utils class
     * @access   public
     * @param    int $index
     * @return   string
     **/
    public function GetRadius($index) {
        $gSpellRadiusIndex = array(
             '7' => array(2,0,2),
             '8' => array(5,0,5),
             '9' => array(20,0,20),
            '10' => array(30,0,30),
            '11' => array(45,0,45),
            '12' => array(100,0,100),
            '13' => array(10,0,10),
            '14' => array(8,0,8),
            '15' => array(3,0,3),
            '16' => array(1,0,1),
            '17' => array(13,0,13),
            '18' => array(15,0,15),
            '19' => array(18,0,18),
            '20' => array(25,0,25),
            '21' => array(35,0,35),
            '22' => array(200,0,200),
            '23' => array(40,0,40),
            '24' => array(65,0,65),
            '25' => array(70,0,70),
            '26' => array(4,0,4),
            '27' => array(50,0,50),
            '28' => array(50000,0,50000),
            '29' => array(6,0,6),
            '30' => array(500,0,500),
            '31' => array(80,0,80),
            '32' => array(12,0,12),
            '33' => array(99,0,99),
            '35' => array(55,0,55),
            '36' => array(0,0,0),
            '37' => array(7,0,7),
            '38' => array(21,0,21),
            '39' => array(34,0,34),
            '40' => array(9,0,9),
            '41' => array(150,0,150),
            '42' => array(11,0,11),
            '43' => array(16,0,16),
            '44' => array(0.5,0,0.5),
            '45' => array(10,0,10),
            '46' => array(5,0,10),
            '47' => array(15,0,15),
            '48' => array(60,0,60),
            '49' => array(90,0,90)
        );
        if(!isset($gSpellRadiusIndex[$index])) {
            return false;
        }
        $radius = @$gSpellRadiusIndex[$index];
        if($radius == 0) {
            return false;
        }
        if($radius[0] == 0 || $radius[0] == $radius[2]) {
            return $radius[2];
        }
        return $radius[0] . ' - ' . $radius[2];
    }
    
    /**
     * Returns string with ID #$id for $this->armory->GetLocale() locale from DB
     * @category Utils class
     * @access   public
     * @param    mixed $id
     * @return   string
     **/
    public function GetArmoryString($id) {
        if(is_array($id)) {
            return $this->armory->aDB->selectCell("SELECT `string_%s` FROM `ARMORYDBPREFIX_string` WHERE `id` IN (%s)", $this->armory->GetLocale(), $id);
        }
        return $this->armory->aDB->selectCell("SELECT `string_%s` FROM `ARMORYDBPREFIX_string` WHERE `id`=%d", $this->armory->GetLocale(), $id);
    }
    
    /**
     * Returns player class ID (by class name)
     * @category Utils class
     * @access   public
     * @param    string $class_string
     * @return   int
     **/
    public function GetClassId($class_string) {
        switch(strtolower($class_string)) {
            case 'death knight':
                return CLASS_DK;
                break;
            case 'druid':
                return CLASS_DRUID;
                break;
            case 'hunter':
                return CLASS_HUNTER;
                break;
            case 'mage':
                return CLASS_MAGE;
                break;
            case 'paladin':
                return CLASS_PALADIN;
                break;
            case 'priest':
                return CLASS_PRIEST;
                break;
            case 'rogue':
                return CLASS_ROGUE;
                break;
            case 'shaman':
                return CLASS_SHAMAN;
                break;
            case 'warlock':
                return CLASS_WARLOCK;
                break;
            case 'warrior':
                return CLASS_WARRIOR;
                break;
            default:
                return CLASS_DK; // Death Knight is default class for talent calc
                break;
        }
    }
    
    /**
     * Returns instance ID from DB
     * @category Utils class
     * @access   public
     * @param    string $instance_key
     * @return   array
     **/
    public function GetDungeonId($instance_key) {
        return $this->armory->aDB->selectCell("SELECT `id` FROM `ARMORYDBPREFIX_instance_template` WHERE `key`='%s' LIMIT 1", $instance_key);
    }
    
    /**
     * Returns dungeon data
     * @category Utils class
     * @access   public
     * @param    string $instance_key
     * @return   array
     **/
    public function GetDungeonData($instance_key) {
        return $this->armory->aDB->selectRow("SELECT `id`, `name_%s` AS `name`, `is_heroic`, `key`, `difficulty` FROM `ARMORYDBPREFIX_instance_template` WHERE `key`='%s'", $this->armory->GetLocale(), $instance_key);
    }
    
    /**
     * Returns pet data for pet talent calculator
     * @category Utils class
     * @access   public
     * @param    string $key
     * @return   array
     **/
    public function GetPetTalentCalculatorData($key) {
        switch(strtolower($key)) {
            case 'ferocity':
            case 'tenacity':
            case 'cunning':
                return $this->armory->aDB->select("SELECT `catId`, `icon`, `id`, `name_%s` AS `name` FROM `ARMORYDBPREFIX_petcalc` WHERE `key`='%s' AND `catId` >= 0", $this->armory->GetLocale(), strtolower($key));
                break;
        }
    }
    
    /**
     * Checks for correct realm name
     * @category Utils class
     * @access   public
     * @param    string $rName
     * @return   int
     **/
    public function IsRealm($rName) {
        $realmId = $this->armory->aDB->selectCell("SELECT `id` FROM `ARMORYDBPREFIX_realm_data` WHERE `name`='%s'", $rName);
        if($realmId > 0) {
            return $realmId;
        }
        $this->armory->Log()->writeError('%s : unable to find id for realm %s (armory_realm_data)', __METHOD__, $rName);
        return false;
    }
    
    /**
     * Returns realm ID from DB
     * @category Utils class
     * @access   public
     * @param    string $rName
     * @return   array
     **/
    public function GetRealmIdByName($rName) {
        if($realms = explode(',', $rName)) {
            $rName = $realms[0];
        }
        return self::IsRealm($rName);
    }
    
    /**
     * Returns model data for race $raceId from DB (model Viewer)
     * @category Utils class
     * @access   public
     * @param    int $raceId
     * @return   array
     **/
    public function RaceModelData($raceId) {
        return $this->armory->aDB->selectRow("SELECT `modeldata_1`, `modeldata_2` FROM `ARMORYDBPREFIX_races` WHERE `id`=%d", $raceId);
    }
    
    /**
     * Returns faction ID for $raceID
     * @category Utils class
     * @access   public
     * @param    int $raceID
     * @return   int
     **/
    public function GetFactionId($raceID) {
        // Get player factionID
        $horde_races    = array(RACE_ORC,     RACE_TROLL, RACE_TAUREN, RACE_UNDEAD, RACE_BLOODELF);
        $alliance_races = array(RACE_DRAENEI, RACE_DWARF, RACE_GNOME,  RACE_HUMAN,  RACE_NIGHTELF);
        if(in_array($raceID, $horde_races)) {
            return FACTION_HORDE;
        }
        elseif(in_array($raceID, $alliance_races)) {
            return FACTION_ALLIANCE;
        }
        else {
            // Unknown race
            $this->armory->Log()->writeError('%s : unknown race: %d', __METHOD__, $raceID);
            return false;
        }
    }
    
    /**
     * Returns array with latest news.
     * To add new item, you need to execute simple query to armory DB:
     * ===========
     * INSERT INTO `armory_news`
     * (`date`,              `title_en_gb`, `title_*`,           `text_en_gb`, `text_*` `display`) 
     * VALUES
     * (UNIXTIMESTAMP_HERE, 'Title (ENGB)', 'Title (ANY Locale)', 'Text ENGB', 'Text (ANY Locale)', 1);
     * ==========
     * See SQL update for 240 rev. (sql/updates/armory_r240_armory_news.sql) for example news.
     * @category Utils class
     * @access   public
     * @param    bool $feed = false
     * @return   array
     **/
    public function GetArmoryNews($feed = false) {
        $news = $this->armory->aDB->select("SELECT `id`, `date`, `title_en_gb` AS `titleOriginal`, `title_%s` AS `titleLoc`, `text_en_gb` AS `textOriginal`, `text_%s` AS `textLoc` FROM `ARMORYDBPREFIX_news` WHERE `display`=1 ORDER BY `date` DESC", $this->armory->GetLocale(), $this->armory->GetLocale());
        if(!$news) {
            return false;
        }
        $allNews = array();
        $i = 0;
        foreach($news as $new) {
            $allNews[$i] = array();
            if($feed == true) {
                $allNews[$i]['date'] = date('d m Y', $new['date']);
            }
            else {
                $allNews[$i]['posted'] = date('Y-m-d\TH:i:s\Z', $new['date']);
            }
            if(!isset($new['titleLoc']) || empty($new['titleLoc'])) {
                $allNews[$i]['title'] = (!empty($new['titleOriginal'])) ? $new['titleOriginal'] : null;
            }
            else {
                $allNews[$i]['title'] = (!empty($new['titleLoc'])) ? $new['titleLoc'] : null;
            }
            if(!isset($new['textLoc']) || empty($new['textLoc'])) {
                $allNews[$i]['text'] = (!empty($new['textOriginal'])) ? $new['textOriginal'] : null;
            }
            else {
                $allNews[$i]['text'] = (!empty($new['textLoc'])) ? $new['textLoc'] : null;
            }
            $allNews[$i]['key'] = $i;
            $i++;
        }
        if($allNews) {
            return $allNews;
        }
        return false;
    }
    
    /**
     * Checks for active session & cookie for dual items tooltips
     * @category Utils class
     * @access   public
     * @return   bool
     **/
    public function IsItemComparisonAllowed() {
        if(isset($_SESSION['accountId']) && isset($_COOKIE['armory_cookieDualTooltip']) && $_COOKIE['armory_cookieDualTooltip'] == 1) {
            return true;
        }
        else {
            return false;
        }
    }
    
    /**
     * Checks all realms for correct configs (in configuration.php and `armory_realm_data` table)
     * and inserts data to DB if something missing.
     * @category Utils class
     * @access   public
     * @return   bool
     **/
    public function CheckConfigRealmData() {
        if(!$this->armory->realmData || !is_array($this->armory->realmData) || !isset($this->armory->realmData[1])) {
            $this->armory->Log()->writeError('%s : unable to detect correct multiRealm config. Please, make sure that you have read INSTALL file and have configured Armory correctly.', __METHOD__);
            return false;
        }
        $allIds = array();
        foreach($this->armory->realmData as $myRealm) {
            $tmpData = $this->armory->aDB->selectRow("SELECT `id`, `name`, `type` FROM `ARMORYDBPREFIX_realm_data` WHERE `name`='%s' LIMIT 1", $myRealm['name']);
            if((!$tmpData || !is_array($tmpData)) || ($tmpData['id'] != $myRealm['id'] || $tmpData['name'] != $myRealm['name'] || $tmpData['type'] == UNK_SERVER)) {
                $replace = $this->armory->aDB->query("REPLACE INTO `armory_realm_data` (`id`, `name`, `type`) VALUES (%d, '%s', %d)", $myRealm['id'], $myRealm['name'], self::GetServerTypeByString($myRealm['type']));
                if($replace) {
                    $this->armory->Log()->writeLog('%s : realm data for realm "%s" was successfully added to `armory_realm_data` table.', __METHOD__, $myRealm['name']);
                }
                else {
                    $this->armory->Log()->writeError('%s : realm data for realm "%s" was not added to `%s_realm_data` table. Please, execute this query manually: "REPLACE INTO `%s_realm_data` (`id`, `name`, `type`) VALUES (%d, \'%s\', %d);"', __METHOD__, $myRealm['name'], $this->armory->armoryconfig['db_prefix'], $this->armory->armoryconfig['db_prefix'], $myRealm['id'], $myRealm['name'], self::GetServerTypeByString($myRealm['type']));
                }
            }
            $allIds[] = $myRealm['id'];
        }
        // Drop wrong realms from armory_realm_data table
        $this->armory->aDB->query("DELETE FROM `ARMORYDBPREFIX_realm_data` WHERE `id` NOT IN (%s)", $allIds);
        return true;
    }
    
    /**
     * Returns true if script should use XMLWriter::WriteRaw() instead of special methods.
     * Required for fr/de/es locales.
     * @category Utils class
     * @access   public
     * @retunr   bool
     **/
    public function IsWriteRaw() {
        if($this->armory->GetLocale() == 'en_gb' || $this->armory->GetLocale() == 'en_us' || $this->armory->GetLocale() == 'ru_ru') {
            return false;
        }
        return true;
    }
    
    /**
     * Checks $_GET variable for multiply realms/names in it (for achievement/statistics comparison).
     * @category Utils class
     * @access   public
     * @param    bool $returnFirstRealmName = false
     * @return   mixed
     **/
    public function IsAchievementsComparison($returnFirstRealmName = false) {
        if(!isset($_GET['r']) || (!isset($_GET['cn']) && !isset($_GET['n']))) {
            return false;
        }
        $realms = explode(',', $_GET['r']);
        if(isset($_GET['n'])) {
            $chars = explode(',', $_GET['n']);
        }
        elseif(isset($_GET['cn'])) {
            $chars = explode(',', $_GET['cn']);
        }
        if(!is_array($realms) || !is_array($chars)) {
            return false;
        }
        $countR = count($realms);
        $countC = count($chars);
        if($countC == 1 && $countR == 1) {
            // Only one character, there's nothing to do.
            return false;
        }
        $totalCount = 0;
        if($countC == $countR) {
            $totalCount = $countC;
        }
        else {
            $this->armory->Log()->writeError('%s : realms and characters counters are not equal (realms: %d, chars: %d, total: %d)!', __METHOD__, $countR, $countC, $totalCount);
            return false;
        }
        $data = array();
        for($i = 0; $i < $totalCount; $i++) {
            if(!isset($realms[$i]) || !isset($chars[$i])) {
                $this->armory->Log()->writeError('%s : data check for loop %d was failed, ignore.', __METHOD__, $i);
                continue;
            }
            $data[$i] = array('name' => $chars[$i], 'realm' => $realms[$i]);
        }
        if($returnFirstRealmName == true) {
            return array(0 => array('name' => $chars[0], 'realm' => $realms[0]), 1 => array('name' => $chars[1], 'realm' => $realms[1]));
        }
        return $data;
    }
    
    /**
     * Returns bit mask for class ID
     * @category Utils class
     * @access   public
     * @param    int $classId
     * @return   int
     **/
    public function GetClassBitMaskByClassId($classId) {
        $mask = 0;
        switch($classId) {
            case CLASS_WARRIOR:
                $mask = 1;
                break;
            case CLASS_PALADIN:
                $mask = 2;
                break;
            case CLASS_HUNTER:
                $mask = 4;
                break;
            case CLASS_ROGUE:
                $mask = 8;
                break;
            case CLASS_PRIEST:
                $mask = 16;
                break;
            case CLASS_DK:
                $mask = 32;
                break;
            case CLASS_SHAMAN:
                $mask = 64;
                break;
            case CLASS_MAGE:
                $mask = 128;
                break;
            case CLASS_WARLOCK:
                $mask = 256;
                break;
            case CLASS_DRUID:
                $mask = 1024;
                break;
        }
        return $mask;
    }
    
    /**
     * Returns bit mask for race ID
     * @category Utils class
     * @access   public
     * @param    int $raceId
     * @return   int
     **/
    public function GetRaceBitMaskByRaceId($raceId) {
        $mask = 0;
        switch($raceId) {
            case RACE_HUMAN:
                $mask = 1;
                break;
            case RACE_ORC:
                $mask = 2;
                break;
            case RACE_DWARF:
                $mask = 4;
                break;
            case RACE_NIGHTELF:
                $mask = 8;
                break;
            case RACE_UNDEAD:
                $mask = 16;
                break;
            case RACE_TAUREN:
                $mask = 32;
                break;
            case RACE_GNOME:
                $mask = 64;
                break;
            case RACE_TROLL:
                $mask = 128;
                break;
            case RACE_BLOODELF:
                $mask = 512;
                break;
            case RACE_DRAENEI:
                $mask = 1024;
                break;
        }
        return $mask;
    }
    
    /**
     * Returns realm type for provided $realm_id.
     * Warning: if detection fails, realm with provided ID will be deleted from allowed realms!
     * @category Utils class
     * @access   public
     * @param    int $realm_id
     * @return   mixed
     **/
    public function GetRealmType($realm_id) {
        if(!isset($this->armory->realmData[$realm_id]) || !isset($this->armory->realmData[$realm_id]['name_world'])) {
            $this->armory->Log()->writeError('%s : unable to detect realm type: world database config not found', __METHOD__);
            return false;
        }
        $realm_info = $this->armory->realmData[$realm_id];
        $db = new ArmoryDatabaseHandler($realm_info['host_world'], $realm_info['user_world'], $realm_info['pass_world'], $realm_info['name_world'], $realm_info['charset_world'], $this->armory->Log());
        if(!$db->TestLink()) {
            $this->armory->Log()->writeError('%s : unable to connect to MySQL database ("%s":"%s":"%s":"%s")', __METHOD__, $realm_info['host_world'], str_replace(substr($realm_info['user_world'], 2, 3), '***', $realm_info['user_world']), str_replace(substr($realm_info['pass_world'], 2, 3), '***', $realm_info['pass_world']), $realm_info['name_world']);
            return false;
        }
        if($tmp = $db->selectCell("SELECT 1 FROM `mangos_string` LIMIT 1")) {
            return 'mangos';
        }
        elseif($tmp = $db->selectCell("SELECT 1 FROM `trinity_string` LIMIT 1")) {
            return 'trinity';
        }
        $this->armory->Log()->writeError('%s : unable to detect realm type, realm info with ID #%d was removed from allowed realms', __METHOD__, $realm_id);
        unset($realm_id, $realm_info, $this->armory->realmData[$realm_id], $db);
        return false;
    }
    
    /**
     * Generate cache ID (md5 hash) for comparison cases (achievements/statistics).
     * @category Utils class
     * @access   public
     * @param    array $comparison_data
     * @return   string
     **/
    public function GenerateCacheIdForComparisons($comparison_data) {
        $characters = '';
        foreach($comparison_data as $char) {
            $characters .= $char['name'].'_'.$char['realm'];
        }
        return md5($characters);
    }
    
    /**
     * Returns server type ID
     * @category Utils class
     * @access   public
     * @param    string $server
     * @return   int
     **/
    public function GetServerTypeByString($server) {
        $server = strtolower($server);
        if($server == 'mangos') {
            return SERVER_MANGOS;
        }
        elseif($server == 'trinity') {
            return SERVER_TRINITY;
        }
        $this->armory->Log()->writeError('%s : unsupported server type ("%s")!', __METHOD__, $server);
        return UNK_SERVER;
    }
    
    /**
     * Return slot name by slot ID
     * @category Utils class
     * @access   public
     * @param    int $slotId
     * @return   string
     **/
    public function GetItemSlotTextBySlotId($slotId) {
        $slots_info = array(
            INV_HEAD => 'head',
            INV_NECK => 'neck',
            INV_SHOULDER => 'shoulder',
            INV_SHIRT => 'shirt',
            INV_CHEST => 'chest',
            INV_BELT => 'belt',
            INV_LEGS => 'legs',
            INV_BOOTS => 'boots',
            INV_BRACERS => 'wrist',
            INV_GLOVES => 'gloves',
            INV_RING_1 => 'ring1',
            INV_RING_2 => 'ring2',
            INV_TRINKET_1 => 'trinket1',
            INV_TRINKET_2 => 'trinket2',
            INV_BACK => 'back',
            INV_MAIN_HAND => 'mainhand',
            INV_OFF_HAND => 'offhand',
            INV_RANGED_RELIC => 'relic',
            INV_TABARD => 'tabard'
        );
        return (isset($slots_info[$slotId])) ? $slots_info[$slotId] : null;
    }
    
    /**
     * Return slot name by inventory type
     * @category Utils class
     * @access   public
     * @param    int $invType
     * @return   string
     **/
    public function GetItemSlotTextByInvType($invType) {
        $slots_info = array (
        	1  => 'head',
            2  => 'neck',
            3  => 'shoulder',
            4  => 'shirt',
            5  => 'chest', 
            6  => 'belt', 
            7  => 'legs', 
            8  => 'boots',
            9  => 'wrist',
            10 => 'gloves',
            11 => 'ring1',
            12 => 'trinket1',
            13 => 'mainhand',
            14 => 'offhand',
            15 => 'relic',
            16 => 'back', 
            17 => 'stave',
            19 => 'tabard',
            20 => 'chest',
            21 => 'mainhand',
            22 => null,
            23 => 'offhand',
            24 => null,
            25 => 'thrown',
            26 => 'gun',
            28 => 'relic'
        );
        return (isset($slots_info[$invType])) ? $slots_info[$invType] : null;
    }
    
    /**
     * Checks and fills missed and required $_GET variables.
     * @category Utils class
     * @access   public
     * @return   bool 
     **/
    public function CheckVariablesForPage() {
        $pageStr = $_SERVER['PHP_SELF'];
        $pageArr = explode('/', $pageStr);
        $pageId  = $pageArr[count($pageArr)-1];
        $pageId  = str_replace('.php', null, $pageId);
        switch($pageId) {
            case 'character-achievements':
            case 'character-arenateams':
            case 'character-calendar':
            case 'character-feed-data':
            case 'character-feed':
            case 'character-model-embed':
            case 'character-model':
            case 'character-reputation':
            case 'character-sheet':
            case 'character-statistics':
            case 'character-talents':
                if(!isset($_GET['r'])) {
                    $_GET['r'] = null;
                }
                if(!isset($_GET['cn'])) {
                    $_GET['cn'] = null;
                }
                break;
            case 'arena-game':
                if(!isset($_GET['gid'])) {
                    $_GET['gid'] = 0;
                }
                break;
            case 'guild-bank-contents':
            case 'guild-bank-log':
            case 'guild-info':
            case 'guild-stats':
                if(!isset($_GET['r'])) {
                    $_GET['r'] = null;
                }
                if(!isset($_GET['gn'])) {
                    $_GET['gn'] = null;
                }
                break;
            default:
                return true;
                break;
        }
        return true;
    }
    
    public function GetAllowableArmorTypesForClass($class, $search = false) {
        $allowable_armor_types = null;
        switch($class) {
            case CLASS_PRIEST:
            case CLASS_MAGE:
            case CLASS_WARLOCK:
                $allowable_armor_types = ITEM_SUBCLASS_ARMOR_CLOTH;
                break;
            case CLASS_ROGUE:
            case CLASS_DRUID:
                $allowable_armor_types = $search ? ITEM_SUBCLASS_ARMOR_LEATHER : ITEM_SUBCLASS_ARMOR_CLOTH . ', ' . ITEM_SUBCLASS_ARMOR_LEATHER;
                break;
            case CLASS_HUNTER:
            case CLASS_SHAMAN:
                $allowable_armor_types = $search ? ITEM_SUBCLASS_ARMOR_MAIL : ITEM_SUBCLASS_ARMOR_CLOTH . ', ' . ITEM_SUBCLASS_ARMOR_LEATHER . ', ' . ITEM_SUBCLASS_ARMOR_MAIL;
                break;
            default:
                $allowable_armor_types = $search ? ITEM_SUBCLASS_ARMOR_PLATE : ITEM_SUBCLASS_ARMOR_CLOTH . ', ' . ITEM_SUBCLASS_ARMOR_LEATHER . ', ' . ITEM_SUBCLASS_ARMOR_MAIL . ', ' . ITEM_SUBCLASS_ARMOR_PLATE;
                break;
        }
        return $allowable_armor_types;
    }
    
    public function GetAllowableWeaponTypesForClass($class, $search = false) {
        $allowable_weapon_types = null;
        switch($class) {
            case CLASS_WARRIOR:
                $allowable_weapon_types = sprintf("%d, %d, %d, %d, %d, %d, %d, %d, %d, %d, %d, %d, %d, %d", ITEM_SUBCLASS_WEAPON_BOW, ITEM_SUBCLASS_WEAPON_CROSSBOW, ITEM_SUBCLASS_WEAPON_DAGGER, ITEM_SUBCLASS_WEAPON_FIST, ITEM_SUBCLASS_WEAPON_GUN, ITEM_SUBCLASS_WEAPON_AXE, ITEM_SUBCLASS_WEAPON_MACE, ITEM_SUBCLASS_WEAPON_SWORD, ITEM_SUBCLASS_WEAPON_POLEARM, ITEM_SUBCLASS_WEAPON_STAFF, ITEM_SUBCLASS_WEAPON_THROWN, ITEM_SUBCLASS_WEAPON_AXE2, ITEM_SUBCLASS_WEAPON_MACE2, ITEM_SUBCLASS_WEAPON_SWORD2);
                break;
            case CLASS_PALADIN:
                $allowable_weapon_types = sprintf("%d, %d, %d, %d, %d, %d, %d", ITEM_SUBCLASS_WEAPON_AXE, ITEM_SUBCLASS_WEAPON_AXE2, ITEM_SUBCLASS_WEAPON_SWORD, ITEM_SUBCLASS_WEAPON_SWORD2, ITEM_SUBCLASS_WEAPON_MACE, ITEM_SUBCLASS_WEAPON_MACE2, ITEM_SUBCLASS_WEAPON_POLEARM);
                break;
            case CLASS_HUNTER:
                $allowable_weapon_types = sprintf("%d, %d, %d, %d, %d, %d, %d, %d, %d, %d, %d, %d", ITEM_SUBCLASS_WEAPON_AXE2, ITEM_SUBCLASS_WEAPON_SWORD2, ITEM_SUBCLASS_WEAPON_THROWN, ITEM_SUBCLASS_WEAPON_STAFF, ITEM_SUBCLASS_WEAPON_POLEARM, ITEM_SUBCLASS_WEAPON_SWORD, ITEM_SUBCLASS_WEAPON_AXE, ITEM_SUBCLASS_WEAPON_GUN, ITEM_SUBCLASS_WEAPON_FIST, ITEM_SUBCLASS_WEAPON_BOW, ITEM_SUBCLASS_WEAPON_CROSSBOW);
                break;
            case CLASS_ROGUE:
                $allowable_weapon_types = sprintf("%d, %d, %d, %d, %d, %d, %d, %d", ITEM_SUBCLASS_WEAPON_BOW, ITEM_SUBCLASS_WEAPON_CROSSBOW, ITEM_SUBCLASS_WEAPON_DAGGER, ITEM_SUBCLASS_WEAPON_FIST, ITEM_SUBCLASS_WEAPON_GUN, ITEM_SUBCLASS_WEAPON_AXE, ITEM_SUBCLASS_WEAPON_SWORD, ITEM_SUBCLASS_WEAPON_THROWN);
                break;
            case CLASS_PRIEST:
                $allowable_weapon_types = sprintf("%d, %d, %d, %d", ITEM_SUBCLASS_WEAPON_MACE2, ITEM_SUBCLASS_WEAPON_DAGGER, ITEM_SUBCLASS_WEAPON_STAFF, ITEM_SUBCLASS_WEAPON_WAND);
                break;
            case CLASS_DK:
                $allowable_weapon_types = sprintf("%d, %d, %d, %d, %d, %d, %d", ITEM_SUBCLASS_WEAPON_AXE, ITEM_SUBCLASS_WEAPON_MACE, ITEM_SUBCLASS_WEAPON_SWORD, ITEM_SUBCLASS_WEAPON_AXE2, ITEM_SUBCLASS_WEAPON_MACE2, ITEM_SUBCLASS_WEAPON_SWORD2, ITEM_SUBCLASS_WEAPON_POLEARM);
                break;
            case CLASS_SHAMAN:
                $allowable_weapon_types = sprintf("%d, %d, %d, %d, %d, %d, %d", ITEM_SUBCLASS_WEAPON_DAGGER, ITEM_SUBCLASS_WEAPON_FIST, ITEM_SUBCLASS_WEAPON_AXE, ITEM_SUBCLASS_WEAPON_MACE, ITEM_SUBCLASS_WEAPON_STAFF, ITEM_SUBCLASS_WEAPON_AXE2, ITEM_SUBCLASS_WEAPON_MACE2);
                break;
            case CLASS_MAGE:
            case CLASS_WARLOCK:
                $allowable_weapon_types = sprintf("%d, %d, %d, %d", ITEM_SUBCLASS_WEAPON_DAGGER, ITEM_SUBCLASS_WEAPON_SWORD, ITEM_SUBCLASS_WEAPON_WAND, ITEM_SUBCLASS_WEAPON_STAFF);
                break;
            case CLASS_DRUID:
                $allowable_weapon_types = sprintf("%d, %d, %d, %d, %d, %d", ITEM_SUBCLASS_WEAPON_DAGGER, ITEM_SUBCLASS_WEAPON_FIST, ITEM_SUBCLASS_WEAPON_MACE, ITEM_SUBCLASS_WEAPON_POLEARM, ITEM_SUBCLASS_WEAPON_STAFF, ITEM_SUBCLASS_WEAPON_MACE2);
                break;
            default:
                break;
        }
        return $allowable_weapon_types;
    }
}
?>