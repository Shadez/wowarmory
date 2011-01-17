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

Class Guilds {
    
    /**
     * Player guid
     * @category Guilds class
     * @access   public
     **/
     public $guid;
     
     /**
      * Guild ID
      * @category Guilds class
      * @access   public
      **/
     public $guildId;
     
     /**
      * Guild name
      * @category Guilds class
      * @access   public
      **/
     public $guildName;
     
     /**
      * Guild tabard style
      * @category Guilds class
      * @access   public
      **/
     public $guildtabard;
     public $emblemstyle;
     public $emblemcolor;
     public $borderstyle;
     public $bordercolor;
     public $bgcolor;
     
     /**
      * Guild Leader GUID
      * @category Guilds class
      * @access   public
      **/
     public $guildleaderguid;
     
     /**
      * Guild faction
      * @category Guilds class
      * @access   public
      **/
     public $guildFaction;
     
     private $guildBankMoney;
     
     /**
      * Server type
      * @category Guilds class
      * @access   private
      **/
     private $m_server;
     
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
        $guild_data = Armory::$cDB->selectRow("SELECT `name`, `leaderguid`, `BankMoney`, `EmblemStyle`, `EmblemColor`, `BorderStyle`, `BorderColor`, `BackgroundColor` FROM `guild` WHERE `guildid`=%d", $this->guildId);
        if(!$guild_data) {
            Armory::Log()->writeError('%s : unable to get data from DB for guild %d', __METHOD__, $this->guildId);
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
      * @param    int $serverType
      * @return   bool
      **/
     public function InitGuild($serverType) {
        if(!$this->guildName) {
            Armory::Log()->writeError('%s : guilName not defined', __METHOD__);
            return false;
        }
        $this->guildId = Armory::$cDB->selectCell("SELECT `guildid` FROM `guild` WHERE `name`='%s' LIMIT 1", $this->guildName);
        if($serverType < SERVER_MANGOS || $serverType > SERVER_TRINITY) {
            Armory::Log()->writeError('%s : unknown server type (%d). Set m_server to SERVER_MANGOS (%d)', __METHOD__, $serverType, SERVER_MANGOS);
            $this->m_server = SERVER_MANGOS;
        }
        else {
            $this->m_server = $serverType;
        }
        if($this->guildId) {
            return true;
        }
        return false;
     }
     
     /**
      * Assign guild ID by player GUID
      * @category Guilds class
      * @access   private
      * @return   bool
      **/
     private function GetGuildIDByPlayerGUID($guid = 0) {
        if($guid > 0) {
            $this->guid = $guid;
        }
        if(!$this->guid) {
            Armory::Log()->writeError('%s : player guid not defined', __METHOD__);
            return false;
        }
        $this->guildId = Armory::$cDB->selectCell("SELECT `guildid` FROM `guild_member` WHERE `guid`=%d", $this->guid);
        if($this->guildId > 0) {
            return true;
        }
     }
     
     /**
      * Return guild members count
      * @category Guilds class
      * @access   public
      * @return   int
      **/
     public function CountGuildMembers() {
        if(!$this->guildId) {
            Armory::Log()->writeError('%s : guildId not defined', __METHOD__);
            return false;
        }
        return Armory::$cDB->selectCell("SELECT COUNT(`guid`) FROM `guild_member` WHERE `guildid`=%d", $this->guildId);
     }
     
     /**
      * Assign guild faction by player faction ID
      * @category Guilds class
      * @access   private
      * @return   bool
      **/
     private function GetGuildFaction() {
        if(!$this->guildleaderguid) {
            Armory::Log()->writeError('%s : guildleaderguid not defined', __METHOD__);
            return false;
        }
        $race = Armory::$cDB->selectCell("SELECT `race` FROM `characters` WHERE `guid`=%d LIMIT 1", $this->guildleaderguid);
        $this->guildFaction = Utils::GetFactionId($race);
        return true;
     }
     
     /**
      * Returns array with guild members list.
      * @category Guilds class
      * @access   public
      * @return   array
      **/
     public function BuildGuildList() {
        if(!$this->guildId) {
            Armory::Log()->writeError('%s : guildId not defined', __METHOD__);
            return false;
        }
        $memberListTmp = Armory::$cDB->select("
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
        WHERE `guild`.`guildid`=%d AND `characters`.`level`>=%d AND `guild_member`.`guid`=`characters`.`guid`", $this->guildId, $this->guildId, $this->guildId, Armory::$armoryconfig['minlevel']);
        $countMembers = count($memberListTmp);
        for($i = 0; $i < $countMembers; $i++) {
            $pl = new Characters();
            $pl->SetOptions(LOAD_NOTHING);
            $pl->SetOptions(array('load_achievements' => true));
            $pl->BuildCharacter($memberListTmp[$i]['name'], Armory::$currentRealmInfo['id'], false);
            $memberListTmp[$i]['achPoints'] = $pl->GetAchievementMgr()->GetAchievementPoints();
            $memberListTmp[$i]['url'] = sprintf('r=%s&cn=%s&gn=%s', urlencode(Armory::$currentRealmInfo['name']), urlencode($memberListTmp[$i]['name']), urlencode($this->guildName));
            unset($pl);
        }
        return $memberListTmp;
     }
     
     /**
      * Returns array with guild members statistics
      * @category Guilds class
      * @access   public
      * @return   array
      **/
     public function BuildStatsList() {
        return Armory::$cDB->select("SELECT `race`, `class`, `level`, `gender` FROM `characters` uid` IN (SELECT `guid` FROM `guild_member` WHERE `guildid`=%d) AND `level`>=%d", $this->guildId, Armory::$armoryconfig['minlevel']);
     }
     
     /**
      * Returns guild info and MOTD
      * @category Guilds class
      * @example Guilds::getGuildInfo()
      * @return array
      **/
     public function GetGuildInfo() {
        if(!$this->guildId) {
            Armory::Log()->writeError('%s : guildId not defined', __METHOD__);
            return false;
        }
        return Armory::$cDB->selectRow("SELECT `info`, `motd` FROM `guild` WHERE `guildid`=%d", $this->guildId);
     }
     
     /**
      * Returns guild bank tabs info (name, icon)
      * @category Guilds class
      * @access   public
      * @return   array
      **/
     public function GetGuildBankTabs() {
        if(!$this->guildId) {
            Armory::Log()->writeError('%s : guildId not defined', __METHOD__);
            return false;
        }
        $tabs = Armory::$cDB->select("SELECT `TabId` AS `id`, `TabName` AS `name`, LOWER(`TabIcon`) AS `icon` FROM `guild_bank_tab` WHERE `guildid`=%d", $this->guildId);
        $count_tabs = count($tabs);
        for($i = 0; $i < $count_tabs; $i++) {
            $tabs[$i]['viewable'] = 'true';
        }
        return $tabs;
     }
     
     /**
      * Returns guild bank money
      * @category Guilds class
      * @access   public
      * @return   int
      **/
     public function GetGuildBankMoney() {
        if(!$this->guildBankMoney) {
            Armory::Log()->writeError('%s : guildBankMoney not defined', __METHOD__);
            return false;
        }
        return $this->guildBankMoney;
     }
     
     /**
      * Returns guild bank items
      * @category Guilds class
      * @category Guilds class
      * @access   public
      * @return   array
      **/
     public function BuildGuildBankItemList() {
        if(!$this->guildId) {
            Armory::Log()->writeError('%s : guildId not defined', __METHOD__);
            return false;
        }
        $items_list = Armory::$cDB->select("SELECT `item_entry` AS `id`, `item_guid` AS `seed`, `SlotId` AS `slot`, `TabId` AS `bag` FROM `guild_bank_item` WHERE `guildid`=%d", $this->guildId);
        $count_items = count($items_list);
        for($i = 0; $i < $count_items; $i++) {
            $item_data = Armory::$wDB->selectRow("SELECT `RandomProperty`, `RandomSuffix` FROM `item_template` WHERE `entry` = %d LIMIT 1", $items_list[$i]['id']);
            $tmp_durability = Items::GetItemDurabilityByItemGuid($items_list[$i]['seed'], $this->m_server);
            $items_list[$i]['durability'] = (int) $tmp_durability['current'];
            $items_list[$i]['maxDurability'] = (int) $tmp_durability['max'];
            $items_list[$i]['icon'] = Items::GetItemIcon($items_list[$i]['id']);
            $items_list[$i]['name'] = Items::GetItemName($items_list[$i]['id']);            
            $items_list[$i]['qi'] = Items::GetItemInfo($items_list[$i]['id'], 'quality');
            if($this->m_server == SERVER_MANGOS) {
                $items_list[$i]['quantity'] = Items::GetItemDataField(ITEM_FIELD_STACK_COUNT, 0, 0, $items_list[$i]['seed']);
            }
            elseif($this->m_server == SERVER_TRINITY) {
                $items_list[$i]['quantity'] = Armory::$cDB->selectCell("SELECT `count` FROM `item_instance` WHERE `guid`=%d", $items_list[$i]['seed']);
            }
            //TODO: Find correct random property/suffix for items in guild vault.
            $items_list[$i]['randomPropertiesId'] = Items::GetRandomPropertiesData($items_list[$i]['id'], 0, $items_list[$i]['seed'], true, $this->m_server, null, $item_data);
            $tmp_classinfo = Items::GetItemSubTypeInfo($items_list[$i]['id']);
            $items_list[$i]['subtype'] = null;
            $items_list[$i]['subtypeLoc'] = $tmp_classinfo['subclass_name'];
            $items_list[$i]['type'] = $tmp_classinfo['key'];
            $items_list[$i]['slot']++;
        }
        return $items_list;
     }
     
     /**
      * Returns array with guild rank IDs.
      * @category Guilds class
      * @access   public
      * @return   array
      **/
     
     public function GetGuildRanks() {
        if(!$this->guildId) {
            Armory::Log()->writeError('%s : guildId not defined', __METHOD__);
            return false;
        }
        return Armory::$cDB->select("SELECT `rid` AS `id`, `rname` AS `name` FROM `guild_rank` WHERE `guildid`=%d", $this->guildId);
     }
     
     /* DEVELOPMENT SECTION */
     
     /*
     
     public function IsAllowedToGuildBank($tab) {
        if(!isset($_SESSION['accountId'])) {
            return false;
        }
        $chars_data = Armory::$cDB->select("
        SELECT
        `characters`.`guid`,
        `guild_member`.`guildid` AS `guildId`
        FROM `characters` AS `characters`
        LEFT JOIN `guild_member` AS `guild_member` ON `guild_member`.`guid`=`characters`.`guid`
        WHERE `characters`.`account`=%d AND `guild_member`.`guildid`=%d", $_SESSION['accountId'], $this->guildId);
        if(!$chars_data) {
            return false;
        }
        // Account have character in current guild but we need to check his/her bank access rights.
        $active_character_data = Utils::GetActiveCharacter();
        if($active_character_data['realmName'] != Armory::$currentRealmInfo['name']) {
            return false;
        }
        $rank = Armory::$cDB->selectCell("SELECT `rank` FROM `guild_member` WHERE `guid`=%d AND `guildid`=%d LIMIT 1", $active_character_data['guid'], $this->guildId);
        $rights = Armory::$cDB->selectCell("SELECT `rights` FROM `guild_rank` WHERE `guildid` = %d AND `rid`=%d LIMIT 1", $this->guildId, $rank);
        return ($this->GetBankRights($rank, $tab) & $rights) == $rights;
     }
     
     public function GetBankRights($rank, $tab) {
        return Armory::$cDB->selectCell("SELECT `gbright` FROM `guild_bank_right` WHERE `guildid` = %d AND `TabId` = %d AND `rid` = %d LIMIT 1", $this->guildId, $tab, $rank);
     }
     
     */
}
?>