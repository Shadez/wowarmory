<?php

/**
 * @package World of Warcraft Armory
 * @version Release Candidate 1
 * @revision 400
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

Class Items {
    
    public $armory = null;
    
    /**
     * Not used now
     **/
    public $itemId;
    
    /**
     * $charGuid used by item-tooltip.php (enchantments, sockets & item durability for current character)
     **/
    public $charGuid;
    
    public function Items($armory) {
        if(!is_object($armory)) {
            die('<b>Fatal Error:</b> armory must be instance of Armory class!');
        }
        $this->armory = $armory;
    }
    
    /**
     * Checks is item exists in DB
     * @category Items class
     * @access   public
     * @param    int $itemID
     * @return   bool
     **/
    public function IsItemExists($itemID) {
        if($this->armory->wDB->selectCell("SELECT 1 FROM `item_template` WHERE `entry`=%d LIMIT 1", $itemID)) {
            return true;
        }
        return false;
    }
    
    /**
     * Returns item name according with defined locale (ru_ru, en_gb, etc.)
     * @category Items class
     * @access   public
     * @param    int $itemID
     * @return   string
     **/
    public function GetItemName($itemID) {
        if($this->armory->GetLocale() == 'en_gb' || $this->armory->GetLocale() == 'en_us') {
            $itemName = $this->armory->wDB->selectCell("SELECT `name` FROM `item_template` WHERE `entry`=%d LIMIT 1", $itemID);
        }
        else {
            $itemName = $this->armory->wDB->selectCell("SELECT `name_loc%d` FROM `locales_item` WHERE `entry`=%d LIMIT 1", $this->armory->GetLoc(), $itemID);
            if(!$itemName) {
                $itemName = $this->armory->wDB->selectCell("SELECT `name` FROM `item_template` WHERE `entry`=%d LIMIT 1", $itemID);
            }
        }
        if($itemName) {
            return $itemName;
        }
        return false;
    }
    
    /**
     * Returns item icon
     * @category Items class
     * @access   public
     * @param    int $itemID
     * @param    int $displayId = 0
     * @return   string
     **/
    public function GetItemIcon($itemID, $displayId = 0) {
        if($displayId == 0) {
            $displayId = $this->armory->wDB->selectCell("SELECT `displayid` FROM `item_template` WHERE `entry`=%d LIMIT 1", $itemID);
        }
        $itemIcon = $this->armory->aDB->selectCell("SELECT `icon` FROM `ARMORYDBPREFIX_icons` WHERE `displayid`=%d LIMIT 1", $displayId);
        return strtolower($itemIcon);
    }
    
    /**
     * Returns item description (if isset) according with defined locale (ru_ru or en_gb)
     * @category Items class
     * @access   public
     * @param    int $itemID
     * @return   string
     **/
    public function GetItemDescription($itemID) {
        if($this->armory->GetLocale() == 'en_gb' || $this->armory->GetLocale() == 'en_us') {
            $itemDescription = $this->armory->wDB->selectCell("SELECT `description` FROM `item_template` WHERE `entry`=%d LIMIT 1", $itemID);
        }
        else {
            $itemDescription = $this->armory->wDB->selectCell("SELECT `description_loc%d` FROM `locales_item` WHERE `entry`=%d LIMIT 1", $this->armory->GetLoc(), $itemID);
            if(!$itemDescription) {
                $itemDescription = $this->armory->wDB->selectCell("SELECT `description` FROM `item_template` WHERE `entry`=%d LIMIT 1", $itemID);
            }
        }
        if($itemDescription) {
            return $itemDescription;
        }
        return false;
    }
    
    /**
     * Returns available races string (if mask > 0)
     * @category Items class
     * @access   public
     * @param    int $mask
     * @return   string
     **/
    public function AllowableRaces($mask) {
        $mask &= 0x7FF;
        // Return zero if for all class (or for none)
		if($mask == 0x7FF || $mask == 0) {
            return 0;
		}
        $races = $this->armory->aDB->select("SELECT `id`, `name_%s` AS `name` FROM `ARMORYDBPREFIX_races`", $this->armory->GetLocale());
        if(!is_array($races)) {
            $this->armory->Log()->writeError('%s : unable to find races names for locale %s (%d)', __METHOD__, $this->armory->GetLocale(), $this->armory->GetLoc());
            return false;
        }
        $races_data = array();
        foreach($races as $race_tmp) {
            $races_data[$race_tmp['id']] = $race_tmp['name'];
        }
        $i = 1;
        $rMask = array();
        while($mask) {
			if($mask & 1) {
                $rMask[$i] = $races_data[$i];
		   	}
			$mask>>=1;
			$i++;
		}
		return $rMask;
    }
    
    /**
     * Returns available classes string (if mask > 0)
     * @category Items class
     * @access   public
     * @param    int $mask
     * @return   string
     **/
    public function AllowableClasses($mask) {
		$mask &= 0x5DF;
		// Return zero if for all class (or for none
		if($mask == 0x5DF || $mask == 0) {
            return 0;
		}
        $classes = $this->armory->aDB->select("SELECT `id`, `name_%s` AS `name` FROM `ARMORYDBPREFIX_classes`", $this->armory->GetLocale());
        if(!is_array($classes)) {
            $this->armory->Log()->writeError('%s : unable to find classes names for locale %s (%d)', __METHOD__, $this->armory->GetLocale(), $this->armory->GetLoc());
            return false;
        }
        $classes_data = array();
        foreach($classes as $class_tmp) {
            $classes_data[$class_tmp['id']] = $class_tmp['name'];
        }
        $i = 1;
        $rMask = array();
        while($mask) {
			if($mask & 1) {
                $rMask[$i] = $classes_data[$i];
	    	}
			$mask>>=1;
			$i++;
		}
		return $rMask;
	}
    
    /**
     * Returns item source string (vendor, drop, chest loot, etc.)
     * @category Items class
     * @access   public
     * @param    int $item
     * @param    bool $areaDataOnly = false
     * @return   string
     **/
    public function GetItemSource($item, $areaDataOnly = false) {
		$bossLoot = $this->armory->wDB->selectCell("SELECT `entry` FROM `creature_loot_template` WHERE `item`=%d LIMIT 1", $item);
        if($bossLoot) {
            if(Mangos::GetNpcInfo($bossLoot, 'isBoss') && self::IsUniqueLoot($item)) {
                // We have boss loot, generate improved tooltip.
                return self::GetImprovedItemSource($item, $bossLoot, $areaDataOnly);
            }
            elseif(Mangos::GetNpcInfo($bossLoot, 'isBoss')) {
                return array('value' => 'sourceType.creatureDrop');
            }
            else {
                return array('value' => 'sourceType.worldDrop');
            }
        }
        $chestLoot = $this->armory->wDB->selectCell("SELECT `entry` FROM `gameobject_loot_template` WHERE `item`=%d LIMIT 1", $item);
        if($chestLoot) {
            if($chest_data = self::GetImprovedItemSource($item, $chestLoot, $areaDataOnly)) {
                return $chest_data;
            }
            else {
                return array('value' => 'sourceType.gameObjectDrop');
            }
        }
        $vendorLoot = $this->armory->wDB->selectCell("SELECT `entry` FROM `npc_vendor` WHERE `item`=%d LIMIT 1", $item);
        $reputationReward = $this->armory->wDB->selectCell("SELECT `RequiredReputationFaction` FROM `item_template` WHERE `entry`=%d", $item);
        if($vendorLoot && $reputationReward > 0) {
            return array('value' => 'sourceType.factionReward');
		}
        elseif($vendorLoot && (!$reputationReward || $reputationReward == 0)) {
            return array('value' => 'sourceType.vendor');
        }
        $questLoot = $this->armory->wDB->selectCell("
		SELECT `entry`
		  FROM `quest_template`
		      WHERE `RewChoiceItemId1` = %d OR `RewChoiceItemId2` = %d OR `RewChoiceItemId3` = %d OR 
		          `RewChoiceItemId4` = %d OR `RewChoiceItemId5` = %d OR `RewChoiceItemId6` = %d LIMIT 1", $item, $item, $item, 
		$item, $item, $item);
        if($questLoot) {
            return array('value' => 'sourceType.questReward');
        }
        $craftLoot = $this->armory->aDB->selectCell("SELECT `id` FROM `ARMORYDBPREFIX_spell` WHERE `EffectItemType_1`=%d OR `EffectItemType_2`=%d OR `EffectItemType_3`=%d LIMIT 1", $item, $item, $item);
        if($craftLoot) {
            return array('value' => 'sourceType.createdByPlans');
        }
        return array('value' => 'sourceType.none');
    }
    
    /**
     * Return itemset bonus spell(s) info
     * @category Items class
     * @access   public
     * @param    int $itemsetdata
     * @return   array
     **/
    public function GetItemSetBonusInfo($itemsetdata) {
        if($this->armory->GetLocale() == 'en_gb' || $this->armory->GetLocale() == 'ru_ru') {
            $tmp_locale = $this->armory->GetLocale();
        }
        else {
            $tmp_locale = 'en_gb';
        }
        $itemSetBonuses = array();
        for($i = 1; $i < 9; $i++) {
            if($itemsetdata['bonus' . $i] > 0) {
                $threshold = $itemsetdata['threshold' . $i];
                $spell_tmp = array();
                $spell_tmp = $this->armory->aDB->selectRow("SELECT * FROM `ARMORYDBPREFIX_spell` WHERE `id`=%d", $itemsetdata['bonus' . $i]);
                if(!isset($spell_tmp['Description_' . $tmp_locale]) || empty($spell_tmp['Description_' . $tmp_locale])) {
                    // try to find en_gb locale
                    if(isset($spell_tmp['Description_en_gb']) && !empty($spell_tmp['Description_en_gb'])) {
                        $tmp_locale = 'en_gb';
                    }
                    else {
                        continue;
                    }
                }
                $itemSetBonuses[$threshold]['desc'] = self::SpellReplace($spell_tmp, Utils::ValidateSpellText($spell_tmp['Description_' . $tmp_locale]));
                $itemSetBonuses[$threshold]['desc'] = str_replace('&quot;', '"', $itemSetBonuses[$threshold]['desc']);
                $itemSetBonuses[$threshold]['threshold'] = $threshold;
                
            }
	   }
       sort($itemSetBonuses); // Correct display itemset bonuses
	   return $itemSetBonuses;
    }
    
    /**
     * Return array with loot info: dropped by, contained in, disenchating to, reagent for, etc.
     * @category Items class
     * @access   public
     * @param    int $item
     * @param    int $vendor
     * @param    array $data = false
     * @return   array
     **/
    public function BuildLootTable($item, $vendor, $data=false) {
        $lootTable = array();
        switch($vendor) {
            case 'vendor':
                $VendorLoot = $this->armory->wDB->select("SELECT `entry`, `ExtendedCost` FROM `npc_vendor` WHERE `item`=%d", $item);
                if(is_array($VendorLoot)) {
				    $i = 0;
                    foreach($VendorLoot as $vItem) {
                        $lootTable[$i] = $this->armory->wDB->selectRow("SELECT `entry` AS `id`, `minlevel` AS `minLevel`, `maxlevel` AS `maxLevel`, name FROM `creature_template` WHERE `entry`=%d", $vItem['entry']);
                        if($this->armory->GetLocale() != 'en_gb' || $this->armory->GetLocale() != 'en_us') {
                            $lootTable[$i]['name'] = Mangos::GetNpcName($vItem['entry']);
                        }
                        $lootTable[$i]['area'] = Mangos::GetNpcInfo($vItem['entry'], 'map');
                        $i++;
                    }
                }
                break;
            case 'boss':
                $BossLoot = $this->armory->wDB->select("SELECT `entry` FROM `creature_loot_template` WHERE `item`=%d", $item);
                if(is_array($BossLoot)) {
				    $i = 0;
                    foreach($BossLoot as $bItem) {
                        $lootTable[$i] = $this->armory->wDB->selectRow("SELECT `entry` AS `id`, `name`, `minlevel` AS `minLevel`, `maxlevel` AS `maxLevel`, `rank` AS `classification` FROM `creature_template` WHERE `entry`=%d", $bItem['entry']);
                        if($this->armory->GetLocale() != 'en_gb' || $this->armory->GetLocale() != 'en_us') {
                            $lootTable[$i]['name'] = Mangos::GetNpcName($bItem['entry']);
                        }
                        if(Mangos::GetNpcInfo($bItem['entry'], 'isBoss')) {
                            $areaData = self::GetImprovedItemSource($item, $bItem['entry'], true);
                            $lootTable[$i]['area'] = $areaData['areaName'];
                            $lootTable[$i]['areaUrl'] = $areaData['areaUrl'];
                        }
                        else {
                            $lootTable[$i]['area'] = Mangos::GetNpcInfo($bItem['entry'], 'map');
                            $lootTable[$i]['areaUrl'] = Mangos::GetNpcInfo($bItem['entry'], 'areaUrl');
                        }
                        $drop_percent = Mangos::GenerateLootPercent($bItem['entry'], 'creature_loot_template', $item);
                        $lootTable[$i]['dropRate'] = Mangos::GetDropRate($drop_percent);
                        if($lootTable[$i]['areaUrl'] && Mangos::GetNpcInfo($bItem['entry'], 'isBoss')) {
                            $lootTable[$i]['url'] = str_replace('boss=all', 'boss='.$bItem['entry'], $lootTable[$i]['areaUrl']);
                        }
                        $i++;
                    }
                }
                break;
            case 'chest':
                $ChestLoot = $this->armory->wDB->select("SELECT `entry` FROM `gameobject_loot_template` WHERE `item`=%d", $item);
                if(is_array($ChestLoot)) {
                    $i = 0;
                    foreach($ChestLoot as $cItem) {
                        $drop_percent = Mangos::GenerateLootPercent($cItem['entry'], 'gameobject_loot_template', $item);
                        $lootTable[$i] = array (
                            'name' => Mangos::GetGameObjectInfo($cItem['entry'], 'name'),
                            'id' => $cItem['entry'],
                            'dropRate' => Mangos::GetDropRate($drop_percent)
                        );
                        if(Mangos::GetGameObjectInfo($cItem['entry'], 'isInInstance')) {
                            $areaData = self::GetImprovedItemSource($item, $cItem['entry'], true);
                            $lootTable[$i]['area'] = $areaData['areaName'];
                            $lootTable[$i]['areaUrl'] = $areaData['areaUrl'];
                        }
                        else {
                            $lootTable[$i]['area'] = Mangos::GetGameObjectInfo($cItem['entry'], 'map');
                            $lootTable[$i]['areaUrl'] = Mangos::GetGameObjectInfo($cItem['entry'], 'areaUrl');
                        }
                        $i++;
                    }
                }
                break;
            case 'questreward':
                $QuestLoot = $this->armory->wDB->select("
                SELECT `entry` AS `id`, `Title` AS `name`, `QuestLevel` AS `level`, `MinLevel` AS `reqMinLevel`, `SuggestedPlayers` AS `suggestedPartySize`
                    FROM `quest_template`
                        WHERE `RewChoiceItemId1` = %d OR `RewChoiceItemId2` = %d OR `RewChoiceItemId3` = %d OR 
                            `RewChoiceItemId4` = %d OR `RewChoiceItemId5` = %d OR `RewChoiceItemId6` = %d", $item, $item, $item, $item, $item, $item);
                if(is_array($QuestLoot)) {
                    $i = 0;
                    foreach($QuestLoot as $qItem) {
                        $lootTable[$i] = $qItem;
                        if($this->armory->GetLocale() != 'en_gb' || $this->armory->GetLocale() != 'en_us') {
                            $lootTable[$i]['name'] = Mangos::GetQuestInfo($qItem['id'], 'title');
                        }
                        $lootTable[$i]['area'] = Mangos::GetQuestInfo($qItem['id'], 'map');
                        $i++;
                    }
                }
                break;
            case 'queststart':
                $QuestStart = $this->armory->wDB->selectCell("SELECT `startquest` FROM `item_template` WHERE `entry`=%d", $item);
                if(!$QuestStart) {
                    return false;
                }
                $lootTable = $this->armory->wDB->selectRow("SELECT `entry` AS `id`, `Title` AS `name`, `QuestLevel` AS `level`, `MinLevel` AS `reqMinLevel`, `SuggestedPlayers` AS `suggestedPartySize` FROM `quest_template` WHERE `entry`=%d", $QuestStart);
                if($this->armory->GetLocale() != 'en_gb' || $this->armory->GetLocale() != 'en_us') {
                    $lootTable['name'] = Mangos::GetQuestInfo($QuestStart, 'title');
                }
                $lootTable['name'] = Mangos::GetQuestInfo($QuestStart, 'title');
                $lootTable['area'] =  Mangos::GetQuestInfo($QuestStart, 'map');
                break;
            case 'providedfor':
                $QuestInfo = $this->armory->wDB->select("SELECT `entry` AS `id`, `QuestLevel` AS `level`, `Title` AS `name`, `MinLevel` AS `reqMinLevel`, `SuggestedPlayers` AS `suggestedPartySize` FROM `quest_template` WHERE `SrcItemId`=%d", $item);
                if(is_array($QuestInfo)) {
                    $i = 0;
                    foreach($QuestInfo as $quest) {
                        $lootTable[$i] = $quest;
                        if($this->armory->GetLocale() != 'en_gb' || $this->armory->GetLocale() != 'en_us') {
                            $lootTable[$i]['name'] = Mangos::GetQuestInfo($quest['id'], 'title');
                        }
                        $lootTable[$i]['area'] = Mangos::GetQuestInfo($quest['id'], 'map');
                    }
                }
                break;            
            case 'objectiveof':
                $QuestInfo = $this->armory->wDB->select("
                SELECT `entry` AS `id`, `QuestLevel` AS `level`, `Title` AS `name`, `MinLevel` AS `reqMinLevel`, `SuggestedPlayers` AS `suggestedPartySize`
                    FROM `quest_template`
                        WHERE `ReqItemId1`=%d OR `ReqItemId2`=%d OR `ReqItemId3`=%d OR `ReqItemId4`=%d OR `ReqItemId5`=%d", $item, $item, $item, $item, $item);
                if(is_array($QuestInfo)) {
                    $i = 0;
                    foreach($QuestInfo as $quest) {
                        $lootTable[$i] = $quest;
                        if($this->armory->GetLocale() != 'en_gb' || $this->armory->GetLocale() != 'en_us') {
                            $lootTable[$i]['name'] = Mangos::GetQuestInfo($quest['id'], 'title');
                        }
                        $lootTable[$i]['area'] = Mangos::GetQuestInfo($quest['id'], 'map');
                    }
                }
                break;
            case 'disenchant':
                $DisenchantLoot = $this->armory->wDB->select("SELECT `item`, `maxcount`, `mincountOrRef` FROM `disenchant_loot_template` WHERE `entry`=%d", $item);
                if(is_array($DisenchantLoot)) {
                    $i = 0;
                    foreach($DisenchantLoot as $dItem) {
                        $tmp_info = $this->armory->wDB->selectRow("SELECT `name`, `Quality`, `displayid` FROM `item_template` WHERE `entry`=%d LIMIT 1", $dItem['item']);
                        $drop_percent = Mangos::GenerateLootPercent($item, 'disenchant_loot_template', $dItem['item']);
                        $lootTable[$i] = array (
                            'id'       => $dItem['item'],
                            'name'     => ($this->armory->GetLocale() == 'en_gb' || $this->armory->GetLocale() == 'en_us') ? $tmp_info['name'] : self::GetItemName($dItem['item']),
                            'dropRate' => Mangos::GetDropRate($drop_percent),
                            'maxCount' => $dItem['maxcount'],
                            'minCount' => $dItem['mincountOrRef'],
                            'icon'     => self::GetItemIcon($dItem['item'], $tmp_info['displayid']),
                            'quality'  => $tmp_info['Quality']
                        );
                        $i++;
                    }
                }
                break;
            case 'craft':
                if($this->armory->GetLocale() == 'en_gb' || $this->armory->GetLocale() == 'ru_ru') {
                    $CraftLoot = $this->armory->aDB->select("
                    SELECT `Reagent_1`, `Reagent_2`, `Reagent_3`, `Reagent_4`, `Reagent_5`, `Reagent_6`, `Reagent_7`, `Reagent_8`,
                        `ReagentCount_1`, `ReagentCount_2`, `ReagentCount_3`, `ReagentCount_4`, `ReagentCount_5`, `ReagentCount_6`, 
                        `ReagentCount_7`, `ReagentCount_8`, `EffectItemType_1`, `EffectItemType_2`, `EffectItemType_3`,
                        `SpellName_%s` AS `SpellName`, `SpellIconID`
                        FROM `ARMORYDBPREFIX_spell`
                            WHERE `EffectItemType_1` =%d OR `EffectItemType_2`=%d OR `EffectItemType_3`=%d", $this->armory->GetLocale(), $item, $item, $item);
                }
                else {
                    $CraftLoot = $this->armory->aDB->select("
                    SELECT `Reagent_1`, `Reagent_2`, `Reagent_3`, `Reagent_4`, `Reagent_5`, `Reagent_6`, `Reagent_7`, `Reagent_8`,
                        `ReagentCount_1`, `ReagentCount_2`, `ReagentCount_3`, `ReagentCount_4`, `ReagentCount_5`, `ReagentCount_6`, 
                        `ReagentCount_7`, `ReagentCount_8`, `EffectItemType_1`, `EffectItemType_2`, `EffectItemType_3`,
                        `SpellName_en_gb` AS `SpellName`, `SpellIconID`
                        FROM `ARMORYDBPREFIX_spell`
                            WHERE `EffectItemType_1` =%d OR `EffectItemType_2`=%d OR `EffectItemType_3`=%d", $item, $item, $item);
                }
                if(is_array($CraftLoot)) {
                    $i=0;
                    foreach($CraftLoot as $craftItem) {
                        $lootTable[$i]['spell']   = array();
                        $lootTable[$i]['item']    = array();
                        $lootTable[$i]['reagent'] = array();                    
                        $lootTable[$i]['spell']['name'] = $craftItem['SpellName'];
                        $lootTable[$i]['spell']['icon'] = $this->armory->aDB->selectCell("SELECT `icon` FROM `ARMORYDBPREFIX_speillicon` WHERE `id`=%d", $craftItem['SpellIconID']);
                        for($o = 1; $o < 9; $o++) {
                            if($craftItem['Reagent_'.$o] > 0) {
                                $tmp_info = $this->armory->wDB->selectRow("SELECT `name`, `Quality`, `displayid` FROM `item_template` WHERE `entry`=%d LIMIT 1", $craftItem['Reagent_'.$o]);
                                $lootTable[$i]['reagent'][$o]['id'] = $craftItem['Reagent_'.$o];
                                $lootTable[$i]['reagent'][$o]['name'] = ($this->armory->GetLocale() == 'en_gb' || $this->armory->GetLocale() == 'en_us') ? $tmp_info['name'] : self::GetItemName($craftItem['Reagent_'.$o]);
                                $lootTable[$i]['reagent'][$o]['icon'] = self::GetItemIcon($craftItem['Reagent_'.$o], $tmp_info['displayid']);
                                $lootTable[$i]['reagent'][$o]['count'] = $craftItem['ReagentCount_'.$o];
                                $lootTable[$i]['reagent'][$o]['quality'] = $tmp_info['Quality'];
                            }
                        }
                        for($j = 1; $j < 4; $j++) {
                            if($craftItem['EffectItemType_'.$j] > 0) {
                                $tmp_info = $this->armory->wDB->selectRow("SELECT `name`, `Quality`, `displayid` FROM `item_template` WHERE `entry`=%d LIMIT 1", $craftItem['EffectItemType_'.$j]);
                                $lootTable[$i]['item'][$j]['name'] = ($this->armory->GetLocale() == 'en_gb' || $this->armory->GetLocale() == 'en_us') ? $tmp_info['name'] : self::GetItemName($craftItem['EffectItemType_'.$j]);
                                $lootTable[$i]['item'][$j]['id'] = $craftItem['EffectItemType_'.$j];
                                $lootTable[$i]['item'][$j]['icon'] = self::GetItemIcon($craftItem['EffectItemType_'.$j], $tmp_info['displayid']);
                                $lootTable[$i]['item'][$j]['quality'] = $tmp_info['Quality'];
                            }
                        }
                        $i++;
                    }
                }
                break;
            case 'currencyfor':
                $exCostIds = $this->armory->aDB->select("SELECT `id` FROM `ARMORYDBPREFIX_extended_cost` WHERE `item1`=%d OR `item2`=%d OR `item3`=%d OR `item4`=%d OR `item5`=%d", $item, $item, $item, $item, $item);
                if(!$exCostIds || !is_array($exCostIds)) {
                    return false;
                }
                $CostIDs = array('pos' => array(), 'neg' => array());
                foreach($exCostIds as $tmp_cost) {
                    $CostIDs['pos'][] = $tmp_cost['id'];
                    $CostIDs['neg'][] = '-'.$tmp_cost['id'];
                }
                $itemsData = $this->armory->wDB->select("
                SELECT
                `item_template`.`entry` AS `id`,
                `item_template`.`name`,
                `item_template`.`class`,
                `item_template`.`subclass`,
                `item_template`.`ItemLevel` AS `level`,
                `item_template`.`Quality` AS `quality`,
                `item_template`.`displayid`,
                `npc_vendor`.`ExtendedCost`
                FROM `item_template` AS `item_template`
                LEFT JOIN `npc_vendor` AS `npc_vendor` ON `npc_vendor`.`item`=`item_template`.`entry`
                WHERE `npc_vendor`.`ExtendedCost` IN (%s) OR `npc_vendor`.`ExtendedCost` IN (%s)", $CostIDs['pos'], $CostIDs['neg'] );
                if(!$itemsData || !is_array($itemsData)) {
                    return false;
                }
                $oldItems = array();
                $i = 0;
                foreach($itemsData as $curItem) {
                    if(isset($oldItems[$curItem['id']])) {
                        // Do not add same items many times
                        continue;
                    }
                    $lootTable[$i]['data'] = array(
                        'icon' => self::GetItemIcon($curItem['id'], $curItem['displayid']),
                        'id' => $curItem['id'],
                        'level' => $curItem['level'],
                        'name' => ($this->armory->GetLocale() == 'en_gb' || $this->armory->GetLocale() == 'en_us') ? $curItem['name'] : self::GetItemName($curItem['id']),
                        'quality' => $curItem['quality'],
                        'type' => $this->armory->aDB->selectCell("SELECT `subclass_name_%s` FROM `ARMORYDBPREFIX_itemsubclass` WHERE `class`=%d AND `subclass`=%d", $this->armory->GetLocale(), $curItem['class'], $curItem['subclass'])
                    );
                    $lootTable[$i]['tokens'] = Mangos::GetExtendedCost($curItem['ExtendedCost']);
                    $oldItems[$curItem['id']] = $curItem['id'];
                    $i++;
                }
                break;
            case 'reagent':
                if($this->armory->GetLocale() == 'en_gb' || $this->armory->GetLocale() == 'ru_ru') {
                    $ReagentLoot = $this->armory->aDB->select("
                    SELECT `Reagent_1`, `Reagent_2`, `Reagent_3`, `Reagent_4`, `Reagent_5`, `Reagent_6`, `Reagent_7`, `Reagent_8`,
                        `ReagentCount_1`, `ReagentCount_2`, `ReagentCount_3`, `ReagentCount_4`, `ReagentCount_5`, `ReagentCount_6`, 
                        `ReagentCount_7`, `ReagentCount_8`, `EffectItemType_1`, `EffectItemType_2`, `EffectItemType_3`,
                        `SpellName_%s` AS `SpellName`, `SpellIconID`
                    FROM `ARMORYDBPREFIX_spell`
                        WHERE `Reagent_1`=%d OR `Reagent_2`=%d OR `Reagent_3`=%d OR `Reagent_4`=%d OR
                            `Reagent_5`=%d OR `Reagent_6`=%d OR `Reagent_7`=%d OR `Reagent_8`=%d", $this->armory->GetLocale(), $item, $item, $item, $item, $item, $item, $item, $item);
                }
                else {
                    $ReagentLoot = $this->armory->aDB->select("
                    SELECT `Reagent_1`, `Reagent_2`, `Reagent_3`, `Reagent_4`, `Reagent_5`, `Reagent_6`, `Reagent_7`, `Reagent_8`,
                        `ReagentCount_1`, `ReagentCount_2`, `ReagentCount_3`, `ReagentCount_4`, `ReagentCount_5`, `ReagentCount_6`, 
                        `ReagentCount_7`, `ReagentCount_8`, `EffectItemType_1`, `EffectItemType_2`, `EffectItemType_3`,
                        `SpellName_en_gb` AS `SpellName`, `SpellIconID`
                    FROM `ARMORYDBPREFIX_spell`
                        WHERE `Reagent_1`=%d OR `Reagent_2`=%d OR `Reagent_3`=%d OR `Reagent_4`=%d OR
                            `Reagent_5`=%d OR `Reagent_6`=%d OR `Reagent_7`=%d OR `Reagent_8`=%d", $item, $item, $item, $item, $item, $item, $item, $item);
                }
                if(!$ReagentLoot) {
                    return false;
                }
                $i = 0;
                foreach($ReagentLoot as $ReagentItem) {
                    $lootTable[$i]['spell']   = array();
                    $lootTable[$i]['item']    = array();
                    $lootTable[$i]['reagent'] = array();
                    $lootTable[$i]['spell']['name'] = $ReagentItem['SpellName'];
                    $lootTable[$i]['spell']['icon'] = $this->armory->aDB->selectCell("SELEC `icon` FROM `ARMORYDBPREFIX_spellicon` WHERE `id`=%d", $ReagentItem['SpellIconID']);
                    for($j = 1; $j < 4; $j++) {
                        if($ReagentItem['EffectItemType_' . $j] > 0) {
                            $tmp_info = $this->armory->wDB->selectRow("SELECT `name`, `Quality`, `displayid` FROM `item_template` WHERE `entry`=%d LIMIT 1", $ReagentItem['EffectItemType_' . $j]);
                            $lootTable[$i]['item'][$j]['id'] = $ReagentItem['EffectItemType_' . $j];
                            $lootTable[$i]['item'][$j]['name'] = ($this->armory->GetLocale() == 'en_gb' || $this->armory->GetLocale() == 'en_us') ? $tmp_info['name'] : self::GetItemName($ReagentItem['EffectItemType_' . $j]);
                            $lootTable[$i]['item'][$j]['icon'] = self::GetItemIcon($ReagentItem['EffectItemType_'.$j], $tmp_info['displayid']);
                            $lootTable[$i]['item'][$j]['quality'] = $tmp_info['Quality'];
                        }
                    }
                    for($o = 1; $o < 9; $o++) {
                        if($ReagentItem['Reagent_' . $o] > 0) {
                            $tmp_info = $this->armory->wDB->selectRow("SELECT `name`, `Quality`, `displayid` FROM `item_template` WHERE `entry`=%d LIMIT 1", $ReagentItem['Reagent_' . $o]);
                            $lootTable[$i]['reagent'][$o]['id'] = $ReagentItem['Reagent_' . $o];
                            $lootTable[$i]['reagent'][$o]['icon'] = self::GetItemIcon($ReagentItem['Reagent_' . $o], $tmp_info['displayid']);
                            $lootTable[$i]['reagent'][$o]['count'] = $ReagentItem['ReagentCount_' . $o];
                            $lootTable[$i]['reagent'][$o]['name'] = ($this->armory->GetLocale() == 'en_gb' || $this->armory->GetLocale() == 'en_us') ? $tmp_info['name'] : self::GetItemName($ReagentItem['Reagent_' . $o]);
                        }
                    }
                    $i++;
                }
                break;
            case 'randomProperty':
                $itemProperty = $this->armory->wDB->selectRow("SELECT `RandomProperty`, `RandomSuffix` FROM `item_template` WHERE `entry`=%d LIMIT 1", $item);
                if(!$itemProperty || ($itemProperty['RandomProperty'] == 0 && $itemProperty['RandomSuffix'] == 0)) {
                    return false;
                }
                $type = false;
                if($itemProperty['RandomProperty'] > 0) {
                    $itemPropertyId = $itemProperty['RandomProperty'];
                    $type = 'property'; 
                }
                elseif($itemProperty['RandomSuffix'] > 0) {
                    $itemPropertyId = $itemProperty['RandomSuffix'];
                    $type = 'suffix';
                }
                $enchants_entries = $this->armory->wDB->select("SELECT * FROM `item_enchantment_template` WHERE `entry`=%d", $itemPropertyId);
                if(!$enchants_entries) {
                    return false;
                }
                $count = count($enchants_entries);
                $ids = array();
                for($i = 0; $i < $count; $i++) {
                    $ids[$enchants_entries[$i]['ench']] = $enchants_entries[$i]['ench'];
                }
                if($type == 'property') {
                    $enchants = $this->armory->aDB->select("SELECT `id`, `name_%s` AS `name`, `ench_1`, `ench_2`, `ench_3` FROM `ARMORYDBPREFIX_randomproperties` WHERE `id` IN (%s)", $this->armory->GetLocale(), $ids);
                }
                elseif($type == 'suffix') {
                    $enchants = $this->armory->aDB->select("SELECT `id`, `name_%s` AS `name`, `ench_1`, `ench_2`, `ench_3`, `ench_4`, `ench_5`, `pref_1`, `pref_2`, `pref_3`, `pref_4`, `pref_5` FROM `ARMORYDBPREFIX_randomsuffix` WHERE `id` IN (%s)", $this->armory->GetLocale(), $ids);
                }
                if(!$enchants) {
                    return false;
                }
                $i = 0;
                $item_data = $this->armory->wDB->selectRow("SELECT `InventoryType`, `ItemLevel`, `Quality` FROM `item_template` WHERE `entry`=%d", $item);
                $points = self::GetRandomPropertiesPoints($item_data['ItemLevel'], $item_data['InventoryType'], $item_data['Quality']);
                foreach($enchants as $entry) {
                    $str_tmp = array();
                    $lootTable[$i]['name'] = $entry['name'];
                    $lootTable[$i]['data'] = array();
                    for($j = 1; $j < 6; $j++) {
                        if(isset($entry['ench_' . $j]) && $entry['ench_' . $j] > 0) {
                            if($type == 'property') {
                                $str_tmp[$entry['ench_' . $j]] = $entry['ench_' . $j];
                            }
                            elseif($type == 'suffix') {
                                $str_tmp[$entry['ench_' . $j]] = $entry['ench_' . $j];
                            }
                        }
                    }
                    $enchs = $this->armory->aDB->select("SELECT `id`, `text_%s` AS `text` FROM `ARMORYDBPREFIX_enchantment` WHERE `id` IN (%s)", $this->armory->GetLocale(), $str_tmp);
                    if(!$enchs) {
                        $i++;
                        continue;
                    }
                    $k = 0;
                    foreach($enchs as $m_ench) {
                        if($type == 'suffix') {
                            for($l=1;$l<3;$l++) {
                                if(isset($entry['ench_' . $l]) && $entry['ench_' . $l] > 0) {
                                    $lootTable[$i]['data'][$k] = str_replace('$i', round($points * $entry['pref_' . $l] / 10000, 0), $m_ench['text']);
                                }
                            }
                        }
                        else {
                            $lootTable[$i]['data'][$k] = $m_ench['text'];
                        }
                        $k++;
                    }
                    $i++;
                }
                break;
        }
        return $lootTable;
    }
    
    /**
     * Some item info
     * @category Items class
     * @access   public
     * @param    int $itemID
     * @param    string $type
     * @todo     Add more cases
     * @return   string
     **/
    public function GetItemInfo($itemID, $type) {
        switch($type) {
            case 'quality':
                $info = $this->armory->wDB->selectCell("SELECT `Quality` FROM `item_template` WHERE `entry`=%d LIMIT 1", $itemID);
                break;
            case 'displayid':
                $info = $this->armory->wDB->selectCell("SELECT `displayid` FROM `item_template` WHERE `entry`=%d LIMIT 1", $itemID);
                break;
            case 'durability':
                $info = $this->armory->wDB->selectCell("SELECT `MaxDurability` FROM `item_template` WHERE `entry`=%d LIMIT 1", $itemID);
                break;
            default:
                $info = false;
                break;
        }
        return $info;
    }
    
    /**
     * Returns array with socket info (gem icon, enchant string, enchant id, item id)
     * @category Items class
     * @access   public
     * @param    int $guid
     * @param    int $item
     * @param    int $socketNum
     * @param    int $item_guid = 0
     * @param    object $db = null
     * @return   array
     **/ 
    public function GetItemSocketInfo($guid, $item, $socketNum, $item_guid = 0, $serverType = -1) {
        $data = array();
        if($serverType == -1) {
            $serverType = $this->armory->currentRealmInfo['type'];
        }
        switch($serverType) {
            case 'mangos':
                $socketfield = array(
                    1 => ITEM_FIELD_ENCHANTMENT_3_2,
                    2 => ITEM_FIELD_ENCHANTMENT_4_2,
                    3 => ITEM_FIELD_ENCHANTMENT_5_2
                );
                if($item_guid == 0) {
                    $socketInfo = $this->armory->cDB->selectCell("
                    SELECT CAST(SUBSTRING_INDEX(SUBSTRING_INDEX(`data`, ' ', %d), ' ', '-1') AS UNSIGNED)  
                        FROM `item_instance` 
                            WHERE `owner_guid`=%d AND CAST(SUBSTRING_INDEX(SUBSTRING_INDEX(`data`, ' ', 4), ' ', '-1') AS UNSIGNED) = %d", $socketfield[$socketNum], $guid, $item);
                }
                else {
                    $socketInfo = $this->armory->cDB->selectCell("
                    SELECT CAST(SUBSTRING_INDEX(SUBSTRING_INDEX(`data`, ' ', %d), ' ', '-1') AS UNSIGNED)  
                        FROM `item_instance` 
                            WHERE `owner_guid`=%d AND `guid`=%d", $socketfield[$socketNum], $guid, $item_guid);
                }
                break;
            case 'trinity':
                $socketfield = array(
                    1 => 6,
                    2 => 9,
                    3 => 12
                );
                if(!isset($socketfield[$socketNum])) {
                    $this->armory->Log()->writeError('%s : wrong socketNum: %d', __METHOD__, $socketNum);
                    return false;
                }
                if($item_guid == 0) {
                    $item_guid = self::GetItemGUIDByEntry($item, $guid);
                }
                $row = $this->armory->cDB->selectCell("SELECT `enchantments` FROM `item_instance` WHERE `guid`=%d", $item_guid);
                if(!$row) {
                    $this->armory->Log()->writeError('%s : item with guid #%d was not found in `item_instance` table.', __METHOD__, $item_guid);
                    return false;
                }
                $enchantments = explode(' ', $row);
                $socketInfo = $enchantments[$socketfield[$socketNum]];
                break;
        }
        if($socketInfo > 0) {
            $gemData = $this->armory->aDB->selectRow("SELECT `text_%s` AS `text`, `gem` FROM `ARMORYDBPREFIX_enchantment` WHERE `id`=%d", $this->armory->GetLocale(), $socketInfo);
            $data['enchant_id'] = $socketInfo;
            $data['item'] = $gemData['gem'];
            $data['icon'] = self::GetItemIcon($data['item']);
            $data['enchant'] = $gemData['text'];
            $data['color'] = $this->armory->aDB->selectCell("SELECT `color` FROM `ARMORYDBPREFIX_gemproperties` WHERE `spellitemenchantement`=%d", $socketInfo);
            return $data;
        }
        return false;
    }
    
    /**
     * Returns array with current/max item durability for selected ($guid) character
     * @category Items class
     * @access   public
     * @param    int $guid
     * @param    int $item
     * @return   array
     **/
    public function GetItemDurability($guid, $item) {
        switch($this->armory->currentRealmInfo['type']) {
            case 'mangos':
                $durability['current'] = self::GetItemDataField(ITEM_FIELD_DURABILITY, 0, $guid, $item);
                $durability['max'] = self::GetItemDataField(ITEM_FIELD_MAXDURABILITY, 0, $guid, $item);
                break;
            case 'trinity':
                $durability['current'] = $this->armory->cDB->selectCell("SELECT `durability` FROM `item_instance` WHERE `owner_guid`=%d AND `guid`=%d", $guid, $item);
                $durability['max'] = self::GetItemInfo($item, 'durability');
                break;
        }
        return $durability;
    }
    
    /**
     * Returns max/current item durability by item guid
     * @category Items class
     * @access   public
     * @param    int $item_guid
     * @return   array
     **/
    public function GetItemDurabilityByItemGuid($item_guid) {
        $durability = array('current' => 0, 'max' => 0);
        switch($this->armory->currentRealmInfo['type']) {
            case 'mangos':
                $durability['current'] = self::GetItemDataField(ITEM_FIELD_DURABILITY, 0, 0, $item_guid);
                $durability['max'] = self::GetItemDataField(ITEM_FIELD_MAXDURABILITY, 0, 0, $item_guid);
                break;
            case 'trinity':
                $durability['current'] = $this->armory->cDB->selectCell("SELECT `durability` FROM `item_instance` WHERE `guid`=%d", $item_guid);
                $itemEntry = self::GetItemEntryByGUID($item_guid);
                $durability['max'] = self::GetItemInfo($itemEntry, 'durability');
                break;
        }
        return $durability;
    }
    
    /**
     * Returns field ($field) value from `item_instance`.`data` field for current item guid (NOT char guid!)
     * @category Items class
     * @access   public
     * @param    int $field
     * @param    int $itemid
     * @param    int $owner_guid
     * @param    int $use_item_guid = 0
     * @param    ArmoryDatabaseHandler $db = null
     * @return   int
     **/
    public function GetItemDataField($field, $itemid, $owner_guid, $use_item_guid = 0, $db = null) {
        $dataField = $field + 1;
        if($db == null) {
            $db = $this->armory->cDB;
        }
        if($use_item_guid > 0) {
            $qData = $db->selectCell("
            SELECT CAST(SUBSTRING_INDEX(SUBSTRING_INDEX(`data`, ' ', %d), ' ', '-1') AS UNSIGNED)
                FROM `item_instance`
                    WHERE `guid`= %d", $dataField, $use_item_guid);
            return $qData;
        }
        else {
            $qData = $db->selectCell("
            SELECT CAST(SUBSTRING_INDEX(SUBSTRING_INDEX(`data`, ' ', %d), ' ', '-1') AS UNSIGNED)  
                FROM `item_instance` 
                    WHERE `owner_guid`=%d AND CAST(SUBSTRING_INDEX(SUBSTRING_INDEX(`data`, ' ', 4), ' ', '-1') AS UNSIGNED) = %d", $dataField, $owner_guid, $itemid);
        }
        unset($db);
        return $qData;
    }
    
    /**
     * Spell Description handler
     * @author   DiSlord aka Chestr
     * @category Items class
     * @access   public
     * @param    array $spell
     * @param    string $text
     * @return   array
     **/
    public function SpellReplace($spell, $text) {
        $letter = array('${','}');
        $values = array( '[',']');
        $text = str_replace($letter, $values, $text);
        $signs = array('+', '-', '/', '*', '%', '^');
        $data = $text;
        $pos = 0;
        $npos = 0;
        $str = null;
        $cacheSpellData=array(); // Spell data for spell
        $lastCount = 1;
        while(false !== ($npos = strpos($data, '$', $pos))) {
            if($npos != $pos) {
                $str .= substr($data, $pos, $npos-$pos);
            }
            $pos = $npos + 1;
            if('$' == substr($data, $pos, 1)) {
                $str .= '$';
    			$pos++;
                continue;
    		}
            if(!preg_match('/^((([+\-\/*])(\d+);)?(\d*)(?:([lg].*?:.*?);|(\w\d*)))/', substr($data, $pos), $result)) {
                continue;
            }
            $pos += strlen($result[0]);
            $op = $result[3];
            $oparg = $result[4];
            $lookup = $result[5]? $result[5]:$spell['id'];
            $var = $result[6] ? $result[6]:$result[7];
            if(!$var) {
                continue;
            }
            if($var[0] == 'l') {
                $select = explode(':', substr($var, 1));
                $str .= @$select[$lastCount == 1 ? 0 : 1];
            }
            elseif($var[0] == 'g') {
                $select = explode(':', substr($var, 1));
                $str .= $select[0];
            }
            else {
                $spellData = @$cacheSpellData[$lookup];
                if($spellData == 0) {
                    if($lookup == $spell['id']) {
                        $cacheSpellData[$lookup] = $this->GetSpellData($spell);
                    }
                    else {
                        $cacheSpellData[$lookup] = $this->GetSpellData($this->armory->aDB->selectRow("SELECT * FROM `ARMORYDBPREFIX_spell` WHERE `id`=%d", $lookup));
                    }
                    $spellData = @$cacheSpellData[$lookup];
                }
                if($spellData && $base = @$spellData[strtolower($var)]) {
                    if($op && is_numeric($oparg) && is_numeric($base)) {
                         $equation = $base.$op.$oparg;
                         @eval("\$base = $equation;");
    		        }
                    if(is_numeric($base)) {
                        $lastCount = $base;
                    }
                }
                else {
                    $base = $var;
                }
                $str .= $base;
            }
        }
        $str .= substr($data, $pos);
        $str = preg_replace_callback("/\[.+[+\-\/*\d]\]/", array($this, 'MyReplace'), $str);
        return $str;
    }
    
    /**
     * Spell Description handler
     * @author   DiSlord aka Chestr
     * @category Items class
     * @access   public
     * @param    array $spell
     * @return   array
     **/
    public function GetSpellData($spell) {
        // Basepoints
        $s1 = abs($spell['EffectBasePoints_1'] + $spell['EffectBaseDice_1']);
        $s2 = abs($spell['EffectBasePoints_2'] + $spell['EffectBaseDice_2']);
        $s3 = abs($spell['EffectBasePoints_3'] + $spell['EffectBaseDice_3']);
        if($spell['EffectDieSides_1']>$spell['EffectBaseDice_1'] && ($spell['EffectDieSides_1']-$spell['EffectBaseDice_1'] != 1)) {
            $s1 .= ' - ' . abs($spell['EffectBasePoints_1'] + $spell['EffectDieSides_1']);
        }
        if($spell['EffectDieSides_2']>$spell['EffectBaseDice_2'] && ($spell['EffectDieSides_2']-$spell['EffectBaseDice_2'] != 1)) {
            $s2 .= ' - ' . abs($spell['EffectBasePoints_2'] + $spell['EffectDieSides_2']);
        }
        if($spell['EffectDieSides_3']>$spell['EffectBaseDice_3'] && ($spell['EffectDieSides_3']-$spell['EffectBaseDice_3'] != 1)) {
            $s3 .= ' - ' . abs($spell['EffectBasePoints_3'] + $spell['EffectDieSides_3']);
        }
        $d = 0;
        if($spell['DurationIndex']) {
            if($spell_duration = $this->armory->aDB->selectRow("SELECT * FROM `ARMORYDBPREFIX_spell_duration` WHERE `id`=%d", $spell['DurationIndex'])) {
                $d = $spell_duration['duration_1']/1000;
            }
        }
        // Tick duration
        $t1 = $spell['EffectAmplitude_1'] ? $spell['EffectAmplitude_1'] / 1000 : 5;
        $t2 = $spell['EffectAmplitude_1'] ? $spell['EffectAmplitude_2'] / 1000 : 5;
        $t3 = $spell['EffectAmplitude_1'] ? $spell['EffectAmplitude_3'] / 1000 : 5;
        
        // Points per tick
        $o1 = @intval($s1 * $d / $t1);
        $o2 = @intval($s2 * $d / $t2);
        $o3 = @intval($s3 * $d / $t3);
        $spellData['t1'] = $t1;
        $spellData['t2'] = $t2;
        $spellData['t3'] = $t3;
        $spellData['o1'] = $o1;
        $spellData['o2'] = $o2;
        $spellData['o3'] = $o3;
        $spellData['s1'] = $s1;
        $spellData['s2'] = $s2;
        $spellData['s3'] = $s3;
        $spellData['m1'] = $s1;
        $spellData['m2'] = $s2;
        $spellData['m3'] = $s3;
        $spellData['x1'] = $spell['EffectChainTarget_1'];
        $spellData['x2'] = $spell['EffectChainTarget_2'];
        $spellData['x3'] = $spell['EffectChainTarget_3'];
        $spellData['i']  = $spell['MaxAffectedTargets'];
        $spellData['d']  = Utils::GetTimeText($d);
        $spellData['d1'] = Utils::GetTimeText($d);
        $spellData['d2'] = Utils::GetTimeText($d);
        $spellData['d3'] = Utils::GetTimeText($d);
        $spellData['v']  = $spell['MaxTargetLevel'];
        $spellData['u']  = $spell['StackAmount'];
        $spellData['a1'] = Utils::GetRadius($spell['EffectRadiusIndex_1']);
        $spellData['a2'] = Utils::GetRadius($spell['EffectRadiusIndex_2']);
        $spellData['a3'] = Utils::GetRadius($spell['EffectRadiusIndex_3']);
        $spellData['b1'] = $spell['EffectPointsPerComboPoint_1'];
        $spellData['b2'] = $spell['EffectPointsPerComboPoint_2'];
        $spellData['b3'] = $spell['EffectPointsPerComboPoint_3'];
        $spellData['e']  = $spell['EffectMultipleValue_1'];
        $spellData['e1'] = $spell['EffectMultipleValue_1'];
        $spellData['e2'] = $spell['EffectMultipleValue_2'];
        $spellData['e3'] = $spell['EffectMultipleValue_3'];
        $spellData['f1'] = $spell['DmgMultiplier_1'];
        $spellData['f2'] = $spell['DmgMultiplier_2'];
        $spellData['f3'] = $spell['DmgMultiplier_3'];
        $spellData['q1'] = $spell['EffectMiscValue_1'];
        $spellData['q2'] = $spell['EffectMiscValue_2'];
        $spellData['q3'] = $spell['EffectMiscValue_3'];
        $spellData['h']  = $spell['procChance'];
        $spellData['n']  = $spell['procCharges'];
        $spellData['z']  = "<home>";
        return $spellData;
    }
    
    /**
     * Replaces square brackets with NULL text
     * @author   DiSlord aka Chestr
     * @category Items class
     * @access   public
     * @param    array $matches
     * @return   int
     **/
    public function MyReplace($matches) {
        $text = str_replace( array('[',']'), array('', ''), $matches[0]);
        //@eval("\$text = abs(".$text.");");
        return intval($text);
    }
    // End of CSWOWD functions
    
    /**
     * Returns instance name (according with current locale) where for boss $key
     * @category Items class
     * @access   public
     * @param    string $key
     * @return   string
     **/
    public function GetItemSourceByKey($key) {
        return $this->armory->aDB->selectCell("SELECT `name_%s` FROM `ARMORYDBPREFIX_instance_template` WHERE `id` IN (SELECT `instance_id` FROM `ARMORYDBPREFIX_instance_data` WHERE `key`='%s')", $this->armory->GetLocale(), $key);
    }
    
    /**
     * Returns item source with area name, boss name, drop rate and area URL
     * @category Items class
     * @access   public
     * @param    int $itemID
     * @param    int $bossID
     * @param    bool $areaDataOnly = false
     * @return   array
     **/
    public function GetImprovedItemSource($itemID, $bossID, $areaDataOnly = false) {
        $dungeonData = $this->armory->aDB->selectRow("SELECT `instance_id`, `name_%s` AS `name`, `lootid_1`, `lootid_2`, `lootid_3`, `lootid_4` FROM `ARMORYDBPREFIX_instance_data` WHERE `id`=%d OR `lootid_1`=%d OR `lootid_2`=%d OR `lootid_3`=%d OR `lootid_4`=%d OR `name_id`=%d LIMIT 1", $this->armory->GetLocale(), $bossID, $bossID, $bossID, $bossID, $bossID, $bossID);
        if(!$dungeonData) {
            return false;
        }
        $difficulty_enum = array(1 => '10n', 2 => '25n', 3 => '10h', 4 => '25h');
        $heroic_string = Utils::GetArmoryString(19);
        $item_difficulty = null;
        for($i = 1; $i < 5; $i++) {
            if(isset($dungeonData['lootid_' . $i]) && $dungeonData['lootid_' . $i] == $bossID && isset($difficulty_enum[$i])) {
                $item_difficulty = $difficulty_enum[$i];
            }
        }
        $instance_heroic = array(4812, 4722, 4987);
        switch($item_difficulty) {
            case '10n':
                if(in_array($dungeonData['instance_id'], $instance_heroic)) {
                    $instance_data = $this->armory->aDB->selectRow("SELECT `id` AS `areaId`, `name_%s` AS `areaName`, `is_heroic`, `key` FROM `ARMORYDBPREFIX_instance_template` WHERE `id`=%d AND `partySize`=10 AND `is_heroic`=1", $this->armory->GetLocale(), $dungeonData['instance_id']);
                }
                else {
                    $instance_data = $this->armory->aDB->selectRow("SELECT `id` AS `areaId`, `name_%s` AS `areaName`, `is_heroic`, `key` FROM `ARMORYDBPREFIX_instance_template` WHERE `id`=%d", $this->armory->GetLocale(), $dungeonData['instance_id']);
                }
                if(!$instance_data) {
                    return false;
                }
                break;
            case '10h':
                if(in_array($dungeonData['instance_id'], $instance_heroic)) {
                    $instance_data = $this->armory->aDB->selectRow("SELECT `id` AS `areaId`, `name_%s` AS `areaName`, `is_heroic`, `key` FROM `ARMORYDBPREFIX_instance_template` WHERE `id`=%d AND `partySize`=10 AND `is_heroic`=1", $this->armory->GetLocale(), $dungeonData['instance_id']);
                }
                else {
                    $instance_data = $this->armory->aDB->selectRow("SELECT `id` AS `areaId`, `name_%s` AS `areaName`, `is_heroic`, `key` FROM `ARMORYDBPREFIX_instance_template` WHERE `id`=%d", $this->armory->GetLocale(), $dungeonData['instance_id']);
                }
                if(!$instance_data) {
                    return false;
                }
                if($heroic_string) {
                    $instance_data['areaName'] .= ' ' . $heroic_string;
                }
                break;
            case '25n':
                if(in_array($dungeonData['instance_id'], $instance_heroic)) {
                    $instance_data = $this->armory->aDB->selectRow("SELECT `id` AS `areaId`, `name_%s` AS `areaName`, `is_heroic`, `key` FROM `ARMORYDBPREFIX_instance_template` WHERE `id`=%d AND `partySize`=25 AND `is_heroic`=1", $this->armory->GetLocale(), $dungeonData['instance_id']);
                }
                else {
                    $instance_data = $this->armory->aDB->selectRow("SELECT `id` AS `areaId`, `name_%s` AS `areaName`, `is_heroic`, `key` FROM `ARMORYDBPREFIX_instance_template` WHERE `id`=%d", $this->armory->GetLocale(), $dungeonData['instance_id']);
                }
                if(!$instance_data) {
                    return false;
                }
                if($instance_data['is_heroic'] == 0) {
                    if($heroic_string) {
                        $instance_data['areaName'] .= ' ' . $heroic_string;
                    }
                    else {
                        $instance_data['areaName'] .= ' (25)';
                    }
                }
                break;
            case '25h':
                if(in_array($dungeonData['instance_id'], $instance_heroic)) {
                    $instance_data = $this->armory->aDB->selectRow("SELECT `id` AS `areaId`, `name_%s` AS `areaName`, `is_heroic`, `key` FROM `ARMORYDBPREFIX_instance_template` WHERE `id`=%d AND `partySize`=25 AND `is_heroic`=1", $this->armory->GetLocale(), $dungeonData['instance_id']);
                }
                else {
                    $instance_data = $this->armory->aDB->selectRow("SELECT `id` AS `areaId`, `name_%s` AS `areaName`, `is_heroic`, `key` FROM `ARMORYDBPREFIX_instance_template` WHERE `id`=%d", $this->armory->GetLocale(), $dungeonData['instance_id']);
                }
                if(!$instance_data) {
                    return false;
                }
                if($heroic_string) {
                    $instance_data['areaName'] .= ' ' . $heroic_string;
                }
                break;
        }
        if(!isset($instance_data) || !is_array($instance_data)) {
            return false;
        }
        if($areaDataOnly == true) {
            return array('areaName' => $instance_data['areaName'], 'areaUrl' => sprintf('source=dungeon&dungeon=%s&boss=all&difficulty=all', $instance_data['key']));
        }
        $instance_data['creatureId'] = $this->armory->aDB->selectCell("SELECT `id` FROM `ARMORYDBPREFIX_instance_data` WHERE `id`=%d OR `lootid_1`=%d OR `lootid_2`=%d OR `lootid_3`=%d OR `lootid_4`=%d OR `name_id`=%d LIMIT 1", $bossID, $bossID, $bossID, $bossID, $bossID, $bossID);
        $instance_data['creatureName'] = $dungeonData['name'];
        if($bossID > 100000) {
            // GameObject
            $drop_percent = Mangos::GenerateLootPercent($bossID, 'gameobject_loot_template', $itemID);
        }
        else {
            // Creature
            $drop_percent = Mangos::GenerateLootPercent($bossID, 'creature_loot_template', $itemID);
        }
        $instance_data['dropRate'] = Mangos::GetDropRate($drop_percent);
        $instance_data['value'] = 'sourceType.creatureDrop';
        return $instance_data;
    }
    
    /**
     * Checks is item is unique in boss's loot table
     * @category Items class
     * @access   public
     * @param    int $itemID
     * @return   bool
     **/
    public function IsUniqueLoot($itemID) {
        $item_count = $this->armory->wDB->selectCell("SELECT COUNT(`entry`) FROM `creature_loot_template` WHERE `item`=%d", $itemID);
        if($item_count > 1) {
            return false;
        }
        return true;
    }
    
    /**
     * Returns model data for $displayId.
     * If $itemid > 0 then $displayId will be loaded from DB
     * @category Items class
     * @access   public
     * @param    int $displayId
     * @param    string $row = null
     * @param    int $itemid = 0
     * @return   mixed
     **/
    public function GetItemModelData($displayId, $row = null, $itemid = 0) {
        if($itemid > 0) {
            $displayId = self::GetItemInfo($itemid, 'displayid');
        }
        if($row == null) {
            $data = $this->armory->aDB->selectRow("SELECT * FROM `ARMORYDBPREFIX_itemdisplayinfo` WHERE `displayid`=%d", $displayId);
        }
        else {
            $data = $this->armory->aDB->selectCell("SELECT `%s` FROM `ARMORYDBPREFIX_itemdisplayinfo` WHERE `displayid`=%d", $row, $displayId);
        }
        if($data) {
            return $data;
        }
        return false;
    }
    
    /**
     * Returns item equivalent for opposite faction
     * FactionIDs are:
     *  1 - Horde
     *  2 - Alliance
     * @category Items class
     * @access   public
     * @param    int $itemID
     * @param    int $factionID
     * @return   array
     **/
    public function GetFactionEquivalent($itemID, $factionID) {
        if($factionID == 1) {
            $equivalent_id = $this->armory->aDB->selectCell("SELECT `item_alliance` FROM `ARMORYDBPREFIX_item_equivalents` WHERE `item_horde`=%d", $itemID);
        }
        elseif($factionID == 2) {
            $equivalent_id = $this->armory->aDB->selectCell("SELECT `item_horde` FROM `ARMORYDBPREFIX_item_equivalents` WHERE `item_alliance`=%d", $itemID);
        }
        if($equivalent_id > 0 && $info = $this->armory->wDB->selectRow("SELECT `name`, `ItemLevel`, `Quality`, `displayid` FROM `item_template` WHERE `entry`=%d", $equivalent_id)) {
            $item_data = array(
                'icon'    => self::GetItemIcon($equivalent_id, $info['displayid']),
                'id'      => $equivalent_id,
                'level'   => $info['ItemLevel'],
                'name'    => ($this->armory->GetLocale() == 'en_gb' || $this->armory->GetLocale() == 'en_us') ? $info['name'] : self::GetItemName($equivalent_id),
                'quality' => $info['Quality']
            );
            return $item_data;
        }
        return false;
    }
    
    /**
     * Returns item subclass/class text string
     * If $tooltip == true, then function will return subclass name only.
     * If $data == false, then required info will be loaded from DB
     * @category Items class
     * @access   public
     * @param    int $itemID
     * @param    bool $tooltip = false
     * @param    array $data = false
     * @return   mixed
     **/
    public function GetItemSubTypeInfo($itemID, $tooltip = false, $data = false) {
        if($data) {
            $itemclassInfo = array('class' => $data['class'], 'subclass' => $data['subclass']);
        }
        else {
            $itemclassInfo = $this->armory->wDB->selectRow("SELECT `class`, `subclass` FROM `item_template` WHERE `entry`=%d", $itemID);
        }
        if($tooltip == true) {
            if($itemclassInfo['class'] == ITEM_CLASS_ARMOR && $itemclassInfo['subclass'] == 0) {
                return;
            }
            return $this->armory->aDB->selectCell("SELECT `subclass_name_%s` FROM `ARMORYDBPREFIX_itemsubclass` WHERE `class`=%d AND `subclass`=%d", $this->armory->GetLocale(), $itemclassInfo['class'], $itemclassInfo['subclass']);
        }
        return $this->armory->aDB->selectRow("SELECT `subclass_name_%s` AS `subclass_name`, `key` FROM `ARMORYDBPREFIX_itemsubclass` WHERE `class`=%d AND `subclass`=%d", $this->armory->GetLocale(), $itemclassInfo['class'], $itemclassInfo['subclass']);
    }
    
    /**
     * Checks if personal arena rating required for sale current item (and returns required rating if exists)
     * @category Items class
     * @access   public
     * @param    int $itemID
     * @return   int
     **/
    public function IsRequiredArenaRating($itemID) {
        $extended_cost_id = $this->armory->wDB->selectCell("SELECT `ExtendedCost` FROM `npc_vendor` WHERE `item`=%d", $itemID);
        if($extended_cost_id === false) {
            return false;
        }
        if($extended_cost_id < 0) {
            $extended_cost_id = abs($extended_cost_id);
        }
        $arenaTeamRating = $this->armory->aDB->selectCell("SELECT `personalRating` FROM `ARMORYDBPREFIX_extended_cost` WHERE `id`=%d", $extended_cost_id);
        if($arenaTeamRating > 0) {
            return $arenaTeamRating;
        }
        return false;
    }
    
    /**
     * Loads neccessary item data from DB (for item-info.xml page)
     * @category Items class
     * @access   public
     * @param    int $itemID
     * @return   array
     **/
    public function GetItemData($itemID) {
        $itemData = array();
        $itemData = $this->armory->wDB->selectRow("SELECT `name`, `Quality`, `ItemLevel`, `displayid`, `SellPrice`, `BuyPrice`, `Flags2`, `RequiredDisenchantSkill` FROM `item_template` WHERE `entry`=%d LIMIT 1", $itemID);
        if(!$itemData) {
            $itemData = $this->armory->wDB->selectRow("SELECT `name`, `Quality`, `ItemLevel`, `displayid`, `SellPrice`, `BuyPrice`, `FlagsExtra`, `RequiredDisenchantSkill` FROM `item_template` WHERE `entry`=%d LIMIT 1", $itemID);
            $itemData['Flags2'] = $itemData['FlagsExtra']; // For compatibility
            unset($itemData['FlagsExtra']);
        }
        return $itemData;
    }
    
    /**
     * Returns suffix for texture file name
     * @category Items class
     * @access   public
     * @param    string $name
     * @return   string
     **/
    public function GetModelSuffix($name) {
        $suffixes = array('_u.png', '_m.png', '_f.png');
        $use_suffix = false;
        foreach($suffixes as $suff) {
            if(@file_exists('models/' . $name . $suff)) {
                $use_suffix = $suff;
            }
        }
        if($use_suffix) {
            return $use_suffix;
        }
        return '_u.png';
    }
    
    /**
     * Generates random enchantments for $item_entry and $item_guid (if provided)
     * @category Items class
     * @access   public
     * @param    int $item_entry
     * @param    int $owner_guid
     * @param    int $item_guid
     * @return   array
     **/
    public function GetRandomPropertiesData($item_entry, $owner_guid, $item_guid = 0, $rIdOnly = false, $serverType = 1, $item = null, $item_data = null) {
        // I have no idea how it works but it works :D
        // Do not touch anything in this method (at least until somebody will explain me what the fuck am I did here).
        $enchId = 0;
        $use = 'property';
        switch($serverType) {
            case SERVER_MANGOS:
                if($item_guid > 0) {
                    if(is_object($item) && $item->IsCorrect()) {
                        if(is_array($item_data) && $item_data['RandomProperty'] > 0) {
                            $enchId = $item->GetItemRandomPropertyId();
                        }
                        elseif(is_array($item_data) && $item_data['RandomSuffix'] > 0) {
                            $suffix_enchants = $item->GetRandomSuffixData();
                            if(!is_array($suffix_enchants) || !isset($suffix_enchants[0]) || $suffix_enchants[0] == 0) {
                                $this->armory->Log()->writeError('%s : suffix_enchants not found', __METHOD__);
                                return false;
                            }
                            $enchId = $this->armory->aDB->selectCell("SELECT `id` FROM `ARMORYDBPREFIX_randomsuffix` WHERE `ench_1` = %d AND `ench_2` = %d AND `ench_3` = %d LIMIT 1", $suffix_enchants[0], $suffix_enchants[1], $suffix_enchants[2]);
                            $use = 'suffix';
                        }
                    }
                    else {
                        $enchId = self::GetItemDataField(ITEM_FIELD_RANDOM_PROPERTIES_ID, 0, $owner_guid, $item_guid);
                    }
                }
                else {
                    $enchId = self::GetItemDataField(ITEM_FIELD_RANDOM_PROPERTIES_ID, $item_entry, $owner_guid);
                }
                break;
            case SERVER_TRINITY:
                if($item_guid > 0) {
                    if(is_object($item) && $item->IsCorrect()) {
                        $enchId = $item->GetItemRandomPropertyId();
                        if($enchId < 0) {
                            $use = 'suffix';
                            $enchId = abs($enchId);
                        }
                    }
                    else {
                        $enchId = $this->armory->cDB->selectCell("SELECT `randomPropertyId` FROM `item_instance` WHERE `guid`=%d", $item_guid);
                    }
                }
                else {
                    $item_guid = self::GetItemGUIDByEntry($item_entry, $owner_guid);
                    $enchId = $this->armory->cDB->selectCell("SELECT `randomPropertyId` FROM `item_instance` WHERE `guid`=%d", $item_guid);
                }
                break;
        }
        if($rIdOnly == true) {
            return $enchId;
        }
        $return_data = array();
        $table = 'randomproperties';
        if($use == 'property') {
            $rand_data = $this->armory->aDB->selectRow("SELECT `name_%s` AS `name`, `ench_1`, `ench_2`, `ench_3` FROM `ARMORYDBPREFIX_randomproperties` WHERE `id`=%d", $this->armory->GetLocale(), $enchId);
        }
        elseif($use == 'suffix') {
            $table = 'randomsuffix';
        }
        if($table == 'randomproperties') {
            if(!$rand_data) {
                $this->armory->Log()->writeLog('%s : unable to get rand_data FROM `%s_%s` for id %d (itemGuid: %d, ownerGuid: %d)', __METHOD__, $this->armory->armoryconfig['db_prefix'], $table, $enchId, $item_guid, $owner_guid);
                return false;
            }
            $return_data['suffix'] = $rand_data['name'];
            $return_data['data'] = array();
            for($i = 1; $i < 4; $i++) {
                if($rand_data['ench_' . $i] > 0) {
                    $return_data['data'][$i] = $this->armory->aDB->selectCell("SELECT `text_%s` FROM `ARMORYDBPREFIX_enchantment` WHERE `id`=%d", $this->armory->GetLocale(), $rand_data['ench_' . $i]);
                }
            }
        }
        elseif($table == 'randomsuffix') {
            $enchant = $this->armory->aDB->selectRow("SELECT `id`, `name_%s` AS `name`, `ench_1`, `ench_2`, `ench_3`, `pref_1`, `pref_2`, `pref_3` FROM `ARMORYDBPREFIX_randomsuffix` WHERE `id`=%d", $this->armory->GetLocale(), $enchId);
            if(!$enchant) {
                return false;
            }
            $return_data['suffix'] = $enchant['name'];
            $return_data['data'] = array();
            $item_data = $this->armory->wDB->selectRow("SELECT `InventoryType`, `ItemLevel`, `Quality` FROM `item_template` WHERE `entry`=%d", $item_entry);
            $points = self::GetRandomPropertiesPoints($item_data['ItemLevel'], $item_data['InventoryType'], $item_data['Quality']);
            $return_data = array(
                'suffix' => $enchant['name'],
                'data' => array()
            );
            $k = 1;
            for($i = 1; $i < 4; $i++) {
                if(isset($enchant['ench_' . $i]) && $enchant['ench_' . $i] > 0) {
                    $cur = $this->armory->aDB->selectCell("SELECT `text_%s` FROM `ARMORYDBPREFIX_enchantment` WHERE `id` = %d", $this->armory->GetLocale(), $enchant['ench_' . $i]);
                    $return_data['data'][$k] = str_replace('$i', round(floor($points * $enchant['pref_' . $i] / 10000), 0), $cur);
                }
                $k++;
            }
        }
        return $return_data;
    }
    
    /**
     * Returns random properties points for itemId
     * @author   DiSlord aka Chestr
     * @category Items class
     * @access   public
     * @param    int $itemLevel
     * @param    int $type
     * @param    int $quality
     * @param    int $itemId = 0
     * @return   mixed
     **/
    public function GetRandomPropertiesPoints($itemLevel, $type, $quality, $itemId = 0) {
        if($itemLevel == 0 && $type == 0 && $quality == 0 && $itemId > 0) {
            $data = $this->armory->wDB->selectRow("SELECT `ItemLevel`, `type`, `Quality` FROM `item_template` WHERE `entry`=%d", $itemId);
            $itemLevel = $data['ItemLevel'];
            $type = $data['type'];
            $quality = $data['Quality'];
        }
        if($itemLevel < 0 || $itemLevel > 300) {
            return false;
        }
        $field = null;
        switch($quality) {
            case 2:
                $field .= 'uncommon';
                break;
            case 3:
                $field .= 'rare';
                break;
            case 4:
                $field .= 'epic';
                break;
            default:
                return false;
                break;
        }
        switch($type) {
            case  0: // INVTYPE_NON_EQUIP:
            case 18: // INVTYPE_BAG:
            case 19: // INVTYPE_TABARD:
            case 24: // INVTYPE_AMMO:
            case 27: // INVTYPE_QUIVER:
            case 28: // INVTYPE_RELIC:
                return 0;
            case  1: // INVTYPE_HEAD:
            case  4: // INVTYPE_BODY:
            case  5: // INVTYPE_CHEST:
            case  7: // INVTYPE_LEGS:
            case 17: // INVTYPE_2HWEAPON:
            case 20: // INVTYPE_ROBE:
                $field .= '_0';
                    break;
            case  3: // INVTYPE_SHOULDERS:
            case  6: // INVTYPE_WAIST:
            case  8: // INVTYPE_FEET:
            case 10: // INVTYPE_HANDS:
            case 12: // INVTYPE_TRINKET:
                $field .= '_1';
                break;
            case  2: // INVTYPE_NECK:
            case  9: // INVTYPE_WRISTS:
            case 11: // INVTYPE_FINGER:
            case 14: // INVTYPE_SHIELD:
            case 16: // INVTYPE_CLOAK:
            case 23: // INVTYPE_HOLDABLE:
                $field .= '_2';
                break;
            case 13: // INVTYPE_WEAPON:
            case 21: // INVTYPE_WEAPONMAINHAND:
            case 22: // INVTYPE_WEAPONOFFHAND:
                $field .= '_3';
                break;
            case 15: // INVTYPE_RANGED:
            case 25: // INVTYPE_THROWN:
            case 26: // INVTYPE_RANGEDRIGHT:
                $field .= '_4';
                break;
            default:
                return 0;
        }
        return $this->armory->aDB->selectCell("SELECT `%s` FROM `ARMORYDBPREFIX_randompropertypoints` WHERE `itemlevel`=%d", $field, $itemLevel);
    }
    
    /**
     * Returns bonus template name for XSLT (by statTypeID)
     * @category Items class
     * @access   public
     * @param    int $statType
     * @return   string
     **/
    public function GetItemBonusTemplate($statType) {
        switch($statType) {
            case 3:
                $bonus_template = 'bonusAgility';
                break;
            case 4:
                $bonus_template = 'bonusStrength';
                break;
            case 5:
                $bonus_template = 'bonusIntellect';
                break;
            case 6:
                $bonus_template = 'bonusSpirit';
                break;
            case 7:
                $bonus_template = 'bonusStamina';
                break;
            case 12:
                $bonus_template = 'bonusDefenseSkillRating';
                break;
            case 13:
                $bonus_template = 'bonusDodgeRating';
                break;
            case 14:
                $bonus_template = 'bonusParryRating';
                break;
            case 15:
            case 48:
                $bonus_template = 'bonusBlockRating';
                break;
            case 16:
                $bonus_template = 'bonusHitMeleeRating';
                break;
            case 17:
                $bonus_template = 'bonusHitRangedRating';
                break;
            case 18:
                $bonus_template = 'bonusHitSpellRating';
                break;
            case 19:
                $bonus_template = 'bonusCritMeleeRating';
                break;
            case 20:
                $bonus_template = 'bonusCritRangedRating';
                break;
            case 21:
                $bonus_template = 'bonusCritSpellRating';
                break;
            case 22:
                $bonus_template = 'bonusHitTakenMeleeRating';
                break;
            case 23:
                $bonus_template = 'bonusHitTakenRangedRating';
                break;
            case 24:
                $bonus_template = 'bonusHitTakenSpellRating';
                break;
            case 25:
                $bonus_template = 'bonusCritTakenMeleeRating';
                break;                
            case 26:
                $bonus_template = 'bonusCritTakenRangedRating';
                break;
            case 27:
                $bonus_template = 'bonusCritTakenSpellRating';
                break;
            case 28:
                $bonus_template = 'bonusHasteMeleeRating';
                break;
            case 29:
                $bonus_template = 'bonusHasteRangedRating';
                break;
            case 30:
                $bonus_template = 'bonusHasteSpellRating';
                break;
            case 31:
                $bonus_template = 'bonusHitRating';
                break;
            case 32:
                $bonus_template = 'bonusCritRating';
                break;
            case 33:
                $bonus_template = 'bonusHitTakenRating';
                break;
            case 34:
                $bonus_template = 'bonusCritTakenRating';
                break;
            case 35:
                $bonus_template = 'bonusResilienceRating';
                break;
            case 36:
                $bonus_template = 'bonusHasteRating';
                break;
            case 37:
                $bonus_template = 'bonusExpertiseRating';
                break;
            case 38:
            case 39:
                $bonus_template = 'bonusAttackPower';
                break;
            case 40:
                $bonus_template = 'bonusFeralAttackPower';
                break;
            case 41:
            case 42:
            case 45:
                $bonus_template = 'bonusSpellPower';
                break;
            case 43:
                $bonus_template = 'bonusManaRegen';
                break;
            case 44:
                $bonus_template = 'bonusArmorPenetration';
                break;
            case 46:
                $bonus_template = 'bonusHealthRegen';
                break;
            case 47:
                $bonus_template = 'bonusSpellPenetration';
                break;
            default:
                $bonus_template = null;
        }
        return $bonus_template;
    }
    
    /**
     * Public access to self::CreateAdditionalItemTooltip() method
     *  - $parent: used for items that created by spells (displays under patterns/recipes, etc.)
     *  - $comparison: used for dual tooltips (if user logged in and primary character is selected)
     * @category Items class
     * @access   public
     * @param    int $itemID
     * @param    XMLHandler $xml
     * @param    Characters $characters
     * @param    bool $parent = false
     * @param    bool $comparison = false
     **/
    public function ItemTooltip($itemID, XMLHandler $xml, Characters $characters, $parent = false, $comparison = false) {
        if(!$xml || !$characters) {
            return false;
        }
        return self::CreateAdditionalItemTooltip($itemID, $xml, $characters, $parent, $comparison);
    }
    
    /**
     * Create item tooltip with provided options
     *  - $parent: used for items that created by spells (displays under patterns/recipes, etc.)
     *  - $comparison: used for dual tooltips (if user logged in and primary character is selected)
     * This method must be called from self::ItemTooltip() only!
     * @category Items class
     * @access   private
     * @param    int $itemID
     * @param    XMLHandler $xml
     * @param    Characters $characters
     * @param    bool $parent = false
     * @param    bool $comparison = false
     **/
    private function CreateAdditionalItemTooltip($itemID, XMLHandler $xml, Characters $characters, $parent = false, $comparsion = false) {
        if(!$xml) {
            $this->armory->Log()->writeError('%s : xml should be instance of XMLHandler class. %s given.', __METHOD__, gettype($xml));
            return false;
        }
        elseif($parent == true && is_array($comparsion)) {
            $this->armory->Log()->writeError('%s : $parent and $comparison have \'true\' value (not allowed), ignore.', __METHOD__);
            return false; // both variables can't have 'true' value.
        }
        // Item comparsion mode
        $realm = false;
        if(is_array($comparsion) && isset($this->armory->realmData[$comparsion['realm_id']])) {
            $realm = $this->armory->realmData[$comparsion['realm_id']];
        }
        $proto = null;
        $isCharacter = $characters->CheckPlayer();
        if($isCharacter) {
            $item = $characters->GetItemByEntry($itemID);
            if($item) {
                $proto = $item->GetProto();
            }
        }
        if(!$proto) {
            // Maybe we haven't any character? Let's find itemproto by entry.
            $proto = new ItemPrototype($this->armory);
            $proto->LoadItem($itemID);
            if(!$proto) {
                $this->armory->Log()->writeError('%s : unable to find item with entry #%d', __METHOD__, $itemID);
                return false;
            }
        }
        // Check for ScalingStatDistribution (Heirloom items)
        $ssd = $this->armory->aDB->selectRow("SELECT * FROM `ARMORYDBPREFIX_ssd` WHERE `entry`=%d LIMIT 1", $proto->ScalingStatDistribution);
        $ssd_level = PLAYER_MAX_LEVEL;
        if($isCharacter) {
            $ssd_level = $characters->GetLevel();
            if($ssd && $ssd_level > $ssd['MaxLevel']) {
                $ssd_level = $ssd['MaxLevel'];
            }
        }
        $ssv = $this->armory->aDB->selectRow("SELECT * FROM `ARMORYDBPREFIX_ssv` WHERE `level`=%d LIMIT 1", $ssd_level);
        $xml->XMLWriter()->startElement('id');
        $xml->XMLWriter()->text($itemID);
        $xml->XMLWriter()->endElement(); //id
        if(Utils::IsWriteRaw()) {
            $xml->XMLWriter()->writeRaw('<name>');
            $xml->XMLWriter()->writeRaw(self::GetItemName($itemID));
            $xml->XMLWriter()->writeRaw('</name>');
        }
        else {
            $xml->XMLWriter()->startElement('name');
            if($this->armory->GetLocale() == 'en_gb' || $this->armory->GetLocale() == 'en_us') {
                $xml->XMLWriter()->text($proto->name);
            }
            else {
                $xml->XMLWriter()->text(self::GetItemName($itemID));
            }
            $xml->XMLWriter()->endElement(); //name
        }
        $xml->XMLWriter()->startElement('icon');
        $xml->XMLWriter()->text(self::GetItemIcon($itemID, $proto->displayid));
        $xml->XMLWriter()->endElement(); //icon
        // 3.2.x heroic item flag
        if($proto->Flags & ITEM_FLAGS_HEROIC) {
            $xml->XMLWriter()->startElement('heroic');
            $xml->XMLWriter()->text('1');
            $xml->XMLWriter()->endElement(); //heroic
        }
        $xml->XMLWriter()->startElement('overallQualityId');
        $xml->XMLWriter()->text($proto->Quality);
        $xml->XMLWriter()->endElement(); //overallQualityId
        // Map
        if($proto->Map > 0 && $mapName = $this->armory->aDB->selectCell("SELECT `name_%s` FROM `ARMORYDBPREFIX_maps` WHERE `id` = %d", $this->armory->GetLocale(), $proto->Map)) {
            if(Utils::IsWriteRaw()) {
                $xml->XMLWriter()->writeRaw('<instanceBound>' . $mapName . '</instanceBound>');
            }
            else {
                $xml->XMLWriter()->startElement('instanceBound');
                $xml->XMLWriter()->text($mapName);
                $xml->XMLWriter()->endElement(); //instanceBound
            }
        }
        if($proto->Flags & ITEM_FLAGS_CONJURED) {
            $xml->XMLWriter()->startElement('conjured');
            $xml->XMLWriter()->endElement(); //conjured
        }
        $xml->XMLWriter()->startElement('bonding');
        $xml->XMLWriter()->text($proto->bonding);
        $xml->XMLWriter()->endElement();//bonding
        $xml->XMLWriter()->startElement('maxCount');
        $xml->XMLWriter()->text($proto->maxcount);
        $xml->XMLWriter()->endElement();//maxCount
        if($proto->startquest > 0) {
            $xml->XMLWriter()->startElement('startQuestId');
            $xml->XMLWriter()->text($proto->startquest);
            $xml->XMLWriter()->endElement(); //startQuestId
        }
        $xml->XMLWriter()->startElement('classId');
        $xml->XMLWriter()->text($proto->class);
        $xml->XMLWriter()->endElement();//classId
        $xml->XMLWriter()->startElement('equipData');
        $xml->XMLWriter()->startElement('inventoryType');
        $xml->XMLWriter()->text($proto->InventoryType);
        $xml->XMLWriter()->endElement();  //inventoryType
        $xml->XMLWriter()->startElement('subclassName');
        $xml->XMLWriter()->text(self::GetItemSubTypeInfo($itemID, true, array('class' => $proto->class, 'subclass' => $proto->subclass)));
        $xml->XMLWriter()->endElement();  //subclassName
        if($proto->class== ITEM_CLASS_CONTAINER) {
            $xml->XMLWriter()->startElement('containerSlots');
            $xml->XMLWriter()->text($proto->ContainerSlots);
            $xml->XMLWriter()->endElement(); //containerSlots
        }
        $xml->XMLWriter()->endElement(); //equipData
        if($proto->class == ITEM_CLASS_WEAPON) {
            $xml->XMLWriter()->startElement('damageData');
            $xml->XMLWriter()->startElement('damage');
            $xml->XMLWriter()->startElement('type');
            $xml->XMLWriter()->text('0');
            $xml->XMLWriter()->endElement(); //type
            // Damage
            $minDmg = $proto->Damage[0]['min'];
            $maxDmg = $proto->Damage[0]['max'];
            $dps = null;
            // SSD Check
            if($ssv) {
                if($extraDPS = self::GetDPSMod($ssv, $proto->ScalingStatValue)) {
                    $average = $extraDPS * $proto->delay / 1000;
                    $minDmg = 0.7 * $average;
                    $maxDmg = 1.3 * $average;
                    $dps = round(($maxDmg + $minDmg) / (2 * ($proto->delay / 1000)));
                }
            }
            $xml->XMLWriter()->startElement('min');
            $xml->XMLWriter()->text(round($minDmg));
            $xml->XMLWriter()->endElement(); //min
            $xml->XMLWriter()->startElement('max');
            $xml->XMLWriter()->text(round($maxDmg));
            $xml->XMLWriter()->endElement();   //max
            $xml->XMLWriter()->endElement();  //damage
            $xml->XMLWriter()->startElement('speed');
            $xml->XMLWriter()->text(round($proto->delay / 1000, 2));
            $xml->XMLWriter()->endElement(); //speed
            for($jj = 0; $jj <= 1; $jj++) {
                $d_type = $proto->Damage[$jj]['type'];// $data['dmg_type' . $jj];
                $d_min  = $proto->Damage[$jj]['min']; // $data['dmg_min' . $jj];
                $d_max  = $proto->Damage[$jj]['max']; // $data['dmg_max' . $jj];
                if(($d_max > 0) && ($proto->class != ITEM_CLASS_PROJECTILE)) {
                    $delay = $proto->delay / 1000;
                    if($delay > 0) {
                        $dps = $dps + round(($d_max + $d_min) / (2 * $delay), 1);
                    }
                    if($jj > 1) {
                        $delay = 0;
                    }
               	}
            }
            if($dps != null) {
                $xml->XMLWriter()->startElement('dps');
                $xml->XMLWriter()->text($dps);
                $xml->XMLWriter()->endElement(); //dps
            }
            $xml->XMLWriter()->endElement(); //damageData
        }
        // Projectile DPS
        if($proto->class == ITEM_CLASS_PROJECTILE) {
            if($proto->Damage[0]['min'] > 0 && $proto->Damage[0]['max'] > 0) {
                $xml->XMLWriter()->startElement('damageData');
                $xml->XMLWriter()->startElement('damage');
                $xml->XMLWriter()->startElement('type');
                $xml->XMLWriter()->text($proto->Damage[0]['type']);
                $xml->XMLWriter()->endElement(); //type
                $xml->XMLWriter()->startElement('max');
                $xml->XMLWriter()->text($proto->Damage[0]['max']);
                $xml->XMLWriter()->endElement(); //max
                $xml->XMLWriter()->startElement('min');
                $xml->XMLWriter()->text($proto->Damage[0]['min']);
                $xml->XMLWriter()->endElement();   //min
                $xml->XMLWriter()->endElement();  //damage
                $xml->XMLWriter()->endElement(); //damageData
            }
        }
        // Gem properties
        if($proto->class == ITEM_CLASS_GEM && $proto->GemProperties > 0) {
            $GemSpellItemEcnhID = $this->armory->aDB->selectCell("SELECT `spellitemenchantement` FROM `ARMORYDBPREFIX_gemproperties` WHERE `id`=%d", $proto->GemProperties);
            $GemText = $this->armory->aDB->selectCell("SELECT `text_%s` FROM `ARMORYDBPREFIX_enchantment` WHERE `id`=%d", $this->armory->GetLocale(), $GemSpellItemEcnhID);
            if($GemText) {
                if(Utils::IsWriteRaw()) {
                    $xml->XMLWriter()->writeRaw('<gemProperties>');
                    $xml->XMLWriter()->writeRaw($GemText);
                    $xml->XMLWriter()->writeRaw('</gemProperties>');
                }
                else {
                    $xml->XMLWriter()->startElement('gemProperties');
                    $xml->XMLWriter()->text($GemText);
                    $xml->XMLWriter()->endElement(); //gemProperties
                }
            }
        }
        if($proto->block > 0) {
            $xml->XMLWriter()->startElement('blockValue');
            $xml->XMLWriter()->text($proto->block);
            $xml->XMLWriter()->endElement(); //blockValue
        }
        if($proto->fire_res > 0) {
            $xml->XMLWriter()->startElement('fireResist');
            $xml->XMLWriter()->text($proto->fire_res);
            $xml->XMLWriter()->endElement(); //fireResist
        }
        if($proto->nature_res > 0) {
            $xml->XMLWriter()->startElement('natureResist');
            $xml->XMLWriter()->text($proto->nature_res);
            $xml->XMLWriter()->endElement(); //natureResist
        }
        if($proto->frost_res > 0) {
            $xml->XMLWriter()->startElement('frostResist');
            $xml->XMLWriter()->text($proto->frost_res);
            $xml->XMLWriter()->endElement(); //frostResist
        }
        if($proto->shadow_res > 0) {
            $xml->XMLWriter()->startElement('shadowResist');
            $xml->XMLWriter()->text($proto->shadow_res);
            $xml->XMLWriter()->endElement(); //shadowResist
        }
        if($proto->arcane_res > 0) {
            $xml->XMLWriter()->startElement('arcaneResist');
            $xml->XMLWriter()->text($proto->arcane_res);
            $xml->XMLWriter()->endElement(); //arcaneResist
        }
        for($i = 0; $i < MAX_ITEM_PROTO_STATS; $i++) {
            if($ssd && $ssv) {
                if($ssd['StatMod_'.$i] < 0) {
                    continue;
                }
                $val = (self::GetSSDMultiplier($ssv, $proto->ScalingStatValue) * $ssd['Modifier_' . $i]) / 10000;
                $bonus_template = self::GetItemBonusTemplate($ssd['StatMod_' . $i]);
                $xml->XMLWriter()->startElement($bonus_template);
                $xml->XMLWriter()->text(round($val));
                $xml->XMLWriter()->endElement();
            }
            else {
                $key = $i + 1;
                if($proto->ItemStat[$i]['type'] > 0 && $proto->ItemStat[$i]['value'] > 0) {
                    $bonus_template = self::GetItemBonusTemplate($proto->ItemStat[$i]['type']);
                    $xml->XMLWriter()->startElement($bonus_template);
                    $xml->XMLWriter()->text($proto->ItemStat[$i]['value']);
                    $xml->XMLWriter()->endElement();
                }
            }
        }
        $armor = $proto->armor;
        if($ssv && $proto->ScalingStatValue > 0) {
            if($ssvarmor = $this->GetArmorMod($ssv, $proto->ScalingStatValue)) {
                $armor = $ssvarmor;
            }
        }
        $xml->XMLWriter()->startElement('armor');
        if($proto->ArmorDamageModifier > 0) {
            $xml->XMLWriter()->writeAttribute('armorBonus', 1);
        }
        $xml->XMLWriter()->text($armor);
        $xml->XMLWriter()->endElement(); //armor
        $itemSlotName = Utils::GetItemSlotTextByInvType($proto->InventoryType);
        if(!$parent && $isCharacter && $itemSlotName != null) {
            $enchantment = $characters->GetCharacterEnchant($itemSlotName);
            if($enchantment > 0) {
                if(Utils::IsWriteRaw()) {
                    $xml->XMLWriter()->writeRaw('<enchant>');
                    $xml->XMLWriter()->writeRaw($this->armory->aDB->selectCell("SELECT `text_%s` FROM `ARMORYDBPREFIX_enchantment` WHERE `id`=%d LIMIT 1", $this->armory->GetLocale(), $enchantment));
                    $xml->XMLWriter()->writeRaw('</enchant>'); //enchant
                }
                else {
                    $xml->XMLWriter()->startElement('enchant');
                    $xml->XMLWriter()->text($this->armory->aDB->selectCell("SELECT `text_%s` FROM `ARMORYDBPREFIX_enchantment` WHERE `id`=%d LIMIT 1", $this->armory->GetLocale(), $enchantment));
                    $xml->XMLWriter()->endElement(); //enchant
                }
            }
        }
        // Random property
        if($proto->RandomProperty > 0 || $proto->RandomSuffix > 0) {
            if(!$isCharacter) {
                $xml->XMLWriter()->startElement('randomEnchantData');
                $xml->XMLWriter()->endElement(); //randomEnchantData
            }
            else {
                if($itemSlotName) {
                    $rPropInfo = self::GetRandomPropertiesData($itemID, $characters->GetGUID(), $characters->GetEquippedItemGuidBySlot($itemSlotName), false, $characters->GetServerType(), $item, array('RandomProperty' => $proto->RandomProperty, 'RandomSuffix' => $proto->RandomSuffix));
                }
                else {
                    $rPropInfo = self::GetRandomPropertiesData($itemID, $characters->GetGUID(), 0, false, $characters->GetServerType(), $item);
                }
                if($isCharacter && !$parent && is_array($rPropInfo)) {
                    $xml->XMLWriter()->startElement('randomEnchantData');
                    if(Utils::IsWriteRaw()) {
                        $xml->XMLWriter()->writeRaw('<suffix>');
                        $xml->XMLWriter()->writeRaw($rPropInfo['suffix']);
                        $xml->XMLWriter()->writeRaw('</suffix>'); //suffix
                    }
                    else {
                        $xml->XMLWriter()->startElement('suffix');
                        $xml->XMLWriter()->text($rPropInfo['suffix']);
                        $xml->XMLWriter()->endElement(); //suffix
                    }
                    if(is_array($rPropInfo['data'])) {
                        if(Utils::IsWriteRaw()) {
                            foreach($rPropInfo['data'] as $randProp) {
                                $xml->XMLWriter()->writeRaw('<enchant>');
                                $xml->XMLWriter()->writeRaw($randProp);
                                $xml->XMLWriter()->writeRaw('</enchant>'); //enchant
                            }
                        }
                        else {
                            foreach($rPropInfo['data'] as $randProp) {
                                $xml->XMLWriter()->startElement('enchant');
                                $xml->XMLWriter()->text($randProp);
                                $xml->XMLWriter()->endElement(); //enchant
                            }
                        }
                    }
                    $xml->XMLWriter()->endElement(); //randomEnchantData
                }
            }
        }
        // Socket data
        $xml->XMLWriter()->startElement('socketData');
        $socket_data = false;
        // If there's no character, check $proto->Socket[X]
        if(!$isCharacter) {
            for($i = 0; $i < 3; $i++) {
                if(isset($proto->Socket[$i]['color']) && $proto->Socket[$i]['color'] > 0) {
                    switch($proto->Socket[$i]['color']) {
                        case 1:
                            $socket_data = array('color' => 'Meta');
                            break;
                        case 2:
                            $socket_data = array('color' => 'Red');
                            break;
                        case 4:
                            $socket_data = array('color' => 'Yellow');
                            break;
                        case 8:
                            $socket_data = array('color' => 'Blue');
                            break;
                    }
                    if(is_array($socket_data)) {
                        if(Utils::IsWriteRaw()) {
                            $xml->XMLWriter()->writeRaw('<socket');
                            foreach($socket_data as $socket_key => $socket_value) {
                                $xml->XMLWriter()->writeRaw(' ' . $socket_key .'="' . $socket_value .'"');
                            }
                            $xml->XMLWriter()->writeRaw('/>');
                        }
                        else {
                            $xml->XMLWriter()->startElement('socket');
                            foreach($socket_data as $socket_key => $socket_value) {
                                $xml->XMLWriter()->writeAttribute($socket_key, $socket_value);
                            }
                            $xml->XMLWriter()->endElement(); //socket
                        }
                    }
                }
            }
        }
        elseif($isCharacter && isset($item) && is_object($item)) {
            $gems = array(
                'g0' => $item->GetSocketInfo(1),
                'g1' => $item->GetSocketInfo(2),
                'g2' => $item->GetSocketInfo(3)
            );
            for($i = 0; $i < 3; $i++) {
                $index = $i+1;
                if(isset($gems['g' . $i]['item']) && $gems['g' . $i]['item'] > 0 && ($parent == false || $comparsion == true)) {
                    $socket_data = array(
                        'color'   => self::GetSocketColorString(($proto->Socket[$i]['color']) ? $proto->Socket[$i]['color'] : 0),
                        'enchant' => $gems['g' . $i]['enchant'],
                        'icon'    => $gems['g' . $i]['icon']
                    );
                    if(self::IsGemMatchesSocketColor($gems['g' . $i]['color'], ($proto->Socket[$i]['color']) ? $proto->Socket[$i]['color'] : -1)) {
                        $socket_data['match'] = '1';
                    }
                }
                else {
                    if(isset($proto->Socket[$i]['color']) && $proto->Socket[$i]['color'] > 0) {
                        $socket_data = array('color' => self::GetSocketColorString($proto->Socket[$i]['color']));
                    }
                }
                if(isset($socket_data) && is_array($socket_data)) {
                    if(Utils::IsWriteRaw()) {
                        $xml->XMLWriter()->writeRaw('<socket');
                        foreach($socket_data as $socket_key => $socket_value) {
                            $xml->XMLWriter()->writeRaw(' ' . $socket_key . '="' . $socket_value . '"');
                        }
                        $xml->XMLWriter()->writeRaw('/>');
                    }
                    else {
                        $xml->XMLWriter()->startElement('socket');
                        foreach($socket_data as $socket_key => $socket_value) {
                            $xml->XMLWriter()->writeAttribute($socket_key, $socket_value);
                        }
                        $xml->XMLWriter()->endElement(); //socket
                    }
                }
                $socket_data = false;
            }
        }
        if($proto->socketBonus > 0) {
            $bonus_text = $this->armory->aDB->selectCell("SELECT `text_%s` FROM `ARMORYDBPREFIX_enchantment` WHERE `id`=%d", $this->armory->GetLocale(), $proto->socketBonus);
            if(Utils::IsWriteRaw()) {
                $xml->XMLWriter()->writeRaw('<socketMatchEnchant>');
                $xml->XMLWriter()->writeRaw($bonus_text);
                $xml->XMLWriter()->writeRaw('</socketMatchEnchant>');  //socketMatchEnchant
            }
            else {
                $xml->XMLWriter()->startElement('socketMatchEnchant');
                $xml->XMLWriter()->text($bonus_text);
                $xml->XMLWriter()->endElement();  //socketMatchEnchant
            }
        }
        $xml->XMLWriter()->endElement(); //socketData
        // Durability
        if($isCharacter) {
            $item_durability = self::GetItemDurability($characters->GetGUID(), $characters->GetEquippedItemGuidBySlot($itemSlotName));
        }
        else {
            $item_durability = array('current' => $proto->MaxDurability, 'max' => $proto->MaxDurability);
        }
        if(is_array($item_durability) && $item_durability['current'] > 0) {
            $xml->XMLWriter()->startElement('durability');
            $xml->XMLWriter()->writeAttribute('current', (int) $item_durability['current']);
            $xml->XMLWriter()->writeAttribute('max', (int) $item_durability['max']);
            $xml->XMLWriter()->endElement(); //durability
        }
        $allowable_classes = self::AllowableClasses($proto->AllowableClass);
        if($allowable_classes) {
            $xml->XMLWriter()->startElement('allowableClasses');
            foreach($allowable_classes as $al_class) {
                if(Utils::IsWriteRaw()) {
                    $xml->XMLWriter()->writeRaw('<class>');
                    $xml->XMLWriter()->writeRaw($al_class);
                    $xml->XMLWriter()->writeRaw('</class>'); //class
                }
                else {
                    $xml->XMLWriter()->startElement('class');
                    $xml->XMLWriter()->text($al_class);
                    $xml->XMLWriter()->endElement(); //class
                }
            }
            $xml->XMLWriter()->endElement(); //allowableClasses
        }
        $allowable_races = self::AllowableRaces($proto->AllowableRace);
        if($allowable_races) {
            $xml->XMLWriter()->startElement('allowableRaces');
            foreach($allowable_races as $al_race) {
                if(Utils::IsWriteRaw()) {
                    $xml->XMLWriter()->writeRaw('<race>');
                    $xml->XMLWriter()->writeRaw($al_race);
                    $xml->XMLWriter()->writeRaw('</race>'); //race
                }
                else {
                    $xml->XMLWriter()->startElement('race');
                    $xml->XMLWriter()->text($al_race);
                    $xml->XMLWriter()->endElement(); //race
                }
            }
            $xml->XMLWriter()->endElement(); //allowableRaces
        }
        if($proto->RequiredSkill > 0) {
            if(Utils::IsWriteRaw()) {
                $xml->XMLWriter()->writeRaw('<requiredSkill');
                $xml->XMLWriter()->writeRaw(' name="' . $this->armory->aDB->selectCell("SELECT `name_%s` FROM `ARMORYDBPREFIX_skills` WHERE `id`=%d", $this->armory->GetLocale(), $proto->RequiredSkill) . '"');
                $xml->XMLWriter()->writeRaw(' rank="', $proto->RequiredSkillRank . '"');
                $xml->XMLWriter()->writeRaw('/>'); //requiredSkill
            }
            else {
                $xml->XMLWriter()->startElement('requiredSkill');
                $xml->XMLWriter()->writeAttribute('name', $this->armory->aDB->selectCell("SELECT `name_%s` FROM `ARMORYDBPREFIX_skills` WHERE `id`=%d", $this->armory->GetLocale(), $proto->RequiredSkill));
                $xml->XMLWriter()->writeAttribute('rank', $proto->RequiredSkillRank);
                $xml->XMLWriter()->endElement(); //requiredSkill
            }
        }
        if($proto->requiredspell > 0 && $spellName = $this->armory->aDB->selectCell("SELECT `SpellName_%s` FROM `ARMORYDBPREFIX_spell` WHERE `id`=%d", $this->armory->GetLocale(), $proto->requiredspell)) {
            $xml->XMLWriter()->startElement('requiredAbility');
            $xml->XMLWriter()->text($spellName);
            $xml->XMLWriter()->endElement(); //requiredAbility
        }
        if($proto->RequiredReputationFaction > 0 && $factionName = $this->armory->aDB->selectCell("SELECT `name_%s` FROM `ARMORYDBPREFIX_faction` WHERE `id`=%d", $this->armory->GetLocale(), $proto->RequiredReputationFaction)) {    
            if(Utils::IsWriteRaw()) {
                $xml->XMLWriter()->writeRaw('<requiredFaction');
                $xml->XMLWriter()->writeRaw(' name="' . $factionName . '"');
                $xml->XMLWriter()->writeRaw(' rep="' . $proto->RequiredReputationRank . '"');
                $xml->XMLWriter()->writeRaw('/>'); //requiredFaction
            }
            else {
                $xml->XMLWriter()->startElement('requiredFaction');
                $xml->XMLWriter()->writeAttribute('name', $factionName);
                $xml->XMLWriter()->writeAttribute('rep', $proto->RequiredReputationRank);
                $xml->XMLWriter()->endElement(); //requiredFaction
            }
        }
        $xml->XMLWriter()->startElement('requiredLevel');
        $xml->XMLWriter()->text($proto->RequiredLevel);
        $xml->XMLWriter()->endElement(); //requiredLevel
        if($proto->ItemLevel > 0) {
            $xml->XMLWriter()->startElement('itemLevel');
            $xml->XMLWriter()->text($proto->ItemLevel);
            $xml->XMLWriter()->endElement(); //itemLevel
        }
        // Item set
        if($proto->itemset > 0) {
            $xml->XMLWriter()->startElement('setData');
            $itemsetName = $this->armory->aDB->selectCell("SELECT `name_%s` FROM `ARMORYDBPREFIX_itemsetinfo` WHERE `id`=%d", $this->armory->GetLocale(), $proto->itemset);
            if(Utils::IsWriteRaw()) {
                $xml->XMLWriter()->writeRaw('<name>');
                $xml->XMLWriter()->writeRaw($itemsetName);
                $xml->XMLWriter()->writeRaw('</name>');
            }
            else {
                $xml->XMLWriter()->startElement('name');
                $xml->XMLWriter()->text($itemsetName);
                $xml->XMLWriter()->endElement(); //name
            }
            $setdata = $this->armory->aDB->selectRow("SELECT * FROM `ARMORYDBPREFIX_itemsetinfo` WHERE `id`=%d", $proto->itemset);
            if(self::IsMultiplyItemSet($proto->itemset)) {
                // Get itemset info from other table (armory_itemsetdata)
                $currentSetData = $this->armory->aDB->select("SELECT * FROM `ARMORYDBPREFIX_itemsetdata` WHERE `original`=%d", $proto->itemset);
                if(is_array($currentSetData)) {
                    $activeSetInfo = array();
                    $basicSetData = $currentSetData[0];
                    foreach($currentSetData as $iSet) {
                        for($i = 1; $i < 6; $i++) {
                            if($characters->IsItemEquipped($iSet['item' . $i])) {
                                $activeSetInfo['item' . $i] = $iSet['item' . $i];
                            }
                        }
                    }
                    for($i = 1; $i < 6; $i++) {
                            if(Utils::IsWriteRaw()) {
                                $xml->XMLWriter()->writeRaw('<item');
                                if(isset($activeSetInfo['item' . $i])) {
                                    $xml->XMLWriter()->writeRaw(' name="' . self::GetItemName($activeSetInfo['item' . $i]) . '"');
                                    if($characters->IsItemEquipped($activeSetInfo['item' . $i])) {
                                        $xml->XMLWriter()->writeRaw(' equipped="1"');
                                    }
                                }
                                else {
                                    $xml->XMLWriter()->writeRaw(' name="' . self::GetItemName($basicSetData['item' . $i]) . '"');
                                }
                                $xml->XMLWriter()->writeRaw('/>'); //item
                            }
                            else {
                                $xml->XMLWriter()->startElement('item');
                                if(isset($activeSetInfo['item' . $i])) {
                                    $xml->XMLWriter()->writeAttribute('name', self::GetItemName($activeSetInfo['item' . $i]));
                                    if($characters->IsItemEquipped($activeSetInfo['item' . $i])) {
                                        $xml->XMLWriter()->writeAttribute('equipped', '1');
                                    }
                                }
                                else {
                                    $xml->XMLWriter()->writeAttribute('name', self::GetItemName($basicSetData['item' . $i]));
                                }
                                $xml->XMLWriter()->endElement(); //item
                            }
                    }
                }
            }
            else {
                for($i = 1; $i < 10; $i++) {
                    if(isset($setdata['item' . $i]) && self::IsItemExists($setdata['item' . $i])) {
                        if(Utils::IsWriteRaw()) {
                            $xml->XMLWriter()->writeRaw('<item');
                            $xml->XMLWriter()->writeRaw(' name="' . self::GetItemName($setdata['item' . $i]) . '"');
                            if($characters->IsItemEquipped($setdata['item' . $i])) {
                                $xml->XMLWriter()->writeRaw(' equipped="1"');
                            }
                            $xml->XMLWriter()->writeRaw('/>'); //item
                        }
                        else {
                            $xml->XMLWriter()->startElement('item');
                            $xml->XMLWriter()->writeAttribute('name', self::GetItemName($setdata['item' . $i]));
                            if($characters->IsItemEquipped($setdata['item' . $i])) {
                                $xml->XMLWriter()->writeAttribute('equipped', 1);
                            }
                            $xml->XMLWriter()->endElement(); //item
                        }
                    }
                }
            }
            $itemsetbonus = self::GetItemSetBonusInfo($setdata);
            if(is_array($itemsetbonus)) {
                foreach($itemsetbonus as $item_bonus) {
                    if(Utils::IsWriteRaw()) {
                        $xml->XMLWriter()->writeRaw('<setBonus');
                        $xml->XMLWriter()->writeRaw(' desc="' . $item_bonus['desc'] . '"');
                        $xml->XMLWriter()->writeRaw(' threshold="' . $item_bonus['threshold'] . '"');
                        $xml->XMLWriter()->writeRaw('/>'); //setBonus
                    }
                    else {
                        $xml->XMLWriter()->startElement('setBonus');
                        $xml->XMLWriter()->writeAttribute('desc', $item_bonus['desc']);
                        $xml->XMLWriter()->writeAttribute('threshold', $item_bonus['threshold']);
                        $xml->XMLWriter()->endElement(); //setBonus
                    }
                }
            }
            $xml->XMLWriter()->endElement(); //setData
        }
        
        $xml->XMLWriter()->startElement('spellData');
        $spellData = 0;
        $spellInfo = false;
        for($i = 0; $i < 5; $i++) {
            if($proto->Spells[$i]['spellid'] > 0) {
                $spellData = 1;
                $spell_tmp = $this->armory->aDB->selectRow("SELECT * FROM `ARMORYDBPREFIX_spell` WHERE `id`=%d", $proto->Spells[$i]['spellid']);
                if($this->armory->GetLocale() == 'en_gb' || $this->armory->GetLocale() == 'ru_ru') {
                    $tmp_locale = $this->armory->GetLocale();
                }
                else {
                    $tmp_locale = 'en_gb';
                }
                if(!isset($spell_tmp['Description_' . $tmp_locale]) || empty($spell_tmp['Description_' . $tmp_locale])) {
                    // Try to find at least en_gb locale
                    if(!isset($spell_tmp['Description_en_gb']) || empty($spell_tmp['Description_en_gb'])) {
                        continue;
                    }
                    else {
                        $tmp_locale = 'en_gb';
                    }
                }
                $spellInfo = $this->SpellReplace($spell_tmp, Utils::ValidateSpellText($spell_tmp['Description_' . $tmp_locale]));
                if($spellInfo) {
                    $spellData = 2;
                    $spellInfo = str_replace('&quot;', '"', $spellInfo);
                    $xml->XMLWriter()->startElement('spell');
                    $xml->XMLWriter()->startElement('trigger');
                    $xml->XMLWriter()->text($proto->Spells[$i]['trigger']);
                    $xml->XMLWriter()->endElement();  //trigger
                    $xml->XMLWriter()->startElement('desc');
                    $xml->XMLWriter()->text($spellInfo);
                    $xml->XMLWriter()->endElement();  //desc
                    $xml->XMLWriter()->endElement(); //spell
                }
            }
        }
        if($spellData == 1 && $proto->description != null) {
            $xml->XMLWriter()->startElement('spell');
            $xml->XMLWriter()->startElement('trigger');
            $xml->XMLWriter()->text('6');
            $xml->XMLWriter()->endElement(); //trigger
            $xml->XMLWriter()->startElement('desc');
            if($this->armory->GetLocale() == 'en_gb' || $this->armory->GetLocale() == 'en_us') {
                $xml->XMLWriter()->text($proto->description);
            }
            else {
                $xml->XMLWriter()->text(self::GetItemDescription($itemID));
            }
            $xml->XMLWriter()->endElement(); //desc
            if(!$parent) {
                for($k = 1; $k < 4; $k++) {
                    if($spell_tmp['EffectItemType_' . $k] > 0 && self::IsItemExists($spell_tmp['EffectItemType_' . $k])) {
                        $xml->XMLWriter()->startElement('itemTooltip');
                        self::ItemTooltip($spell_tmp['EffectItemType_' . $k], $xml, $characters, true);
                        $xml->XMLWriter()->endElement(); //itemTooltip
                        $spellreagents = $this->GetSpellItemCreateReagentsInfo($spell_tmp['EffectItemType_' . $k]);
                        if(is_array($spellreagents)) {
                            foreach($spellreagents as $reagent) {
                                if(Utils::IsWriteRaw()) {
                                    $xml->XMLWriter()->writeRaw('<reagent');
                                    $xml->XMLWriter()->writeRaw(' count="' . $reagent['count'] . '"');
                                    $xml->XMLWriter()->writeRaw(' name="' . $reagent['name'] . '"');
                                    $xml->XMLWriter()->writeRaw('/>'); //reagent
                                }
                                else {
                                    $xml->XMLWriter()->startElement('reagent');
                                    $xml->XMLWriter()->writeAttribute('count', $reagent['count']);
                                    $xml->XMLWriter()->writeAttribute('name', $reagent['name']);
                                    $xml->XMLWriter()->endElement(); //reagent
                                }
                            }
                        }
                        else {
                            $xml->XMLWriter()->startElement('reagent');
                            $xml->XMLWriter()->endElement(); //reagent
                        }
                    }
                }
            }
            $xml->XMLWriter()->endElement(); //spell
        }
        $xml->XMLWriter()->endElement(); //spellData
        if($proto->description != null && $proto->description != $spellInfo && $spellData != 1) {
            if(Utils::IsWriteRaw()) {
                $xml->XMLWriter()->writeRaw('<desc>');
                $xml->XMLWriter()->writeRaw(self::GetItemDescription($itemID));
                $xml->XMLWriter()->writeRaw('</desc>'); //desc
            }
            else {
                $xml->XMLWriter()->startElement('desc');
                if($this->armory->GetLocale() == 'en_gb' || $this->armory->GetLocale() == 'en_us') {
                    $xml->XMLWriter()->text($proto->description);
                }
                else {
                    $xml->XMLWriter()->text(self::GetItemDescription($itemID));
                }
                $xml->XMLWriter()->endElement(); //desc
            }
        }
        if(!$parent) {
            $itemSource = self::GetItemSource($itemID);
            if(is_array($itemSource)) {
                if(Utils::IsWriteRaw()) {
                    $xml->XMLWriter()->writeRaw('<itemSource');
                    foreach($itemSource as $source_key => $source_value) {
                        $xml->XMLWriter()->writeRaw(' ' . $source_key . '="' . $source_value . '"');
                    }    
                    $xml->XMLWriter()->writeRaw('/>'); //itemSource
                }
                else {
                    $xml->XMLWriter()->startElement('itemSource');
                    foreach($itemSource as $source_key => $source_value) {
                        $xml->XMLWriter()->writeAttribute($source_key, $source_value);
                    }    
                    $xml->XMLWriter()->endElement(); //itemSource
                }
            }
            if($itemSource['value'] == 'sourceType.vendor' && $reqArenaRating = self::IsRequiredArenaRating($itemID)) {
                $xml->XMLWriter()->startElement('requiredPersonalArenaRating');
                $xml->XMLWriter()->writeAttribute('personalArenaRating', $reqArenaRating);
                $xml->XMLWriter()->endElement(); //requiredPersonalArenaRating
            }
        }
    }
    
    /**
     * Returns reagents info for crafted item (itemID)
     * @category Items class
     * @access   private
     * @param    int $itemID
     * @return   array
     **/
    private function GetSpellItemCreateReagentsInfo($itemID) {
        $spell = $this->armory->aDB->selectRow("
        SELECT
        `Reagent_1`, `Reagent_2`, `Reagent_3`, `Reagent_4`, `Reagent_5`, `Reagent_6`,
        `ReagentCount_1`, `ReagentCount_2`, `ReagentCount_3`,
        `ReagentCount_4`, `ReagentCount_5`, `ReagentCount_6`
        FROM `ARMORYDBPREFIX_spell`
        WHERE `EffectItemType_1`=%d OR `EffectItemType_2`=%d OR `EffectItemType_3`=%d", $itemID, $itemID, $itemID);
        if(!$spell) {
            return false;
        }
        $data = array();
        for($i = 1; $i < 6; $i++) {
            if(isset($spell['Reagent_' . $i]) && $spell['Reagent_' . $i] > 0) {
                $data[$i] = array(
                    'count' => $spell['ReagentCount_' . $i],
                    'name'  => self::GetItemName($spell['Reagent_' . $i])
                );
            }
        }
        return $data;
    }
    
    /**
     * Returns item slot ID by InventoryType
     * @category Items class
     * @access   public
     * @param    int $itemID
     * @param    int $item_slot = -1
     * @return   array
     **/
    public function GetItemSlotId($itemID, $item_slot = -1) {
        if($item_slot == -1) {
            $item_slot = $this->armory->wDB->selectCell("SELECT `InventoryType` FROM `item_template` WHERE `entry`=%d AND (`class`=2 OR `class`=4)", $itemID);
        }
        switch($item_slot) {
            case 1:
                $slot_id = INV_HEAD;
                $slotname = 'head';
                break;
            case 2:
                $slot_id = INV_NECK;
                $slotname = 'neck';
                break;
            case 3:
                $slot_id = INV_SHOULDER;
                $slotname = 'shoulder';
                break;
            case 4:
                $slot_id = INV_SHIRT;
                $slotname = 'shirt';
                break;
            case 5:
                $slot_id = INV_CHEST;
                $slotname = 'chest';
                break;
            case 6:
                $slot_id = INV_BRACERS;
                $slotname = 'wrist';
                break;
            case 7:
                $slot_id = INV_LEGS;
                $slotname = 'legs';
                break;
            case 8:
                $slot_id = INV_BOOTS;
                $slotname = 'boots';
                break;
            case 9:
                $slot_id = INV_BELT;
                $slotname = 'belt';
                break;
            case 10:
                $slot_id = INV_GLOVES;
                $slotname = 'gloves';
                break;
            case 11:
                $slot_id = array(INV_RING_1, INV_RING_2);
                $slotname = array('ring1', 'ring2');
                break;
            case 12:
                $slot_id = array(INV_TRINKET_1, INV_TRINKET_2);
                $slotname = array('trinket1', 'trinket2');
                break;
            case 16:
                $slot_id = INV_BACK;
                $slotname = 'back';
                break;
            case 19:
                $slot_id = INV_TABARD;
                $slotname = 'tabard';
                break;
            case 20:
                $slot_id = INV_CHEST;
                $slotname = 'chest';
                break;
            case 13:
            case 17:
            case 21:
                $slot_id = INV_MAIN_HAND;
                $slotname = 'mainhand';
                break;
            case 14:
            case 22:
                $slot_id = INV_OFF_HAND;
                $slotname = 'offhand';
                break;
            case 15:
            case 23:
            case 28:
                $slot_id = INV_RANGED_RELIC;
                $slotname = 'relic';
                break;
            default:
                $slot_id = 0;
                $slotname = null;
                break;
        }
        return array('slot_id' => $slot_id, 'slotname' => $slotname);
    }
    
    /**
     * Checks is item sold by vendor
     * @category Items class
     * @access   public
     * @param    int $itemID
     * @return   bool
     **/
    public function IsVendorItem($itemID) {
        return $this->armory->wDB->selectCell("SELECT 1 FROM `npc_vendor` WHERE `item`=%d LIMIT 1", $itemID);
    }
    
    public function GenerateEnchantmentSpellData($spellID) {
        if($this->armory->GetLocale() == 'en_gb' || $this->armory->GetLocale() == 'ru_ru') {
            $tmp_locale = $this->armory->GetLocale();
        }
        else {
            $tmp_locale = 'en_gb';
        }
        $spell_info = $this->armory->aDB->selectRow("SELECT `SpellName_%s`, `Description_%s`, `SpellName_en_gb`, `Description_en_gb` FROM `ARMORYDBPREFIX_spell` WHERE `id`=%d LIMIT 1", $tmp_locale, $tmp_locale, $spellID);
        if(!isset($spell_info['Description_' . $tmp_locale]) || empty($spell_info['Description_' . $tmp_locale])) {
            // Try to find en_gb locale
            if(isset($spell_info['Description_en_gb']) && !empty($spell_info['Description_en_gb'])) {
                $tmp_locale = 'en_gb';
            }
            else {
                return false;
            }
        }
        $data = array(
            'name' => $spell_info['SpellName_' . $tmp_locale],
            'desc' => str_replace(array('&quot;', '&lt;br&gt;', '<br>'), array('"', '', ''), $spell_info['Description_' . $tmp_locale])
        );
        return $data;
    }
    
    /**
     * Returns typeID or subtypeID for provided data
     * @category Items class
     * @access   public
     * @param    string $key
     * @param    string $row = 'type'
     * @return   int
     **/
    public function GetItemTypeInfo($key, $row = 'type') {
        if($key == 'all' || ($row != 'type' && $row != 'subtype')) {
            return false;
        }
        return $this->armory->aDB->selectCell("SELECT `%s` FROM `ARMORYDBPREFIX_item_sources` WHERE `key`='%s' LIMIT 1", $row, $key);
    }
    
    /**
     * Returns item stats that can be useful for different class types (tank, melee, caster, etc.)
     * @category Items class
     * @access   public
     * @param    string $classType
     * @param    int    $value
     * @param    string $type = '>'
     * @param    string $mode = 'AND'
     **/
    public function GetItemModsByClassType($classType, $value, $type = '>', $mode = 'AND') {
        $roles = array(
            'tank' => array(
                ITEM_MOD_DEFENSE_SKILL_RATING, ITEM_MOD_DODGE_RATING, ITEM_MOD_PARRY_RATING, ITEM_MOD_BLOCK_RATING
            ),
            'caster' => array(
                ITEM_MOD_SPELL_POWER
            ),
            'melee' => array(
                ITEM_MOD_AGILITY, ITEM_MOD_ATTACK_POWER
            ),
            'dd' => array(
                ITEM_MOD_SPELL_POWER
            ),
            'dot' => array(
                ITEM_MOD_SPELL_POWER
            ),
            'healer' => array(
                ITEM_MOD_SPELL_POWER, ITEM_MOD_MANA_REGENERATION
            )
        );
        $query = null;
        switch($classType) {
            case 'tank':
            case 'caster':
            case 'melee':
            case 'dd':
            case 'dot':
            case 'healer':
                $loop = 0;
                foreach($roles[$classType] as $m_type) {
                    if($loop > 0) {
                        $query .= ' ' . $mode . ' ';
                    }
                    $query .= self::GenerateQueryByItemOpt($m_type, $type, $value);
                    $loop++;
                }
                break;
        }
        return $query;
    }
    
    /**
     * Returns InventoryType ID by slot name ('head', for example)
     * @category Items class
     * @access   public
     * @param    string $slotName
     * @return   int
     **/
    public function GetInventoryTypeBySlotName($slotName) {
        switch($slotName) {
            case 'head':
                $slot_id = INV_TYPE_HEAD;
                break;
            case 'neck':
                $slot_id = INV_TYPE_NECK;
                break;
            case 'shoulders':
                $slot_id = INV_TYPE_SHOULDER;
                break;
            case 'back':
                $slot_id = INV_TYPE_BACK;
                break;
            case 'chest':
                $slot_id = INV_TYPE_CHEST;
                break;
            case 'shirt':
                $slot_id = INV_TYPE_SHIRT;
                break;
            case 'wrists':
                $slot_id = INV_TYPE_WRISTS;
                break;
            case 'hands':
                $slot_id = INV_TYPE_HANDS;
                break;
            case 'waist':
                $slot_id = INV_TYPE_WAIST;
                break;
            case 'legs':
                $slot_id = INV_TYPE_LEGS;
                break;
            case 'feet':
                $slot_id = INV_TYPE_FEET;
                break;
            case 'finger':
                $slot_id = INV_TYPE_FINGER;
                break;
            case 'trinket':
                $slot_id = INV_TYPE_TRINKET;
                break;
            case 'main':
                $slot_id = INV_TYPE_MAINHAND;
                break;
            case 'off':
                $slot_id = INV_TYPE_OFFHAND;
                break;
            case 'one':
                $slot_id = INV_TYPE_WEAPON;
                break;
            case 'two':
                $slot_id = INV_TYPE_TWOHAND;
                break;
            case 'ranged':
                $slot_id = INV_TYPE_RANGED;
                break;
            default:
                $slot_id = 0;
                break;
        }
        return $slot_id;
    }
    
    /**
     * Returns item stats by OptName
     * @category Items class
     * @access   public
     * @param    string $opt
     * @param    string $mode
     * @param    int    $value
     **/
    public function GetItemModsByOpt($opt, $mode, $value) {
        $data = false;
        switch($opt) {
            case 'strength':
                $data = self::GenerateQueryByItemOpt(ITEM_MOD_STRENGTH, $mode, $value);
                break;
            case 'agility':
                $data = self::GenerateQueryByItemOpt(ITEM_MOD_AGILITY, $mode, $value);
                break;
            case 'stamina':
                $data = self::GenerateQueryByItemOpt(ITEM_MOD_STAMINA, $mode, $value);
                break;
            case 'intellect':
                $data = self::GenerateQueryByItemOpt(ITEM_MOD_INTELLECT, $mode, $value);
                break;
            case 'spirit':
                $data = self::GenerateQueryByItemOpt(ITEM_MOD_SPIRIT, $mode, $value);
                break;
            case 'critRating':
                $data = self::GenerateQueryByItemOpt(ITEM_MOD_CRIT_RATING, $mode, $value);
                break;
            case 'hitRating':
                $data = self::GenerateQueryByItemOpt(ITEM_MOD_HIT_RATING, $mode, $value);
                break;
            case 'attackPower':
                $data = self::GenerateQueryByItemOpt(ITEM_MOD_ATTACK_POWER, $mode, $value);
                break;
            case 'ignoreArmor':
                $data = self::GenerateQueryByItemOpt(ITEM_MOD_ARMOR_PENETRATION_RATING, $mode, $value);
                break;
            case 'expertiseRating':
                $data = self::GenerateQueryByItemOpt(ITEM_MOD_EXPERTISE_RATING, $mode, $value);
                break;
            case 'spellPower':
                $data = self::GenerateQueryByItemOpt(ITEM_MOD_SPELL_POWER, $mode, $value);
                break;
            case 'spellPenetration':
                $data = self::GenerateQueryByItemOpt(ITEM_MOD_SPELL_PENETRATION, $mode, $value);
                break;
            case 'spellManaRegen':
                $data = self::GenerateQueryByItemOpt(ITEM_MOD_MANA_REGENERATION, $mode, $value);
                break;
            case 'armor':
                break;
            case 'blockRating':
                $data = self::GenerateQueryByItemOpt(ITEM_MOD_BLOCK_RATING, $mode, $value);
                break;
            case 'blockValue':
                $data = self::GenerateQueryByItemOpt(ITEM_MOD_BLOCK_VALUE, $mode, $value);
                break;
            case 'defenseRating':
                $data = self::GenerateQueryByItemOpt(ITEM_MOD_DEFENSE_SKILL_RATING, $mode, $value);
                break;
            case 'dodgeRating':
                $data = self::GenerateQueryByItemOpt(ITEM_MOD_DODGE_RATING, $mode, $value);
                break;
            case 'parryRating':
                $data = self::GenerateQueryByItemOpt(ITEM_MOD_PARRY_RATING, $mode, $value);
                break;
            case 'healthRegen':
                $data = self::GenerateQueryByItemOpt(ITEM_MOD_HEALTH_REGEN, $mode, $value);
                break;
            case 'resilience':
                $data = self::GenerateQueryByItemOpt(ITEM_MOD_RESILIENCE_RATING, $mode, $value);
                break;
            case 'resistArcane':
                $data = sprintf("(`item_template`.`arcane_res`%s%d) ", $mode, $value);
                break;
            case 'resistShadow':
                $data = sprintf("(`item_template`.`shadow_res`%s%d) ", $mode, $value);
                break;
            case 'resistNature':
                $data = sprintf("(`item_template`.`nature_res`%s%d) ", $mode, $value);
                break;
            case 'resistFrost':
                $data = sprintf("(`item_template`.`frost_res`%s%d) ", $mode, $value);
                break;
            case 'resistFire':
                $data = sprintf("(`item_template`.`fire_res`%s%d) ", $mode, $value);
                break;
            case 'dps':
                break;
            case 'minDamage':
            case 'maxDamage':
                $m_type = ($opt == 'minDamage') ? 'min' : 'max';
                $data = '';
                for($i = 0; $i < 2; $i++) {
                    if($i) {
                        $data .= sprintf(" OR (`item_template`.`dmg_%s%d`%s%d) ", $m_type, $i+1, $mode, $value);
                    }
                    else {
                        $data .= sprintf("(`item_template`.`dmg_%s%d`%s%d) ", $m_type, $i+1, $mode, $value);
                    }
                }
                break;
            case 'speed':
                $data = sprintf("(`item_template`.`delay`%s%d)", $mode, $value);
                break;
            case 'bindsPickedUp':
                $data = "(`item_template`.`bonding`=1) ";
                break;
            case 'bindsEquip':
                $data = "(`item_template`.`bonding`=2) ";
                break;
            case 'bindsWhenUsed':
                $data = "(`item_template`.`bonding`=3) ";
                break;
            case 'unique':
            case 'uniqueEquipped':
                $data = "(`item_template`.`maxcount`=1) ";
                break;
            case 'hasSpellEffect':
                for($i = 0; $i < 4; $i++) {
                    if($i) {
                        $data .= sprintf(" OR (`item_template`.`spellid_%d`>0) ", $i+1);
                    }
                    else {
                        $data .= sprintf("(`item_template`.`spellid_%d`>0) ", $i+1);
                    }
                }
                break;
        }
        return $data;
    }
    
    /**
     * Generates SQL query part (stat_typeX)
     * @category Items class
     * @access   private
     * @param    int $mod
     * @param    string $type
     * @param    int $value
     **/
    private function GenerateQueryByItemOpt($mod, $type, $value) {
        $query = '(';
        for($i = 0; $i < 10; $i++) {
            if($i) {
                $query .= sprintf(" OR (`item_template`.`stat_type%d`='%d' AND `item_template`.`stat_value%d`%s%d) ", $i+1, $mod, $i+1, $type, $value);
            }
            else {
                $query .= sprintf("(`item_template`.`stat_type%d`='%d' AND `item_template`.`stat_value%d`%s%d) ", $i+1, $mod, $i+1, $type, $value);
            }
        }
        $query .= ')';
        return $query;
    }
    
    /**
     * Returns multiplier for SSV mask
     * @category Items class
     * @access   public
     * @param    array $ssv
     * @param    int $mask
     * @return   int
     **/
    public function GetSSDMultiplier($ssv, $mask) {
        if(!is_array($ssv)) {
            return 0;
        }
        if($mask & 0x4001F) {
            if($mask & 0x00000001) {
                return $ssv['ssdMultiplier_0'];
            }
            if($mask & 0x00000002) {
                return $ssv['ssdMultiplier_1'];
            }
            if($mask & 0x00000004) {
                return $ssv['ssdMultiplier_2'];
            }
            if($mask & 0x00000008) {
                return $ssv['ssdMultiplier2'];
            }
            if($mask & 0x00000010) {
                return $ssv['ssdMultiplier_3'];
            }
            if($mask & 0x00040000) {
                return $ssv['ssdMultiplier3'];
            }
        }
        return 0;
    }
    
    /**
     * Returns armor mod for SSV mask
     * @category Items class
     * @access   public
     * @param    array $ssv
     * @param    int $mask
     * @return   int
     **/
    public function GetArmorMod($ssv, $mask) {
        if(!is_array($ssv)) {
            return 0;
        }
        if($mask & 0x00F001E0) {
            if($mask & 0x00000020) {
                return $ssv['armorMod_0'];
            }
            if($mask & 0x00000040) {
                return $ssv['armorMod_1'];
            }
            if($mask & 0x00000080) {
                return $ssv['armorMod_2'];
            }
            if($mask & 0x00000100) {
                return $ssv['armorMod_3'];
            }
            if($mask & 0x00100000) {
                return $ssv['armorMod2_0']; // cloth
            }
            if($mask & 0x00200000) {
                return $ssv['armorMod2_1']; // leather
            }
            if($mask & 0x00400000) {
                return $ssv['armorMod2_2']; // mail
            }
            if($mask & 0x00800000) {
                return $ssv['armorMod2_3']; // plate
            }
        }
        return 0;
    }
    
    /**
     * Returns DPS mod for SSV mask
     * @category Items class
     * @access   public
     * @param    array $ssv
     * @param    int $mask
     * @return   int
     **/
    public function GetDPSMod($ssv, $mask) {
        if(!is_array($ssv)) {
            return 0;
        }
        if($mask & 0x7E00) {
            if($mask & 0x00000200) {
                return $ssv['dpsMod_0'];
            }
            if($mask & 0x00000400) {
                return $ssv['dpsMod_1'];
            }
            if($mask & 0x00000800) {
                return $ssv['dpsMod_2'];
            }
            if($mask & 0x00001000) {
                return $ssv['dpsMod_3'];
            }
            if($mask & 0x00002000) {
                return $ssv['dpsMod_4'];
            }
            if($mask & 0x00004000) {
                return $ssv['dpsMod_5'];   // not used?
            }
        }
        return 0;
    }
    
    /**
     * Returns Spell Bonus for SSV mask
     * @category Items class
     * @access   public
     * @param    array $ssv
     * @param    int $mask
     * @return   int
     **/
    public function GetSpellBonus($ssv, $mask) {
        if(!is_array($ssv)) {
            return 0;
        }
        if($mask & 0x00008000) {
            return $ssv['spellBonus'];
        }
        return 0;
    }
    
    /**
     * Returns feral bonus for SSV mask
     * @category Items class
     * @access   public
     * @param    array $ssv
     * @param    int $mask
     * @return   int
     **/
    public function GetFeralBonus($ssv, $mask) {
        if(!is_array($ssv)) {
            return 0;
        }
        if($mask & 0x00010000) {
            return 0;   // not used?
        }
        return 0;
    }
    
    /**
     * Returns item entry from DB
     * @category Items class
     * @access   public
     * @param    int $item_guid
     * @return   int
     **/
    public function GetItemEntryByGUID($item_guid) {
        return $this->armory->cDB->selectCell("SELECT `item_template` FROM `character_inventory` WHERE `item`=%d", $item_guid);
    }
    
    /**
     * Returns item GUID from DB
     * @category Items class
     * @access   public
     * @param    int $item_entry
     * @param    int $owner_guid
     * @return   int
     **/
    public function GetItemGUIDByEntry($item_entry, $owner_guid) {
        return $this->armory->cDB->selectCell("SELECT `item` FROM `character_inventory` WHERE `item_template`=%d AND `owner_guid`=%d", $item_entry, $owner_guid);
    }
    
    public function IsGemMatchesSocketColor($gem_color, $socket_color) {
        if($socket_color == $gem_color) {
            return true;
        }
        elseif($socket_color == 2 && in_array($gem_color, array(6, 10, 14))) {
            return true;
        }
        elseif($socket_color == 4 && in_array($gem_color, array(6, 12, 14))) {
            return true;
        }
        elseif($socket_color == 8 && in_array($gem_color, array(10, 12, 14))) {
            return true;
        }
        elseif($socket_color == 0) {
            // Extra socket
            return true;
        }
        else {
            return false;
        }
    }
    
    public function GetSocketColorString($color) {
        $string = null;
        switch($color) {
            case 1:
                $string = 'Meta';
                break;
            case 2:
                $string = 'Red';
                break;
            case 4:
                $string = 'Yellow';
                break;
            case 8:
                $string = 'Blue';
                break;
        }
        return $string;
    }
    
    private function IsMultiplyItemSet($itemSetID) {
        if($itemSetID >= 843 && $itemSetID != 881 && $itemSetID != 882) {
            return true;
        }
        $setID = $this->armory->aDB->selectCell("SELECT `id` FROM `ARMORYDBPREFIX_itemsetdata` WHERE `original`=%d LIMIT 1", $itemSetID);
        if($setID > 160) {
            return true;
        }
        return false;
    }
    
    public function GetItemIdByName($name) {
        $name = Utils::escape(urldecode($name));
        return $this->armory->wDB->selectCell("SELECT `entry` FROM `item_template` WHERE `name` = '%s' LIMIT 1", $name);
    }
}
?>