<?php

/**
 * @package World of Warcraft Armory
 * @version Release Candidate 1
 * @revision 241
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

Class Utils extends Connector {
    
    public $accountId;
    public $username;
    public $password;
    public $shaHash;
    
    public function timeMeasure() {
        list($msec, $sec) = explode(chr(32), microtime());
        return ($sec+$msec);
    }
    
    public function authUser() {
        if(!$this->username || !$this->password) {
            $this->Log()->writeError('%s : username or password not defined', __METHOD__);
            return false;
        }
        $info = $this->rDB->selectRow("SELECT `id`, `sha_pass_hash` FROM `account` WHERE `username`=? LIMIT 1", $this->username);
        if(!$info) {
            $this->Log()->writeError('%s : unable to get data from DB for account %s', __METHOD__, $this->username);
            return false;
        }
        elseif($info['sha_pass_hash'] != $this->createShaHash()) {
            $this->Log()->writeError('%s : sha_pass_hash and generated SHA1 hash are diffirent (%s and %s), unable to auth user.', __METHOD__, $info['sha_pass_hash'], $this->createShaHash());
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
    
    public function logoffUser() {
        unset($_SESSION['wow_login']);
        unset($_SESSION['username']);
        unset($_SESSION['accountId']);
        return true;
    }
    
    public function getCharsArray($select = false) {
        if(!isset($_SESSION['accountId'])) {
            $this->Log()->writeLog('%s : session not found', __METHOD__);
            return false;
        }
        if($select == true) {
            $chars = $this->aDB->select("SELECT `guid`, `name`, `class`, `race`, `gender`, `level` FROM `armory_login_characters` WHERE `account`=? AND `selected` <> 1 ORDER BY `num` ASC LIMIT 2", $_SESSION['accountId']);
            $chars[0]['show'] = true;
            $chars[1]['show'] = true;
        }
        else {
            $chars = $this->aDB->select("SELECT `guid`, `name`, `class`, `race`, `gender`, `level` FROM `armory_login_characters` WHERE `account`=? ORDER BY `num` ASC LIMIT 3", $_SESSION['accountId']);
        }
        // TODO: achievement points for each character
        return $chars;
    }
    
    public function IsAllowedToGuildBank($guildId, $realmId) {
        if(!isset($_SESSION['accountId'])) {
            $this->Log()->writeLog('%s : session not found', __METHOD__);
            return false;
        }
        if(!isset($this->realmData[$realmId])) {
            $this->Log()->writeError('%s : unable to find connection data for realm %d', __METHOD__, $realmId);
            return false;
        }
        $realm_info = $this->realmData[$realmId];
        $db = DbSimple_Generic::connect('mysql://'.$realm_info['user_characters'].':'.$realm_info['pass_characters'].'@'.$realm_info['host_characters'].'/'.$realm_info['name_characters']);
        if(!$db) {
            $this->Log()->writeError('%s : unable to connect to MySQL server (host: %s; user: %s; password: %s; db: %s)', __METHOD__, $realm_info['host_characters'], $realm_info['user_characters'], $realm_info['pass_characters'], $realm_info['name_characters']);
        }
        $db->query("SET NAMES ?", $realm_info['charset_characters']);
        $chars_data = $db->select("
        SELECT
        `characters`.`guid`,
        `guild_member`.`guildid` AS `guildId`
        FROM `characters` AS `characters`
        LEFT JOIN `guild_member` AS `guild_member` ON `guild_member`.`guid`=`characters`.`guid`
        WHERE `characters`.`account`=? AND `guild_member`.`guildid`=?", $_SESSION['accountId'], $guildId);
        if(!$chars_data) {
            $this->Log()->writeLog('%s : account %d does not have any character in %d guild on realm %d', __METHOD__, $_SESSION['accountId'], $guildId, $realmId);
            return false;
        }
        // Account have character in $guildId guild
        return true;
    }
    
    public function IsAccountHaveCurrentCharacter($guid, $realmId) {
        if(!isset($_SESSION['accountId'])) {
            $this->Log()->writeLog('%s : session not found', __METHOD__);
            return false;
        }
        if(!isset($this->realmData[$realmId])) {
            $this->Log()->writeError('%s : unable to find connection data for realm %d', __METHOD__, $realmId);
            return false;
        }
        $realm_info = $this->realmData[$realmId];
        $db = DbSimple_Generic::connect('mysql://'.$realm_info['user_characters'].':'.$realm_info['pass_characters'].'@'.$realm_info['host_characters'].'/'.$realm_info['name_characters']);
        if(!$db) {
            $this->Log()->writeError('%s : unable to connect to MySQL server (host: %s; user: %s; password: %s; db: %s)', __METHOD__, $realm_info['host_characters'], $realm_info['user_characters'], $realm_info['pass_characters'], $realm_info['name_characters']);
        }
        $db->query("SET NAMES ?", $realm_info['charset_characters']);
        $chars_data = $db->select("SELECT 1 FROM `characters` WHERE `account`=? AND `guid`=?", $_SESSION['accountId'], $guid);
        if(!$chars_data) {
            $this->Log()->writeLog('%s : user with account %d does not have character %d', __METHOD__, $_SESSION['accountId'], $guid);
            return false;
        }
        // Account $_SESSION['accountId'] have character $guid on $realmId realm
        return true;
    }
    
    public function CountSelectedCharacters() {
        if(!isset($_SESSION['accountId'])) {
            $this->Log()->writeLog('%s : session not found', __METHOD__);
            return false;
        }
        return $this->aDB->selectCell("SELECT COUNT(`guid`) FROM `armory_login_characters` WHERE `account`=?", $_SESSION['accountId']);
    }
    
    public function CountAllCharacters() {
        if(!isset($_SESSION['accountId'])) {
            $this->Log()->writeLog('%s : session not found', __METHOD__);
            return false;
        }
        $count_all = 0;
        foreach($this->realmData as $realm_info) {
            $db = DbSimple_Generic::connect('mysql://'.$realm_info['user_characters'].':'.$realm_info['pass_characters'].'@'.$realm_info['host_characters'].'/'.$realm_info['name_characters']);
            $current = $this->cDB->selectCell("SELECT COUNT(`guid`) FROM `characters` WHERE `account`=?", $_SESSION['accountId']);
            $count_all += $current;
        }
        unset($realm_info, $db);
        return $count_all;
    }
    
    public function GetAllCharacters() {
        if(!isset($_SESSION['accountId'])) {
            $this->Log()->writeLog('%s : session not found', __METHOD__);
            return false;
        }
        $results = array();
        foreach($this->realmData as $realm_info) {
            $db = DbSimple_Generic::connect('mysql://'.$realm_info['user_characters'].':'.$realm_info['pass_characters'].'@'.$realm_info['host_characters'].'/'.$realm_info['name_characters']);
            if(!$db) {
                $this->Log()->writeError('%s : unable to connect to MySQL server (host: %s; user: %s; password: %s; db: %s)', __METHOD__, $realm_info['host_characters'], $realm_info['user_characters'], $realm_info['pass_characters'], $realm_info['name_characters']);
                continue;
            }
            $db->query("SET NAMES UTF8");
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
            WHERE `characters`.`account`=?", $_SESSION['accountId']);
            if(!$chars_data) {
                $this->Log()->writeLog('%s : no characters found for account %d in `%s` database', __METHOD__, $_SESSION['accountId'], $realm_info['name_characters']);
                continue;
            }
            foreach($chars_data as $realm) {
                $realm['account'] = strtoupper($_SESSION['username']);
                $realm['factionId'] = Utils::GetFactionId($realm['raceId']);
                $realm['realm'] = $realm_info['name'];
                $realm['relevance'] = 100;
                if($realm['level'] < $this->armoryconfig['minlevel']) {
                    $realm['relevance'] = 0;
                }
                elseif($realm['level'] >= $this->armoryconfig['minlevel'] && $realm['level'] <= 79) {
                    $realm['relevance'] = $realm['level'];
                }
                elseif($realm['level'] == 80) {
                    $realm['relevance'] = 100;
                }
                else {
                    $realm['relevance'] = 0; // Unknown
                }
                $realm['url'] = sprintf('r=%s&cn=%s', urlencode($realm['realm']), urlencode($realm['name']));
                $realm['selected'] = $this->aDB->selectCell("SELECT `selected` FROM `armory_login_characters` WHERE `account`=?d AND `guid`=?d AND `realm_id`=?d LIMIT 1", $_SESSION['accountId'], $realm['guid'], $realm_info['id']);
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
        $this->Log()->writeLog('%s : unable to find any character for account %d', __METHOD__, $_SESSION['accountId']);
        return false;
    }
    
    public function getCharacter() {
        return;
    }
    
    public function loadRandomCharacter() {
        return;
    }
    
    public function GetBookmarks() {
        if(!isset($_SESSION['accountId'])) {
            $this->Log()->writeLog('%s : session not found', __METHOD__);
            return false;
        }
        // Bookmarks limit is 60
        $bookmarks_data = $this->aDB->select("SELECT `name`, `classId`, `level`, `realm`, `url` FROM `armory_bookmarks` WHERE `account`=?d LIMIT 60", $_SESSION['accountId']);
        if(!$bookmarks_data) {
            $this->Log()->writeLog('%s : bookmarks for account %d not found', __METHOD__, $_SESSION['accountId']);
            return false;
        }
        $result = array();
        foreach($bookmarks_data as $bookmark) {
            $realm = $this->aDB->selectRow("SELECT `id`, `name` FROM `armory_realm_data` WHERE `name`=?", $bookmark['realm']);
            if(!$realm) {
                continue;
            }
            elseif(!isset($this->realmData[$realm['id']])) {
                continue;
            }
            $realm_info = $this->realmData[$realm['id']];
            $db = DbSimple_Generic::connect('mysql://'.$realm_info['user_characters'].':'.$realm_info['pass_characters'].'@'.$realm_info['host_characters'].'/'.$realm_info['name_characters']);
            if(!$db) {
                continue;
            }
            $db->query("SET NAMES ?", $realm_info['charset_characters']);
            $guid = $db->selectCell("SELECT `guid` FROM `characters` WHERE `name`=?", $bookmark['name']);
            if(!$guid) {
                continue;
            }
            $bookmark['achPoints'] = $this->aDB->selectCell("SELECT SUM(`points`) FROM `armory_achievement` WHERE `id` IN (SELECT `achievement` FROM `" . $realm_info['name_characters'] . "`.`character_achievement` WHERE `guid`=?)", $guid);
            $result[] = $bookmark;
            unset($db, $realm_info, $achievement_ids, $guid, $realm);
        }
        return $result;
    }
    
    public function AddBookmark($name, $realmName) {
        if(!isset($_SESSION['accountId'])) {
            $this->Log()->writeLog('%s : session not found', __METHOD__);
            return false;
        }
        if($this->GetBookmarksCount() >= 60) {
            // Unable to store more than 60 bookmarks for single account
            return false;
        }
        $realm = $this->aDB->selectRow("SELECT `id`, `name` FROM `armory_realm_data` WHERE `name`=?", $realmName);
        if(!$realm) {
            return false;
        }
        elseif(!isset($this->realmData[$realm['id']])) {
            return false;
        }
        $realm_info = $this->realmData[$realm['id']];
        $db = DbSimple_Generic::connect('mysql://'.$realm_info['user_characters'].':'.$realm_info['pass_characters'].'@'.$realm_info['host_characters'].'/'.$realm_info['name_characters']);
        if(!$db) {
            return false;
        }
        $char_data = $db->selectRow("SELECT `name`, `class` AS `classId`, `level` FROM `characters` WHERE `name`=? LIMIT 1", $name);
        if(!$char_data) {
            return false;
        }
        $char_data['realmUrl'] = sprintf('r=%s&cn=%s', urlencode($realmName), urlencode($name));
        $query = sprintf("INSERT IGNORE INTO `armory_bookmarks` VALUES (%d, '%s', %d, %d, '%s', '%s')", $_SESSION['accountId'], $char_data['name'], $char_data['classId'], $char_data['level'], $realmName, $char_data['realmUrl']);
        $this->aDB->query($query);
        return true;
    }
    
    public function DeleteBookmark($name, $realmName) {
        if(!isset($_SESSION['accountId'])) {
            $this->Log()->writeLog('%s : session not found', __METHOD__);
            return false;
        }
        $query = sprintf("DELETE FROM `armory_bookmarks` WHERE `name`='%s' AND `realm`='%s' AND `account`='%d' LIMIT 1", $name, $realmName, $_SESSION['accountId']);
        $this->aDB->query($query);
        return true;
    }
    
    public function GetBookmarksCount() {
        if(!isset($_SESSION['accountId'])) {
            $this->Log()->writeLog('%s : session not found', __METHOD__);
            return false;
        }
        $count = $this->aDB->selectCell("SELECT COUNT(`name`) FROM `armory_bookmarks` WHERE `account`=?d", $_SESSION['accountId']);
        if($count > 60) {
            return 60;
        }
        return $count;
    }
    
    public function createShaHash() {
        if(!$this->username || !$this->password) {
            $this->Log()->writeError('%s : username or password not defined', __METHOD__);
            return false;
        }
        $this->shaHash = sha1(strtoupper($this->username).':'.strtoupper($this->password));
        return $this->shaHash;
    }
    
    public function ComputePetBonus($stat, $value, $unitClass) {
        $hunter_pet_bonus = array(0.22, 0.1287, 0.3, 0.4, 0.35, 0.0, 0.0, 0.0);
        $warlock_pet_bonus = array(0.0, 0.0, 0.3, 0.4, 0.35, 0.15, 0.57, 0.3);
        if($unitClass == CLASS_WARLOCK) {
            if($warlock_pet_bonus[$stat]) {
                return $value * $warlock_pet_bonus[$stat];
            }
            else {
                return 0;
            }
        }
        elseif($unitClass == CLASS_HUNTER) {
            if($hunter_pet_bonus[$stat]) {
                return $value * $hunter_pet_bonus[$stat];
            }
            else {
                return 0;
            }
        }
        return 0;
    }
    
    public function getFloatValue($value, $num) {
        $txt = unpack('f', pack('L', $value));
        return round($txt[1], $num);
    }
    
    public function GetRatingCoefficient($rating, $id) {
        $ratingkey = array_keys($rating);
        $c = $rating[$ratingkey[44+$id]];
        if($c == 0) {
            $c = 1;
        }
        return $c;
    }
    
    public function GetRating($level) {
        return $this->aDB->selectRow("SELECT * FROM `armory_rating` WHERE `level`=?", $level);
    }
    
    public function escape($string) {
        return !get_magic_quotes_gpc() ? addslashes($string) : $string;
    }
    
    public function getPercent($max, $min) {
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
    
    public function GetMaxArray($arr) {
        if(!is_array($arr)) {
            $this->Log()->writeError('%s : arr must be in array', __METHOD__);
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
    
    public function GetSpellBonusDamage($school, $guid) {
        $field_done_pos = PLAYER_FIELD_MOD_DAMAGE_DONE_POS+$school;
        $field_done_neg = PLAYER_FIELD_MOD_DAMAGE_DONE_NEG+$school;
        $field_done_pct = PLAYER_FIELD_MOD_DAMAGE_DONE_PCT+$school;
        $damage_done_pos = $this->cDB->selectCell("
        SELECT CAST(SUBSTRING_INDEX(SUBSTRING_INDEX(`data`, ' ', ".$field_done_pos."), ' ', '-1') AS UNSIGNED)
            FROM `armory_character_stats` 
                WHERE `guid`=?", $guid);
        $damage_done_neg = $this->cDB->selectCell("
		SELECT CAST(SUBSTRING_INDEX(SUBSTRING_INDEX(`data`, ' ', ".$field_done_neg."), ' ', '-1') AS UNSIGNED)
			FROM `armory_character_stats` 
				WHERE `guid`=?", $guid);
        $damage_done_pct = $this->cDB->selectCell("
		SELECT CAST(SUBSTRING_INDEX(SUBSTRING_INDEX(`data`, ' ', ".$field_done_pct."), ' ', '-1') AS UNSIGNED)
			FROM `armory_character_stats` 
				WHERE `guid`=?", $guid);
        $bonus = $damage_done_pos + $damage_done_neg;
        $bonus = $bonus*Utils::getFloatValue($damage_done_pct, 5);
        return $bonus;
    }
    
    /**
     * Returns array with Realm firsts achievements
     * @category Utils class
     * @example Utils::realmFirsts()
     * @todo Merge characters who earned same achievement (realm first boss kill) into one group
     * @return array
     **/
    public function realmFirsts() {
        $achievements_data = $this->cDB->select("
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
            $this->Log()->writeLog('%s : unable to get data from DB for achievement firsts (theres no completed achievement firsts?)', __METHOD__);
            return false;
        }
        $countAch = count($achievements_data);
        for($i=0;$i<$countAch;$i++) {
            $tmp_info = $this->aDB->selectRow("SELECT `name_".$this->_locale."` AS `name`, `description_".$this->_locale."` AS `desc`, `iconname` FROM `armory_achievement` WHERE `id`=? LIMIT 1", $achievements_data[$i]['achievement']);
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
            $tmp = $this->cDB->select("
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
            WHERE `character_achievement`.`achievement`=?
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
    
    public function GetCritChanceFromAgility($rating, $class, $agility) {
        $base = array(3.1891, 3.2685, -1.532, -0.295, 3.1765, 3.1890, 2.922, 3.454, 2.6222, 20, 7.4755);
        $ratingkey = array_keys($rating);
        return $base[$class-1] + $agility*$rating[$ratingkey[$class]]*100;
    }
    
    public function GetSpellCritChanceFromIntellect($rating, $class, $intellect) {
        $base = array(0, 3.3355, 3.602, 0, 1.2375, 0, 2.201, 0.9075, 1.7, 20, 1.8515);
        $ratingkey = array_keys($rating);
        return $base[$class-1] + $intellect*$rating[$ratingkey[11+$class]]*100;
    }
    
    public function GetHRCoefficient($rating, $class) {
        $ratingkey = array_keys($rating);
        $c = $rating[$ratingkey[22+$class]];if ($c==0) $c=1;
        return $c;
    }
    
    public function GetMRCoefficient($rating, $class) {
        $ratingkey = array_keys($rating);
        $c = $rating[$ratingkey[33+$class]];if ($c==0) $c=1;
        return $c;
    }
    
    public function getSkillFromItemID($id) {
        if($id == 0) {
            return SKILL_UNARMED;
        }
        $item = $this->wDB->selectRow("SELECT `class`, `subclass` FROM `item_template` WHERE `entry`=? LIMIT 1", $id);
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
    
    public function getSkill($id, $char_data) {
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
    
    public function GenerateCacheId($page, $att1=0, $att2=0, $att3=0) {
        return md5($page.':'.ARMORY_REVISION.':'.$att1.':'.$att2.':'.$att3.':'.$this->_locale);
    }
    
    public function GetCache($file_id, $file_dir = 'characters') {
        if($this->armoryconfig['useCache'] != true) {
            return false;
        }
        $cache_path = sprintf('cache/%s/%s.cache', $file_dir, $file_id);
        $data_path = sprintf('cache/%s/%s.data', $file_dir, $file_id);
        if(file_exists($data_path)) {
            $data_contents = @file_get_contents($data_path);
            $data_explode = explode(':', $data_contents);
            $cache_timestamp = $data_explode[0];
            $cache_revision  = $data_explode[1];
            $name_or_itemid  = $data_explode[2];
            $character_guid  = $data_explode[3];
            $cache_locale    = $data_explode[4];
            $file_expire = $cache_timestamp + $this->armoryconfig['cache_lifetime'];
            if($file_expire < time() || $cache_revision != ARMORY_REVISION) {
                self::DeleteCache($file_id, $file_dir); // Remove old cache
                return false;
            }
            else {
                if(file_exists($cache_path)) {
                    $cache_contents = @file_get_contents($cache_path);
                    if(sizeof($cache_contents) > 0x00) {
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
    
    public function DeleteCache($file_id, $file_dir) {
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
    
    public function WriteCache($file_id, $filedata, $filecontents, $filedir='characters') {
        if($this->armoryconfig['useCache'] != true) {
            return false;
        }
        $data_path  = sprintf('cache/%s/%s.data', $filedir, $file_id);
        $cache_path = sprintf('cache/%s/%s.cache', $filedir, $file_id);
        $error_message = null;
        $cacheData = @fopen($data_path, 'w+');
        if(!@fwrite($cacheData, $filedata)) {
            $this->Log()->writeError('%s : unable to write %s.data', __METHOD__, $file_id);
        }
        @fclose($cacheData);
        $cacheCache = @fopen($cache_path, 'w+');
        if(!@fwrite($cacheCache, $filecontents)) {
            $this->Log()->writeError('%s : unable to write %s.cache', __METHOD__, $file_id);
        }
        @fclose($cacheCache);
        return 0x01;
    }
    
    public function GenerateCacheData($nameOrItemID, $charGuid, $page=null) {
        return sprintf('%d:%d:%s:%d:%s:%s', time(), ARMORY_REVISION, $nameOrItemID, $charGuid, $page, $this->_locale);
    }
    
    public function validateText($text) {
        $letter = array("'",'"'     ,"<"   ,">"   ,">"   ,"\r","\n"  );
        $values = array("`",'&quot;',"&lt;","&gt;","&gt;",""  ,"<br>");
        return str_replace($letter, $values, $text);
    }
    
    public function getTimeText($seconds) {
        $text = null;
        if($seconds >=24*3600) {
            $text .= intval($seconds / (24 * 3600)) . ' days';
            if($seconds %= 24 * 3600) {
                $text .= ' ';
            }
        }
        if($seconds >= 3600) {
            $text .= intval($seconds / 3600) . ' hours';
            if($seconds %= 3600) {
                $text .= ' ';
            }
        }
        if($seconds >= 60) {
            $text .= intval($seconds / 60).' min';
            if($seconds %= 60) {
                $text .= ' ';
            }
        }
        if($seconds > 0) {
            $text .= $seconds.' sec';
        }
        return $text;
    }
    
    public function getRadius($index) {
        $gSpellRadiusIndex = array(
         '7'=>array(2,0,2),
         '8'=>array(5,0,5),
         '9'=>array(20,0,20),
        '10'=>array(30,0,30),
        '11'=>array(45,0,45),
        '12'=>array(100,0,100),
        '13'=>array(10,0,10),
        '14'=>array(8,0,8),
        '15'=>array(3,0,3),
        '16'=>array(1,0,1),
        '17'=>array(13,0,13),
        '18'=>array(15,0,15),
        '19'=>array(18,0,18),
        '20'=>array(25,0,25),
        '21'=>array(35,0,35),
        '22'=>array(200,0,200),
        '23'=>array(40,0,40),
        '24'=>array(65,0,65),
        '25'=>array(70,0,70),
        '26'=>array(4,0,4),
        '27'=>array(50,0,50),
        '28'=>array(50000,0,50000),
        '29'=>array(6,0,6),
        '30'=>array(500,0,500),
        '31'=>array(80,0,80),
        '32'=>array(12,0,12),
        '33'=>array(99,0,99),
        '35'=>array(55,0,55),
        '36'=>array(0,0,0),
        '37'=>array(7,0,7),
        '38'=>array(21,0,21),
        '39'=>array(34,0,34),
        '40'=>array(9,0,9),
        '41'=>array(150,0,150),
        '42'=>array(11,0,11),
        '43'=>array(16,0,16),
        '44'=>array(0.5,0,0.5),
        '45'=>array(10,0,10),
        '46'=>array(5,0,10),
        '47'=>array(15,0,15),
        '48'=>array(60,0,60),
        '49'=>array(90,0,90)
        );
        $radius = @$gSpellRadiusIndex[$index];
        if($radius == 0) {
            return false;
        }
        if($radius[0] == 0 || $radius[0] == $radius[2]) {
            return $radius[2];
        }
        return $radius[0].' - '.$radius[2];
    }
    
    public function GetArmoryString($id) {
        if($this->_locale == 'en_gb' || $this->_locale == 'ru_ru') {
            return $this->aDB->selectCell("SELECT `string_".$this->_locale."` FROM `armory_string` WHERE `id`=?", $id);
        }
        return $this->aDB->selectCell("SELECT `string_en_gb` FROM `armory_string` WHERE `id`=?", $id);
    }
    
    /**
     * At this moment can be called from talent-calc.php only
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
    
    public function GetDungeonKey($instance_id) {
        return $this->aDB->selectCell("SELECT `key` FROM `armory_instance_template` WHERE `id`=? LIMIT 1", $instance_id);
    }
    
    public function GetBossDungeonKey($bossIdOrKey) {
        return $this->aDB->selectCell("SELECT `key` FROM `armory_instance_template` WHERE `id` IN (SELECT `instance_id` FROM `armory_instance_data` WHERE `id`=? OR `name_id`=? OR `lootid_1`=? OR `lootid_2`=? OR `lootid_3`=? OR `lootid_4`=?) LIMIT 1", $bossIdOrKey, $bossIdOrKey, $bossIdOrKey, $bossIdOrKey, $bossIdOrKey, $bossIdOrKey);
    }
    
    public function GetDungeonId($instance_key) {
        return $this->aDB->selectCell("SELECT `id` FROM `armory_instance_template` WHERE `key`=? LIMIT 1", $instance_key);
    }
    
    public function GetDungeonData($instance_key) {
        return $this->aDB->selectRow("SELECT `id`, `name_".$this->_locale."` AS `name`, `is_heroic`, `key`, `difficulty` FROM `armory_instance_template` WHERE `key`=?", $instance_key);
    }
    
    public function PetTalentCalcData($key) {
        switch(strtolower($key)) {
            case 'ferocity':
            case 'tenacity':
            case 'cunning':
                return $this->aDB->select("SELECT `catId`, `icon`, `id`, `name_".$this->_locale."` AS `name` FROM `armory_petcalc` WHERE `key`=? AND `catId` >= 0", strtolower($key));
                break;
        }
    }
    
    public function IsRealm($rName) {
        return $this->aDB->selectCell("SELECT `id` FROM `armory_realm_data` WHERE `name`=?", $rName);
    }
    
    public function RaceModelData($raceId) {
        return $this->aDB->selectRow("SELECT `modeldata_1`, `modeldata_2` FROM `armory_races` WHERE `id`=?", $raceId);
    }
    
    /**
     * Returns icon name for selected class & talent tree
     * @category Utils
     * @example Utils::ReturnTalentTreeIcon(2)
     * @return string
     **/
    public function ReturnTalentTreeIcon($spec, $class) {
        return $this->aDB->selectCell("SELECT `icon` FROM `armory_talent_icons` WHERE `class`=?d AND `spec`=?d LIMIT 1", $class, $spec);
    }
    
    /**
     * Returns talent tree name for selected class
     * @category Utils
     * @example Utils::ReturnTalentTreeNames(2)
     * @return string
     **/
    public function ReturnTalentTreeName($spec, $class) {
		return $this->aDB->selectCell("SELECT `name_".$this->_locale."` FROM `armory_talent_icons` WHERE `class`=?d AND `spec`=?d", $class, $spec);
	}
    
    public function GetFactionId($raceID) {
        // Get player factionID
        $horde_races    = array(RACE_ORC,     RACE_TROLL, RACE_TAUREN, RACE_UNDEAD, RACE_BLOODELF);
        $alliance_races = array(RACE_DRAENEI, RACE_DWARF, RACE_GNOME,  RACE_HUMAN,  RACE_NIGHTELF);
        if(in_array($raceID, $horde_races)) {
            return 1;
        }
        elseif(in_array($raceID, $alliance_races)) {
            return 0;
        }
        else {
            // Unknown class
            $this->Log()->writeError('%s : unknown race: %d', __METHOD__, $raceID);
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
     **/
    public function GetArmoryNews() {
        $news = $this->aDB->select("SELECT `id`, `date`, `title_en_gb` AS `titleOriginal`, `title_" . $this->_locale ."` AS `titleLoc`, `text_en_gb` AS `textOriginal`, `text_". $this->_locale ."` AS `textLoc` FROM `armory_news` WHERE `display`=1 ORDER BY `date` DESC");
        $allNews = array();
        $i = 0;
        foreach($news as $new) {
            $allNews[$i] = array();
            $allNews[$i]['posted'] = date('Y-m-d\TH:i:s\Z', $new['date']);
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
            $i++;
        }
        if($allNews) {
            return $allNews;
        }
        return false;
    }
}
?>