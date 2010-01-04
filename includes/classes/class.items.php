<?php

/**
 * @package World of Warcraft Armory
 * @version Release Candidate 1
 * @revision 40
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
    
    public $itemId;
    
    /**
     * $charGuid used by item-tooltip.php (enchantments, sockets & item durability for current character)
     **/
    public $charGuid;
    
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
    
    public function GetItemSource($item, $flag=false) {
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
		if($flag == true) {
            if($bossLoot) {
                return 0x01;
            }
            elseif($chestLoot) {
                return 0x02;
            }
		}
        if(!empty($bossLoot)) {
            $returnString .= $this->aDB->selectCell("SELECT `string_" . $locale . "` FROM `armory_string` WHERE `id`=1");
        }
		if(!empty($vendorLoot)) {
            if($returnString) {
		      $returnString .= ', ';
            }
			$returnString .= $this->aDB->selectCell("SELECT `string_" . $locale . "` FROM `armory_string` WHERE `id`=2");
		}
        if(!empty($questLoot)) {
            if($returnString) {
                $returnString .= ', ';
            }
            $returnString .= $this->aDB->selectCell("SELECT `string_" . $locale . "` FROM `armory_string` WHERE `id`=3");
        }
        if(!empty($chestLoot)) {
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
    
    public function BuildItemSetInfo($itemset) {
        $locale = (isset($_SESSION['armoryLocale'])) ? $_SESSION['armoryLocale'] : $this->armoryconfig['defaultLocale'];
        if($locale == 'en_gb') {
            $spell_locale = '_1';
        }
        else {
            $spell_locale = false;
        }
        $itemSetBonuses = '';
        $itemsName='';
        $query = $this->aDB->selectRow("
        SELECT *
            FROM `itemset`
                WHERE `id`=? LIMIT 1", $itemset);
        $itemSetName = $query['name'];
        $itemsCount = 0;
        for($i=1; $i !=9; $i++) {
            if($query['item_'.$i] > 0) {
                $itemsCount++;
                $curName = $this->getItemName($query['item_'.$i]);
                if($curName) {	// TODO: разобраться с сетами гладиаторов
                    $itemsName .= '<span class="setItemGray">'.$curName.'</span><br />';
                }
                    //setItem
            }
        }
		
        for($i=1; $i!=9; $i++) {
            if($query['bonus_'.$i] > 0) {
                $spell_tmp = $this->aDB->selectRow("SELECT * FROM `spell` WHERE `id`=?", $query['bonus_'.$i]);
                $itemSetBonuses .= '<span class="setItemGray">('.$i.') Комплект:&nbsp;'.$this->spellReplace($spell_tmp, Utils::validateText($spell_tmp['Description'.$spell_locale])).'</span><br />';
            }
		}
		$fullItemInfoString = sprintf('<span class="setNameYellow">%s (0/%s)</span><div class="setItemIndent"><br />%s<br />%s</div>', $itemSetName, $itemsCount, $itemsName, $itemSetBonuses);
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
            $data['enchant_id'] = $socketInfo;
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
    
    public function GetItemDataField($field, $itemGuid) {
        $dataField = $field+1;
        $qData = $this->cDB->selectCell("
        SELECT CAST(SUBSTRING_INDEX(SUBSTRING_INDEX(`data`, ' ', " . $dataField . "), ' ', '-1') AS UNSIGNED)  
            FROM `item_instance` 
				WHERE `guid`=?", $itemGuid);
        return $qData;
    }
    
    // CSWOWD
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
                    else                         $cacheSpellData[$lookup] = $this->getSpellData($this->aDB->selectRow("SELECT * FROM `spell` WHERE `id`=?", $lookup));
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
       if ($spell_duration = $this->aDB->selectRow("SELECT * FROM `spell_duration` WHERE `id`=?", $spell['DurationIndex']))
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
        eval("\$text = abs(".$text.");");
        return intval($text);
    }
}
?>