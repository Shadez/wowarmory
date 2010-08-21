<?php

/**
 * @package World of Warcraft Armory
 * @version Release Candidate 1
 * @revision 365
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

Class Guilds extends Armory {
    
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
     
     private $guildBankMoney;
     
     /**
      * Build guild info
      * @category Guilds class
      * @access   public
      * @return   bool
      **/
     public function BuildGuildInfo() {
        if(!$this->guildId) {
            $this->GetGuildIDByPlayerGUID();
        }
        $guild_data = $this->cDB->selectRow("SELECT `name`, `leaderguid`, `BankMoney`, `EmblemStyle`, `EmblemColor`, `BorderStyle`, `BorderColor`, `BackgroundColor` FROM `guild` WHERE `guildid`=%d", $this->guildId);
        if(!$guild_data) {
            $this->Log()->writeError('%s : unable to get data from DB for guild %d', __METHOD__, $this->guildId);
            return false;
        }
        $this->guildName       = $guild_data['name'];
        $this->guildleaderguid = $guild_data['leaderguid'];
        $this->guildBankMoney  = $guild_data['BankMoney'];
        $this->bgcolor         = $guild_data['BackgroundColor'];
        $this->emblemcolor     = $guild_data['EmblemColor'];
        $this->emblemstyle     = $guild_data['EmblemStyle'];
        $this->bordercolor     = $guild_data['BorderColor'];
        $this->borderstyle     = $guild_data['BorderStyle'];
        $this->GetGuildFaction();
        return true;
     }
     
     /**
      * Initialize guild
      * @category Guilds class
      * @access   public
      * @return   bool
      **/
     public function InitGuild() {
        if(!$this->guildName) {
            $this->Log()->writeError('%s : guilName not defined', __METHOD__);
            return false;
        }
        $this->guildId = $this->cDB->selectCell("SELECT `guildid` FROM `guild` WHERE `name`='%s' LIMIT 1", $this->guildName);
        if($this->guildId) {
            return true;
        }
        return false;
     }
     /**
      * Set $this->guildId of selected player ($this->guid)
      * @category Guilds class
      * @access   private
      * @return   bool
      **/
     private function GetGuildIDByPlayerGUID($guid = false) {
        if($guid) {
            $this->guid = $guid;
        }
        if(!$this->guid) {
            $this->Log()->writeError('%s : player guid not defined', __METHOD__);
            return false;
        }
        $this->guildId = $this->cDB->selectCell("SELECT `guildid` FROM `guild_member` WHERE `guid`=%d", $this->guid);
        if($this->guildId) {
            return true;
        }
     }
     
     /**
      * Counts guild members count
      * @category Guilds class
      * @example Guilds::countGuildMembers()
      * @return int
      **/
     public function CountGuildMembers() {
        if(!$this->guildId) {
            $this->Log()->writeError('%s : guildId not defined', __METHOD__);
            return false;
        }
        return $this->cDB->selectCell("SELECT COUNT(`guid`) FROM `guild_member` WHERE `guildid`=%d", $this->guildId);
     }
     
     /**
      * Sets $this->guildFaction as $this->guildleaderguid's faction
      * @category Guilds class
      * @access   private
      * @return   bool
      **/
     private function GetGuildFaction() {
        if(!$this->guildleaderguid) {
            $this->Log()->writeError('%s : guildleaderguid not defined', __METHOD__);
            return false;
        }
        $race = $this->cDB->selectCell("SELECT `race` FROM `characters` WHERE `guid`=%d LIMIT 1", $this->guildleaderguid);
        $this->guildFaction = Utils::GetFactionId($race);
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
            $this->Log()->writeError('%s : guildId not defined', __METHOD__);
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
        LEFT JOIN `guild_member` AS `guild_member` ON `guild_member`.`guid`=`characters`.`guid` AND `guild_member`.`guildid`=%d
        LEFT JOIN `guild` AS `guild` ON `guild`.`guildid`=%d
        WHERE `guild`.`guildid`=%d AND `characters`.`level`>=%d AND `guild_member`.`guid`=`characters`.`guid`", $this->guildId, $this->guildId, $this->guildId, $this->armoryconfig['minlevel']);
        $countMembers = count($memberListTmp);
        for($i=0;$i<$countMembers;$i++) {
            $pl = new Characters;
            $pl->BuildCharacter($memberListTmp[$i]['name'], $this->currentRealmInfo['id'], false);
            $memberListTmp[$i]['achPoints'] = $pl->GetAchievementMgr()->GetAchievementPoints();
            $memberListTmp[$i]['url'] = sprintf('r=%s&cn=%s&gn=%s', urlencode($this->currentRealmInfo['name']), urlencode($memberListTmp[$i]['name']), urlencode($this->guildName));
            unset($pl);
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
        return $this->cDB->select("
        SELECT `race`, `class`, `level`, `gender`
            FROM `characters`
                WHERE `guid` IN (SELECT `guid` FROM `guild_member` WHERE `guildid`=%d) AND `level`>=%d", $this->guildId, $this->armoryconfig['minlevel']);
     }
     
     /**
      * Returns guild info and MOTD
      * @category Guilds class
      * @example Guilds::getGuildInfo()
      * @return array
      **/
     public function GetGuildInfo() {
        if(!$this->guildId) {
            $this->Log()->writeError('%s : guildId not defined', __METHOD__);
            return false;
        }
        return $this->cDB->selectRow("SELECT `info`, `motd` FROM `guild` WHERE `guildid`=%d", $this->guildId);
     }
     
     /**
      * Returns guild bank tabs info (name, icon)
      * @category Guilds class
      * @example Guilds::getGuildBankTabs()
      * @return array
      **/
     public function GetGuildBankTabs() {
        if(!$this->guildId) {
            $this->Log()->writeError('%s : guildId not defined', __METHOD__);
            return false;
        }
        $tabs = $this->cDB->select("SELECT `TabId` AS `id`, `TabName` AS `name`, LOWER(`TabIcon`) AS `icon` FROM `guild_bank_tab` WHERE `guildid`=%d", $this->guildId);
        $count_tabs = count($tabs);
        for($i=0;$i<$count_tabs;$i++) {
            $tabs[$i]['viewable'] = 'true';
        }
        return $tabs;
     }
     
     /**
      * Returns guild bank money
      * @category Guilds class
      * @example Guilds::GetGuildBankMoney()
      * @return int
      **/
     public function GetGuildBankMoney() {
        if(!$this->guildBankMoney) {
            $this->Log()->writeError('%s : guildBankMoney not defined', __METHOD__);
            return false;
        }
        return $this->guildBankMoney;
     }
     
     /**
      * Returns list of items that stored in guild bank
      * @category Guilds class
      * @example Guilds::BuildGuildBankItemList()
      * @return array
      **/
     public function BuildGuildBankItemList() {
        if(!$this->guildId) {
            $this->Log()->writeError('%s : guildId not defined', __METHOD__);
            return false;
        }
        $items_list = $this->cDB->select("SELECT `item_entry` AS `id`, `item_guid` AS `seed`, `SlotId` AS `slot`, `TabId` AS `bag` FROM `guild_bank_item` WHERE `guildid`=%d", $this->guildId);
        $count_items = count($items_list);
        for($i=0;$i<$count_items;$i++) {
            $tmp_durability = Items::GetItemDurabilityByItemGuid($items_list[$i]['seed']);
            $items_list[$i]['durability'] = (int) $tmp_durability['current'];
            $items_list[$i]['maxDurability'] = (int) $tmp_durability['max'];
            unset($tmp_durability);
            $items_list[$i]['icon'] = Items::GetItemIcon($items_list[$i]['id']);
            $items_list[$i]['name'] = Items::GetItemName($items_list[$i]['id']);            
            $items_list[$i]['qi'] = Items::GetItemInfo($items_list[$i]['id'], 'quality');
            if($this->currentRealmInfo['type'] == 'mangos') {
                $items_list[$i]['quantity'] = Items::GetItemDataField(ITEM_FIELD_STACK_COUNT, 0, 0, $items_list[$i]['seed']);
            }
            elseif($this->currentRealmInfo['type'] == 'trinity') {
                $items_list[$i]['quantity'] = $this->cDB->selectCell("SELECT `count` FROM `item_instance` WHERE `guid`=%d", $items_list[$i]['seed']);
            }
            $items_list[$i]['randomPropertiesId'] = Items::GetRandomPropertiesData($items_list[$i]['id'], 0, $items_list[$i]['seed'], true);
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
            $this->Log()->writeError('%s : guildId not defined', __METHOD__);
            return false;
        }
        return $this->cDB->select("SELECT `rid` AS `id`, `rname` AS `name` FROM `guild_rank` WHERE `guildid`=%d", $this->guildId);
     }
}
?>