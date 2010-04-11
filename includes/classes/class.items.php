<?php

/**
 * @package World of Warcraft Armory
 * @version Release Candidate 1
 * @revision 135
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
    
    public $itemId;
    
    /**
     * $charGuid used by item-tooltip.php (enchantments, sockets & item durability for current character)
     **/
    public $charGuid;
    
    public function IsItemExists($itemID) {
        if($this->wDB->selectCell("SELECT `name` FROM `item_template` WHERE `entry`=?", $itemID)) {
            return true;
        }
        return false;
    }
    
    /**
     * Returns item name according with defined locale (ru_ru or en_gb)
     * @category Items class
     * @example Items::getItemName(35000)
     * @return string
     **/
    public function getItemName($itemID) {
        if($this->_locale == 'en_gb' || $this->_locale == 'en_us') {
            $itemName = $this->wDB->selectCell("SELECT `name` FROM `item_template` WHERE `entry`=? LIMIT 1", $itemID);
        }
        else {
            $itemName = $this->wDB->selectCell("SELECT `name_loc" . $this->_loc . "` FROM `locales_item` WHERE `entry`=? LIMIT 1", $itemID);
            if(!$itemName) {
                $itemName = $this->wDB->selectCell("SELECT `name` FROM `item_template` WHERE `entry`=? LIMIT 1", $itemID);
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
     * @example Items::getItemIcon(35000)
     * @return string
     **/
    public function getItemIcon($itemID) {
        $displayId = $this->wDB->selectCell("SELECT `displayid` FROM `item_template` WHERE `entry`=? LIMIT 1", $itemID);
        $itemIcon = $this->aDB->selectCell("SELECT `icon` FROM `armory_icons` WHERE `displayid`=? LIMIT 1", $displayId);
        return strtolower($itemIcon);
    }
    
    /**
     * Returns item description (if isset) according with defined locale (ru_ru or en_gb)
     * @category Items class
     * @example Items::getItemDescription(35000)
     * @return string
     **/
    public function GetItemDescription($itemID) {
        if($this->_locale == 'en_gb' || $this->_locale == 'en_us') {
            $itemDescription = $this->wDB->selectCell("SELECT `description` FROM `item_template` WHERE `entry`=? LIMIT 1", $itemID);
        }
        else {
            $itemDescription = $this->wDB->selectCell("SELECT `description_loc" . $this->_loc . "` FROM `locales_item` WHERE `entry`=? LIMIT 1", $itemID);
            if(!$itemDescription) {
                $itemDescription = $this->wDB->selectCell("SELECT `description` FROM `item_template` WHERE `entry`=? LIMIT 1", $itemID);
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
     * @example Items::AllowableRaces(690) // Horde only
     * @return string
     **/
    public function AllowableRaces($mask) {
        $mask&=0x7FF;
        // Return zero if for all class (or for none
		if ($mask == 0x7FF OR $mask == 0) {
            return 0;
		}
        $i=1;
        $rMask = array();
		while($mask) {
			if($mask & 1) {
                $rMask[$i] = $this->aDB->selectCell("SELECT `name_" . $this->_locale . "` FROM `armory_races` WHERE `id`=?", $i);
		   	}
			$mask>>=1;
			$i++;
		}
		return $rMask;
    }
    
    /**
     * Returns available classes string (if mask > 0)
     * @category Items class
     * @example Items::AllowableClasses(16) // Priests
     * @return string
     **/
    public function AllowableClasses($mask) {
		$mask &= 0x5DF;
		// Return zero if for all class (or for none
		if($mask == 0x5DF || $mask == 0) {
            return 0;
		}
        $i=1;
        $rMask = array();
		while($mask) {
			if($mask & 1) {
                $rMask[$i] = $this->aDB->selectCell("SELECT `name_" . $this->_locale . "` FROM `armory_classes` WHERE `id`=?", $i);
	    	}
			$mask>>=1;
			$i++;
		}
		return $rMask;
	}
    
    /**
     * Returns item source strin (vendor, drop, chest loot, etc.)
     * @category Items class
     * @example Items::GetItemSource(35000)
     * @return string
     **/
    public function GetItemSource($item) {
		$bossLoot = $this->wDB->selectCell("
		SELECT `entry`
			FROM `creature_loot_template`
				WHERE `item`=? LIMIT 1", $item);
        $chestLoot = $this->wDB->selectCell("
        SELECT `entry`
            FROM `gameobject_loot_template`
                WHERE `item`=? LIMIT 1", $item);
        if($bossLoot) {
            if(Mangos::GetNpcInfo($bossLoot, 'isBoss') && self::IsUniqueLoot($item)) {
                // We got boss loot, generate improved tooltip.
                return self::GetImprovedItemSource($item, $bossLoot);
            }
            elseif(Mangos::GetNpcInfo($bossLoot, 'isBoss')) {
                return array('value' => 'sourceType.creatureDrop');
            }
            else {
                return array('value' => 'sourceType.worldDrop');
            }
        }
        if($chestLoot) {
            if($chest_data = self::GetImprovedItemSource($item, $chestLoot)) {
                return $chest_data;
            }
            else {
                return array('value' => 'sourceType.gameObjectDrop');
            }
        }
        
        $vendorLoot = $this->wDB->selectCell("
		SELECT `entry`
			FROM `npc_vendor`
				WHERE `item`=? LIMIT 1", $item);		
        $reputationReward = $this->wDB->selectCell("SELECT `RequiredReputationFaction` FROM `item_template` WHERE `entry`=?", $item);
        if($vendorLoot && $reputationReward > 0) {
            return array('value' => 'sourceType.factionReward');
		}
        elseif($vendorLoot && (!$reputationReward || $reputationReward == 0)) {
            return array('value' => 'sourceType.vendor');
        }
        	
		$questLoot = $this->wDB->selectCell("
		SELECT `entry`
		  FROM `quest_template`
		      WHERE `RewChoiceItemId1` = ? OR `RewChoiceItemId2` = ? OR `RewChoiceItemId3` = ? OR 
		          `RewChoiceItemId4` = ? OR `RewChoiceItemId5` = ? OR `RewChoiceItemId6` = ? LIMIT 1", $item, $item, $item, 
		$item, $item, $item);
        if($questLoot) {
            return array('value' => 'sourceType.questReward');
        }
        
        $craftLoot = $this->aDB->selectCell("
        SELECT `id`
            FROM `armory_spell`
                WHERE `EffectItemType_1`=? OR `EffectItemType_2`=? OR `EffectItemType_3`=? LIMIT 1", $item, $item, $item);
        if($craftLoot) {
            return array('value' => 'sourceType.createdByPlans');
        }
    }
    
    /**
     * Return full loot info (not used now)
     * @category Items class
     * @example Items::lootInfo(35000)
     * @return array
     **/
    public function lootInfo($itemID) {
        $bossLoot = $this->wDB->selectRow("SELECT `entry`, `ChanceOrQuestChance` FROM `creature_loot_template` WHERE `item`=?", $itemID);
        $chestLoot = $this->wDB->selectRow("SELECT `entry`, `ChanceOrQuestChance` FROM `gameobject_loot_template` WHERE `item`=?", $itemID);
        $loot = array();
        if($bossLoot) {
            $loot = array(
                'source' =>   Mangos::GetNPCName($bossLoot['entry']),
                'instance' => Mangos::GetNpcInfo($bossLoot['entry'], 'map'),
                'percent' =>  Mangos::DropPercent($bossLoot['ChanceOrQuestChance'])
            );
        }
        elseif($chestLoot) {
            $loot = array(
                'source' =>   Mangos::GameobjectInfo($chestLoot['entry'], 'name'),
                'instance' => Mangos::GameobjectInfo($chestLoot['entry'], 'map'),
                'percent' =>  Mangos::DropPercent($chestLoot['ChanceOrQuestChance'])
            );
        }
        else {
            $loot = array(
                'source' => 'Unknown',
                'instance' => 'Unknown',
                'percent' => 'Unknown'
            );
        }
        return $loot;
    }
    
    public function GetItemSetBonusInfo($itemsetdata) {
        $itemSetBonuses = array();
        for($i=1; $i<9; $i++) {
            if($itemsetdata['bonus'.$i] > 0) {
                $spell_tmp = array();
                $spell_tmp = $this->aDB->selectRow("SELECT * FROM `armory_spell` WHERE `id`=?", $itemsetdata['bonus'.$i]);
                if(!isset($spell_tmp['Description_'.$this->_locale])) {
                    $spell_tmp['Description_'.$this->_locale] = '';
                }
                $itemSetBonuses[$i]['desc'] = self::spellReplace($spell_tmp, Utils::validateText($spell_tmp['Description_'.$this->_locale]));
                $itemSetBonuses[$i]['desc'] = str_replace('&quot;', '"', $itemSetBonuses[$i]['desc']);
                $itemSetBonuses[$i]['threshold'] = $i;
            }
		}
	   return $itemSetBonuses;
    }
    
    /**
     * Return array with loot info: dropped by, contained in, disenchating to, reagent for, etc.
     * @category Items class
     * @example Items::BuildLootTable(35000, 'vendor')
     * @todo Currency for
     * @return array
     **/
    public function BuildLootTable($item, $vendor, $data=false) {
        $lootTable = array();
        switch($vendor) {
			case 'vendor':
				$VendorLoot = $this->wDB->select("
				SELECT `entry`, `ExtendedCost`
					FROM `npc_vendor`
						WHERE `item`=?", $item);
				if(!empty($VendorLoot)) {
				    $i = 0;
					foreach($VendorLoot as $vItem) {
                        $lootTable[$i] = $this->wDB->selectRow("SELECT `entry` AS `id`, `minlevel` AS `minLevel`, `maxlevel` AS `maxLevel`, name FROM `creature_template` WHERE `entry`=?", $vItem['entry']);
                        if($this->_locale != 'en_gb' || $this->_locale != 'en_us') {
                            $lootTable[$i]['name'] = Mangos::GetNpcName($vItem['entry']);
                        }
                        $lootTable[$i]['area'] = Mangos::GetNpcInfo($vItem['entry'], 'map');
						$i++;
					}
				}
                break;
			case 'boss':
				$BossLoot = $this->wDB->select("
				SELECT `entry`, `ChanceOrQuestChance`
					FROM `creature_loot_template`
						WHERE `item`=?", $item);                        
				if($BossLoot) {
				    $i = 0;
					foreach($BossLoot as $bItem) {
                        $lootTable[$i] = $this->wDB->selectRow("
                        SELECT `entry` AS `id`, `name`, `minlevel` AS `minLevel`, `maxlevel` AS `maxLevel`, `rank` AS `classification`
                            FROM `creature_template`
                                WHERE `entry`=?", $bItem['entry']);
                        if($this->_locale != 'en_gb' || $this->_locale != 'en_us') {
                            $lootTable[$i]['name'] = Mangos::GetNpcName($bItem['entry']);
                        }
                        $lootTable[$i]['area'] = Mangos::GetNpcInfo($bItem['entry'], 'map');
                        $lootTable[$i]['areaUrl'] = Mangos::GetNpcInfo($bItem['entry'], 'areaUrl');
                        $lootTable[$i]['dropRate'] = Mangos::DropPercent($bItem['ChanceOrQuestChance']);
                        if($lootTable[$i]['areaUrl'] && Mangos::GetNpcInfo($bItem['entry'], 'isBoss')) {
                            $lootTable[$i]['url'] = str_replace('boss=all', 'boss='.$bItem['entry'], $lootTable[$i]['areaUrl']);
                        }
                        $i++;
					}
				}
                break;
			case 'chest':
				$ChestLoot = $this->wDB->select("
				SELECT `entry`, `ChanceOrQuestChance`
					FROM `gameobject_loot_template`
						WHERE `item`=?", $item);
                if(!$ChestLoot) {
                    return false;
                }
                $i = 0;
                foreach($ChestLoot as $cItem) {
                    $lootTable[$i] = array (
                        'name' => Mangos::GameobjectInfo($cItem['entry'], 'name'),
                        'area' => Mangos::GameobjectInfo($cItem['entry'], 'map'),
                        'areaUrl' => Mangos::GameobjectInfo($cItem['entry'], 'areaUrl'),
                        'id' => $cItem['entry'],
                        'dropRate' => Mangos::DropPercent($cItem['ChanceOrQuestChance'])
                    );
                    $i++;
				}
                break;
			case 'questreward':
				$QuestLoot = $this->wDB->select("
				SELECT `entry` AS `id`, `Title` AS `name`, `QuestLevel` AS `level`, `MinLevel` AS `reqMinLevel`, `SuggestedPlayers` AS `suggestedPartySize`
					FROM `quest_template`
						WHERE `RewChoiceItemId1` = ? OR `RewChoiceItemId2` = ? OR `RewChoiceItemId3` = ? OR 
						`RewChoiceItemId4` = ? OR `RewChoiceItemId5` = ? OR `RewChoiceItemId6` = ?", $item, $item, $item, 
						$item, $item, $item);
                if(!$QuestLoot) {
                    return false;
                }
                $i = 0;
                foreach($QuestLoot as $qItem) {
                    $lootTable[$i] = $qItem;
                    if($this->_locale != 'en_gb' || $this->_locale != 'en_us') {
                        $lootTable[$i]['name'] = Mangos::QuestInfo($qItem['id'], 'title');
                    }
                    $lootTable[$i]['area'] = Mangos::QuestInfo($qItem['id'], 'map');
                    $i++;
				}
                break;
            case 'queststart':
                $QuestStart = $this->wDB->selectCell("SELECT `startquest` FROM `item_template` WHERE `entry`=?", $item);
                if(!$QuestStart) {
                    return false;
                }
                $lootTable = $this->wDB->selectRow("SELECT `entry` AS `id`, `Title` AS `name`, `QuestLevel` AS `level`, `MinLevel` AS `reqMinLevel`, `SuggestedPlayers` AS `suggestedPartySize` FROM `quest_template` WHERE `entry`=?", $QuestStart);
                if($this->_locale != 'en_gb' || $this->_locale != 'en_us') {
                    $lootTable['name'] = Mangos::QuestInfo($QuestStart, 'title');
                }
                $lootTable['name'] = Mangos::QuestInfo($QuestStart, 'title');
                $lootTable['area'] =  Mangos::QuestInfo($QuestStart, 'map');
                break;
            case 'providedfor':
                $QuestInfo = $this->wDB->select("SELECT `entry` AS `id`, `QuestLevel` AS `level`, `Title` AS `name`, `MinLevel` AS `reqMinLevel`, `SuggestedPlayers` AS `suggestedPartySize` FROM `quest_template` WHERE `SrcItemId`=?", $item);
                if(!$QuestInfo) {
                    return false;
                }
                $i = 0;
                foreach($QuestInfo as $quest) {
                    $lootTable[$i] = $quest;
                    if($this->_locale != 'en_gb' || $this->_locale != 'en_us') {
                        $lootTable[$i]['name'] = Mangos::QuestInfo($quest['id'], 'title');
                    }
                    $lootTable[$i]['area'] = Mangos::QuestInfo($quest['id'], 'map');
                }
                break;            
            case 'objectiveof':
                $QuestInfo = $this->wDB->select("
                SELECT `entry` AS `id`, `QuestLevel` AS `level`, `Title` AS `name`, `MinLevel` AS `reqMinLevel`, `SuggestedPlayers` AS `suggestedPartySize`
                    FROM `quest_template`
                        WHERE `ReqItemId1`=? OR `ReqItemId2`=? OR `ReqItemId3`=? OR `ReqItemId4`=? OR `ReqItemId5`=?", $item, $item, $item, $item, $item);
                if(!$QuestInfo) {
                    return false;
                }
                $i = 0;
                foreach($QuestInfo as $quest) {
                    $lootTable[$i] = $quest;
                    if($this->_locale != 'en_gb' || $this->_locale != 'en_us') {
                        $lootTable[$i]['name'] = Mangos::QuestInfo($quest['id'], 'title');
                    }
                    $lootTable[$i]['area'] = Mangos::QuestInfo($quest['id'], 'map');
                }                
                break;
            case 'disenchant':
                $DisenchantLoot = $this->wDB->select("
                SELECT `item`, `ChanceOrQuestChance`, `maxcount`, `mincountOrRef`
                    FROM `disenchant_loot_template`
                        WHERE `entry`=?", $item);
                if(!$DisenchantLoot) {
                    return false;
                }
                $i = 0;
                foreach($DisenchantLoot as $dItem) {
                    $lootTable[$i] = array (
                        'id'       => $dItem['item'],
                        'name'     => self::GetItemName($dItem['item']),
                        'dropRate' => Mangos::DropPercent($dItem['ChanceOrQuestChance']),
                        'maxCount' => $dItem['maxcount'],
                        'maxCount' => $dItem['mincountOrRef'],
                        'icon'     => self::GetItemIcon($dItem['item']),
                        'quality'  => self::GetItemInfo($dItem['item'], 'quality')
                    );
                    $i++;
                }
                break;
            case 'craft':
                $CraftLoot = $this->aDB->select("
                    SELECT `Reagent_1`, `Reagent_2`, `Reagent_3`, `Reagent_4`, `Reagent_5`, `Reagent_6`, `Reagent_7`, `Reagent_8`,
                        `ReagentCount_1`, `ReagentCount_2`, `ReagentCount_3`, `ReagentCount_4`, `ReagentCount_5`, `ReagentCount_6`, 
                        `ReagentCount_7`, `ReagentCount_8`, `EffectItemType_1`, `EffectItemType_2`, `EffectItemType_3`,
                        `SpellName_".$this->_locale."` AS `SpellName`, `spellicon`
                        FROM `armory_spell`
                            WHERE `EffectItemType_1` =? OR `EffectItemType_2`=? OR `EffectItemType_3`=?", $item, $item, $item);
                if(!$CraftLoot) {
                    return false;
                }
                $i=0;
                foreach($CraftLoot as $craftItem) {
                    $lootTable[$i]['spell']   = array();
                    $lootTable[$i]['item']    = array();
                    $lootTable[$i]['reagent'] = array();                    
                    $lootTable[$i]['spell']['name'] = $craftItem['SpellName'];
                    $lootTable[$i]['spell']['icon'] = $this->aDB->selectCell("SELECT `icon` FROM `armory_speillicon` WHERE `id`=?", $craftItem['spellicon']);
                    for($o=1;$o<9;$o++) {
                        if($craftItem['Reagent_'.$o] > 0) {
                            $lootTable[$i]['reagent'][$o]['id'] = $craftItem['Reagent_'.$o];
                            $lootTable[$i]['reagent'][$o]['name'] = self::getItemName($craftItem['Reagent_'.$o]);
                            $lootTable[$i]['reagent'][$o]['icon'] = self::getItemIcon($craftItem['Reagent_'.$o]);
                            $lootTable[$i]['reagent'][$o]['count'] = $craftItem['ReagentCount_'.$o];
                            $lootTable[$i]['reagent'][$o]['quality'] = self::GetItemInfo($craftItem['Reagent_'.$o], 'quality');
                        }
                    }
                    for($j=1;$j<4;$j++) {
                        if($craftItem['EffectItemType_'.$j] > 0) {
                            $lootTable[$i]['item'][$j]['name'] = self::GetItemName($craftItem['EffectItemType_'.$j]);
                            $lootTable[$i]['item'][$j]['id'] = $craftItem['EffectItemType_'.$j];
                            $lootTable[$i]['item'][$j]['icon'] = self::GetItemIcon($craftItem['EffectItemType_'.$j]);
                            $lootTable[$i]['item'][$j]['quality'] = self::GetItemInfo($craftItem['EffectItemType_'.$j], 'quality');
                        }
                    }
                    $i++;
                }
                break;
            case 'currency':
                return false;
                break;
            case 'reagent':
                $ReagentLoot = $this->aDB->select("
                SELECT `Reagent_1`, `Reagent_2`, `Reagent_3`, `Reagent_4`, `Reagent_5`, `Reagent_6`, `Reagent_7`, `Reagent_8`,
                `ReagentCount_1`, `ReagentCount_2`, `ReagentCount_3`, `ReagentCount_4`, `ReagentCount_5`, `ReagentCount_6`, 
                `ReagentCount_7`, `ReagentCount_8`, `EffectItemType_1`, `EffectItemType_2`, `EffectItemType_3`,
                `SpellName_".$this->_locale."` AS `SpellName`, `spellicon`
                FROM `armory_spell`
                    WHERE `Reagent_1`=? OR `Reagent_2`=? OR `Reagent_3`=? OR `Reagent_4`=? OR
                        `Reagent_5`=? OR `Reagent_6`=? OR `Reagent_7`=? OR `Reagent_8`=?", $item, $item, $item, $item, $item, $item, $item, $item);
                if(!$ReagentLoot) {
                    return false;
                }
                $i = 0;
                foreach($ReagentLoot as $ReagentItem) {
                    $lootTable[$i]['spell']   = array();
                    $lootTable[$i]['item']    = array();
                    $lootTable[$i]['reagent'] = array();
                    
                    $lootTable[$i]['spell']['name'] = $ReagentItem['SpellName'];
                    $lootTable[$i]['spell']['icon'] = $this->aDB->selectCell("SELEC `icon` FROM `armory_spellicon` WHERE `id`=?", $ReagentItem['spellicon']);
                    
                    for($j=1;$j<4;$j++) {
                        if($ReagentItem['EffectItemType_'.$j] > 0) {
                            $lootTable[$i]['item'][$j]['id'] = $ReagentItem['EffectItemType_'.$j];
                            $lootTable[$i]['item'][$j]['name'] = self::getItemName($ReagentItem['EffectItemType_'.$j]);
                            $lootTable[$i]['item'][$j]['icon'] = self::getItemIcon($ReagentItem['EffectItemType_'.$j]);
                            $lootTable[$i]['item'][$j]['quality'] = self::GetItemInfo($ReagentItem['EffectItemType_'.$j], 'quality');
                        }
                    }
                    for($o=1;$o<9;$o++) {
                        if($ReagentItem['Reagent_'.$o] > 0) {
                            $lootTable[$i]['reagent'][$o]['id'] = $ReagentItem['Reagent_'.$o];
                            $lootTable[$i]['reagent'][$o]['icon'] = self::getItemIcon($ReagentItem['Reagent_'.$o]);
                            $lootTable[$i]['reagent'][$o]['count'] = $ReagentItem['ReagentCount_'.$o];
                            $lootTable[$i]['reagent'][$o]['name'] = self::getItemName($ReagentItem['Reagent_'.$o]);
                        }
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
     * @example Items::GetItemInfo(3500, 'quality')
     * @todo Add more cases
     * @return string
     **/
    public function GetItemInfo($itemID, $type) {
        switch($type) {
            case 'quality':
                $info = $this->wDB->selectCell("SELECT `Quality` FROM `item_template` WHERE `entry`=? LIMIT 1", $itemID);
                break;
            case 'displayid':
                $info = $this->wDB->selectCell("SELECT `displayid` FROM `item_template` WHERE `entry`=? LIMIT 1", $itemID);
                break;
            default:
                $info = false;
        }
        return $info;
    }
    
    /**
     * Returns array with socket info (gem icon, enchant string, enchant id, item id)
     * @category Items class
     * @example Items::extractSocketInfo(100, 3500, 1)
     * @return array
     **/ 
    public function extractSocketInfo($guid, $item, $socketNum) {
        $data = array();
        $socketfield = array(
            1 => ITEM_FIELD_ENCHANTMENT_3_2,
            2 => ITEM_FIELD_ENCHANTMENT_4_2,
            3 => ITEM_FIELD_ENCHANTMENT_5_2
        );
        $socketInfo = $this->cDB->selectCell("
        SELECT CAST(SUBSTRING_INDEX(SUBSTRING_INDEX(`data`, ' ', ".$socketfield[$socketNum]."), ' ', '-1') AS UNSIGNED)  
            FROM `item_instance` 
                WHERE `owner_guid`=? AND CAST(SUBSTRING_INDEX(SUBSTRING_INDEX(`data`, ' ', 4), ' ', '-1') AS UNSIGNED) = ?", $guid, $item);
        if($socketInfo > 0) {
            $data['enchant_id'] = $socketInfo;
            $data['item'] = $this->aDB->selectCell("SELECT `gem` FROM `armory_enchantment` WHERE `id`=?", $socketInfo);
            $data['icon'] = self::getItemIcon($data['item']);
            $data['enchant'] = $this->aDB->selectCell("SELECT `text_".$this->_locale."` FROM `armory_enchantment` WHERE `id`=?", $socketInfo);
            return $data;
        }
        return false;
    }
    
    /**
     * Returns array with current/max item durability for selected ($guid) character
     * @category Items class
     * @example Items::getItemDurability(100, 35000)
     * @return array
     **/
    public function getItemDurability($guid, $item) {
        $durability['current'] = self::GetItemDataField(ITEM_FIELD_DURABILITY, $item, $guid);
        $durability['max'] = self::GetItemDataField(ITEM_FIELD_MAXDURABILITY, $item, $guid);
        return $durability;
    }
    
    public function GetItemDurabilityByItemGuid($item_guid) {
        $durability['current'] = self::GetItemDataField(ITEM_FIELD_DURABILITY, 0, 0, $item_guid);
        $durability['max'] = self::GetItemDataField(ITEM_FIELD_MAXDURABILITY, 0, 0, $item_guid);
        return $durability;
    }
    
    /**
     * Returns field ($field) value from `item_instance`.`data` field for current item guid (NOT char guid!)
     * @category Items class
     * @example Items::GetItemDataField(10, 333)
     * @return int
     **/
    public function GetItemDataField($field, $itemid, $owner_guid, $use_item_guid=0) {
        $dataField = $field+1;
        if($use_item_guid > 0) {
            $qData = $this->cDB->selectCell("
            SELECT CAST(SUBSTRING_INDEX(SUBSTRING_INDEX(`data`, ' ', ".$dataField."), ' ', '-1') AS UNSIGNED)
                FROM `item_instance`
                    WHERE `guid`= ?", $use_item_guid);
            return $qData;
        }
        else {
            $qData = $this->cDB->selectCell("
            SELECT CAST(SUBSTRING_INDEX(SUBSTRING_INDEX(`data`, ' ', ".$dataField."), ' ', '-1') AS UNSIGNED)  
                FROM `item_instance` 
                    WHERE `owner_guid`=? AND CAST(SUBSTRING_INDEX(SUBSTRING_INDEX(`data`, ' ', 4), ' ', '-1') AS UNSIGNED) = ?", $owner_guid, $itemid);
        }        
        return $qData;
    }
    
    // CSWOWD functions
    public function spellReplace($spell, $text) {
        $letter = array('${','}');
        $values = array( '[',']');
        $text = str_replace($letter, $values, $text);
    
    	$signs = array('+', '-', '/', '*', '%', '^');
        $data = $text;
    	$pos = 0;
        $npos = 0;
    	$str = '';
        $cacheSpellData=array(); // Spell data for spell
        $lastCount = 1;
        while (false!==($npos=strpos($data, '$', $pos))) {
    	   if ($npos!=$pos)
                $str .= substr($data, $pos, $npos-$pos);
    		$pos = $npos+1;
    		if ('$' == substr($data, $pos, 1))
    		{
    			$str .= '$';
    			$pos++;
    			continue;
    		}
    
    		if (!preg_match('/^((([+\-\/*])(\d+);)?(\d*)(?:([lg].*?:.*?);|(\w\d*)))/', substr($data, $pos), $result))
    			continue;
    		$pos += strlen($result[0]);
    		$op = $result[3];
    		$oparg = $result[4];
    		$lookup = $result[5]? $result[5]:$spell['id'];
    		$var = $result[6] ? $result[6]:$result[7];
    		if (!$var)
    			continue;
            if ($var[0]=='l')
            {
                $select = explode(':', substr($var, 1));
                $str.=@$select[$lastCount==1 ? 0:1];
            }
            else if ($var[0]=='g')
            {
                $select = explode(':', substr($var, 1));
                $str.=$select[0];
            }
            else
            {
                $spellData = @$cacheSpellData[$lookup];
                if ($spellData == 0)
                {
                    if ($lookup == $spell['id']) $cacheSpellData[$lookup] = $this->getSpellData($spell);
                    else                         $cacheSpellData[$lookup] = $this->getSpellData($this->aDB->selectRow("SELECT * FROM `armory_spell` WHERE `id`=?", $lookup));
                    $spellData = @$cacheSpellData[$lookup];
                }
                if ($spellData && $base = @$spellData[strtolower($var)])
                {
                    if ($op && is_numeric($oparg) && is_numeric($base))
                    {
                         $equation = $base.$op.$oparg;
                         eval("\$base = $equation;");
    		        }
                    if (is_numeric($base)) $lastCount = $base;
                }
                else
                    $base = $var;
                $str.=$base;
            }
    	}
    	$str .= substr($data, $pos);
    	$str = preg_replace_callback("/\[.+[+\-\/*\d]\]/", array($this, 'my_replace'), $str);
    	return $str;
    }
    
    public function getSpellData($spell) {
      // Basepoints
      $s1 = abs($spell['EffectBasePoints_1']+$spell['EffectBaseDice_1']);
      $s2 = abs($spell['EffectBasePoints_2']+$spell['EffectBaseDice_2']);
      $s3 = abs($spell['EffectBasePoints_3']+$spell['EffectBaseDice_3']);
      if ($spell['EffectDieSides_1']>$spell['EffectBaseDice_1']) $s1.=" - ".abs($spell['EffectBasePoints_1']+$spell['EffectDieSides_1']);
      if ($spell['EffectDieSides_2']>$spell['EffectBaseDice_2']) $s2.=" - ".abs($spell['EffectBasePoints_2']+$spell['EffectDieSides_2']);
      if ($spell['EffectDieSides_3']>$spell['EffectBaseDice_3']) $s3.=" - ".abs($spell['EffectBasePoints_3']+$spell['EffectDieSides_3']);
    
      $d  = 0;
      if ($spell['DurationIndex'])
       if ($spell_duration = $this->aDB->selectRow("SELECT * FROM `armory_spell_duration` WHERE `id`=?", $spell['DurationIndex']))
         $d = $spell_duration['duration_1']/1000;
    
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
      $spellData['d'] = $d;
      $spellData['d1']= Utils::getTimeText($d);
      $spellData['d2']= Utils::getTimeText($d);
      $spellData['d3']= Utils::getTimeText($d);
      $spellData['v'] = $spell['AffectedTargetLevel'];
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
    
    public function my_replace($matches) {
        $text = str_replace( array('[',']'), array('', ''), $matches[0]);
        //eval("\$text = abs(".$text.");");
        return intval($text);
    }
    
    // End of CSWOWD functions
    
    public function GetItemSourceByKey($key) {
        $name = $this->aDB->selectCell("SELECT `name_".$this->_locale."` FROM `armory_instance_template` WHERE `id` IN (SELECT `instance_id` FROM `armory_instance_data` WHERE `key`=?)", $key);
        if($name) {
            return $name;
        }
        return false;
    }
    
    public function GetImprovedItemSource($itemID, $bossID) {
        $dungeonData = $this->aDB->selectRow("SELECT `instance_id`, `name_".$this->_locale."` AS `name` FROM `armory_instance_data` WHERE `id`=? OR `lootid_1`=? OR `lootid_2`=? OR `lootid_3`=? OR `lootid_4`=? OR `name_id`=? LIMIT 1", $bossID, $bossID, $bossID, $bossID, $bossID, $bossID);
        if(!$dungeonData) {
            return false;
        }
        $instance_data = $this->aDB->selectRow("SELECT `id` AS `areaId`, `name_".$this->_locale."` AS `areaName` FROM `armory_instance_template` WHERE `id`=?", $dungeonData['instance_id']);
        $instance_data['creatureId'] = $this->aDB->selectCell("SELECT `id` FROM `armory_instance_data` WHERE `id`=? OR `lootid_1`=? OR `lootid_2`=? OR `lootid_3`=? OR `lootid_4`=? OR `name_id`=? LIMIT 1", $bossID, $bossID, $bossID, $bossID, $bossID, $bossID);
        $instance_data['creatureName'] = $dungeonData['name'];
        $instance_data['dropRate'] = Mangos::DropPercent($this->wDB->selectCell("SELECT `ChanceOrQuestChance` FROM `creature_loot_template` WHERE `item`=? AND `entry`=? LIMIT 1", $itemID, $bossID));
        $instance_data['value'] = 'sourceType.creatureDrop';
        return $instance_data;
    }
    
    public function IsUniqueLoot($itemID) {
        $item_count = $this->wDB->selectCell("SELECT COUNT(`entry`) FROM `creature_loot_template` WHERE `item`=?", $itemID);
        if($item_count > 1) {
            return false;
        }
        return true;
    }
    
    public function GetItemModelData($displayId, $row='', $itemid=0) {
        if($itemid > 0) {
            $displayId = self::GetItemInfo($itemid, 'displayid');
        }
        if($row == '') {
            $data = $this->aDB->selectRow("SELECT * FROM `armory_itemdisplayinfo` WHERE `displayid`=?", $displayId);
        }
        else {
            $data = $this->aDB->selectCell("SELECT `".$row."` FROM `armory_itemdisplayinfo` WHERE `displayid`=?", $displayId);
        }
        return $data;
    }
    
    /**
     * IN_DEV
     **/
    public function GetEnchantmentInfo($id) {
        $spells = array();
        $spell_id = $this->aDB->selectRow("
        SELECT `spellid_1`, `spellid_2`, `spellid_3`, `type_1`, `type_2`, `type_3`
            FROM `armory_enchantment`
                WHERE `id`=?", $id);
        for($i=1;$i<4;$i++) {
            if($spell_id['type_'.$i] != 5) {
                $spells[$i] = $spell_id['spellid_'.$i];
            }
        }
        $item_id = $this->wDB->selectCell("
        SELECT `entry`
            FROM `item_template`
                WHERE `spellid_1` IN(?a) OR `spellid_2` IN(?a) OR `spellid_3` IN(?a) OR `spellid_4` IN(?a) OR `spellid_5` IN(?a) LIMIT 1",
                $spells, $spells, $spells, $spells, $spells);
        if(!$item_id) {
            return false;
        }
    }
    
    public function GetFactionEquivalent($itemID, $factionID) {
        if($factionID == 1) {
            // Got Horde
            $equivalent_id = $this->aDB->selectCell("SELECT `item_alliance` FROM `armory_item_equivalents` WHERE `item_horde`=?", $itemID);
        }
        elseif($factionID == 2) {
            // Got Horde
            $equivalent_id = $this->aDB->selectCell("SELECT `item_horde` FROM `armory_item_equivalents` WHERE `item_alliance`=?", $itemID);
        }
        if($equivalent_id > 0 && $info = $this->wDB->selectRow("SELECT `name`, `ItemLevel`, `Quality` FROM `item_template` WHERE `entry`=?", $equivalent_id)) {
            $item_data = array(
                'icon'    => self::getItemIcon($equivalent_id),
                'id'      => $equivalent_id,
                'level'   => $info['ItemLevel'],
                'name'    => ($this->_locale == 'en_gb' || $this->_locale == 'en_us') ? $info['name'] : self::getItemName($equivalent_id),
                'quality' => $info['Quality']
            );
            return $item_data;
        }
        return false;
    }
    
    public function GetItemSubTypeInfo($itemID, $tooltip=false) {
        $itemclassInfo = $this->wDB->selectRow("SELECT `class`, `subclass` FROM `item_template` WHERE `entry`=?", $itemID);
        if($tooltip) {
            return $this->aDB->selectCell("SELECT `subclass_name_".$this->_locale."` FROM `armory_itemsubclass` WHERE `class`=? AND `subclass`=?", $itemclassInfo['class'], $itemclassInfo['subclass']);
        }
        return $this->aDB->selectRow("SELECT `subclass_name_".$this->_locale."` AS `subclass_name`, `key` FROM `armory_itemsubclass` WHERE `class`=? AND `subclass`=?", $itemclassInfo['class'], $itemclassInfo['subclass']);
    }
}
?>