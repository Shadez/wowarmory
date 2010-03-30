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
     public $emblemstyle;
     public $emblemcolor;
     public $borderstyle;
     public $bordercolor;
     public $bgcolor;
     
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
        $this->guildId = $this->cDB->selectCell("SELECT `guildid` FROM `guild_member` WHERE `guid`=?", $this->guid);
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
     public function CountGuildMembers() {
        if(!$this->guildId) {
            return false;
        }
        return $this->cDB->selectCell("SELECT COUNT(`guid`) FROM `guild_member` WHERE `guildid`=?", $this->guildId);
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
      * Sets $this->guildtabard of selected guild ($this->guildId)
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
        $this->bgcolor     = $gTabard['BackgroundColor'];
        $this->emblemcolor = $gTabard['EmblemColor'];
        $this->emblemstyle = $gTabard['EmblemStyle'];
        $this->bordercolor = $gTabard['BorderColor'];
        $this->borderstyle = $gTabard['BorderStyle'];
        return true;
     }
     
     /**
      * Sets $this->guildFaction as $this->guildleaderguid's faction
      * @category Guilds class
      * @example Guilds::getGuildFaction()
      * @return bool
      **/
     public function getGuildFaction() {
        if(!$this->guildleaderguid) {
            return false;
        }
        $race = $this->cDB->selectCell("SELECT `race` FROM `characters` WHERE `guid`=? LIMIT 1", $this->guildleaderguid);
        $this->guildFaction = ($race==2 || $race==5 || $race==6 || $race==8 || $race==10) ? '1' : '0';
        return true;
     }
     
     /**
      * Returns array with guild members list. If $gm == true, returns his/her data only.
      * @category Guilds class
      * @example Guilds::buildGuildList(false)
      * @return array
      **/
     public function BuildGuildList() {
        if(!$this->guildId) {
            return false;
        }
        $memberListTmp = $this->cDB->select("
        SELECT
        `characters`.`guid`,
        `characters`.`name`,
        `characters`.`class` AS `classId`,
        `characters`.`race` AS `raceId`,
        `characters`.`gender` AS `genderId`,
        `characters`.`level`,
        `guild_member`.`rank`
        FROM `characters` AS `characters`
        LEFT JOIN `guild_member` AS `guild_member` ON `guild_member`.`guid`=`characters`.`guid` AND `guild_member`.`guildid`=?
        LEFT JOIN `guild` AS `guild` ON `guild`.`guildid`=?
        WHERE `guild`.`guildid`=? AND `characters`.`level`>=? AND `guild_member`.`guid`=`characters`.`guid`", $this->guildId, $this->guildId, $this->guildId, $this->armoryconfig['minlevel']);
        $countMembers = count($memberListTmp);
        for($i=0;$i<$countMembers;$i++) {
            $memberListTmp[$i]['achPoints'] = Achievements::calculateAchievementPoints($memberListTmp[$i]['guid']);
            $memberListTmp[$i]['url'] = sprintf('r=%s&cn=%s', urlencode($this->armoryconfig['defaultRealmName']), urlencode($memberListTmp[$i]['name']));
        }
        return $memberListTmp;
     }
     
     /**
      * Returns array with guild members info for guild-stats.php page
      * @category Guilds class
      * @example Guilds::BuildStatsList()
      * @return array
      **/
     public function BuildStatsList() {
        $cList = $this->cDB->select("
        SELECT `race`, `class`, `level`, `gender`
            FROM `characters`
                WHERE `guid` IN (SELECT `guid` FROM `guild_member` WHERE `guildid`=?) AND `level`>=?", $this->guildId, $this->armoryconfig['minlevel']);
        return $cList;
     }
     
     /**
      * Returns guild info and MOTD
      * @category Guilds class
      * @example Guilds::getGuildInfo()
      * @return array
      **/
     public function GetGuildInfo() {
        if(!$this->guildId) {
            return false;
        }
        return $this->cDB->selectRow("SELECT `info`, `motd` FROM `guild` WHERE `guildid`=?", $this->guildId);
     }
     
     /**
      * Returns guild bank tabs info (name, icon)
      * @category Guilds class
      * @example Guilds::getGuildBankTabs()
      * @return array
      **/
     public function GetGuildBankTabs() {
        if(!$this->guildId) {
            return false;
        }
        $tabs = $this->cDB->select("
        SELECT `TabId` AS `id`, `TabName` AS `name`, LOWER(`TabIcon`) AS `icon`
            FROM `guild_bank_tab`
                WHERE `guildid`=?", $this->guildId);
        $count_tabs = count($tabs);
        for($i=0;$i<$count_tabs;$i++) {
            $tabs[$i]['viewable'] = 'true';
        }
        return $tabs;
     }
     
     /**
      * Generates array with guild bank contents.
      * @category Guilds class
      * @example Guilds::showGuildBankContents()
      * @todo Manage rights to access some GB tabs
      * @return array
      **/
     public function showGuildBankContents() {
        if(!$this->guildId) {
            return false;
        }
        $GuildBankContents = '';
        $GB = '';
        $j = 0;      
        for($bank=0;$bank<7;$bank++) {
            $x = 0;
            for($i=0;$i<14;$i++) {
                if($x > 97) {
                    return $GuildBankContents;
                }
                for($j=0;$j<7;$j++) {
                    $GuildBankContents[$bank][$i]['slot_'.$j]['item_entry'] = $this->cDB->selectCell("SELECT `item_entry` FROM `guild_bank_item` WHERE `SlotId`=? AND `TabId`=?", $x, $bank);
                    $GuildBankContents[$bank][$i]['slot_'.$j]['item_icon']  = Items::GetItemIcon($GuildBankContents[$bank][$i]['slot_'.$j]['item_entry']);
                    $GuildBankContents[$bank][$i]['slot_'.$j]['item_count'] = Items::GetItemDataField(14, 0, 0, $this->cDB->selectCell("SELECT `item_guid` FROM `guild_bank_item` WHERE `SlotId`=? AND `TabId`=?", $x, $bank));
                    $x++;
                    }
            }
        }
        return $GuildBankContents;
     }
     
     /**
      * Returns guild bank money
      * @category Guilds class
      * @example Guilds::GetGuildBankMoney()
      * @return int
      **/
     public function GetGuildBankMoney() {
        if(!$this->guildId) {
            return false;
        }
        return $this->cDB->selectCell("SELECT `BankMoney` FROM `guild` WHERE `guildid`=? LIMIT 1", $this->guildId);
     }
     
     /**
      * Returns list of items that stored in guild bank
      * @category Guilds class
      * @example Guilds::BuildGuildBankItemList()
      * @return array
      **/
     public function BuildGuildBankItemList() {
        if(!$this->guildId) {
            return false;
        }
        $items_list = $this->cDB->select("SELECT `item_entry` AS `id`, `item_guid` AS `seed`, `SlotId` AS `slot`, `TabId` AS `bag` FROM `guild_bank_item` WHERE `guildid`=?", $this->guildId);
        $count_items = count($items_list);
        for($i=0;$i<$count_items;$i++) {
            $tmp_durability = Items::GetItemDurabilityByItemGuid($items_list[$i]['seed']);
            $items_list[$i]['durability'] = $tmp_durability['current'];
            $items_list[$i]['maxDurability'] = $tmp_durability['max'];
            unset($tmp_durability);
            $items_list[$i]['icon'] = Items::getItemIcon($items_list[$i]['id']);
            $items_list[$i]['name'] = Items::getItemName($items_list[$i]['id']);            
            $items_list[$i]['qi'] = Items::GetItemInfo($items_list[$i]['id'], 'quality');
            $items_list[$i]['quantity'] = Items::GetItemDataField(ITEM_FIELD_STACK_COUNT, 0, 0, $items_list[$i]['seed']);
            $items_list[$i]['randomPropertiesId'] = 0;
            $tmp_classinfo = Items::GetItemSubTypeInfo($items_list[$i]['id']);
            $items_list[$i]['subtype'] = '';
            $items_list[$i]['subtypeLoc'] = $tmp_classinfo['subclass_name'];
            $items_list[$i]['type'] = $tmp_classinfo['key'];
            $items_list[$i]['slot']++;
        }
        return $items_list;
     }
     
     /**
      * Returns array with guild ranks id (not titles). Requires $this->guildId!
      * @category Guilds class
      * @example Guilds::GetGuildRanks()
      * @return array
      **/
     
     public function GetGuildRanks() {
        if(!$this->guildId) {
            return false;
        }
        return $this->cDB->select("SELECT `rid` AS `id`, `rname` AS `name` FROM `guild_rank` WHERE `guildid`=?", $this->guildId);
     }
}
?>