<?php

/**
 * @package World of Warcraft Armory
 * @version Release Candidate 1
 * @revision 122
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
            return false;
        }
        $info = $this->rDB->selectRow("SELECT `id`, `sha_pass_hash` FROM `account` WHERE `username`=? LIMIT 1", $this->username);
        if(!$info) {
            return false;
        }
        elseif($info['sha_pass_hash'] != $this->createShaHash()) {
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
    
    public function getCharsArray($select=false) {
        if(!$_SESSION['accountId']) {
            return false;
        }
        if($select == true) {
            $chars = $this->aDB->select("SELECT `guid`, `name`, `class`, `race`, `gender`, `level` FROM `armory_login_characters` WHERE `account`=? AND `selected`<>1 ORDER BY `num` ASC LIMIT 2", $_SESSION['accountId']);
            $chars['0']['show'] = true;
            $chars['1']['show'] = true;
        }
        else {
            $chars = $this->aDB->select("SELECT `guid`, `name`, `class`, `race`, `gender`, `level` FROM `armory_login_characters` WHERE `account`=? ORDER BY `num` ASC LIMIT 3", $_SESSION['accountId']);
        }
        // TODO: achievement points for each character
        return $chars;
    }
    
    public function guildBankRights($guildid) {
        if(!$_SESSION['accountId']) {
            return false;
        }
        $selectedCharData = $this->getCharacter();
        /* Hack */
        $characterGuildId = $this->cDB->selectCell("SELECT `guildid` FROM `guild_member` WHERE `guid`=? LIMIT 1", $selectedCharData['guid']);
        if(!$characterGuildId || $characterGuildId != $guildid) {
            return false;
        }
        return true;
    }
    
    public function CountSelectedCharacters() {
        if(!$_SESSION['accountId']) {
            return false;
        }
        return $this->aDB->selectCell("SELECT COUNT(`guid`) FROM `armory_login_characters` WHERE `account`=?", $_SESSION['accountId']);
    }
    
    public function CountAllCharacters() {
        if(!$_SESSION['accountId']) {
            return false;
        }
        return $this->cDB->selectCell("SELECT COUNT(`guid`) FROM `characters` WHERE `account`=?", $_SESSION['accountId']);
    }
    
    public function GetAllCharacters() {
        if(!$_SESSION['accountId']) {
            return false;
        }
        $gField = PLAYER_GUILDID+1;
        $chars = $this->cDB->select("
        SELECT
        `characters`.`name`, 
        `characters`.`class` AS `classId`, 
        `characters`.`race` AS `raceId`, 
        `characters`.`gender` AS `genderId`, 
        `characters`.`level`,
        `guild`.`name` AS `guild`,
        `guild`.`guildid` AS `guildId`
        FROM `characters` AS `characters`
        LEFT JOIN `guild` AS `guild` ON `guild`.`guildid`=CAST(SUBSTRING_INDEX(SUBSTRING_INDEX(`characters`.`data`, ' ', ".$gField."), ' ', '-1') AS UNSIGNED)
        WHERE `account`=?", $_SESSION['accountId']);
        $count = count($chars);
        for($i=0;$i<$count;$i++) {
            $chars[$i]['account'] = strtoupper($_SESSION['username']);
            $chars[$i]['factionId'] = Characters::GetCharacterFaction($chars[$i]['raceId']);
            $chars[$i]['realm'] = $this->armoryconfig['defaultRealmName'];
            $chars[$i]['relevance'] = '100';
            $chars[$i]['url'] = 'r='.urlencode($chars[$i]['realm']).'&cn='.urlencode($chars[$i]['name']);
        }
        return $chars;
    }
    
    public function getCharacter() {
        if(!$_SESSION['accountId']) {
            return false;
        }
        $data = $this->aDB->selectRow("SELECT `guid`, `name`, `class`, `race`, `gender`, `level` FROM `armory_login_characters` WHERE `account`=? AND `selected`=1", $_SESSION['accountId']);
        if(!$data) {
            return $this->loadRandomCharacter();
        }
        return $data;
    }
    
    public function loadRandomCharacter() {
        if(!$_SESSION['accountId']) {
            return false;
        }
        $char = $this->cDB->selectRow("SELECT `guid`, `name`, `class`, `race`, `gender`, `level` FROM `characters` WHERE `account`=? LIMIT 1", $_SESSION['accountId']);
        if(!$char) {
            return false;
        }
        $char['account'] = $_SESSION['accountId'];
        $char['selected'] = 1;
        $this->aDB->query("INSERT INTO `armory_login_characters` (?#) VALUES (?a)", array_keys($char), array_values($char));
        return $char;
    }
    
    public function getCharacterBookmarks() {
        if(!$_SESSION['accountId']) {
            return false;
        }
        $guids = $this->aDB->select("SELECT `guid` FROM `armory_bookmarks` WHERE `account`=?", $_SESSION['accountId']);
        if($guids) {
            $bookmarks = array();
            $i = 0;
            foreach($guids as $char) {
                $bookmarks[$i] = $this->cDB->selectRow("SELECT `name`, `class`, `level` FROM `characters` WHERE `guid`=? LIMIT 1", $char['guid']);
                $charAchievements = $this->cDB->select("SELECT `achievement` FROM `character_achievement` WHERE `guid`=?", $char['guid']);
                $countAchievements = count($charAchievements);
                for($j=0;$j<$countAchievements;$j++) {
                    $ach[$j] = $charAchievements[$j]['achievement'];
                }
                $bookmarks[$i]['apoints'] = $this->aDB->selectCell("SELECT SUM(`points`) FROM `armory_achievement` WHERE `id` IN (?a)", $ach);
                $i++;
            }
            return $bookmarks;
        }
        return false;
    }
    
    public function createShaHash() {
        if(!$this->username || !$this->password) {
            return false;
        }
        $this->shaHash = sha1(strtoupper($this->username).':'.strtoupper($this->password));
        return $this->shaHash;
    }
    
    public function ComputePetBonus($stat, $value, $unitClass) {
        $hunter_pet_bonus = array(0.22, 0.1287, 0.3, 0.4, 0.35, 0.0, 0.0, 0.0);
        $warlock_pet_bonus = array(0.0, 0.0, 0.3, 0.4, 0.35, 0.15, 0.57, 0.3);
        if($unitClass == CLASS_WARLOCK) {
            if($warlock_pet_bonus[$stat])
                return $value * $warlock_pet_bonus[$stat];
            else
                return 0;
        }
        elseif($unitClass == CLASS_HUNTER) {
            if($hunter_pet_bonus[$stat])
                return $value * $hunter_pet_bonus[$stat];
            else
                return 0;
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
        $rating = $this->aDB->selectRow("SELECT * FROM `armory_rating` WHERE `level`=?", $level);
        return $rating;
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
		$cnt=count($arr); 
		$min=$max=$arr[0]; 
		$index_min=$index_max=0; 
		for($i=1;$i<$cnt;$i++)
		{ 
			if($arr[$i]>$max)
			{ 
				$index_max=$i; 
				$max=$arr[$i]; 
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
        )"); // 3.3.2 IDs
        if(!$achievements_data) {
            return false;
        }
        $countAch = count($achievements_data);
        for($i=0;$i<$countAch;$i++) {
            $achievements_data[$i]['title'] = $this->aDB->selectCell("SELECT `name_".$this->_locale."` FROM `armory_achievement` WHERE `id`=? LIMIT 1", $achievements_data[$i]['achievement']);
            $achievements_data[$i]['desc']  = $this->aDB->selectCell("SELECT `description_".$this->_locale."` FROM `armory_achievement` WHERE `id`=?", $achievements_data[$i]['achievement']);
            $achievements_data[$i]['icon']  = $this->aDB->selectCell("SELECT `iconname` FROM `armory_achievement` WHERE `id`=?", $achievements_data[$i]['achievement']);
            $achievements_data[$i]['dateCompleted'] = date('Y-m-d\TH:i:s\Z', $achievements_data[$i]['date']);            
        }
        /*
        $start_id = $countAch+1;
        //                   Sartharion Malygos Kel'thuzed Yogg-Saron ToGC  The Lich King
        $boss_firsts = array(456,       1400,   1402,      3117,      4078, 4576);
        $bosses = array();
        */
        return $achievements_data;
    }
    
    public function GetAttackPowerForStat($statIndex, $effectiveStat, $class) {
        $ap = 0;
        if($statIndex == STAT_STRENGTH) {
            switch ($class) {
                case CLASS_WARRIOR:
                case CLASS_PALADIN:
                case CLASS_DK:
                case CLASS_DRUID:
                    $baseStr=min($effectiveStat,20);
                    $moreStr=$effectiveStat-$baseStr;
                    $ap=$baseStr + 2*$moreStr;
                    break;
                default:
                    $ap=$effectiveStat - 10;
                    break;
            }
        }
        else if($statIndex == STAT_AGILITY) {
            switch ($class) {
                case CLASS_SHAMAN:
                case CLASS_ROGUE:
                case CLASS_HUNTER:
                $ap = $effectiveStat - 10;
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
        if($item['class'] != 2) {
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
        for ($i=0;$i<128;$i++)
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
        return $skillInfo;
    }
    
    public function GenerateCacheId($page, $att1=0, $att2=0, $att3=0) {
        return md5($page.':'.ARMORY_REVISION.':'.$att1.':'.$att2.':'.$att3.':'.$this->_locale);
    }
    
    public function GetCache($file_id, $file_dir = 'characters') {
        if($this->armoryconfig['useCache'] != true) {
            return false;
        }
        if(file_exists('cache/'.$file_dir.'/'.$file_id.'.data')) {
            $data_contents = file_get_contents('cache/'.$file_dir.'/'.$file_id.'.data');
            $data_explode = explode(':', $data_contents);
            $cache_timestamp = $data_explode[0];
            $cache_revision  = $data_explode[1];
            $name_or_itemid  = $data_explode[2];
            $character_guid  = $data_explode[3];
            $cache_locale    = $data_explode[4];
            $file_expire = $cache_timestamp + $this->armoryconfig['cache_lifetime'];
            if($file_expire < time() || $cache_revision != ARMORY_REVISION) {
                return false;
            }
            else {
                if(file_exists('cache/'.$file_dir.'/'.$file_id.'.cache')) {
                    $cache_contents = @file_get_contents('cache/'.$file_dir.'/'.$file_id.'.cache');
                    if(sizeof($cache_contents) > 0x00) {
                        return $cache_contents;
                    }
                }
            }
        }
        return false;
    }
    
    public function WriteCache($file_id, $filedata, $filecontents, $filedir='characters') {
        if($this->armoryconfig['useCache'] != true) {
            return false;
        }
        $error_message = null;
        $cacheData = @fopen('cache/'.$filedir.'/'.$file_id.'.data', 'w+');
        if(!@fwrite($cacheData, $filedata)) {
            $error_message .= sprintf('Unable to write %s.data\n', $file_id);
        }
        @fclose($cacheData);
        $cacheCache = @fopen('cache/'.$filedir.'/'.$file_id.'.cache', 'w+');
        if(!@fwrite($cacheCache, $filecontents)) {
            $error_message .= sprintf('Unable to write %s.cache', $file_id);
        }
        @fclose($cacheCache);
        if($error_message == null) {
            return 0x01;
        }
        else {
            return $error_message;
        }
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
        $text = "";
        if ($seconds >=24*3600) {$text.= intval($seconds/(24*3600))." days"; if ($seconds%=24*3600) $text.=" ";}
        if ($seconds >=   3600) {$text.= intval($seconds/3600)." hours"; if ($seconds%=3600) $text.=" ";}
        if ($seconds >=     60) {$text.= intval($seconds/60)." min"; if ($seconds%=60) $text.=" ";}
        if ($seconds >       0) {$text.= $seconds." sec";}
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
        if ($radius == 0) {
            return "Err index $index";
        }        
        if ($radius[0]==0 OR $radius[0]==$radius[2]) {
            return $radius[2];
        }
        return $radius[0]." - ".$radius[2];
    }
    
    public function GetDungeonList($expansion) {
        $data = array();
        switch($expansion) {
            case 0: // WoW Classic
                $data = $this->aDB->select("
                SELECT `id`, `name_".$this->_locale."` AS `name`, `boss_num`, `key`, `levelMin`, `levelMax`, `partySize`, `raid`
                    FROM `armory_instance_template`
                        WHERE `expansion`=0");                
                break;
            case 1: // WoW TBC
                $data = $this->aDB->select("
                SELECT `id`, `name_".$this->_locale."` AS `name`, `boss_num`, `key`, `levelMin`, `levelMax`, `partySize`, `raid`
                    FROM `armory_instance_template`
                        WHERE `expansion`=1");   
                break;
            case 2: // WoW WotLK
                $data = $this->aDB->select("
                    SELECT `id`, `name_".$this->_locale."` AS `name`, `boss_num`, `key`, `levelMin`, `levelMax`, `partySize`, `raid`
                        FROM `armory_instance_template`
                            WHERE `expansion`=2");   
                break;
        }
        $count = count($data);
        for($i=0;$i<$count;$i++) {
            $data[$i]['bosses'] = $this->aDB->select("SELECT `id`, `name_".$this->_locale."` AS `bossname` FROM `armory_instance_data` WHERE `instance_id`=?", $data[$i]['id']);
        }
        return $data;
    }
    
    public function GetFactionList($expansion) {
        $data = array();
        switch($expansion) {
            case 0: // WoW Classic
                $data = $this->aDB->select("
                SELECT `id`, `name_".$this->_locale."` AS `name`, `friendlyTo` AS `side`
                    FROM `armory_faction`
                        WHERE `expansion`=0 AND `hasRewards`=1");
                break;
            case 1: // WoW TBC
                $data = $this->aDB->select("
                SELECT `id`, `name_".$this->_locale."` AS `name`, `friendlyTo` AS `side`
                    FROM `armory_faction`
                        WHERE `expansion`=1 AND `hasRewards`=1");
                break;
            case 2: // WoW WotLK
                $data = $this->aDB->select("
                SELECT `id`, `name_".$this->_locale."` AS `name`, `friendlyTo` AS `side`
                    FROM `armory_faction`
                        WHERE `expansion`=2 AND `hasRewards`=1");
                break;
        }
        return $data;
    }
    
    public function GetArmoryString($id) {
        $str = $this->aDB->selectCell("SELECT `string_".$this->_locale."` FROM `armory_string` WHERE `id`=?", $id);
        return $str;
    }
    
    public function GetClassId($class_string) {
        switch(strtolower($class_string)) {
            case 'death knight':
                return 6;
                break;
            case 'druid':
                return 11;
                break;
            case 'hunter':
                return 3;
                break;
            case 'mage':
                return 8;
                break;
            case 'paladin':
                return 2;
                break;
            case 'priest':
                return 5;
                break;
            case 'rogue':
                return 4;
                break;
            case 'shaman':
                return 7;
                break;
            case 'warlock':
                return 9;
                break;
            case 'warrior':
                return 1;
                break;
            default:
                return 6; // Death Knight is default class
                break;
        }
    }
}
?>