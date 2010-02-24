<?php

/**
 * @package World of Warcraft Armory
 * @version Release Candidate 1
 * @revision 78
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
    
    /**
     * Returns item name according with defined locale (ru_ru or en_gb)
     * @category Items class
     * @example Items::getItemName(35000)
     * @return string
     **/
    public function getItemName($itemID) {
        $locale = (isset($_SESSION['armoryLocale'])) ? $_SESSION['armoryLocale'] : $this->armoryconfig['defaultLocale'];
        switch(strtolower($locale)) {
            case 'en_gb':
                $itemName = $this->wDB->selectCell("SELECT `name` FROM `item_template` WHERE `entry`=? LIMIT 1", $itemID);
                break;
            case 'ru_ru':
                $itemName = $this->wDB->selectCell("SELECT `name_loc8` FROM `locales_item` WHERE `entry`=? LIMIT 1", $itemID);
                if(!$itemName) {
                    // Lookup for original name
                    $itemName = $this->wDB->selectCell("SELECT `name` FROM `item_template` WHERE `entry`=? LIMIT 1", $itemID);
                }
                break;
            default:
                return false;
                break;
        }
        return $itemName;
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
    public function getItemDescription($itemID) {
        $locale = (isset($_SESSION['armoryLocale'])) ? $_SESSION['armoryLocale'] : $this->armoryconfig['defaultLocale'];
        switch(strtolower($locale)) {
            case 'en_gb':
                $itemDescription = $this->wDB->selectCell("SELECT `description` FROM `item_template` WHERE `entry`=? LIMIT 1", $itemID);
                break;
            case 'ru_ru':
                $itemDescription = $this->wDB->selectCell("SELECT `description_loc8` FROM `locales_item` WHERE `entry`=? LIMIT 1", $itemID);
                if(!$itemDescription) {
                    // Lookup for original name
                    $itemDescription = $this->wDB->selectCell("SELECT `description` FROM `item_template` WHERE `entry`=? LIMIT 1", $itemID);
                }
                break;
            default:
                return false;
                break;
        }
        return $itemDescription;
    }
    
    /**
     * Returns available races string (if mask > 0)
     * @category Items class
     * @example Items::AllowableRaces(690) // Horde only
     * @return string
     **/
    public function AllowableRaces($mask) {
        $mask&=0x7FF;
        $text = '';
        // Return zero if for all class (or for none
		if ($mask == 0x7FF OR $mask == 0) {
            return 0;
		}
        $locale = (isset($_SESSION['armoryLocale'])) ? $_SESSION['armoryLocale'] : $this->armoryconfig['defaultLocale'];
		$i=1;
		while($mask) {
			if($mask & 1) {
                $name = $this->aDB->selectCell("SELECT `name_" . $locale . "` FROM `armory_races` WHERE `id`=?", $i);
				$data = @$name; if ($data == "") $data = $i;
				$text.=$data;
				if($mask!=1) {
					$text.=", ";
				}
		   	}
			$mask>>=1;
			$i++;
		}
		return $text;
    }
    
    /**
     * Returns available classes string (if mask > 0)
     * @category Items class
     * @example Items::AllowableClasses(16) // Priests
     * @return string
     **/
    public function AllowableClasses($mask) {
		$mask&=0x5DF;
        $text = '';
		// Return zero if for all class (or for none
		if($mask==0x5DF || $mask==0) {
            return 0;
		}
        $locale = (isset($_SESSION['armoryLocale'])) ? $_SESSION['armoryLocale'] : $this->armoryconfig['defaultLocale'];
		$i=1;
		while($mask)
		{
			if($mask & 1) {
                $name = $this->aDB->selectCell("SELECT `name_" . $locale . "` FROM `armory_classes` WHERE `id`=?", $i);
				$data = @$name; if($data == "") $data = $i;
				$text.=$data;
				if ($mask!=1) {
					$text.=", ";
				}
	    	}
			$mask>>=1;
			$i++;
		}
		return $text;
	}
    
    /**
     * Returns item source strin (vendor, drop, chest loot, etc.)
     * @category Items class
     * @example Items::GetItemSource(35000)
     * @return string
     **/
    public function GetItemSource($item) {
        $locale = (isset($_SESSION['armoryLocale'])) ? $_SESSION['armoryLocale'] : $this->armoryconfig['defaultLocale'];
	    $returnString = false;
		$vendorLoot = $this->wDB->selectCell("
		SELECT `entry`
			FROM `npc_vendor`
				WHERE `item`=? LIMIT 1", $item);			
		$bossLoot = $this->wDB->selectCell("
		SELECT `entry`
			FROM `creature_loot_template`
				WHERE `item`=? LIMIT 1", $item);
        $chestLoot = $this->wDB->selectCell("
        SELECT `entry`
            FROM `gameobject_loot_template`
                WHERE `item`=? LIMIT 1", $item);
        $questLoot = $this->wDB->selectCell("
		SELECT `entry`
		  FROM `quest_template`
		      WHERE `RewChoiceItemId1` = ? OR `RewChoiceItemId2` = ? OR `RewChoiceItemId3` = ? OR 
		          `RewChoiceItemId4` = ? OR `RewChoiceItemId5` = ? OR `RewChoiceItemId6` = ? LIMIT 1", $item, $item, $item, 
		$item, $item, $item);
        $craftLoot = $this->aDB->selectCell("
        SELECT `id`
            FROM `armory_spell`
                WHERE `EffectItemType_1`=? OR `EffectItemType_2`=? OR `EffectItemType_3`=? LIMIT 1", $item, $item, $item);
        $reputationReward = $this->wDB->selectCell("SELECT `RequiredReputationFaction` FROM `item_template` WHERE `entry`=?", $item);
        if($bossLoot) {
            $returnString .= $this->aDB->selectCell("SELECT `string_" . $locale . "` FROM `armory_string` WHERE `id`=1");
        }
		if($vendorLoot && $reputationReward > 0) {
            if($returnString) {
		      $returnString .= ', ';
            }
			$returnString .= $this->aDB->selectCell("SELECT `string_" . $locale . "` FROM `armory_string` WHERE `id`=6");
		}
        elseif($vendorLoot && (!$reputationReward || $reputationReward == 0)) {
            if($returnString) {
		      $returnString .= ', ';
            }
			$returnString .= $this->aDB->selectCell("SELECT `string_" . $locale . "` FROM `armory_string` WHERE `id`=2");
        }
        //
        if($questLoot) {
            if($returnString) {
                $returnString .= ', ';
            }
            $returnString .= $this->aDB->selectCell("SELECT `string_" . $locale . "` FROM `armory_string` WHERE `id`=3");
        }
        if($chestLoot) {
            if($returnString) {
                $returnString .= ', ';
            }
            $returnString .= $this->aDB->selectCell("SELECT `string_" . $locale . "` FROM `armory_string` WHERE `id`=4");
        }
        if($craftLoot) {
            if($returnString) {
                $returnString .= ', ';
            }
            $returnString .= $this->aDB->selectCell("SELECT `string_" . $locale . "` FROM `armory_string` WHERE `id`=5");
        }
		return $returnString;
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
    
    /**
     * Returns itemset info: item pieces & bonuses.
     * @category Items class
     * @example Items::BuildItemSetInfo(870)
     * @todo Check & update itemset data in DB (some itemset pieces & bonuses are not displayed)
     * @return string
     **/
    public function BuildItemSetInfo($itemset) {
        $locale = (isset($_SESSION['armoryLocale'])) ? $_SESSION['armoryLocale'] : $this->armoryconfig['defaultLocale'];
        $itemSetBonuses = '';
        $itemsName='';
        $query = $this->aDB->selectRow("
        SELECT *
            FROM `armory_itemsetinfo`
                WHERE `id`=? LIMIT 1", $itemset);
        if(!$query) {
            return false;
        }
        $itemSetName = $query['name_'.$locale];
        $itemsCount = 0;
        for($i=1; $i !=9; $i++) {
            if($query['item'.$i] > 0) {
                $itemsCount++;
                $curName = $this->getItemName($query['item'.$i]);
                if($curName) {	// TODO: разобраться с сетами гладиаторов
                    $itemsName .= '<span class="setItemGray">'.$curName.'</span><br />';
                }
            }
        }
		
        for($i=1; $i<9; $i++) {
            if($query['bonus'.$i] > 0) {
                $spell_tmp = array();
                $spell_tmp = $this->aDB->selectRow("SELECT * FROM `armory_spell` WHERE `id`=?", $query['bonus'.$i]);
                $itemSetBonuses .= '<span class="setItemGray">('.$i.') ';
                $itemSetBonuses .=  ($locale == 'ru_ru') ? 'Комплект' : 'Set';
                if(!isset($spell_tmp['Description_'.$locale])) {
                    $spell_tmp['Description_'.$locale] = '';
                }
                $itemSetBonuses .=  ':&nbsp;'.$this->spellReplace($spell_tmp, Utils::validateText($spell_tmp['Description_'.$locale])).'</span><br />';
            }
		}
		$fullItemInfoString = sprintf('<span class="setNameYellow">%s (0/%s)</span><div class="setItemIndent"><br />%s<br />%s</div>', $itemSetName, $itemsCount, $itemsName, $itemSetBonuses);
		return $fullItemInfoString;
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
        $locale = (isset($_SESSION['armoryLocale'])) ? $_SESSION['armoryLocale'] : $this->armoryconfig['defaultLocale'];
        switch($vendor) {
			case 'vendor':
				$VendorLoot = $this->wDB->select("
				SELECT `entry`, `ExtendedCost`
					FROM `npc_vendor`
						WHERE `item`=?", $item);
				if(!empty($VendorLoot)) {
				    $i = 0;
					foreach($VendorLoot as $vItem) {
						$lootTable[$i] = array (
							'name' => Mangos::GetNpcName($vItem['entry']),
							'level'=> Mangos::GetNpcInfo($vItem['entry'], 'level'),
							'map' => Mangos::GetNpcInfo($vItem['entry'], 'map'),
                            'extended_cost' => Mangos::GetExtendedCost($vItem['ExtendedCost'])
						);
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
                               $lootTable[$i] = array (
                                    'entry' => $bItem['entry'],
        							'name' => Mangos::GetNpcName($bItem['entry']),
        							'level'=> Mangos::GetNpcInfo($bItem['entry'], 'level'),
        							'boss' => Mangos::GetNpcInfo($bItem['entry'], 'isBoss'),
        							'map' => Mangos::GetNpcInfo($bItem['entry'], 'map'),
        							'difficult' => Mangos::GetNpcInfo($bItem['entry'], 'dungeonlevel'),
                                    'instance_type' => Mangos::GetNpcInfo($bItem['entry'], 'instance_type'),
        						 	'drop_percent' => Mangos::DropPercent($bItem['ChanceOrQuestChance'])
    						  );
                              $i++;
					}
				}
                break;			
			case 'chest':
				$ChestLoot = $this->wDB->select("
				SELECT `entry`, `ChanceOrQuestChance`
					FROM `gameobject_loot_template`
						WHERE `item`=?", $item);
				if(!empty($ChestLoot)) {
				    $i = 0;
					foreach($ChestLoot as $cItem) {
                            $lootTable[$i] = array (
                                'name' => Mangos::GameobjectInfo($cItem['entry'], 'name'),
    							'map' => Mangos::GameobjectInfo($cItem['entry'], 'map'),
    							'difficult' => '&nbsp;',
    							'drop_percent' => Mangos::DropPercent($cItem['ChanceOrQuestChance'])
    						);
                            $i++;
					}
				}
                break;			
			case 'questreward':
				$QuestLoot = $this->wDB->select("
				SELECT `entry`, `MinLevel`
					FROM `quest_template`
						WHERE `RewChoiceItemId1` = ? OR `RewChoiceItemId2` = ? OR `RewChoiceItemId3` = ? OR 
						`RewChoiceItemId4` = ? OR `RewChoiceItemId5` = ? OR `RewChoiceItemId6` = ?", $item, $item, $item, 
						$item, $item, $item);
				if(!empty($QuestLoot)) {
				    $i = 0;
					foreach($QuestLoot as $qItem) {
						$lootTable[$i] = array (
							'title' => Mangos::QuestInfo($qItem['entry'], 'title'),
							'reqlevel' => $qItem['MinLevel'],
							'map' => Mangos::QuestInfo($qItem['entry'], 'map')
						);
                        $i++;
					}
				}
                break;            
            case 'queststart':
                $QuestStart = $this->wDB->selectCell("SELECT `startquest` FROM `item_template` WHERE `entry`=?", $item);
                if(!$QuestStart) {
                    return false;
                }
                $lootTable[0] = array(
                    'title' => Mangos::QuestInfo($QuestStart, 'title'),
                    'reqlevel' => Mangos::QuestInfo($QuestStart, 'reqlevel'),
                    'map' => Mangos::QuestInfo($QuestStart, 'map')
                );
                break;            
            case 'providedfor':
                $QuestInfo = $this->wDB->select("SELECT `entry`, `MinLevel` FROM `quest_template` WHERE `SrcItemId`=?", $item);
                if(!$QuestInfo) {
                    return false;
                }
                $i = 0;
                foreach($QuestInfo as $quest) {
                    $lootTable[$i] = array(
                        'title' => Mangos::QuestInfo($quest['entry'], 'title'),
                        'reqlevel' => $quest['MinLevel'],
                        'map' => Mangos::QuestInfo($quest['entry'], 'map')
                    );
                }                
                break;            
            case 'objectiveof':
                $QuestInfo = $this->wDB->select("
                SELECT `entry`, `MinLevel`
                    FROM `quest_template`
                        WHERE `ReqItemId1`=? OR `ReqItemId2`=? OR `ReqItemId3`=?
                        OR `ReqItemId4`=? OR `ReqItemId5`=?", $item, $item, $item, $item, $item);
                if(!$QuestInfo) {
                    return false;
                }
                $i = 0;
                foreach($QuestInfo as $quest) {
                    $lootTable[$i] = array(
                        'title' => Mangos::QuestInfo($quest['entry'], 'title'),
                        'reqlevel' => $quest['MinLevel'],
                        'map' => Mangos::QuestInfo($quest['entry'], 'map')
                    );
                }                
                break;            
            case 'item':
                $ItemLoot = $this->wDB->select("
                SELECT `entry`, `ChanceOrQuestChance`
                    FROM `item_loot_template`
                        WHERE `item`=?", $item);
                if(!empty($ItemLoot)) {
                    $i = 0;
                    foreach($ItemLoot as $iItem) {
                        $lootTable[$i] = array (
                            'name' => Items::GetItemName($iItem['entry']),
                            'drop_percent' => Mangos::DropPercent($iItem['ChanceOrQuestChance'])
                        );
                        $i++;
                    }
                }
                break;                
            case 'disenchant':
                $DisenchantLoot = $this->wDB->select("
                SELECT `item`, `ChanceOrQuestChance`, `maxcount`
                    FROM `disenchant_loot_template`
                        WHERE `entry`=?", $item);
                if(!empty($DisenchantLoot)) {
                    $i = 0;
                    foreach($DisenchantLoot as $dItem) {
                        $lootTable[$i] = array (
                            'entry' => $dItem['item'],
                            'name' => $this->GetItemName($dItem['item']),
                            'drop_percent' => Mangos::DropPercent($dItem['ChanceOrQuestChance']),
                            'count' => $dItem['maxcount'],
                            'icon' => $this->GetItemIcon($dItem['item'])
                        );
                        $i++;
                    }
                }
                break;                
            case 'craft':
                $CraftLoot = $this->aDB->select("
                    SELECT `Reagent_1`, `Reagent_2`, `Reagent_3`, `Reagent_4`, `Reagent_5`, `Reagent_6`, `Reagent_7`, `Reagent_8`,
                        `ReagentCount_1`, `ReagentCount_2`, `ReagentCount_3`, `ReagentCount_4`, `ReagentCount_5`, `ReagentCount_6`, 
                        `ReagentCount_7`, `ReagentCount_8`, `EffectItemType_1`, `EffectItemType_2`, `EffectItemType_3`,
                        `SpellName_".$locale."`
                        FROM `armory_spell`
                            WHERE `EffectItemType_1` =? OR `EffectItemType_2`=? OR `EffectItemType_3`=?", $item, $item, $item);
                if(!empty($CraftLoot)) {
                    $i=0;
                    foreach($CraftLoot as $craftItem) {
                        $lootTable[$i]['name'] = $craftItem['SpellName_'.$locale];
                        for($o=1;$o<9;$o++) {
                            if($craftItem['Reagent_'.$o] > 0) {
                                $lootTable[$i]['entry_reagent_'.$o] = $craftItem['Reagent_'.$o];
                                $lootTable[$i]['name_reagent_'.$o] = $this->GetItemName($craftItem['Reagent_'.$o]);
                                $lootTable[$i]['icon_reagent_'.$o] = $this->GetItemIcon($craftItem['Reagent_'.$o]);
                                $lootTable[$i]['count_reagent_'.$o] = $craftItem['ReagentCount_'.$o];
                            }
                        }
                        for($j=1;$j<4;$j++) {
                            if($craftItem['EffectItemType_'.$j] > 0) {
                                $lootTable[$i]['item_name_'.$j] = $this->GetItemName($craftItem['EffectItemType_'.$j]);
                                $lootTable[$i]['item_entry_'.$j] = $craftItem['EffectItemType_'.$j];
                                $lootTable[$i]['item_icon_'.$j] = $this->GetItemIcon($craftItem['EffectItemType_'.$j]);
                                $lootTable[$i]['item_quality_'.$j] = $this->GetItemInfo($craftItem['EffectItemType_'.$j], 'quality');
                            }
                        }
                        $i++;
                    }
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
                        `SpellName_".$locale."` AS `SpellName`
                        FROM `armory_spell`
                        WHERE `Reagent_1`=? OR `Reagent_2`=? OR `Reagent_3`=? OR `Reagent_4`=? OR 
                        `Reagent_5`=? OR `Reagent_6`=? OR `Reagent_7`=? OR `Reagent_8`=?", $item, $item, $item, $item, $item, $item, $item, $item);
                if($ReagentLoot) {
                    $i = 0;
                    foreach($ReagentLoot as $ReagentItem) {
                        for($j=1;$j<4;$j++) {
                            if($ReagentItem['EffectItemType_'.$j] > 0) {
                                $lootTable[$i]['item_entry'] = $ReagentItem['EffectItemType_'.$j];
                                $lootTable[$i]['item_name'] = $this->getItemName($ReagentItem['EffectItemType_'.$j]);
                                $lootTable[$i]['item_icon'] = $this->getItemIcon($ReagentItem['EffectItemType_'.$j]);
                                $lootTable[$i]['item_quality'] = $this->GetItemInfo($ReagentItem['EffectItemType_'.$j], 'quality');
                            }
                        }
                        for($o=1;$o<9;$o++) {
                            if($ReagentItem['Reagent_'.$o] > 0) {
                                $lootTable[$i]['Reagent_'.$o] = $ReagentItem['Reagent_'.$o];
                                $lootTable[$i]['ReagentIcon_'.$o] = $this->getItemIcon($ReagentItem['Reagent_'.$o]);
                                $lootTable[$i]['ReagentCount_'.$o] = $ReagentItem['ReagentCount_'.$o];
                            }
                        }
                        $i++;
                    }
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
        $locale = (isset($_SESSION['armoryLocale'])) ? $_SESSION['armoryLocale'] : $this->armoryconfig['defaultLocale'];
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
            $data['item'] = $this->aDB->selectCell("SELECT `gem` FROM `armory_enchantment` WHERE `id`=?", $socketInfo);
            $data['icon'] = $this->getItemIcon($data['item']);
            $data['enchant'] = $this->aDB->selectCell("SELECT `text_".$locale."` FROM `armory_enchantment` WHERE `id`=?", $socketInfo);
            $data['enchant_id'] = $socketInfo;
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
        $durability['current'] = $this->GetItemDataField(ITEM_FIELD_DURABILITY, $item, $guid);
        $durability['max'] = $this->GetItemDataField(ITEM_FIELD_MAXDURABILITY, $item, $guid);
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
            // l - размер последней величины == 1 ? 0 : 1
            if ($var[0]=='l')
            {
                $select = explode(':', substr($var, 1));
                $str.=@$select[$lastCount==1 ? 0:1];
            }
            // g - пол персонжа
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
}
?>