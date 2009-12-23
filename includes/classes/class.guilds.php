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

if(!defined('__ARMORY__')) {
    die('Direct access to this file not allowed!');
}

Class Guilds extends Connector {
    
    /**
     * Player guid
     **/
     public $guid;
     
     /**
      * Guild id
      **/
     public $guildId;
     
     /**
      * Guild name
      **/
     public $guildName;
     
     /**
      * Guild tabard style
      **/
     public $guildtabard;
     
     /**
      * Guild leader guid
      **/
     public $guildleaderguid;
     
     /**
      * Guild faction
      **/
     public $guildFaction;
     
     /**
      * Constructs guild info
      * @category Guilds class
      * @example Guilds::constructGuildInfo()
      * @return bool
      **/
     public function _structGuildInfo() {
        if(!$this->guildId) {
            $this->extractPlayerGuildId();
        }
        $this->getGuildName();
        $this->getGuildLeaderGuid();
        $this->getGuildTabardStyle();
        $this->getGuildFaction();
        return true;
     }
     
     /**
      * Set $this->guildId by $this->guildName
      * @category Guilds class
      * @example Guilds::initGuild()
      * @return bool
      **/
     public function initGuild() {
        if(!$this->guildName) {
            return false;
        }
        $this->guildId = $this->cDB->selectCell("SELECT `guildid` FROM `guild` WHERE `name`=? LIMIT 1", $this->guildName);
        if($this->guildId) {
            return true;
        }
        return false;
     }
     /**
      * Set $this->guildId of selected player ($this->guid)
      * @category Guilds class
      * @example Guilds::extractPlayerGuildId()
      * @return bool
      **/
     public function extractPlayerGuildId($guid = false) {
        if($guid) {
            $this->guid = $guid;
        }
        if(!$this->guid) {
            return false;
        }
        $this->guildId = Characters::GetDataField(PLAYER_GUILDID, $this->guid);
        if($this->guildId) {
            return true;
        }
     }
     
     /**
      * Set $this->guildName of selected guild ($this->guildId)
      * @category Guilds class
      * @example Guilds::getGuildName()
      * @return bool
      **/
     public function getGuildName() {
        if(!$this->guildId) {
            return false;
        }
        $this->guildName = $this->cDB->selectCell("SELECT `name` FROM `guild` WHERE `guildid`=? LIMIT 1", $this->guildId);
        return $this->guildName;
     }
     
     /**
      * Counts guild members count
      * @category Guilds class
      * @example Guilds::countGuildMembers()
      * @return int
      **/
     public function countGuildMembers() {
        if(!$this->guildId) {
            return false;
        }
        $tmp = $this->cDB->selectPage($gCount, "SELECT `guid` FROM `guild_member` WHERE `guildid`=?", $this->guildId);
        return $gCount;
     }
     
     /**
      * Set $this->guildleaderguid of selected guild ($this->guildId)
      * @category Guilds class
      * @example Guilds::getGuildLeaderGuid()
      * @return bool
      **/     
     public function getGuildLeaderGuid() {
        if(!$this->guildId) {
            return false;
        }
        $this->guildleaderguid = $this->cDB->selectCell("SELECT `leaderguid` FROM `guild` WHERE `guildid`=? LIMIT 1", $this->guildId);
     }
     
     /**
      * Set $this->guildtabard of selected guild ($this->guildId)
      * @category Guilds class
      * @example Guilds::getGuildTabardStyle()
      * @return bool
      **/   
     public function getGuildTabardStyle() {
        if(!$this->guildId) {
            return false;
        }
        $gTabard = $this->cDB->selectRow("
        SELECT `EmblemStyle`, `EmblemColor`, `BorderStyle`, `BorderColor`, `BackgroundColor`
            FROM `guild`
                WHERE `guildid`=? LIMIT 1", $this->guildId);
        $this->guildtabard = sprintf('emblemstyle=%d&emblemcolor=%d&embborderstyle=%d&embbordercolor=%d&bgcolor=%d&faction=%d',
            $gTabard['EmblemStyle'], $gTabard['EmblemColor'], $gTabard['BorderStyle'], $gTabard['BorderColor'], $gTabard['BackgroundColor'], $this->guildFaction);
        return true;
     }
     
     public function getGuildFaction() {
        if(!$this->guildleaderguid) {
            return false;
        }
        $race = $this->cDB->selectCell("SELECT `race` FROM `characters` WHERE `guid`=? LIMIT 1", $this->guildleaderguid);
        $this->guildFaction = ($race==2 || $race==5 || $race==6 || $race==8 || $race==10) ? '1' : '0';
        return true;
     }
     
     public function buildGuildList($gm=false) {
        if(!$this->guildId) {
            return false;
        }
        if($gm == true) {
            $memberListTmp = $this->cDB->select("
            SELECT `guid`, `name`, `race`, `class`, `gender`, `level`
                FROM `characters` WHERE `guid` IN 
                (
                    SELECT `guid`
                    FROM `guild_member`
                    WHERE `guildid`=? AND `rank`=0
                ) LIMIT 1", $this->guildId);
        }
        else {
            $memberListTmp = $this->cDB->select("
            SELECT
            `characters`.`guid`,
            `characters`.`name`,
            `characters`.`class`,
            `characters`.`race`,
            `characters`.`gender`,
            `characters`.`level`,
            `guild_member`.`rank`
            FROM `characters` AS `characters`
            LEFT JOIN `guild_member` AS `guild_member` ON `guild_member`.`guid`=`characters`.`guid` AND `guild_member`.`guildid`=?
            LEFT JOIN `guild` AS `guild` ON `guild`.`guildid`=?
            WHERE `guild`.`guildid`=? AND `characters`.`level` >= 10 AND `guild_member`.`guid`=`characters`.`guid` AND `guild_member`.`rank` <> 0
            GROUP BY `guild_member`.`rank`", $this->guildId, $this->guildId, $this->guildId);
        }
        $i = 0;
        $countMembers = count($memberListTmp);
        for($i=0;$i<$countMembers;$i++) {
            $memberListTmp[$i]['ach_points'] = Achievements::calculateAchievementPoints($memberListTmp[$i]['guid']);
        }
        return $memberListTmp;
     }
     
     public function BuildStatsList() {
        $cList = $this->cDB->select("
        SELECT `race`, `class`, `level`, `gender`
            FROM `characters`
                WHERE `guid` IN (SELECT `guid` FROM `guild_member` WHERE `guildid`=?) AND `level`>=10", $this->guildId);
        return $cList;
     }
}

?>