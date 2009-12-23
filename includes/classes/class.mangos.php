<?php

/**
 * @package World of Warcraft Armory
 * @version Release Candidate 1
 * @revision 30
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

Class Mangos extends Connector {
    
    public $searchTerms;
    public $searchCount;
    public $searchResults;
    
    public function getSpellInfo($spellID) {
        $tooltip = $this->aDB->selectCell("
		SELECT `tooltip`
			FROM `spells`
				WHERE `id`=? LIMIT 1", $spellID);
        if(!empty($tooltip)) {
            return $tooltip;
		}
		return false;
    }
    
    public function searchCharacters() {
        if(!$this->searchTerms) {
            return false;
        }
        if($this->searchCount == true) {
            $x = $this->cDB->selectPage($count, "
            SELECT `guid`
                FROM `characters`
                    WHERE `name` LIKE ?", '%'.$this->searchTerms.'%');
            return $count;
        }
        $this->searchResults = $this->cDB->select("
        SELECT `name`, `class`, `race`, `level`, `gender`
            FROM `characters`
                WHERE `name` LIKE ?", '%'.$this->searchTerms.'%');
        return true;
    }
    
    public function getSkillFromItemID($id) {
        if($id==0) {
            return SKILL_UNARMED;
        }
        $item = $this->wDB->selectRow("SELECT `class`, `subclass` FROM `item_template` WHERE `entry`=? LIMIT 1", $id);
        if(empty($item)) {
            return SKILL_UNARMED;
        }
        if($item['class']!=2) {
            return SKILL_UNARMED;
        }
        switch ($item['subclass']) {
                case 0: return SKILL_AXES;
                case 1: return SKILL_TWO_HANDED_AXE;
                case 2: return SKILL_BOWS;
                case 3: return SKILL_GUNS;
                case 4: return SKILL_MACES;
                case 5: return SKILL_TWO_HANDED_MACES;
                case 6: return SKILL_POLEARMS;
                case 7: return SKILL_SWORDS;
                case 8: return SKILL_TWO_HANDED_SWORDS;
                case 10: return SKILL_STAVES;
                case 13: return SKILL_FIST_WEAPONS;
                case 15: return SKILL_DAGGERS;
                case 16: return SKILL_THROWN;
                case 18: return SKILL_CROSSBOWS;
                case 19: return SKILL_WANDS;
        }
        return SKILL_UNARMED;
    }
    
    public function QuestInfo($quest, $infoType) {
        switch($infoType) {
            case "title":
                $info = $this->wDB->selectCell("SELECT `Title` FROM `quest_template` WHERE `entry`=?", $quest);
                $nameRus = $this->wDB->selectCell("SELECT `Title_loc8` FROM `locales_quest` WHERE `entry`=?", $quest);
                if(!empty($nameRus)) {
                    $info = $nameRus;
                }
				break;
            
            case "reqlevel":
				$info = $this->wDB->selectCell("SELECT `MinLevel` FROM `quest_template` WHERE `entry`=?", $quest);
				break;
				
			case "map":
				$quester = $this->wDB->selectCell("SELECT `id` FROM `creature_questrelation` WHERE `quest`=?", $quest);
				$mapID = $this->wDB->selectCell("SELECT `map` FROM `creature` WHERE `id`=?", $quester);
				$info = $this->aDB->selectCell("SELECT `name` FROM `maps` WHERE `id`=?", $mapID);
				break;
			}
        return $info;
    }
    
    public function DropPercent($percent) {
        if($percent>51) {
            $string = 'высокая (100%)';	
		}
		elseif($percent>25) {
		  $string = 'большая (51-100%)';
        }
        elseif($percent>15) {
            $string = 'низкая (15-24%)'; 
        }
        elseif($percent>1) {
            $string = 'крайне низкая (1-2%)';
        }
        elseif($percent<1) {
            $string = 'крайне низкая (0%)'; 
        }
        elseif($percent==0) {
            $string = 'неизвестно (0%)';
        }
        return $string;
    }
    
    public function GameobjectInfo($entry, $infoType) {
        switch($infoType) {
            case 'name':
                $locale = (isset($_SESSION['armoryLocale'])) ? $_SESSION['armoryLocale'] : $this->armoryconfig['defaultLocale'];
                switch($locale) {
                    case 'ru_ru':
                        $info = $this->wDB->selectCell("
                        SELECT `name_loc8`
                            FROM `locales_gameobject`
                                WHERE `entry`=?", $entry);
                    default:
                        $info = $this->wDB->selectCell("
                        SELECT `name`
                            FROM `gameobject_template`
                                WHERE `entry`=?", $entry);
                        break;
                }
				break;
            
            case 'map':
				$mapID = $this->wDB->selectCell("SELECT `map` FROM `gameobject` WHERE `id`=?", $entry);
				$info = $this->aDB->selectCell("SELECT `name` FROM `maps` WHERE `id`=?", $mapID);
				break;
		}
		return $info;
    }
    
    public function GetNPCName($npc) {
        $_locale = (isset($_SESSION['armoryLocale'])) ? $_SESSION['armoryLocale'] : $this->armoryconfig['defaultLocale'];
        $NPCName = $this->wDB->selectCell("
        SELECT `name`
            FROM `creature_template`
                WHERE `entry`=? LIMIT 1", $npc);        
        $NPCNameRU = $this->wDB->selectCell("
        SELECT `name_loc8`
            FROM `locales_creature`
                WHERE `entry`=? LIMIT 1", $npc);        
        $info = ($_locale=='ru_ru') ? $NPCNameRU : $NPCName;
		return $info;
	}
    
    public function GetNpcInfo($npc, $infoType) {
        $info = '';
		switch($infoType) {
            case "level":
				$info = $this->wDB->selectCell("SELECT `maxlevel` FROM `creature_template` WHERE `entry`=?", $npc);
				break;
				
			case "map":
				$mapID = $this->wDB->selectCell("SELECT `map` FROM `creature` WHERE `id`=? LIMIT 1", $npc);
				$info = $this->aDB->selectCell("SELECT `name` FROM `maps` WHERE `id`=?", $mapID);
				break;
            
            case "subname":
                $subname = $this->wDB->selectCell("SELECT `subname` FROM `creature_template` WHERE `entry`=? LIMIT 1", $npc);
                $subnameRus = $this->wDB->selectCell("SELECT `subname_loc8` FROM `locales_creature` WHERE `entry`=? LIMIT 1", $npc);
                $info = ($_SESSION['armoryLocale']=='ru_ru') ? $subnameRus : $subname;
                break;
				
			case "dungeonlevel":
                $query = $this->wDB->selectCell("
				SELECT `difficulty_entry_1`
					FROM `creature_template` 
						WHERE `entry`=? AND `difficulty_entry_1` <> 0", $npc);
				if(!empty($query)) {
					$info = '';
				}
				elseif($query!=0) {
					$info = '&nbsp;(Героический)';
				}
				else {
					$info = '';
				}
                break;
				
			case "isBoss": 
                $rank = $this->wDB->selectCell("SELECT `rank` FROM `creature_template` WHERE `entry`=? AND `rank`=3 LIMIT 1", $npc);
                if($rank) {
						$info = '&nbsp;Босс';
				}
				break;
		}
		return $info;
	}
    
    public function getMoney($money) {
        $getMoney['gold'] = floor($money/(100*100));
        $money = $money-$getMoney['gold']*100*100;
        $getMoney['silver'] = floor($money/100);
        $money = $money-$getMoney['silver']*100;
        $getMoney['copper'] = floor($money);
        return $getMoney;
    }
}
?>