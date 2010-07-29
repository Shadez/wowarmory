<?php

/**
 * @package World of Warcraft Armory
 * @version Release Candidate 1
 * @revision 334
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

Class Items extends Connector {
    
    /**
     * Not used now
     **/
    public $itemId;
    
    /**
     * $charGuid used by item-tooltip.php (enchantments, sockets & item durability for current character)
     **/
    public $charGuid;
    
    /**
     * Checks is item exists in DB
     * @category Items class
     * @access   public
     * @param    int $itemID
     * @return   bool
     **/
    public function IsItemExists($itemID) {
        if($this->wDB->selectCell("SELECT 1 FROM `item_template` WHERE `entry`=%d LIMIT 1", $itemID)) {
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
    public function getItemName($itemID) {
        if($this->_locale == 'en_gb' || $this->_locale == 'en_us') {
            $itemName = $this->wDB->selectCell("SELECT `name` FROM `item_template` WHERE `entry`=%d LIMIT 1", $itemID);
        }
        else {
            $itemName = $this->wDB->selectCell("SELECT `name_loc%d` FROM `locales_item` WHERE `entry`=%d LIMIT 1", $this->_loc, $itemID);
            if(!$itemName) {
                $itemName = $this->wDB->selectCell("SELECT `name` FROM `item_template` WHERE `entry`=%d LIMIT 1", $itemID);
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
    public function getItemIcon($itemID, $displayId = 0) {
        if($displayId == 0) {
            $displayId = $this->wDB->selectCell("SELECT `displayid` FROM `item_template` WHERE `entry`=%d LIMIT 1", $itemID);
        }
        $itemIcon = $this->aDB->selectCell("SELECT `icon` FROM `armory_icons` WHERE `displayid`=%d LIMIT 1", $displayId);
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
        if($this->_locale == 'en_gb' || $this->_locale == 'en_us') {
            $itemDescription = $this->wDB->selectCell("SELECT `description` FROM `item_template` WHERE `entry`=%d LIMIT 1", $itemID);
        }
        else {
            $itemDescription = $this->wDB->selectCell("SELECT `description_loc%d` FROM `locales_item` WHERE `entry`=%d LIMIT 1", $this->_loc, $itemID);
            if(!$itemDescription) {
                $itemDescription = $this->wDB->selectCell("SELECT `description` FROM `item_template` WHERE `entry`=%d LIMIT 1", $itemID);
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
        // Return zero if for all class (or for none
		if($mask == 0x7FF || $mask == 0) {
            return 0;
		}
        $races = $this->aDB->select("SELECT `id`, `name_%s` AS `name` FROM `armory_races`", $this->_locale);
        if(!is_array($races)) {
            $this->Log()->writeError('%s : unable to find races names for locale %s (%d)', __METHOD__, $this->_locale, $this->_loc);
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
        $classes = $this->aDB->select("SELECT `id`, `name_%s` AS `name` FROM `armory_classes`", $this->_locale);
        if(!is_array($classes)) {
            $this->Log()->writeError('%s : unable to find classes names for locale %s (%d)', __METHOD__, $this->_locale, $this->_loc);
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
		$bossLoot = $this->wDB->selectCell("SELECT `entry` FROM `creature_loot_template` WHERE `item`=%d LIMIT 1", $item);
        if($bossLoot) {
            if(Mangos::GetNpcInfo($bossLoot, 'isBoss') && self::IsUniqueLoot($item)) {
                // We got boss loot, generate improved tooltip.
                return self::GetImprovedItemSource($item, $bossLoot, $areaDataOnly);
            }
            elseif(Mangos::GetNpcInfo($bossLoot, 'isBoss')) {
                return array('value' => 'sourceType.creatureDrop');
            }
            else {
                return array('value' => 'sourceType.worldDrop');
            }
        }
        $chestLoot = $this->wDB->selectCell("SELECT `entry` FROM `gameobject_loot_template` WHERE `item`=%d LIMIT 1", $item);
        if($chestLoot) {
            if($chest_data = self::GetImprovedItemSource($item, $chestLoot, $areaDataOnly)) {
                return $chest_data;
            }
            else {
                return array('value' => 'sourceType.gameObjectDrop');
            }
        }
        $vendorLoot = $this->wDB->selectCell("SELECT `entry` FROM `npc_vendor` WHERE `item`=%d LIMIT 1", $item);
        $reputationReward = $this->wDB->selectCell("SELECT `RequiredReputationFaction` FROM `item_template` WHERE `entry`=%d", $item);
        if($vendorLoot && $reputationReward > 0) {
            return array('value' => 'sourceType.factionReward');
		}
        elseif($vendorLoot && (!$reputationReward || $reputationReward == 0)) {
            return array('value' => 'sourceType.vendor');
        }
        $questLoot = $this->wDB->selectCell("
		SELECT `entry`
		  FROM `quest_template`
		      WHERE `RewChoiceItemId1` = %d OR `RewChoiceItemId2` = %d OR `RewChoiceItemId3` = %d OR 
		          `RewChoiceItemId4` = %d OR `RewChoiceItemId5` = %d OR `RewChoiceItemId6` = %d LIMIT 1", $item, $item, $item, 
		$item, $item, $item);
        if($questLoot) {
            return array('value' => 'sourceType.questReward');
        }
        $craftLoot = $this->aDB->selectCell("SELECT `id` FROM `armory_spell` WHERE `EffectItemType_1`=%d OR `EffectItemType_2`=%d OR `EffectItemType_3`=%d LIMIT 1", $item, $item, $item);
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
        if($this->_locale == 'en_gb' || $this->_locale == 'ru_ru') {
            $tmp_locale = $this->_locale;
        }
        else {
            $tmp_locale = 'en_gb';
        }
        $itemSetBonuses = array();
        for($i=1; $i<9; $i++) {
            if($itemsetdata['bonus'.$i] > 0) {
                $spell_tmp = array();
                $spell_tmp = $this->aDB->selectRow("SELECT * FROM `armory_spell` WHERE `id`=%d", $itemsetdata['bonus'.$i]);
                if(!isset($spell_tmp['Description_'.$tmp_locale]) || empty($spell_tmp['Description_' . $tmp_locale])) {
                    // try to find en_gb locale
                    if(isset($spell_tmp['Description_en_gb']) && !empty($spell_tmp['Description_en_gb'])) {
                        $tmp_locale = 'en_gb';
                    }
                    else {
                        continue;
                    }
                }
                $itemSetBonuses[$i]['desc'] = self::spellReplace($spell_tmp, Utils::validateText($spell_tmp['Description_'.$tmp_locale]));
                $itemSetBonuses[$i]['desc'] = str_replace('&quot;', '"', $itemSetBonuses[$i]['desc']);
                $itemSetBonuses[$i]['threshold'] = $i;
            }
	   }
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
                $VendorLoot = $this->wDB->select("SELECT `entry`, `ExtendedCost` FROM `npc_vendor` WHERE `item`=%d", $item);
                if(is_array($VendorLoot)) {
				    $i = 0;
                    foreach($VendorLoot as $vItem) {
                        $lootTable[$i] = $this->wDB->selectRow("SELECT `entry` AS `id`, `minlevel` AS `minLevel`, `maxlevel` AS `maxLevel`, name FROM `creature_template` WHERE `entry`=%d", $vItem['entry']);
                        if($this->_locale != 'en_gb' || $this->_locale != 'en_us') {
                            $lootTable[$i]['name'] = Mangos::GetNpcName($vItem['entry']);
                        }
                        $lootTable[$i]['area'] = Mangos::GetNpcInfo($vItem['entry'], 'map');
                        $i++;
                    }
                }
                break;
            case 'boss':
                $BossLoot = $this->wDB->select("SELECT `entry` FROM `creature_loot_template` WHERE `item`=%d", $item);
                if(is_array($BossLoot)) {
				    $i = 0;
                    foreach($BossLoot as $bItem) {
                        $lootTable[$i] = $this->wDB->selectRow("SELECT `entry` AS `id`, `name`, `minlevel` AS `minLevel`, `maxlevel` AS `maxLevel`, `rank` AS `classification` FROM `creature_template` WHERE `entry`=%d", $bItem['entry']);
                        if($this->_locale != 'en_gb' || $this->_locale != 'en_us') {
                            $lootTable[$i]['name'] = Mangos::GetNpcName($bItem['entry']);
                        }
                        if(Mangos::GetNpcInfo($bItem['entry'], 'isBoss')) {
                            $areaData = Items::GetImprovedItemSource($item, $bItem['entry'], true);
                            $lootTable[$i]['area'] = $areaData['areaName'];
                            $lootTable[$i]['areaUrl'] = $areaData['areaUrl'];
                        }
                        else {
                            $lootTable[$i]['area'] = Mangos::GetNpcInfo($bItem['entry'], 'map');
                            $lootTable[$i]['areaUrl'] = Mangos::GetNpcInfo($bItem['entry'], 'areaUrl');
                        }
                        $drop_percent = Mangos::GenerateLootPercent($bItem['entry'], 'creature_loot_template', $item);
                        $lootTable[$i]['dropRate'] = Mangos::DropPercent($drop_percent);
                        if($lootTable[$i]['areaUrl'] && Mangos::GetNpcInfo($bItem['entry'], 'isBoss')) {
                            $lootTable[$i]['url'] = str_replace('boss=all', 'boss='.$bItem['entry'], $lootTable[$i]['areaUrl']);
                        }
                        $i++;
                    }
                }
                break;
            case 'chest':
                $ChestLoot = $this->wDB->select("SELECT `entry` FROM `gameobject_loot_template` WHERE `item`=%d", $item);
                if(is_array($ChestLoot)) {
                    $i = 0;
                    foreach($ChestLoot as $cItem) {
                        $drop_percent = Mangos::GenerateLootPercent($cItem['entry'], 'gameobject_loot_template', $item);
                        $lootTable[$i] = array (
                            'name' => Mangos::GameobjectInfo($cItem['entry'], 'name'),
                            'id' => $cItem['entry'],
                            'dropRate' => Mangos::DropPercent($drop_percent)
                        );
                        if(Mangos::GameobjectInfo($cItem['entry'], 'isInInstance')) {
                            $areaData = Items::GetImprovedItemSource($item, $cItem['entry'], true);
                            $lootTable[$i]['area'] = $areaData['areaName'];
                            $lootTable[$i]['areaUrl'] = $areaData['areaUrl'];
                        }
                        else {
                            $lootTable[$i]['area'] = Mangos::GameobjectInfo($cItem['entry'], 'map');
                            $lootTable[$i]['areaUrl'] = Mangos::GameobjectInfo($cItem['entry'], 'areaUrl');
                        }
                        $i++;
                    }
                }
                break;
            case 'questreward':
                $QuestLoot = $this->wDB->select("
                SELECT `entry` AS `id`, `Title` AS `name`, `QuestLevel` AS `level`, `MinLevel` AS `reqMinLevel`, `SuggestedPlayers` AS `suggestedPartySize`
                    FROM `quest_template`
                        WHERE `RewChoiceItemId1` = %d OR `RewChoiceItemId2` = %d OR `RewChoiceItemId3` = %d OR 
                            `RewChoiceItemId4` = %d OR `RewChoiceItemId5` = %d OR `RewChoiceItemId6` = %d", $item, $item, $item, $item, $item, $item);
                if(is_array($QuestLoot)) {
                    $i = 0;
                    foreach($QuestLoot as $qItem) {
                        $lootTable[$i] = $qItem;
                        if($this->_locale != 'en_gb' || $this->_locale != 'en_us') {
                            $lootTable[$i]['name'] = Mangos::QuestInfo($qItem['id'], 'title');
                        }
                        $lootTable[$i]['area'] = Mangos::QuestInfo($qItem['id'], 'map');
                        $i++;
                    }
                }
                break;
            case 'queststart':
                $QuestStart = $this->wDB->selectCell("SELECT `startquest` FROM `item_template` WHERE `entry`=%d", $item);
                if(!$QuestStart) {
                    return false;
                }
                $lootTable = $this->wDB->selectRow("SELECT `entry` AS `id`, `Title` AS `name`, `QuestLevel` AS `level`, `MinLevel` AS `reqMinLevel`, `SuggestedPlayers` AS `suggestedPartySize` FROM `quest_template` WHERE `entry`=%d", $QuestStart);
                if($this->_locale != 'en_gb' || $this->_locale != 'en_us') {
                    $lootTable['name'] = Mangos::QuestInfo($QuestStart, 'title');
                }
                $lootTable['name'] = Mangos::QuestInfo($QuestStart, 'title');
                $lootTable['area'] =  Mangos::QuestInfo($QuestStart, 'map');
                break;
            case 'providedfor':
                $QuestInfo = $this->wDB->select("SELECT `entry` AS `id`, `QuestLevel` AS `level`, `Title` AS `name`, `MinLevel` AS `reqMinLevel`, `SuggestedPlayers` AS `suggestedPartySize` FROM `quest_template` WHERE `SrcItemId`=%d", $item);
                if(is_array($QuestInfo)) {
                    $i = 0;
                    foreach($QuestInfo as $quest) {
                        $lootTable[$i] = $quest;
                        if($this->_locale != 'en_gb' || $this->_locale != 'en_us') {
                            $lootTable[$i]['name'] = Mangos::QuestInfo($quest['id'], 'title');
                        }
                        $lootTable[$i]['area'] = Mangos::QuestInfo($quest['id'], 'map');
                    }
                }
                break;            
            case 'objectiveof':
                $QuestInfo = $this->wDB->select("
                SELECT `entry` AS `id`, `QuestLevel` AS `level`, `Title` AS `name`, `MinLevel` AS `reqMinLevel`, `SuggestedPlayers` AS `suggestedPartySize`
                    FROM `quest_template`
                        WHERE `ReqItemId1`=%d OR `ReqItemId2`=%d OR `ReqItemId3`=%d OR `ReqItemId4`=%d OR `ReqItemId5`=%d", $item, $item, $item, $item, $item);
                if(is_array($QuestInfo)) {
                    $i = 0;
                    foreach($QuestInfo as $quest) {
                        $lootTable[$i] = $quest;
                        if($this->_locale != 'en_gb' || $this->_locale != 'en_us') {
                            $lootTable[$i]['name'] = Mangos::QuestInfo($quest['id'], 'title');
                        }
                        $lootTable[$i]['area'] = Mangos::QuestInfo($quest['id'], 'map');
                    }
                }
                break;
            case 'disenchant':
                $DisenchantLoot = $this->wDB->select("SELECT `item`, `maxcount`, `mincountOrRef` FROM `disenchant_loot_template` WHERE `entry`=%d", $item);
                if(is_array($DisenchantLoot)) {
                    $i = 0;
                    foreach($DisenchantLoot as $dItem) {
                        $tmp_info = $this->wDB->selectRow("SELECT `name`, `Quality`, `displayid` FROM `item_template` WHERE `entry`=%d LIMIT 1", $dItem['item']);
                        $drop_percent = Mangos::GenerateLootPercent($item, 'disenchant_loot_template', $dItem['item']);
                        $lootTable[$i] = array (
                            'id'       => $dItem['item'],
                            'name'     => ($this->_locale == 'en_gb' || $this->_locale == 'en_us') ? $tmp_info['name'] : self::GetItemName($dItem['item']),
                            'dropRate' => Mangos::DropPercent($drop_percent),
                            'maxCount' => $dItem['maxcount'],
                            'minCount' => $dItem['mincountOrRef'],
                            'icon'     => self::getItemIcon($dItem['item'], $tmp_info['displayid']),
                            'quality'  => $tmp_info['Quality']
                        );
                        $i++;
                    }
                }
                break;
            case 'craft':
                if($this->_locale == 'en_gb' || $this->_locale == 'ru_ru') {
                    $CraftLoot = $this->aDB->select("
                    SELECT `Reagent_1`, `Reagent_2`, `Reagent_3`, `Reagent_4`, `Reagent_5`, `Reagent_6`, `Reagent_7`, `Reagent_8`,
                        `ReagentCount_1`, `ReagentCount_2`, `ReagentCount_3`, `ReagentCount_4`, `ReagentCount_5`, `ReagentCount_6`, 
                        `ReagentCount_7`, `ReagentCount_8`, `EffectItemType_1`, `EffectItemType_2`, `EffectItemType_3`,
                        `SpellName_%s` AS `SpellName`, `SpellIconID`
                        FROM `armory_spell`
                            WHERE `EffectItemType_1` =%d OR `EffectItemType_2`=%d OR `EffectItemType_3`=%d", $this->_locale, $item, $item, $item);
                }
                else {
                    $CraftLoot = $this->aDB->select("
                    SELECT `Reagent_1`, `Reagent_2`, `Reagent_3`, `Reagent_4`, `Reagent_5`, `Reagent_6`, `Reagent_7`, `Reagent_8`,
                        `ReagentCount_1`, `ReagentCount_2`, `ReagentCount_3`, `ReagentCount_4`, `ReagentCount_5`, `ReagentCount_6`, 
                        `ReagentCount_7`, `ReagentCount_8`, `EffectItemType_1`, `EffectItemType_2`, `EffectItemType_3`,
                        `SpellName_en_gb` AS `SpellName`, `SpellIconID`
                        FROM `armory_spell`
                            WHERE `EffectItemType_1` =%d OR `EffectItemType_2`=%d OR `EffectItemType_3`=%d", $item, $item, $item);
                }
                if(is_array($CraftLoot)) {
                    $i=0;
                    foreach($CraftLoot as $craftItem) {
                        $lootTable[$i]['spell']   = array();
                        $lootTable[$i]['item']    = array();
                        $lootTable[$i]['reagent'] = array();                    
                        $lootTable[$i]['spell']['name'] = $craftItem['SpellName'];
                        $lootTable[$i]['spell']['icon'] = $this->aDB->selectCell("SELECT `icon` FROM `armory_speillicon` WHERE `id`=%d", $craftItem['SpellIconID']);
                        for($o=1;$o<9;$o++) {
                            if($craftItem['Reagent_'.$o] > 0) {
                                $tmp_info = $this->wDB->selectRow("SELECT `name`, `Quality`, `displayid` FROM `item_template` WHERE `entry`=%d LIMIT 1", $craftItem['Reagent_'.$o]);
                                $lootTable[$i]['reagent'][$o]['id'] = $craftItem['Reagent_'.$o];
                                $lootTable[$i]['reagent'][$o]['name'] = ($this->_locale == 'en_gb' || $this->_locale == 'en_us') ? $tmp_info['name'] : self::getItemName($craftItem['Reagent_'.$o]);
                                $lootTable[$i]['reagent'][$o]['icon'] = self::getItemIcon($craftItem['Reagent_'.$o], $tmp_info['displayid']);
                                $lootTable[$i]['reagent'][$o]['count'] = $craftItem['ReagentCount_'.$o];
                                $lootTable[$i]['reagent'][$o]['quality'] = $tmp_info['Quality'];
                            }
                        }
                        for($j=1;$j<4;$j++) {
                            if($craftItem['EffectItemType_'.$j] > 0) {
                                $tmp_info = $this->wDB->selectRow("SELECT `name`, `Quality`, `displayid` FROM `item_template` WHERE `entry`=%d LIMIT 1", $craftItem['EffectItemType_'.$j]);
                                $lootTable[$i]['item'][$j]['name'] = ($this->_locale == 'en_gb' || $this->_locale == 'en_us') ? $tmp_info['name'] : self::GetItemName($craftItem['EffectItemType_'.$j]);
                                $lootTable[$i]['item'][$j]['id'] = $craftItem['EffectItemType_'.$j];
                                $lootTable[$i]['item'][$j]['icon'] = self::getItemIcon($craftItem['EffectItemType_'.$j], $tmp_info['displayid']);
                                $lootTable[$i]['item'][$j]['quality'] = $tmp_info['Quality'];
                            }
                        }
                        $i++;
                    }
                }
                break;
            case 'currencyfor':
                $exCostIds = $this->aDB->select("SELECT `id` FROM `armory_extended_cost` WHERE `item1`=%d OR `item2`=%d OR `item3`=%d OR `item4`=%d OR `item5`=%d", $item, $item, $item, $item, $item);
                if(!$exCostIds || !is_array($exCostIds)) {
                    return false;
                }
                $CostIDs = array('pos' => array(), 'neg' => array());
                foreach($exCostIds as $tmp_cost) {
                    $CostIDs['pos'][] = $tmp_cost['id'];
                    $CostIDs['neg'][] = '-'.$tmp_cost['id'];
                }
                $itemsData = $this->wDB->select("
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
                        'icon' => self::getItemIcon($curItem['id'], $curItem['displayid']),
                        'id' => $curItem['id'],
                        'level' => $curItem['level'],
                        'name' => ($this->_locale == 'en_gb' || $this->_locale == 'en_us') ? $curItem['name'] : self::getItemName($curItem['id']),
                        'quality' => $curItem['quality'],
                        'type' => $this->aDB->selectCell("SELECT `subclass_name_%s` FROM `armory_itemsubclass` WHERE `class`=%d AND `subclass`=%d", $this->_locale, $curItem['class'], $curItem['subclass'])
                    );
                    $lootTable[$i]['tokens'] = Mangos::GetExtendedCost($curItem['ExtendedCost']);
                    $oldItems[$curItem['id']] = $curItem['id'];
                    $i++;
                }
                break;
            case 'reagent':
                if($this->_locale == 'en_gb' || $this->_locale == 'ru_ru') {
                    $ReagentLoot = $this->aDB->select("
                    SELECT `Reagent_1`, `Reagent_2`, `Reagent_3`, `Reagent_4`, `Reagent_5`, `Reagent_6`, `Reagent_7`, `Reagent_8`,
                        `ReagentCount_1`, `ReagentCount_2`, `ReagentCount_3`, `ReagentCount_4`, `ReagentCount_5`, `ReagentCount_6`, 
                        `ReagentCount_7`, `ReagentCount_8`, `EffectItemType_1`, `EffectItemType_2`, `EffectItemType_3`,
                        `SpellName_%s` AS `SpellName`, `SpellIconID`
                    FROM `armory_spell`
                        WHERE `Reagent_1`=%d OR `Reagent_2`=%d OR `Reagent_3`=%d OR `Reagent_4`=%d OR
                            `Reagent_5`=%d OR `Reagent_6`=%d OR `Reagent_7`=%d OR `Reagent_8`=%d", $this->_locale, $item, $item, $item, $item, $item, $item, $item, $item);
                }
                else {
                    $ReagentLoot = $this->aDB->select("
                    SELECT `Reagent_1`, `Reagent_2`, `Reagent_3`, `Reagent_4`, `Reagent_5`, `Reagent_6`, `Reagent_7`, `Reagent_8`,
                        `ReagentCount_1`, `ReagentCount_2`, `ReagentCount_3`, `ReagentCount_4`, `ReagentCount_5`, `ReagentCount_6`, 
                        `ReagentCount_7`, `ReagentCount_8`, `EffectItemType_1`, `EffectItemType_2`, `EffectItemType_3`,
                        `SpellName_en_gb` AS `SpellName`, `SpellIconID`
                    FROM `armory_spell`
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
                    $lootTable[$i]['spell']['icon'] = $this->aDB->selectCell("SELEC `icon` FROM `armory_spellicon` WHERE `id`=%d", $ReagentItem['SpellIconID']);
                    for($j=1;$j<4;$j++) {
                        if($ReagentItem['EffectItemType_'.$j] > 0) {
                            $tmp_info = $this->wDB->selectRow("SELECT `name`, `Quality`, `displayid` FROM `item_template` WHERE `entry`=%d LIMIT 1", $ReagentItem['EffectItemType_'.$j]);
                            $lootTable[$i]['item'][$j]['id'] = $ReagentItem['EffectItemType_'.$j];
                            $lootTable[$i]['item'][$j]['name'] = ($this->_locale == 'en_gb' || $this->_locale == 'en_us') ? $tmp_info['name'] : self::getItemName($ReagentItem['EffectItemType_'.$j]);
                            $lootTable[$i]['item'][$j]['icon'] = self::getItemIcon($ReagentItem['EffectItemType_'.$j], $tmp_info['displayid']);
                            $lootTable[$i]['item'][$j]['quality'] = $tmp_info['Quality'];
                        }
                    }
                    for($o=1;$o<9;$o++) {
                        if($ReagentItem['Reagent_'.$o] > 0) {
                            $tmp_info = $this->wDB->selectRow("SELECT `name`, `Quality`, `displayid` FROM `item_template` WHERE `entry`=%d LIMIT 1", $ReagentItem['Reagent_'.$o]);
                            $lootTable[$i]['reagent'][$o]['id'] = $ReagentItem['Reagent_'.$o];
                            $lootTable[$i]['reagent'][$o]['icon'] = self::getItemIcon($ReagentItem['Reagent_'.$o], $tmp_info['displayid']);
                            $lootTable[$i]['reagent'][$o]['count'] = $ReagentItem['ReagentCount_'.$o];
                            $lootTable[$i]['reagent'][$o]['name'] = ($this->_locale == 'en_gb' || $this->_locale == 'en_us') ? $tmp_info['name'] : self::getItemName($ReagentItem['Reagent_'.$o]);
                        }
                    }
                    $i++;
                }
                break;
            case 'randomProperty':
                $itemProperty = $this->wDB->selectRow("SELECT `RandomProperty`, `RandomSuffix` FROM `item_template` WHERE `entry`=%d LIMIT 1", $item);
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
                $enchants_entries = $this->wDB->select("SELECT * FROM `item_enchantment_template` WHERE `entry`=%d", $itemPropertyId);
                if(!$enchants_entries) {
                    return false;
                }
                $count = count($enchants_entries);
                $ids = array();
                for($i = 0; $i < $count; $i++) {
                    $ids[$enchants_entries[$i]['ench']] = $enchants_entries[$i]['ench'];
                }
                if($type == 'property') {
                    $enchants = $this->aDB->select("SELECT `id`, `name_%s` AS `name`, `ench_1`, `ench_2`, `ench_3` FROM `armory_randomproperties` WHERE `id` IN (%s)", $this->_locale, $ids);
                }
                elseif($type == 'suffix') {
                    $enchants = $this->aDB->select("SELECT `id`, `name_%s` AS `name`, `ench_1`, `ench_2`, `ench_3`, `ench_4`, `ench_5`, `pref_1`, `pref_2`, `pref_3`, `pref_4`, `pref_5` FROM `armory_randomsuffix` WHERE `id` IN (%s)", $this->_locale, $ids);
                }
                if(!$enchants) {
                    return false;
                }
                $i = 0;
                $item_data = $this->wDB->selectRow("SELECT `InventoryType`, `ItemLevel`, `Quality` FROM `item_template` WHERE `entry`=%d", $item);
                $points = self::GetRandomPropertiesPoints($item_data['ItemLevel'], $item_data['InventoryType'], $item_data['Quality']);
                foreach($enchants as $entry) {
                    $str_tmp = array();
                    $lootTable[$i]['name'] = $entry['name'];
                    $lootTable[$i]['data'] = array();
                    for($j=1;$j<6;$j++) {
                        if(isset($entry['ench_' . $j]) && $entry['ench_' . $j] > 0) {
                            if($type == 'property') {
                                $str_tmp[$entry['ench_' . $j]] = $entry['ench_' . $j];
                            }
                            elseif($type == 'suffix') {
                                $str_tmp[$entry['ench_' . $j]] = $entry['ench_' . $j];
                            }
                        }
                    }
                    $enchs = $this->aDB->select("SELECT `id`, `text_%s` AS `text` FROM `armory_enchantment` WHERE `id` IN (%s)", $this->_locale, $str_tmp);
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
                $info = $this->wDB->selectCell("SELECT `Quality` FROM `item_template` WHERE `entry`=%d LIMIT 1", $itemID);
                break;
            case 'displayid':
                $info = $this->wDB->selectCell("SELECT `displayid` FROM `item_template` WHERE `entry`=%d LIMIT 1", $itemID);
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
    public function extractSocketInfo($guid, $item, $socketNum, $item_guid = 0, $db = null) {
        $data = array();
        $socketfield = array(
            1 => ITEM_FIELD_ENCHANTMENT_3_2,
            2 => ITEM_FIELD_ENCHANTMENT_4_2,
            3 => ITEM_FIELD_ENCHANTMENT_5_2
        );
        if($db === null) {
            $db = $this->cDB;
        }
        if($item_guid == 0) {
            $socketInfo = $db->selectCell("
            SELECT CAST(SUBSTRING_INDEX(SUBSTRING_INDEX(`data`, ' ', %d), ' ', '-1') AS UNSIGNED)  
                FROM `item_instance` 
                    WHERE `owner_guid`=%d AND CAST(SUBSTRING_INDEX(SUBSTRING_INDEX(`data`, ' ', 4), ' ', '-1') AS UNSIGNED) = %d", $socketfield[$socketNum], $guid, $item);
        }
        else {
            $socketInfo = $db->selectCell("
            SELECT CAST(SUBSTRING_INDEX(SUBSTRING_INDEX(`data`, ' ', %d), ' ', '-1') AS UNSIGNED)  
                FROM `item_instance` 
                    WHERE `owner_guid`=%d AND `guid`=%d", $socketfield[$socketNum], $guid, $item_guid);
        }
        if($socketInfo > 0) {
            $data['enchant_id'] = $socketInfo;
            $data['item'] = $this->aDB->selectCell("SELECT `gem` FROM `armory_enchantment` WHERE `id`=%d", $socketInfo);
            $data['icon'] = self::getItemIcon($data['item']);
            $data['enchant'] = $this->aDB->selectCell("SELECT `text_".$this->_locale."` FROM `armory_enchantment` WHERE `id`=%d", $socketInfo);
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
    public function getItemDurability($guid, $item) {
        $durability['current'] = self::GetItemDataField(ITEM_FIELD_DURABILITY, $item, $guid);
        $durability['max'] = self::GetItemDataField(ITEM_FIELD_MAXDURABILITY, $item, $guid);
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
        $durability['current'] = self::GetItemDataField(ITEM_FIELD_DURABILITY, 0, 0, $item_guid);
        $durability['max'] = self::GetItemDataField(ITEM_FIELD_MAXDURABILITY, 0, 0, $item_guid);
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
     * @return   int
     **/
    public function GetItemDataField($field, $itemid, $owner_guid, $use_item_guid = 0) {
        $dataField = $field+1;
        if($use_item_guid > 0) {
            $qData = $this->cDB->selectCell("
            SELECT CAST(SUBSTRING_INDEX(SUBSTRING_INDEX(`data`, ' ', %d), ' ', '-1') AS UNSIGNED)
                FROM `item_instance`
                    WHERE `guid`= %d", $dataField, $use_item_guid);
            return $qData;
        }
        else {
            $qData = $this->cDB->selectCell("
            SELECT CAST(SUBSTRING_INDEX(SUBSTRING_INDEX(`data`, ' ', %d), ' ', '-1') AS UNSIGNED)  
                FROM `item_instance` 
                    WHERE `owner_guid`=%d AND CAST(SUBSTRING_INDEX(SUBSTRING_INDEX(`data`, ' ', 4), ' ', '-1') AS UNSIGNED) = %d", $dataField, $owner_guid, $itemid);
        }        
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
    public function spellReplace($spell, $text) {
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
                        $cacheSpellData[$lookup] = $this->getSpellData($spell);
                    }
                    else {
                        $cacheSpellData[$lookup] = $this->getSpellData($this->aDB->selectRow("SELECT * FROM `armory_spell` WHERE `id`=%d", $lookup));
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
                $str.=$base;
            }
        }
        $str .= substr($data, $pos);
        $str = preg_replace_callback("/\[.+[+\-\/*\d]\]/", array($this, 'my_replace'), $str);
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
    public function getSpellData($spell) {
        // Basepoints
        $s1 = abs($spell['EffectBasePoints_1']+$spell['EffectBaseDice_1']);
        $s2 = abs($spell['EffectBasePoints_2']+$spell['EffectBaseDice_2']);
        $s3 = abs($spell['EffectBasePoints_3']+$spell['EffectBaseDice_3']);
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
            if($spell_duration = $this->aDB->selectRow("SELECT * FROM `armory_spell_duration` WHERE `id`=%d", $spell['DurationIndex'])) {
                $d = $spell_duration['duration_1']/1000;
            }
        }
        // Tick duration
        $t1 = $spell['EffectAmplitude_1'] ? $spell['EffectAmplitude_1']/1000 : 5;
        $t2 = $spell['EffectAmplitude_1'] ? $spell['EffectAmplitude_2']/1000 : 5;
        $t3 = $spell['EffectAmplitude_1'] ? $spell['EffectAmplitude_3']/1000 : 5;
        
        // Points per tick
        $o1 = @intval($s1*$d/$t1);
        $o2 = @intval($s2*$d/$t2);
        $o3 = @intval($s3*$d/$t3);
        $spellData['t1']=$t1;
        $spellData['t2']=$t2;
        $spellData['t3']=$t3;
        $spellData['o1']=$o1;
        $spellData['o2']=$o2;
        $spellData['o3']=$o3;
        $spellData['s1']=$s1;
        $spellData['s2']=$s2;
        $spellData['s3']=$s3;
        $spellData['m1']=$s1;
        $spellData['m2']=$s2;
        $spellData['m3']=$s3;
        $spellData['x1']= $spell['EffectChainTarget_1'];
        $spellData['x2']= $spell['EffectChainTarget_2'];
        $spellData['x3']= $spell['EffectChainTarget_3'];
        $spellData['i'] = $spell['MaxAffectedTargets'];
        $spellData['d'] = Utils::getTimeText($d);
        $spellData['d1']= Utils::getTimeText($d);
        $spellData['d2']= Utils::getTimeText($d);
        $spellData['d3']= Utils::getTimeText($d);
        $spellData['v'] = $spell['MaxTargetLevel'];
        $spellData['u'] = $spell['StackAmount'];
        $spellData['a1']= Utils::getRadius($spell['EffectRadiusIndex_1']);
        $spellData['a2']= Utils::getRadius($spell['EffectRadiusIndex_2']);
        $spellData['a3']= Utils::getRadius($spell['EffectRadiusIndex_3']);
        $spellData['b1']= $spell['EffectPointsPerComboPoint_1'];
        $spellData['b2']= $spell['EffectPointsPerComboPoint_2'];
        $spellData['b3']= $spell['EffectPointsPerComboPoint_3'];
        $spellData['e'] = $spell['EffectMultipleValue_1'];
        $spellData['e1']= $spell['EffectMultipleValue_1'];
        $spellData['e2']= $spell['EffectMultipleValue_2'];
        $spellData['e3']= $spell['EffectMultipleValue_3'];
        $spellData['f1']= $spell['DmgMultiplier_1'];
        $spellData['f2']= $spell['DmgMultiplier_2'];
        $spellData['f3']= $spell['DmgMultiplier_3'];
        $spellData['q1']= $spell['EffectMiscValue_1'];
        $spellData['q2']= $spell['EffectMiscValue_2'];
        $spellData['q3']= $spell['EffectMiscValue_3'];
        $spellData['h'] = $spell['procChance'];
        $spellData['n'] = $spell['procCharges'];
        $spellData['z'] = "<home>";
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
    public function my_replace($matches) {
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
        $name = $this->aDB->selectCell("SELECT `name_%s` FROM `armory_instance_template` WHERE `id` IN (SELECT `instance_id` FROM `armory_instance_data` WHERE `key`='%s')", $this->_locale, $key);
        if($name) {
            return $name;
        }
        return false;
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
        $dungeonData = $this->aDB->selectRow("SELECT `instance_id`, `name_%s` AS `name`, `lootid_1`, `lootid_2`, `lootid_3`, `lootid_4` FROM `armory_instance_data` WHERE `id`=%d OR `lootid_1`=%d OR `lootid_2`=%d OR `lootid_3`=%d OR `lootid_4`=%d OR `name_id`=%d LIMIT 1", $this->_locale, $bossID, $bossID, $bossID, $bossID, $bossID, $bossID);
        if(!$dungeonData) {
            $this->Log()->writeError('%s : dungeonData for lootid %d not found (current_locale: %s, locId: %d)', __METHOD__, $bossID, $this->_locale, $this->_loc);
            return false;
        }
        $difficulty_enum = array(1 => '10n', 2 => '25n', 3 => '10h', 4 => '25h');
        $heroic_string = Utils::GetArmoryString(19);
        $item_difficulty = null;
        for($i=1;$i<5;$i++) {
            if(isset($dungeonData['lootid_'.$i]) && $dungeonData['lootid_'.$i] == $bossID && isset($difficulty_enum[$i])) {
                $item_difficulty = $difficulty_enum[$i];
            }
        }
        $instance_heroic = array(4812, 4722, 4987);
        switch($item_difficulty) {
            case '10n':
                if(in_array($dungeonData['instance_id'], $instance_heroic)) {
                    $instance_data = $this->aDB->selectRow("SELECT `id` AS `areaId`, `name_%s` AS `areaName`, `is_heroic`, `key` FROM `armory_instance_template` WHERE `id`=%d AND `partySize`=10 AND `is_heroic`=1", $this->_locale, $dungeonData['instance_id']);
                }
                else {
                    $instance_data = $this->aDB->selectRow("SELECT `id` AS `areaId`, `name_%s` AS `areaName`, `is_heroic`, `key` FROM `armory_instance_template` WHERE `id`=%d", $this->_locale, $dungeonData['instance_id']);
                }
                if(!$instance_data) {
                    return false;
                }
                break;
            case '10h':
                if(in_array($dungeonData['instance_id'], $instance_heroic)) {
                    $instance_data = $this->aDB->selectRow("SELECT `id` AS `areaId`, `name_%s` AS `areaName`, `is_heroic`, `key` FROM `armory_instance_template` WHERE `id`=%d AND `partySize`=10 AND `is_heroic`=1", $this->_locale, $dungeonData['instance_id']);
                }
                else {
                    $instance_data = $this->aDB->selectRow("SELECT `id` AS `areaId`, `name_%s` AS `areaName`, `is_heroic`, `key` FROM `armory_instance_template` WHERE `id`=%d", $this->_locale, $dungeonData['instance_id']);
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
                    $instance_data = $this->aDB->selectRow("SELECT `id` AS `areaId`, `name_%s` AS `areaName`, `is_heroic`, `key` FROM `armory_instance_template` WHERE `id`=%d AND `partySize`=25 AND `is_heroic`=1", $this->_locale, $dungeonData['instance_id']);
                }
                else {
                    $instance_data = $this->aDB->selectRow("SELECT `id` AS `areaId`, `name_%s` AS `areaName`, `is_heroic`, `key` FROM `armory_instance_template` WHERE `id`=%d", $this->_locale, $dungeonData['instance_id']);
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
                    $instance_data = $this->aDB->selectRow("SELECT `id` AS `areaId`, `name_%s` AS `areaName`, `is_heroic`, `key` FROM `armory_instance_template` WHERE `id`=%d AND `partySize`=25 AND `is_heroic`=1", $this->_locale, $dungeonData['instance_id']);
                }
                else {
                    $instance_data = $this->aDB->selectRow("SELECT `id` AS `areaId`, `name_%s` AS `areaName`, `is_heroic`, `key` FROM `armory_instance_template` WHERE `id`=%d", $this->_locale, $dungeonData['instance_id']);
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
        $instance_data['creatureId'] = $this->aDB->selectCell("SELECT `id` FROM `armory_instance_data` WHERE `id`=%d OR `lootid_1`=%d OR `lootid_2`=%d OR `lootid_3`=%d OR `lootid_4`=%d OR `name_id`=%d LIMIT 1", $bossID, $bossID, $bossID, $bossID, $bossID, $bossID);
        $instance_data['creatureName'] = $dungeonData['name'];
        if($bossID > 100000) { // GameObject
            $drop_percent = Mangos::GenerateLootPercent($bossID, 'gameobject_loot_template', $itemID);
        }
        else { // Creature
            $drop_percent = Mangos::GenerateLootPercent($bossID, 'creature_loot_template', $itemID);
        }
        $instance_data['dropRate'] = Mangos::DropPercent($drop_percent);
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
        $item_count = $this->wDB->selectCell("SELECT COUNT(`entry`) FROM `creature_loot_template` WHERE `item`=%d", $itemID);
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
            $data = $this->aDB->selectRow("SELECT * FROM `armory_itemdisplayinfo` WHERE `displayid`=%d", $displayId);
        }
        else {
            $data = $this->aDB->selectCell("SELECT `%s` FROM `armory_itemdisplayinfo` WHERE `displayid`=%d", $row, $displayId);
        }
        if($data) {
            return $data;
        }
        $this->Log()->writeError('%s : unable to get model data for displayID %d (row: %s, itemid: %d)', __METHOD__, $displayId, $row, $itemid);
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
            $equivalent_id = $this->aDB->selectCell("SELECT `item_alliance` FROM `armory_item_equivalents` WHERE `item_horde`=%d", $itemID);
        }
        elseif($factionID == 2) {
            $equivalent_id = $this->aDB->selectCell("SELECT `item_horde` FROM `armory_item_equivalents` WHERE `item_alliance`=%d", $itemID);
        }
        if($equivalent_id > 0 && $info = $this->wDB->selectRow("SELECT `name`, `ItemLevel`, `Quality`, `displayid` FROM `item_template` WHERE `entry`=%d", $equivalent_id)) {
            $item_data = array(
                'icon'    => self::getItemIcon($equivalent_id, $info['displayid']),
                'id'      => $equivalent_id,
                'level'   => $info['ItemLevel'],
                'name'    => ($this->_locale == 'en_gb' || $this->_locale == 'en_us') ? $info['name'] : self::getItemName($equivalent_id),
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
            $itemclassInfo = $this->wDB->selectRow("SELECT `class`, `subclass` FROM `item_template` WHERE `entry`=%d", $itemID);
        }
        if($tooltip) {
            if($itemclassInfo['class'] == ITEM_CLASS_ARMOR && $itemclassInfo['subclass'] === 0) {
                return;
            }
            return $this->aDB->selectCell("SELECT `subclass_name_%s` FROM `armory_itemsubclass` WHERE `class`=%d AND `subclass`=%d", $this->_locale, $itemclassInfo['class'], $itemclassInfo['subclass']);
        }
        return $this->aDB->selectRow("SELECT `subclass_name_%s` AS `subclass_name`, `key` FROM `armory_itemsubclass` WHERE `class`=%d AND `subclass`=%d", $this->_locale, $itemclassInfo['class'], $itemclassInfo['subclass']);
    }
    
    /**
     * Checks if personal arena rating required for sale current item (and returns required rating if exists)
     * @category Items class
     * @access   public
     * @param    int $itemID
     * @return   int
     **/
    public function IsRequiredArenaRating($itemID) {
        $extended_cost_id = $this->wDB->selectCell("SELECT `ExtendedCost` FROM `npc_vendor` WHERE `item`=%d", $itemID);
        if($extended_cost_id === false) {
            return false;
        }
        if($extended_cost_id < 0) {
            $extended_cost_id = abs($extended_cost_id);
        }
        $arenaTeamRating = $this->aDB->selectCell("SELECT `personalRating` FROM `armory_extended_cost` WHERE `id`=%d", $extended_cost_id);
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
        return $this->wDB->selectRow("SELECT `name`, `Quality`, `ItemLevel`, `displayid`, `SellPrice`, `BuyPrice`, `Flags2`, `RequiredDisenchantSkill` FROM `item_template` WHERE `entry`=%d LIMIT 1", $itemID);
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
    public function GetRandomPropertiesData($item_entry, $owner_guid, $item_guid = 0) {
        if($item_guid > 0) {
            $enchId = self::GetItemDataField(ITEM_FIELD_RANDOM_PROPERTIES_ID, 0, $owner_guid, $item_guid);
        }
        else {
            $enchId = self::GetItemDataField(ITEM_FIELD_RANDOM_PROPERTIES_ID, $item_entry, $owner_guid);
        }
        $rand_data = $this->aDB->selectRow("SELECT `name_%s` AS `name`, `ench_1`, `ench_2`, `ench_3` FROM `armory_randomproperties` WHERE `id`=%d", $this->_locale, $enchId);
        if(!$rand_data) {
            $this->Log()->writeLog('%s : unable to get rand_data from `armory_randomproperties` for id %d', __METHOD__, $enchId);
            return false;
        }
        $return_data = array();
        $return_data['suffix'] = $rand_data['name'];
        $return_data['data'] = array();
        for($i = 1; $i < 4; $i++) {
            if($rand_data['ench_' . $i] > 0) {
                $return_data['data'][$i] = $this->aDB->selectCell("SELECT `text_%s` FROM `armory_enchantment` WHERE `id`=%d", $this->_locale, $rand_data['ench_' . $i]);
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
            $data = $this->wDB->selectRow("SELECT `ItemLevel`, `type`, `Quality` FROM `item_template` WHERE `entry`=%d", $itemId);
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
        return $this->aDB->selectCell("SELECT `%s` FROM `armory_randompropertypoints` WHERE `itemlevel`=%d", $field, $itemLevel);
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
     * Public access to Items::CreateAdditionalItemTooltip() method
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
        return Items::CreateAdditionalItemTooltip($itemID, $xml, $characters, $parent, $comparison);
    }
    
    /**
     * Create item tooltip with provided options
     *  - $parent: used for items that created by spells (displays under patterns/recipes, etc.)
     *  - $comparison: used for dual tooltips (if user logged in and primary character is selected)
     * This method must be called from Items::ItemTooltip() only!
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
            $this->Log()->writeError('%s : xml should be instance of XMLHandler class. %s given.', __METHOD__, gettype($xml));
            return false;
        }
        elseif($parent == true && is_array($comparsion)) {
            $this->Log()->writeError('%s : $parent and $comparison have \'true\' value (not allowed), ignore.', __METHOD__);
            return false; // both variables can't have 'true' value.
        }
        // Item comparsion mode
        $realm = false;
        if(is_array($comparsion) && isset($this->realmData[$comparsion['realm_id']])) {
            $realm = $this->realmData[$comparsion['realm_id']];
        }
        $data = $this->wDB->selectRow("SELECT * FROM `item_template` WHERE `entry`=%d", $itemID);
        if(!is_array($data)) {
            return false;
        }
        $isCharacter = $characters->CheckPlayer();
        $xml->XMLWriter()->startElement('id');
        $xml->XMLWriter()->text($itemID);
        $xml->XMLWriter()->endElement(); //id
        if(Utils::IsWriteRaw()) {
            $xml->XMLWriter()->writeRaw('<name>');
            $xml->XMLWriter()->writeRaw(Items::getItemName($itemID));
            $xml->XMLWriter()->writeRaw('</name>');
        }
        else {
            $xml->XMLWriter()->startElement('name');
            if($this->_locale == 'en_gb' || $this->_locale == 'en_us') {
                $xml->XMLWriter()->text($data['name']);
            }
            else {
                $xml->XMLWriter()->text(Items::getItemName($itemID));
            }
            $xml->XMLWriter()->endElement(); //name
        }
        $xml->XMLWriter()->startElement('icon');
        $xml->XMLWriter()->text(Items::getItemIcon($itemID, $data['displayid']));
        $xml->XMLWriter()->endElement(); //icon
        // 3.2.x heroic item flag
        if($data['Flags']&ITEM_FLAGS_HEROIC) {
            $xml->XMLWriter()->startElement('heroic');
            $xml->XMLWriter()->text(1);
            $xml->XMLWriter()->endElement();//heroic
        }
        $xml->XMLWriter()->startElement('overallQualityId');
        $xml->XMLWriter()->text($data['Quality']);
        $xml->XMLWriter()->endElement();//overallQualityId
        $xml->XMLWriter()->startElement('bonding');
        $xml->XMLWriter()->text($data['bonding']);
        $xml->XMLWriter()->endElement();//bonding
        $xml->XMLWriter()->startElement('maxCount');
        $xml->XMLWriter()->text($data['maxcount']);
        $xml->XMLWriter()->endElement();//maxCount
        if($data['startquest'] > 0) {
            $xml->XMLWriter()->startElement('startQuestId');
            $xml->XMLWriter()->text($data['startquest']);
            $xml->XMLWriter()->endElement(); //startQuestId
        }
        $xml->XMLWriter()->startElement('classId');
        $xml->XMLWriter()->text($data['class']);
        $xml->XMLWriter()->endElement();//classId
        $xml->XMLWriter()->startElement('equipData');
        $xml->XMLWriter()->startElement('inventoryType');
        $xml->XMLWriter()->text($data['InventoryType']);
        $xml->XMLWriter()->endElement();  //inventoryType
        $xml->XMLWriter()->startElement('subclassName');
        $xml->XMLWriter()->text(Items::GetItemSubTypeInfo($itemID, true, $data));
        $xml->XMLWriter()->endElement();  //subclassName
        if($data['class'] == ITEM_CLASS_CONTAINER) {
            $xml->XMLWriter()->startElement('containerSlots');
            $xml->XMLWriter()->text($data['ContainerSlots']);
            $xml->XMLWriter()->endElement(); //containerSlots
        }
        $xml->XMLWriter()->endElement(); //equipData
        if($data['class'] == ITEM_CLASS_WEAPON) {
            $xml->XMLWriter()->startElement('damageData');
            $xml->XMLWriter()->startElement('damage');
            $xml->XMLWriter()->startElement('type');
            $xml->XMLWriter()->text('0');
            $xml->XMLWriter()->endElement(); //type
            $xml->XMLWriter()->startElement('min');
            $xml->XMLWriter()->text($data['dmg_min1']);
            $xml->XMLWriter()->endElement(); //min
            $xml->XMLWriter()->startElement('max');
            $xml->XMLWriter()->text($data['dmg_max1']);
            $xml->XMLWriter()->endElement();   //max
            $xml->XMLWriter()->endElement();  //damage
            $xml->XMLWriter()->startElement('speed');
            $xml->XMLWriter()->text(round($data['delay']/1000, 2));
            $xml->XMLWriter()->endElement(); //speed
            $xml->XMLWriter()->startElement('dps');
            $dps = null;
            for($jj=1;$jj<=2;$jj++) {
                $d_type = $data['dmg_type'.$jj];
                $d_min = $data['dmg_min'.$jj];
                $d_max = $data['dmg_max'.$jj];
                if(($d_max>0) && ($data['class'] != ITEM_CLASS_PROJECTILE)) {
                    $delay = $data['delay'] / 1000;
                    if($delay>0) {
                        $dps = $dps + round(($d_max+$d_min) / (2*$delay), 1);
                    }
                    if($jj>1) {
                        $delay=0;
                    }
               	}
            }
            $xml->XMLWriter()->text($dps);
            $xml->XMLWriter()->endElement(); //dps
            $xml->XMLWriter()->endElement(); //damageData
        }
        // Gem properties
        if($data['class'] == ITEM_CLASS_GEM && $data['GemProperties'] > 0) {
            $GemSpellItemEcnhID = $this->aDB->selectCell("SELECT `spellitemenchantement` FROM `armory_gemproperties` WHERE `id`=%d", $data['GemProperties']);
            $GemText = $this->aDB->selectCell("SELECT `text_%s` FROM `armory_enchantment` WHERE `id`=%d", $this->_locale, $GemSpellItemEcnhID);
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
        if($data['block'] > 0) {
            $xml->XMLWriter()->startElement('blockValue');
            $xml->XMLWriter()->text($data['block']);
            $xml->XMLWriter()->endElement(); //blockValue
        }
        if($data['fire_res'] > 0) {
            $xml->XMLWriter()->startElement('fireResist');
            $xml->XMLWriter()->text($data['fire_res']);
            $xml->XMLWriter()->endElement(); //fireResist
        }
        if($data['nature_res'] > 0) {
            $xml->XMLWriter()->startElement('natureResist');
            $xml->XMLWriter()->text($data['nature_res']);
            $xml->XMLWriter()->endElement(); //natureResist
        }
        if($data['frost_res'] > 0) {
            $xml->XMLWriter()->startElement('frostResist');
            $xml->XMLWriter()->text($data['frost_res']);
            $xml->XMLWriter()->endElement(); //frostResist
        }
        if($data['shadow_res'] > 0) {
            $xml->XMLWriter()->startElement('shadowResist');
            $xml->XMLWriter()->text($data['shadow_res']);
            $xml->XMLWriter()->endElement(); //shadowResist
        }
        if($data['arcane_res'] > 0) {
            $xml->XMLWriter()->startElement('arcaneResist');
            $xml->XMLWriter()->text($data['arcane_res']);
            $xml->XMLWriter()->endElement(); //arcaneResist
        }
        for($i=1;$i<11;$i++) {
            if($data['stat_type'.$i] > 0 && $data['stat_value'.$i] > 0) {
                $bonus_template = Items::GetItemBonusTemplate($data['stat_type'.$i]);
                $xml->XMLWriter()->startElement($bonus_template);
                $xml->XMLWriter()->text($data['stat_value'.$i]);
                $xml->XMLWriter()->endElement();
            }
        }
        $xml->XMLWriter()->startElement('armor');
        if($data['ArmorDamageModifier'] > 0) {
            $xml->XMLWriter()->writeAttribute('armorBonus', 1);
        }
        $xml->XMLWriter()->text($data['armor']);
        $xml->XMLWriter()->endElement(); //armor
        $ench_array = array (
        	1 => 'head',
            2 => 'neck',
            3 => 'shoulder',
            4 => 'shirt',
            5 => 'chest', 
            6 => 'belt', 
            7 => 'legs', 
            8 => 'boots',
            9 => 'wrist',
            10=> 'gloves',
            11=>'ring1',
            12=>'trinket1',
            13=>'mainhand',
            14=>'offhand',
            15=>'relic',
            16=>'back', 
            17=>'stave',
            19=>'tabard',
            20=>'chest',
            21=>'mainhand',
            22=>'',
            23=>'offhand',
            24=>'',
            25=>'thrown',
            26=>'gun',
            28=>'sigil'
        );
        if(isset($ench_array[$data['InventoryType']])) {
            $itemSlotName = $ench_array[$data['InventoryType']];
        }
        else {
            $itemSlotName = false;
        }
        if(!$parent && $isCharacter && $itemSlotName) {
            $enchantment = $characters->getCharacterEnchant($itemSlotName);
            if($enchantment) {
                if(Utils::IsWriteRaw()) {
                    $xml->XMLWriter()->writeRaw('<enchant>');
                    $xml->XMLWriter()->writeRaw($this->aDB->selectCell("SELECT `text_%s` FROM `armory_enchantment` WHERE `id`=%d LIMIT 1", $this->_locale, $enchantment));
                    $xml->XMLWriter()->writeRaw('</enchant>'); //enchant
                }
                else {
                    $xml->XMLWriter()->startElement('enchant');
                    $xml->XMLWriter()->text($this->aDB->selectCell("SELECT `text_%s` FROM `armory_enchantment` WHERE `id`=%d LIMIT 1", $this->_locale, $enchantment));
                    $xml->XMLWriter()->endElement(); //enchant
                }
            }
        }
        // Random property
        if($data['RandomProperty'] > 0 || $data['RandomSuffix'] > 0) {
            if(!$isCharacter) {
                $xml->XMLWriter()->startElement('randomEnchantData');
                $xml->XMLWriter()->endElement(); //randomEnchantData
            }
            else {
                if($itemSlotName) {
                    $rPropInfo = Items::GetRandomPropertiesData($itemID, $characters->GetGUID(), $characters->GetEquippedItemGuidBySlot($itemSlotName));
                }
                else {
                    $rPropInfo = Items::GetRandomPropertiesData($itemID, $characters->GetGUID());
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
        $xml->XMLWriter()->startElement('socketData');
        $socket_data = false;
        $socketBonusCheck = array();
        for($i=1;$i<4;$i++) {
            if($data['socketColor_'.$i] > 0) {
                switch($data['socketColor_'.$i]) {
                    case 1:
                        $color = 'Meta';
                        $socket_data = array('color' => 'Meta');
                        $gem = Items::extractSocketInfo($characters->GetGUID(), $itemID, $i, ($isCharacter) ? $characters->GetEquippedItemGuidBySlot($itemSlotName) : null, ($isCharacter) ? $characters->GetDB() : null);
                        if($gem && ($parent == false || $comparsion == true) ) {
                            $socket_data['enchant'] = $gem['enchant'];
                            $socket_data['icon'] = $gem['icon'];
                            $currentColor = $this->aDB->selectCell("SELECT `color` FROM `armory_gemproperties` WHERE `spellitemenchantement`=%d LIMIT 1", $gem['enchant_id']);
                            if($currentColor == 1) {
                                $socket_data['match'] = '1';
                            }
                        }
                        break;
                    case 2:
                        $socket_data = array('color' => 'Red');
                        $gem = Items::extractSocketInfo($characters->GetGUID(), $itemID, $i, ($isCharacter) ? $characters->GetEquippedItemGuidBySlot($itemSlotName) : null, ($isCharacter) ? $characters->GetDB() : null);
                        if($gem && ($parent == false || $comparsion == true) ) {
                            $socket_data['enchant'] = $gem['enchant'];
                            $socket_data['icon'] = $gem['icon'];
                            $currentColor = $this->aDB->selectCell("SELECT `color` FROM `armory_gemproperties` WHERE `spellitemenchantement`=%d LIMIT 1", $gem['enchant_id']);
                            if($currentColor == 6 || $currentColor == 10 || $currentColor == 14) {
                                $socket_data['match'] = '1';
                            }
                        }
                        break;
                    case 4:
                        $socket_data = array('color' => 'Yellow');
                        $gem = Items::extractSocketInfo($characters->GetGUID(), $itemID, $i, ($isCharacter) ? $characters->GetEquippedItemGuidBySlot($itemSlotName) : null, ($isCharacter) ? $characters->GetDB() : null);
                        if($gem && ($parent == false || $comparsion == true) ) {
                            $socket_data['enchant'] = $gem['enchant'];
                            $socket_data['icon'] = $gem['icon'];
                            $currentColor = $this->aDB->selectCell("SELECT `color` FROM `armory_gemproperties` WHERE `spellitemenchantement`=%d LIMIT 1", $gem['enchant_id']);
                            if($currentColor == 6 || $currentColor == 12 || $currentColor == 14) {
                                $socket_data['match'] = '1';
                            }
                        }
                        break;
                    case 8:
                        $socket_data = array('color' => 'Blue');
                        $gem = Items::extractSocketInfo($characters->GetGUID(), $itemID, $i, ($isCharacter) ? $characters->GetEquippedItemGuidBySlot($itemSlotName) : null, ($isCharacter) ? $characters->GetDB() : null);
                        if($gem && ($parent == false || $comparsion == true) ) {
                            $socket_data['enchant'] = $gem['enchant'];
                            $socket_data['icon'] = $gem['icon'];
                            $currentColor = $this->aDB->selectCell("SELECT `color` FROM `armory_gemproperties` WHERE `spellitemenchantement`=%d LIMIT 1", $gem['enchant_id']);
                            if($currentColor == 10 || $currentColor == 12 || $currentColor == 14) {
                                $socket_data['match'] = '1';
                            }
                        }
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
                    $color = false;
                }
            }
        }
        if(isset($socketBonusCheck)) {
            $socketBonusCheckCount = count($socketBonusCheck);
            $socketMatches = 0;
            foreach($socketBonusCheck as $socket) {
                if($socket['color'] == $socket['current']) {
                    $socketMatches++;
                }
                elseif($socket['color'] == 2 && ($socket['current'] == 6 || $socket['current'] == 10 || $socket['current'] == 14)) {
                    $socketMatches++;
                }
                elseif($socket['color'] == 4 && ($socket['current'] == 6 || $socket['current'] == 12 || $socket['current'] == 14)) {
                    $socketMatches++;
                }
                elseif($socket['color'] == 8 && ($socket['current'] == 10 || $socket['current'] == 12 || $socket['current'] == 14)) {
                    $socketMatches++;
                }
            }
            if($socketBonusCheckCount == $socketMatches) {
                $socket_data['match'] = '1';
            }
        }
        if($data['socketBonus'] > 0) {
            $bonus_text = $this->aDB->selectCell("SELECT `text_%s` FROM `armory_enchantment` WHERE `id`=%d", $this->_locale, $data['socketBonus']);
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
        $allowable_classes = Items::AllowableClasses($data['AllowableClass']);
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
        $allowable_races = Items::AllowableRaces($data['AllowableRace']);
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
        if($data['RequiredSkill'] > 0) {
            if(Utils::IsWriteRaw()) {
                $xml->XMLWriter()->writeRaw('<requiredSkill');
                $xml->XMLWriter()->writeRaw(' name="' . $this->aDB->selectCell("SELECT `name_%s` FROM `armory_skills` WHERE `id`=%d", $this->_locale, $data['RequiredSkill']) . '"');
                $xml->XMLWriter()->writeRaw(' rank="', $data['RequiredSkillRank'].'"');
                $xml->XMLWriter()->writeRaw('/>'); //requiredSkill
            }
            else {
                $xml->XMLWriter()->startElement('requiredSkill');
                $xml->XMLWriter()->writeAttribute('name', $this->aDB->selectCell("SELECT `name_%s` FROM `armory_skills` WHERE `id`=%d", $this->_locale, $data['RequiredSkill']));
                $xml->XMLWriter()->writeAttribute('rank', $data['RequiredSkillRank']);
                $xml->XMLWriter()->endElement(); //requiredSkill
            }
        }
        if($data['RequiredReputationFaction'] > 0) {    
            if(Utils::IsWriteRaw()) {
                $xml->XMLWriter()->writeRaw('<requiredFaction');
                $xml->XMLWriter()->writeRaw(' name="' . $this->aDB->selectCell("SELECT `name_%s` FROM `armory_faction` WHERE `id`=%d", $this->_locale, $data['RequiredReputationFaction']) . '"');
                $xml->XMLWriter()->writeRaw(' rep="' . $data['RequiredReputationRank'] . '"');
                $xml->XMLWriter()->writeRaw('/>'); //requiredFaction
            }
            else {
                $xml->XMLWriter()->startElement('requiredFaction');
                $xml->XMLWriter()->writeAttribute('name', $this->aDB->selectCell("SELECT `name_%s` FROM `armory_faction` WHERE `id`=%d", $this->_locale, $data['RequiredReputationFaction']));
                $xml->XMLWriter()->writeAttribute('rep', $data['RequiredReputationRank']);
                $xml->XMLWriter()->endElement(); //requiredFaction
            }
        }
        $xml->XMLWriter()->startElement('requiredLevel');
        $xml->XMLWriter()->text($data['RequiredLevel']);
        $xml->XMLWriter()->endElement(); //requiredLevel
        $xml->XMLWriter()->startElement('itemLevel');
        $xml->XMLWriter()->text($data['ItemLevel']);
        $xml->XMLWriter()->endElement(); //itemLevel
        
        if($data['itemset'] > 0) {
            $xml->XMLWriter()->startElement('setData');
            $itemsetName = $this->aDB->selectCell("SELECT `name_%s` FROM `armory_itemsetinfo` WHERE `id`=%d", $this->_locale, $data['itemset']);
            if(Utils::IsWriteRaw()) {
                $xml->XMLWriter()->writeRaw('<name>');
                $xml->XMLWriter()->writeRaw($itemsetName);
                $xml->XMLWriter()->writeRaw('</name>');
            }
            else {
                $xml->XMLWriter()->startElement('name');
                $xml->XMLWriter()->text($itemsetName);
                $xml->XMLWriter()->endElement();
            }
            $setdata = $this->aDB->selectRow("SELECT * FROM `armory_itemsetinfo` WHERE `id`=%d", $data['itemset']);
            //                   t9/t10                    Onyxia trinkets
            if($data['itemset'] >= 843 && $data['itemset'] != 881 && $data['itemset'] != 882) {
                // Get itemset info from other table (armory_itemsetdata)
                $currentSetData = $this->aDB->selectRow("SELECT * FROM `armory_itemsetdata` WHERE `original`=%d AND (`item1`=%d OR `item2`=%d OR `item3`=%d OR `item4`=%d OR `item5`=%d)", $data['itemset'], $itemID, $itemID, $itemID, $itemID, $itemID);
                if($currentSetData) {
                    for($i=1;$i<6;$i++) {
                        if(Items::IsItemExists($currentSetData['item'.$i])) {
                            if(Utils::IsWriteRaw()) {
                                $xml->XMLWriter()->writeRaw('<item');
                                $xml->XMLWriter()->writeRaw(' name="' . Items::getItemName($currentSetData['item'.$i]).'"');
                                if($characters->IsItemEquipped($currentSetData['item'.$i])) {
                                    $xml->XMLWriter()->writeRaw(' equipped="' . 1 . '"');
                                }
                                $xml->XMLWriter()->writeRaw('/>'); //item
                            }
                            else {
                                $xml->XMLWriter()->startElement('item');
                                $xml->XMLWriter()->writeAttribute('name', Items::getItemName($currentSetData['item'.$i]));
                                if($characters->IsItemEquipped($currentSetData['item'.$i])) {
                                    $xml->XMLWriter()->writeAttribute('equipped', '1');
                                }
                                $xml->XMLWriter()->endElement(); //item
                            }
                        }
                    }
                }
            }
            else {
                for($i=1;$i<10;$i++) {
                    if(isset($setdata['item'.$i]) && Items::IsItemExists($setdata['item'.$i])) {
                        if(Utils::IsWriteRaw()) {
                            $xml->XMLWriter()->writeRaw('<item');
                            $xml->XMLWriter()->writeRaw(' name="' . Items::getItemName($setdata['item'.$i]) . '"');
                            if($characters->IsItemEquipped($setdata['item'.$i])) {
                                $xml->XMLWriter()->writeRaw(' equipped="1"');
                            }
                            $xml->XMLWriter()->writeRaw('/>'); //item
                        }
                        else {
                            $xml->XMLWriter()->startElement('item');
                            $xml->XMLWriter()->writeAttribute('name', Items::getItemName($setdata['item'.$i]));
                            if($characters->IsItemEquipped($setdata['item'.$i])) {
                                $xml->XMLWriter()->writeAttribute('equipped', 1);
                            }
                            $xml->XMLWriter()->endElement(); //item
                        }
                    }
                }
            }
            $itemsetbonus = Items::GetItemSetBonusInfo($setdata);
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
        for($i=1;$i<6;$i++) {
            if($data['spellid_'.$i] > 0) {
                $spellData = 1;
                $spell_tmp = $this->aDB->selectRow("SELECT * FROM `armory_spell` WHERE `id`=%d", $data['spellid_'.$i]);
                if($this->_locale == 'en_gb' || $this->_locale == 'ru_ru') {
                    $tmp_locale = $this->_locale;
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
                $spellInfo = $this->spellReplace($spell_tmp, Utils::ValidateText($spell_tmp['Description_'.$tmp_locale]));
                if($spellInfo) {
                    $spellData = 2;
                    $spellInfo = str_replace('&quot;', '"', $spellInfo);
                    $xml->XMLWriter()->startElement('spell');
                    $xml->XMLWriter()->startElement('trigger');
                    $xml->XMLWriter()->text($data['spelltrigger_'.$i]);
                    $xml->XMLWriter()->endElement();  //trigger
                    $xml->XMLWriter()->startElement('desc');
                    $xml->XMLWriter()->text($spellInfo);
                    $xml->XMLWriter()->endElement();  //desc
                    $xml->XMLWriter()->endElement(); //spell
                }
            }
        }
        if($spellData == 1 && !empty($data['description'])) {
            $xml->XMLWriter()->startElement('spell');
            $xml->XMLWriter()->startElement('trigger');
            $xml->XMLWriter()->text(6);
            $xml->XMLWriter()->endElement();  //trigger
            $xml->XMLWriter()->startElement('desc');
            if($this->_locale == 'en_gb' || $this->_locale == 'en_us') {
                $xml->XMLWriter()->text($data['description']);
            }
            else {
                $xml->XMLWriter()->text(Items::GetItemDescription($itemID));
            }
            $xml->XMLWriter()->endElement();  //desc
            if(!$parent) {
                for($k = 1; $k < 4; $k++) {
                    if($spell_tmp['EffectItemType_' . $k] > 0 && Items::IsItemExists($spell_tmp['EffectItemType_' . $k])) {
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
                            $xml->XMLWriter()->startElement('reag');
                            $xml->XMLWriter()->endElement(); //reagent
                        }
                    }
                }
            }
            $xml->XMLWriter()->endElement(); //spell
        }
        $xml->XMLWriter()->endElement(); //spellData
        if(!empty($data['description']) && $data['description'] != $spellInfo && $spellData != 1) {
            if(Utils::IsWriteRaw()) {
                $xml->XMLWriter()->writeRaw('<desc>');
                $xml->XMLWriter()->writeRaw(Items::GetItemDescription($itemID));
                $xml->XMLWriter()->writeRaw('</desc>'); //desc
            }
            else {
                $xml->XMLWriter()->startElement('desc');
                if($this->_locale == 'en_gb' || $this->_locale == 'en_us') {
                    $xml->XMLWriter()->text($data['description']);
                }
                else {
                    $xml->XMLWriter()->text(Items::GetItemDescription($itemID));
                }
                $xml->XMLWriter()->endElement(); //desc
            }
        }
        if(!$parent) {
            $itemSource = Items::GetItemSource($itemID);
            if(is_array($itemSource)) {
                if(Utils::IsWriteRaw()) {
                    $xml->XMLWriter()->writeRaw('<itemSource');
                    foreach($itemSource as $source_key => $source_value) {
                        $xml->XMLWriter()->writeRaw(' ' . $source_key .'="' . $source_value . '"');
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
            if($itemSource['value'] == 'sourceType.vendor' && $reqArenaRating = Items::IsRequiredArenaRating($itemID)) {
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
        $spell = $this->aDB->selectRow("
        SELECT
        `Reagent_1`, `Reagent_2`, `Reagent_3`, `Reagent_4`, `Reagent_5`, `Reagent_6`,
        `ReagentCount_1`, `ReagentCount_2`, `ReagentCount_3`,
        `ReagentCount_4`, `ReagentCount_5`, `ReagentCount_6`
        FROM `armory_spell`
        WHERE `EffectItemType_1`=%d OR `EffectItemType_2`=%d OR `EffectItemType_3`=%d", $itemID, $itemID, $itemID);
        if(!$spell) {
            return false;
        }
        $data = array();
        for($i = 1; $i < 6; $i++) {
            if(isset($spell['Reagent_' . $i]) && $spell['Reagent_' . $i] > 0) {
                $data[$i] = array(
                    'count' => $spell['ReagentCount_' . $i],
                    'name'  => $this->getItemName($spell['Reagent_' . $i])
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
            $item_slot = $this->wDB->selectCell("SELECT `InventoryType` FROM `item_template` WHERE `entry`=%d AND (`class`=2 OR `class`=4)", $itemID);
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
        if($this->wDB->selectCell("SELECT 1 FROM `npc_vendor` WHERE `item`=%d", $itemID)) {
            return true;
        }
        return false;
    }
    
    public function GenerateEnchantmentSpellData($spellID) {
        if($this->_locale == 'en_gb' || $this->_locale == 'ru_ru') {
            $tmp_locale = $this->_locale;
        }
        else {
            $tmp_locale = 'en_gb';
        }
        $data = array();
        $spell_info = $this->aDB->selectRow("SELECT `SpellName_%s`, `Description_%s`, `SpellName_en_gb`, `Description_en_gb` FROM `armory_spell` WHERE `id`=%d LIMIT 1", $tmp_locale, $tmp_locale, $spellID);
        if(!isset($spell_info['Description_' . $tmp_locale]) || empty($spell_info['Description_' . $tmp_locale])) {
            // Try to find en_gb locale
            if(isset($spell_info['Description_en_gb']) && !empty($spell_info['Description_en_gb'])) {
                $tmp_locale = 'en_gb';
            }
            else {
                return false;
            }
        }
        $data['name'] = $spell_info['SpellName_' . $tmp_locale];
        $data['desc'] = $spell_info['Description_' . $tmp_locale];
        $data['desc'] = str_replace('&quot;', '"', $data['desc']);
        $data['desc'] = str_replace('&lt;br&gt;', '', $data['desc']);
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
            //$this->Log()->writeError('%s : wrong key or row type (key: %s, row: %s)', __METHOD__, $key, $row);
            return false;
        }
        return $this->aDB->selectCell("SELECT `%s` FROM `armory_item_sources` WHERE `key`='%s' LIMIT 1", $row, $key);
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
        $query = '';
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
}
?>