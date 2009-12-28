<?php

/**
 * @package World of Warcraft Armory
 * @version Release Candidate 1
 * @revision 38
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

session_start();

Class Items extends Connector {
    var $itemId;
    
    public function getItemName($itemID) {
        $locale = (isset($_SESSION['armoryLocale'])) ? $_SESSION['armoryLocale'] : $this->armoryconfig['defaultLocale'];
        switch($locale) {
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
    
    public function getItemIcon($itemID) {
        $displayId = $this->wDB->selectCell("SELECT `displayid` FROM `item_template` WHERE `entry`=? LIMIT 1", $itemID);
        $itemIcon = $this->aDB->selectCell("SELECT `icon` FROM `icons` WHERE `displayid`=? LIMIT 1", $displayId);
        return strtolower($itemIcon);
    }
    
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
                $name = $this->aDB->selectCell("SELECT `name_" . $locale . "` FROM `races` WHERE `id`=?", $i);
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
                $name = $this->aDB->selectCell("SELECT `name_" . $locale . "` FROM `classes` WHERE `id`=?", $i);
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
            FROM `spell`
                WHERE `EffectItemType_1`=? OR `EffectItemType_2`=? OR `EffectItemType_3`=? LIMIT 1", $item, $item, $item);
			
        if(!empty($bossLoot)) {
            $returnString .= $this->aDB->selectCell("SELECT `string_" . $locale . "` FROM `armory_string` WHERE `id`=1");
        }
		if(!empty($vendorLoot)) {
            if($returnString) {
		      $returnString .= ', ';
            }
			$returnString .= $this->aDB->selectCell("SELECT `string_" . $locale . "` FROM `armory_string` WHERE `id`=2");
		}
        if(!empty($chestLoot)) {
            if($returnString) {
                $returnString .= ', ';
            }
            $returnString .= $this->aDB->selectCell("SELECT `string_" . $locale . "` FROM `armory_string` WHERE `id`=3");
        }
        if(!empty($questLoot)) {
            if($returnString) {
                $returnString .= ', ';
            }
            $returnString .= $this->aDB->selectCell("SELECT `string_" . $locale . "` FROM `armory_string` WHERE `id`=4");
        }
        if(!empty($craftLoot)) {
            if($returnString) {
                $returnString .= ', ';
            }
            $returnString .= $this->aDB->selectCell("SELECT `string_" . $locale . "` FROM `armory_string` WHERE `id`=5");
        }
		return $returnString;
    }
    
    public function BuildItemSetInfo($itemset) {
        $itemSetBonuses = '';
        $itemsName='';
        $query = $this->aDB->selectRow("
        SELECT *
            FROM `itemset`
                WHERE `id`=? LIMIT 1", $itemset);
        $itemSetName = $query['name'];
        $itemsCount = 0;	
        //$equipped_itemsetinfo = explode(' ', $_SESSION['item_equip']);
        for($i=1; $i !=9; $i++) {
            if($query['item_'.$i] > 0) {
                $itemsCount++;
                $curName = $this->GetItemName($query['item_'.$i]);
                if(!empty($curName)) {	// TODO: разобраться с сетами гладиаторов
                    $itemsName .= '<span class="setItemGray">'.$curName.'</span><br />';
                }
                    //setItem
            }
        }
		
        for($i=1; $i!=9; $i++) {
            if($query['bonus_'.$i] > 0) {
                $itemSetBonuses .= '<span class="setItemGray">('.$i.') Комплект:&nbsp;'.
				Mangos::GetSpellInfo($query['bonus_'.$i]).'</span><br />';
            }
		}
		$fullItemInfoString = sprintf('<span class="setNameYellow">%s (0/%s)</span>
<div class="setItemIndent">
<br />
%s
<br />
%s
</div>
<br />', $itemSetName, $itemsCount, $itemsName, $itemSetBonuses);
			
		return $fullItemInfoString;
    }
    
    public function BuildLootTable($item, $vendor) {
        $lootTable = '';
        switch($vendor) {
			case 'vendor':
				$VendorLoot = $this->wDB->select("
				SELECT `entry`
					FROM `npc_vendor`
						WHERE `item`=?", $item);
				if(!empty($VendorLoot)) {
					foreach($VendorLoot as $vItem) {
						$lootTable[count($lootTable)] = array (
							'name' => Mangos::GetNpcName($vItem['entry']),
							'level'=> Mangos::GetNpcInfo($vItem['entry'], 'level'),
							'map' => Mangos::GetNpcInfo($vItem['entry'], 'map')
						);
					}
				}
			break;
			
			case 'boss':
				$BossLoot = $this->wDB->select("
				SELECT `entry`, `ChanceOrQuestChance`
					FROM `creature_loot_template`
						WHERE `item`=?", $item);
				if(!empty($BossLoot)) {
					foreach($BossLoot as $bItem) {
					    $map_npc = Mangos::GetNpcInfo($bItem['entry'], 'map');
                           if(!empty($map_npc)) {
                               $lootTable[count($lootTable)] = array (
                                    'entry' => $bItem['entry'],
        							'name' => Mangos::GetNpcName($bItem['entry']),
        							'level'=> Mangos::GetNpcInfo($bItem['entry'], 'level'),
        							'boss' => Mangos::GetNpcInfo($bItem['entry'], 'isBoss'),
        							'map' => $map_npc,
        							'difficult' => Mangos::GetNpcInfo($bItem['entry'], 'dungeonlevel'),
        						 	'drop_percent' => Mangos::DropPercent($bItem['ChanceOrQuestChance'])
    						  );
                        }
					}
				}
			break;
			
			case 'chest':
				$ChestLoot = $this->wDB->select("
				SELECT `entry`, `ChanceOrQuestChance`
					FROM `gameobject_loot_template`
						WHERE `item`=?", $item);
				if(!empty($ChestLoot)) {
					foreach($ChestLoot as $cItem) {
					    $map_chest = Mangos::GameobjectInfo($cItem['entry'], 'map');
                        if(!empty($map_chest)) {
                            $lootTable[count($lootTable)] = array (
                                'name' => Mangos::GameobjectInfo($cItem['entry'], 'name'),
    							'map' => $map_chest,
    							'difficult' => '&nbsp;',
    							'drop_percent' => Mangos::DropPercent($cItem['ChanceOrQuestChance'])
    						);
                        }
					}
				}
			break;
			
			case 'quest':
				$QuestLoot = $this->wDB->select("
				SELECT `entry`
					FROM `quest_template`
						WHERE `RewChoiceItemId1` = ? OR `RewChoiceItemId2` = ? OR `RewChoiceItemId3` = ? OR 
						`RewChoiceItemId4` = ? OR `RewChoiceItemId5` = ? OR `RewChoiceItemId6` = ?", $item, $item, $item, 
						$item, $item, $item);
				if(!empty($QuestLoot)) {
					foreach($QuestLoot as $qItem) {
						$lootTable[count($lootTable)] = array (
							'title' => Mangos::QuestInfo($qItem['entry'], 'title'),
							'reqlevel' => Mangos::QuestInfo($qItem['entry'], 'reqlevel'),
							'map' => Mangos::QuestInfo($qItem['entry'], 'map')
						);
					}
				}
			break;
            
            case 'item':
                $ItemLoot = $this->wDB->select("
                SELECT `entry`, `ChanceOrQuestChance`
                    FROM `item_loot_template`
                        WHERE `item`=?", $item);
                if(!empty($ItemLoot)) {
                    foreach($ItemLoot as $iItem) {
                        $lootTable[count($lootTable)] = array (
                            'name' => Items::GetItemName($iItem['entry']),
                            'drop_percent' => Mangos::DropPercent($iItem['ChanceOrQuestChance'])
                        );
                    }
                }
                break;
                
            case 'disenchant':
                $DisenchantLoot = $this->wDB->select("
                SELECT `item`, `ChanceOrQuestChance`, `maxcount`
                    FROM `disenchant_loot_template`
                        WHERE `entry`=?", $item);
                if(!empty($DisenchantLoot)) {
                    foreach($DisenchantLoot as $dItem) {
                        $lootTable[count($lootTable)] = array (
                            'entry' => $dItem['item'],
                            'name' => $this->GetItemName($dItem['item']),
                            'drop_percent' => Mangos::DropPercent($dItem['ChanceOrQuestChance']),
                            'count' => $dItem['maxcount'],
                            'icon' => $this->GetItemIcon($dItem['item'])
                        );
                    }
                }
                break;
                
            case 'craft':
                $CraftLoot = $this->aDB->select("
                    SELECT `Reagent_1`, `Reagent_2`, `Reagent_3`, `Reagent_4`, `Reagent_5`, `Reagent_6`, `Reagent_7`, `Reagent_8`,
                        `ReagentCount_1`, `ReagentCount_2`, `ReagentCount_3`, `ReagentCount_4`, `ReagentCount_5`, `ReagentCount_6`, 
                        `ReagentCount_7`, `ReagentCount_8`, `EffectItemType_1`, `EffectItemType_2`, `EffectItemType_3`,
                        `SpellName`
                        FROM `spell`
                            WHERE `EffectItemType_1` =? OR `EffectItemType_2`=? OR `EffectItemType_3`=?", $item, $item, $item);
                if(!empty($CraftLoot)) {
                    $i=0;
                    foreach($CraftLoot as $craftItem) {
                        $lootTable[$i]['name'] = $craftItem['SpellName'];
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
        }
		return $lootTable;
    }
    
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
     * Sockets
     **/
     
    public function extractSocketInfo($guid, $item, $socketNum) {
        $locale = (isset($_SESSION['armoryLocale'])) ? $_SESSION['armoryLocale'] : $this->armoryconfig['defaultLocale'];
        $data = array();
        $socketfield = array(
            1 => '29',
            2 => '32',
            3 => '35'
        );
        $socketInfo = $this->cDB->selectCell("
        SELECT CAST(SUBSTRING_INDEX(SUBSTRING_INDEX(`data`, ' ', ".$socketfield[$socketNum]."), ' ', '-1') AS UNSIGNED)  
            FROM `item_instance` 
                WHERE `owner_guid`=? AND CAST(SUBSTRING_INDEX(SUBSTRING_INDEX(`data`, ' ', 4), ' ', '-1') AS UNSIGNED) = ?", $guid, $item);
        if($socketInfo > 0) {
            $data['item'] = $this->aDB->selectCell("SELECT `gem` FROM `enchantment` WHERE `id`=?", $socketInfo);
            $data['icon'] = $this->getItemIcon($data['item']);
            $data['enchant'] = $this->aDB->selectCell("SELECT `text_".$locale."` FROM `enchantment` WHERE `id`=?", $socketInfo);
            return $data;
        }
        return false;
    }
    
    public function getItemDurability($guid, $item) {
        $durability['current'] = $this->cDB->selectCell("
        SELECT CAST(SUBSTRING_INDEX(SUBSTRING_INDEX(`data`, ' ', 62), ' ', '-1') AS UNSIGNED)  
            FROM `item_instance` 
                WHERE `owner_guid`=? AND CAST(SUBSTRING_INDEX(SUBSTRING_INDEX(`data`, ' ', 4), ' ', '-1') AS UNSIGNED) = ?", $guid, $item);
        $durability['max'] = $this->cDB->selectCell("
        SELECT CAST(SUBSTRING_INDEX(SUBSTRING_INDEX(`data`, ' ',    63), ' ', '-1') AS UNSIGNED)  
            FROM `item_instance` 
                WHERE `owner_guid`=? AND CAST(SUBSTRING_INDEX(SUBSTRING_INDEX(`data`, ' ', 4), ' ', '-1') AS UNSIGNED) = ?", $guid, $item);
        return $durability;
    }
}
?>