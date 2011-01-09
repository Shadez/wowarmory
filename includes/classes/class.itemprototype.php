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

/**
 * This class used in item tooltips.
 **/
Class ItemPrototype {
    
    public $entry;
    public $class;
    public $subclass;
    public $unk0;
    public $name;
    public $displayid;
    public $Quality;
    public $Flags;
    public $Flags2;     // MaNGOS field
    public $FlagsExtra; // Trinity Core field
    public $BuyCount;
    public $BuyPrice;
    public $SellPrice;
    public $InventoryType;
    public $AllowableClass;
    public $AllowableRace;
    public $ItemLevel;
    public $RequiredLevel;
    public $RequiredSkill;
    public $RequiredSkillRank;
    public $requiredspell;
    public $requiredhonorrank;
    public $RequiredCityRank;
    public $RequiredReputationFaction;
    public $RequiredReputationRank;
    public $maxcount;
    public $stackable;
    public $ContainerSlots;
    public $StatsCount;
    public $stat_type1;
    public $stat_value1;
    public $stat_type2;
    public $stat_value2;
    public $stat_type3;
    public $stat_value3;
    public $stat_type4;
    public $stat_value4;
    public $stat_type5;
    public $stat_value5;
    public $stat_type6;
    public $stat_value6;
    public $stat_type7;
    public $stat_value7;
    public $stat_type8;
    public $stat_value8;
    public $stat_type9;
    public $stat_value9;
    public $stat_type10;
    public $stat_value10;
    public $ScalingStatDistribution;
    public $ScalingStatValue;
    public $dmg_min1;
    public $dmg_max1;
    public $dmg_type1;
    public $dmg_min2;
    public $dmg_max2;
    public $dmg_type2;
    public $armor;
    public $holy_res;
    public $fire_res;
    public $nature_res;
    public $frost_res;
    public $shadow_res;
    public $arcane_res;
    public $delay;
    public $ammo_type;
    public $RangedModRange;
    public $spellid_1;
    public $spelltrigger_1;
    public $spellcharges_1;
    public $spellppmRate_1;
    public $spellcooldown_1;
    public $spellcategory_1;
    public $spellcategorycooldown_1;
    public $spellid_2;
    public $spelltrigger_2;
    public $spellcharges_2;
    public $spellppmRate_2;
    public $spellcooldown_2;
    public $spellcategory_2;
    public $spellcategorycooldown_2;
    public $spellid_3;
    public $spelltrigger_3;
    public $spellcharges_3;
    public $spellppmRate_3;
    public $spellcooldown_3;
    public $spellcategory_3;
    public $spellcategorycooldown_3;
    public $spellid_4;
    public $spelltrigger_4;
    public $spellcharges_4;
    public $spellppmRate_4;
    public $spellcooldown_4;
    public $spellcategory_4;
    public $spellcategorycooldown_4;
    public $spellid_5;
    public $spelltrigger_5;
    public $spellcharges_5;
    public $spellppmRate_5;
    public $spellcooldown_5;
    public $spellcategory_5;
    public $spellcategorycooldown_5;
    public $bonding;
    public $description;
    public $PageText;
    public $LanguageID;
    public $PageMaterial;
    public $startquest;
    public $lockid;
    public $Material;
    public $sheath;
    public $RandomProperty;
    public $RandomSuffix;
    public $block;
    public $itemset;
    public $MaxDurability;
    public $area;
    public $Map;
    public $BagFamily;
    public $TotemCategory;
    public $socketColor_1;
    public $socketContent_1;
    public $socketColor_2;
    public $socketContent_2;
    public $socketColor_3;
    public $socketContent_3;
    public $socketBonus;
    public $GemProperties;
    public $RequiredDisenchantSkill;
    public $ArmorDamageModifier;
    public $Duration;
    public $ItemLimitCategory;
    public $HolidayId;
    public $ScriptName;
    public $DisenchantID;
    public $FoodType;
    public $minMoneyLoot;
    public $maxMoneyLoot;
    public $ExtraFlags;
    
    public $ItemStat = array();
    public $Damage = array();
    public $Spells = array();
    public $Socket = array();
    
    private $loaded  = false;
    private $m_guid  = 0;
    private $m_owner = 0;
    
    public function LoadItem($item_entry, $itemGuid = 0, $ownerGuid = 0) {
        $item_row = Armory::$wDB->selectRow("SELECT * FROM `item_template` WHERE `entry` = '%d' LIMIT 1", $item_entry);
        if(!$item_row) {
            Armory::Log()->writeError('%s : item #%d (GUID: %d) was not found in `item_template` table.', __METHOD__, $item_entry, $itemGuid);
            return false;
        }
        // FlagsExtra check
        if(isset($item_row['FlagsExtra'])) {
            $item_row['Flags2'] = $item_row['FlagsExtra'];
            unset($item_row['FlagsExtra']); // For compatibility
        }
        // Assign variables
        foreach($item_row as $field => $value) {
            $this->{$field} = $value;
        }
        // Create arrays
        
        // Item mods
        for($i = 0; $i < MAX_ITEM_PROTO_STATS+1; $i++) {
            $key = $i+1;
            if(isset($this->{'stat_type' . $key})) {
                $this->ItemStat[$i] = array(
                    'type'  => $this->{'stat_type'  . $key},
                    'value' => $this->{'stat_value' . $key});
            }
        }
        // Item damages
        for($i = 0; $i < MAX_ITEM_PROTO_DAMAGES+1; $i++) {
            $key = $i+1;
            if(isset($this->{'dmg_type' . $key})) {
                $this->Damage[$i] = array(
                    'type' => $this->{'dmg_type' . $key},
                    'min'  => $this->{'dmg_min'  . $key},
                    'max'  => $this->{'dmg_max'  . $key});
            }
        }
        // Item spells
        for($i = 0; $i < MAX_ITEM_PROTO_SPELLS+1; $i++) {
            $key = $i+1;
            if(isset($this->{'spellid_' . $key})) {
                $this->Spells[$i] = array(
                    'spellid'          => $this->{'spellid_'               . $key}, 
                    'trigger'          => $this->{'spelltrigger_'          . $key}, 
                    'charges'          => $this->{'spellcharges_'          . $key}, 
                    'ppmRate'          => $this->{'spellppmRate_'          . $key},
                    'cooldown'         => $this->{'spellcooldown_'         . $key},
                    'category'         => $this->{'spellcategory_'         . $key},
                    'categorycooldown' => $this->{'spellcategorycooldown_' . $key}
                );
            }
        }
        // Item sockets
        for($i = 0; $i < MAX_ITEM_PROTO_SOCKETS+1; $i++) {
            $key = $i+1;
            if(isset($this->{'socketColor_' . $key})) {
                $this->Socket[$i] = array(
                    'color'   => $this->{'socketColor_'   . $key},
                    'content' => $this->{'socketContent_' . $key}
                );
            }
        }
        $this->m_guid  = $itemGuid;  // Can have NULL value.
        $this->m_owner = $ownerGuid; // Can have NULL value.
        $this->loaded  = true;
        return true;
    }
    
    public function IsCorrect() {
        if($this->entry > 0 && $this->loaded == true) {
            // Do not check item GUID and owner GUID here.
            return true;
        }
        return false;
    }
    
    /* Helpers (not used now; from MaNGOS core) */
    public function getFeralBonus($extraDPS = 0) {
        if($this->class == ITEM_CLASS_WEAPON && (1 << $this->subclass) & 0x02A5F3) {
            $bonus = ($extraDPS + $this->getDPS()*14.0) - 767;
            if($bonus < 0) {
                $bonus = 0;
            }
            return $bonus;
        }
        return 0;
    }
    
    public function getDPS() {
        if($this->delay == 0) {
            return 0;
        }
        $temp = 0;
        for($i = 0; $i < MAX_ITEM_PROTO_DAMAGES; $i++) {
            $temp += $this->Damage[$i]['min'] + $this->Damage[$i]['max'];
        }
        return $temp * 500 / $this->delay;
    }
    
    // Not used now.
    public function GetItemQualityColor() {
        $colors_array = array(
            '#c9c9c9',        //GREY
            '#ffffff',        //WHITE
            '#00FF00',        //GREEN
            '#0070DD',        //BLUE
            '#A335EE',        //PURPLE
            '#ff8000',        //ORANGE
            '#7e7046',        //LIGHT YELLOW
            '#7e7046'         //LIGHT YELLOW
        );
        return (isset($colors_array[$this->Quality])) ? $colors_array[$this->Quality] : $colors_array[1];
    }
}

?>