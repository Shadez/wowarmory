<?php

/**
 * @package World of Warcraft Armory
 * @version Release 4.50
 * @revision 450
 * @copyright (c) 2009-2011 Shadez
 * @license http://opensource.org/licenses/gpl-license.php GNU Public License
 *
 * This program is free software; you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation; either version 2 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; with`out even the implied warranty of
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

Class Item {

    private $db       = false;
    private $entry    = false;
    private $equipped = false;
    private $loaded   = false;
    private $m_bag    = 0;
    private $m_guid   = false;
    private $m_ench   = array();
    private $m_owner  = 0;
    private $m_proto  = false;
    private $m_server = 0;
    private $m_slot   = 0;
    private $m_socketInfo = array();
    private $m_values = false;
    private $tc_data  = false;
    private $tc_ench  = false;
    
    /**
     * Class constructor
     * @category Item class
     * @access   public
     * @param    int $serverType
     * @return   bool
     **/
    public function Item($serverType) {
        if(!in_array($serverType, array(SERVER_MANGOS, SERVER_TRINITY))) {
            Armory::Log()->writeError('%s : fatal error: unknown server type (%d)!', __METHOD__, $serverType);
            return false;
        }
        $this->m_server = $serverType;
        return true;
    }
    
    /**
     * Load item from characters database
     * @category Item class
     * @access   public
     * @param    array $data
     * @param    int $owner_guid
     * @param    object $db
     * @return   bool
     **/
    public function LoadFromDB($data, $owner_guid, $db) {
        if(!is_object($db) || !$db->TestLink()) {
            Armory::Log()->writeError('%s : wrong database handler', __METHOD__);
            return false;
        }
        $this->db = $db;
        $this->m_owner = $owner_guid;
        $this->m_guid = $data['item'];
        if($this->m_server == SERVER_MANGOS) {
            $m_values = $this->db->selectCell("SELECT `data` FROM `item_instance` WHERE `guid`=%d AND `owner_guid`=%d", $this->m_guid, $this->m_owner);
            if(!$m_values) {
                Armory::Log()->writeError('%s : item (GUID: %d) was not found in `item_instance` table (server type: SERVER_MANGOS - %d)!', __METHOD__, $this->m_guid, $this->m_server);
                unset($db, $this->db);
                return false;
            }
            $this->m_values = explode(' ', $m_values);
            $this->entry = $data['item_template'];
        }
        elseif($this->m_server == SERVER_TRINITY) {
            $this->tc_data = $this->db->selectRow("SELECT * FROM `item_instance` WHERE `guid` = %d AND `owner_guid` = %d", $this->m_guid, $this->m_owner);
            if(!$this->tc_data) {
                Armory::Log()->writeError('%s : item (GUID: %d) was not found in `item_instance` table (server type: SERVER_TRINITY - %d)!', __METHOD__, $this->m_guid, $this->m_server);
                unset($db, $this->db);
                return false;
            }
            if(isset($this->tc_data['enchantments'])) {
                $this->tc_ench = explode(' ', $this->tc_data['enchantments']);
            }
            $this->entry = $this->tc_data['itemEntry'];
            $this->tc_data['maxdurability'] = Armory::$wDB->selectCell("SELECT `MaxDurability` FROM `item_template` WHERE `entry`=%d", $this->entry);
        }
        else {
            Armory::Log()->writeError('%s : unknown server type (%d), unable to handle item!', __METHOD__, $this->m_server);
            $this->loaded = false;
            return false;
        }
        if($data['bag'] == 0 && $data['slot'] < INV_MAX) {
            $this->equipped = true;
        }
        $this->m_slot = $data['slot'];
        $this->m_bag = $data['bag'];
        $this->m_ench = $data['enchants'];
        $this->m_socketInfo = array();
        $this->loaded = true;
        if($this->entry == 0) {
            $this->loaded = false;
            return false;
        }
        return true;
    }
    
    /**
     * @return bool
     **/
    public function IsCorrect() {
        if($this->m_guid > 0 && $this->entry > 0 && $this->loaded == true) {
            return true;
        }
        return false;
    }
    
    /**
     * @return bool
     **/
    public function IsEquipped() {
        return $this->equipped;
    }
    
    /**
     * Returns item GUID
     * @category Item class
     * @access   public
     * @return   int
     **/
    public function GetGUID() {
        return $this->m_guid;
    }
    
    /**
     * @return object
     **/
    public function GetProto() {
        if(!$this->m_proto) {
            $this->m_proto = new ItemPrototype();
            $this->m_proto->LoadItem($this->GetEntry(), $this->GetGUID(), $this->GetOwnerGUID());
            if(!$this->m_proto || !$this->m_proto->IsCorrect()) {
                Armory::Log()->writeError('%s : unable to find item with entry %d in `item_template` table.', __METHOD__, $this->GetEntry());
                return false;
            }
        }
        return $this->m_proto;
    }
    
    /**
     * @return int
     **/
    public function GetEntry() {
        return $this->entry;
    }
    
    /**
     * @return int
     **/
    public function GetOwnerGUID() {
        return $this->m_owner;
    }
    
    /**
     * @return object
     **/
    public function GetOwner() {
        return $this->GetOwnerGUID(); //PH
    }
    
    /**
     * @return bool
     **/
    public function IsBroken() {
        if($this->m_server == SERVER_MANGOS) {
            return $this->GetUInt32Value(ITEM_FIELD_MAXDURABILITY) > 0 && $this->GetUInt32Value(ITEM_FIELD_DURABILITY) == 0;
        }
        elseif($this->m_server == SERVER_TRINITY) {
            return $this->tc_data['maxdurability'] > 0 && $this->tc_data['durability'] == 0;
        }
        return false;
    }
    
    /**
     * @return int
     **/
    public function GetItemRandomPropertyId() {
        if($this->m_server == SERVER_MANGOS) {
            return $this->GetUInt32Value(ITEM_FIELD_RANDOM_PROPERTIES_ID);
        }
        elseif($this->m_server == SERVER_TRINITY) {
            return $this->tc_data['randomPropertyId'];
        }
        return 0;
    }
    
    /**
     * @return int
     **/
    public function GetItemSuffixFactor() {
        if($this->m_server == SERVER_MANGOS) {
            return $this->GetUInt32Value(ITEM_FIELD_PROPERTY_SEED);
        }
        return 0;
    }
    
    /**
     * @return int
     **/
    public function GetEnchantmentId() {
        return $this->m_ench;
    }
    
    /**
     * @return array
     **/
    public function GetSocketInfo($num) {
        if($num <= 0 || $num > 4) {
            return 0;
        }
        if(isset($this->m_socketInfo[$num])) {
            return $this->m_socketInfo[$num];
        }
        $data = array();
        switch($this->m_server) {
            case SERVER_MANGOS:
                $socketfield = array(
                    1 => ITEM_FIELD_ENCHANTMENT_3_2,
                    2 => ITEM_FIELD_ENCHANTMENT_4_2,
                    3 => ITEM_FIELD_ENCHANTMENT_5_2
                );
                $socketInfo = $this->GetUInt32Value($socketfield[$num]-1);
                break;
            case SERVER_TRINITY:
                $socketfield = array(
                    1 => 6,
                    2 => 9,
                    3 => 12
                );
                $socketInfo = $this->tc_ench[$socketfield[$num]];
                break;
            default:
                Armory::Log()->writeError('%s : unknown server type (%d)', __METHOD__, $this->m_server);
                return false;
                break;
        }
        if($socketInfo > 0) {
            $gemData = Armory::$aDB->selectRow("SELECT `text_%s` AS `text`, `gem` FROM `ARMORYDBPREFIX_enchantment` WHERE `id`=%d", Armory::GetLocale(), $socketInfo);
            $data['enchant_id'] = $socketInfo;
            $data['item'] = $gemData['gem'];
            $data['icon'] = Items::GetItemIcon($data['item']);
            $data['enchant'] = $gemData['text'];
            $data['color'] = Armory::$aDB->selectCell("SELECT `color` FROM `ARMORYDBPREFIX_gemproperties` WHERE `spellitemenchantement`=%d", $socketInfo);
            $this->m_socketInfo[$num] = $data; // Is it neccessary?
            return $data;
        }
        return false;
    }
    
    /**
     * @return int
     **/
    public function GetUInt32Value($index) {
        return (isset($this->m_values[$index])) ? $this->m_values[$index] : 0;
    }
    
    /**
     * @return int
     **/
    public function GetSlot() {
        return $this->m_slot;
    }
    
    /**
     * @return int
     **/
    public function GetBag() {
        return $this->m_bag;
    }
    
    /**
     * @return int
     **/
    public function GetSkill() {
        $item_weapon_skills = array(
            SKILL_AXES,     SKILL_2H_AXES,  SKILL_BOWS,          SKILL_GUNS,      SKILL_MACES,
            SKILL_2H_MACES, SKILL_POLEARMS, SKILL_SWORDS,        SKILL_2H_SWORDS, 0,
            SKILL_STAVES,   0,              0,                   SKILL_UNARMED,   0,
            SKILL_DAGGERS,  SKILL_THROWN,   SKILL_ASSASSINATION, SKILL_CROSSBOWS, SKILL_WANDS,
            SKILL_FISHING
        );
        $item_armor_skills = array(
            0, SKILL_CLOTH, SKILL_LEATHER, SKILL_MAIL, SKILL_PLATE_MAIL, 0, SKILL_SHIELD, 0, 0, 0, 0
        );
        $item_info = Armory::$wDB->selectRow("SELECT `class`, `subclass` FROM `item_template` WHERE `entry`=%d", $this->GetEntry());
        if(!$item_info) {
            return 0;
        }
        switch($item_info['class']) {
            case ITEM_CLASS_WEAPON:
                if($item_info['subclass'] > MAX_ITEM_SUBCLASS_WEAPON) {
                    return 0;
                }
                return (isset($item_weapon_skills[$item_info['subclass']])) ? $item_weapon_skills[$item_info['subclass']] : 0;
                break;
            case ITEM_CLASS_ARMOR:
                if($item_info['subclass'] > MAX_ITEM_SUBCLASS_ARMOR) {
                    return 0;
                }
                return (isset($item_armor_skills[$item_info['subclass']])) ? $item_armor_skills[$item_info['subclass']] : 0;
                break;
            default:
                return 0;
                break;
        }
    }
    
    /**
     * @return int
     **/
    public function GetCurrentDurability() {
        if($this->m_server == SERVER_MANGOS) {
            return $this->GetUInt32Value(ITEM_FIELD_DURABILITY);
        }
        elseif($this->m_server == SERVER_TRINITY) {
            return $this->tc_data['durability'];
        }
        Armory::Log()->writeLog('%s : wrong server type', __METHOD__);
        return 0;
    }
    
    /**
     * @return int
     **/
    public function GetMaxDurability() {
        if($this->m_server == SERVER_MANGOS) {
            return $this->GetUInt32Value(ITEM_FIELD_MAXDURABILITY);
        }
        elseif($this->m_server == SERVER_TRINITY) {
            return $this->tc_data['maxdurability']; // assigned in Item::LoadFromDB()
        }
        Armory::Log()->writeLog('%s : wrong server type', __METHOD__);
        return 0;
    }
    
    /**
     * @return array
     **/
    public function GetItemDurability() {
        return array('current' => $this->GetCurrentDurability(), 'max' => $this->GetMaxDurability());
    }
    
    /**
     * @return array
     **/
    public function GetRandomSuffixData() {
        if($this->m_server != SERVER_MANGOS) {
            Armory::Log()->writeError('%s : this method is usable with MaNGOS servers only.', __METHOD__);
            return false;
        }
        return array(
            $this->GetUInt32Value(ITEM_FIELD_ENCHANTMENT_8_1),
            $this->GetUInt32Value(ITEM_FIELD_ENCHANTMENT_9_1),
            $this->GetUInt32Value(ITEM_FIELD_ENCHANTMENT_10_1)
        );
    }
}

?>