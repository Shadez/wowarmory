<?php

/**
 * @package World of Warcraft Armory
 * @version Release Candidate 1
 * @revision 47
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

Class Characters extends Connector {
    
    /**
     * Player GUID
     **/
    public $guid;
    
    /**
     * Player name
     **/
    public $name;
    
    /**
     * Player level
     **/
    public $level;
    
    /**
     * Player race
     **/
    public $race;
    
    /**
     * Player class
     **/
    public $class;
    
    /**
     * Player faction
     **/
    public $faction;
    
    /**
     * Player gender
     **/
    public $gender;
    
    /**
     * Character stat calculating variable
     **/
     public $rating;
    
    /******************************/
    /***  Basic character info  ***/
    /******************************/
    
    /**
     * Is character exists? !Requires $this->name!
     * @category Characters class
     * @example Characters::IsCharacter()
     * @return bool
     **/
    public function IsCharacter() {
        if(!$this->name) {
            return false;
        }
        $guid = $this->cDB->selectRow("
        SELECT `guid`, `account`
            FROM `characters`
                WHERE `name`=? AND `level`>=? LIMIT 1", $this->name, $this->armoryconfig['minlevel']);
        if(!$guid) {
            return false;
        }
        $gmAccount = $this->rDB->selectCell("SELECT `gmlevel` FROM `account` WHERE `id`=? LIMIT 1", $guid['account']);
        $showIt = ($gmAccount == $this->armoryconfig['minGmLevelToShow'] || $gmAccount < $this->armoryconfig['minGmLevelToShow']) ? true : false;
        if($guid && $showIt) {
            return true;
        }
        return false;
    }
    
    /**
     * Constructs basic character info
     * @category Characters class
     * @example Characters::_structCharacter()
     * @return bool
     **/
    public function _structCharacter() {
        if(!$this->name)
            return false;
        $this->GetCharacterGuid();
        $this->GetCharacterLevel();
        $this->GetCharacterRace();
        $this->GetCharacterClass();
        $this->GetCharacterFaction();
        $this->GetCharacterGender();
        return true;
    }
    
    /**
     * Returns character GUID. !Requires $this->name!
     * @category Characters class
     * @example Characters::GetCharacterGuid()
     * @return int
     **/ 
    public function GetCharacterGuid() {
        if(!$this->name) {
            return false;
        }
        $this->guid = $this->cDB->selectCell("SELECT `guid` FROM `characters` WHERE `name`=? LIMIT 1", $this->name);
        return $this->guid;
    }
    
    /**
     * Returns character name. !Requires $this->guid!
     * @category Characters class
     * @example Characters::GetCharacterName()
     * @return string
     **/
    public function GetCharacterName($guid = false) {
        if($guid) {
            $this->guid = $guid;
        }
        if(!$this->guid) {
            return false;
        }
        $this->name = $this->cDB->selectCell("SELECT `name` FROM `characters` WHERE `guid`=? LIMIT 1", $this->guid);
        return $this->name;
    }
    
    /**
     * Returns character level. !Requires $this->guid!
     * @category Characters class
     * @example Characters::GetCharacterLevel()
     * @return int
     **/
    public function GetCharacterLevel() {
        if(!$this->guid) {
            return false;
        }
        $this->level = $this->cDB->selectCell("SELECT `level` FROM `characters` WHERE `guid`=? LIMIT 1", $this->guid);
        return $this->level;
    }
    
    /**
     * Returns character race (int). !Requires $this->guid!
     * @category Characters class
     * @example Characters::GetCharacterRace()
     * @return int
     **/
    public function GetCharacterRace() {
        if(!$this->guid) {
            return false;
        }
        $this->race = $this->cDB->selectCell("SELECT `race` FROM `characters` WHERE `guid`=? LIMIT 1", $this->guid);
        return $this->race;
    }
    
    public function GetCharacterTitle($guid=false) {
        if($guid) {
            $this->guid = $guid;
        }
        $this->GetCharacterGender();
        $locale = (isset($_SESSION['armoryLocale'])) ? $_SESSION['armoryLocale'] : $this->armoryconfig['defaultLocale'];
        $title = $this->aDB->selectRow("SELECT * FROM `titles` WHERE `id`=?", $this->GetDataField(PLAYER_CHOSEN_TITLE));
        $data = array();
        if($title) {
            switch($this->gender) {
                case 1:
                    $data['title'] = $title['title_F_'.$locale];
                    break;
                case 0:
                    $data['title'] = $title['title_M_'.$locale];
                    break;
            }
            $data['place'] = $title['place'];
            return $data;
        }
        return false;
    }
    
    /**
     * Returns character class (int). !Requires $this->guid!
     * @category Characters class
     * @example Characters::GetCharacterClass()
     * @return int
     **/
    public function GetCharacterClass() {
        if(!$this->guid) {
            return false;
        }
        $this->class = $this->cDB->selectCell("SELECT `class` FROM `characters` WHERE `guid`=? LIMIT 1", $this->guid);
        return $this->class;
    }
    
    /**
     * Returns character gender (int). !Requires $this->race!
     * @category Characters class
     * @example Characters::GetCharacterGender()
     * @return int
     **/
    public function GetCharacterGender() {
        if(!$this->guid) {
            return false;
        }
        $this->gender = $this->cDB->selectCell("SELECT `gender` FROM `characters` WHERE `guid`=? LIMIT 1", $this->guid);
        return $this->gender;
    }
    
    /**
     * Returns character faction (int). !Requires $this->race!
     * @category Characters class
     * @example Characters::GetCharacterFaction()
     * @return int
     **/
    public function GetCharacterFaction($race=false) {
        // 1 - Horde, 0 - Alliance
        if(!$race) {
            $race = $this->race;
        }
        $this->faction = ($race==1 or $race==3 or $race==4 or $race==7 or $race==11) ? '0' : '1';
        return $this->faction;
    }
    
    /**
     * Returns string with 'r=realm&n=name&gn=guild' format. !Requires $this->race!
     * @category Characters class
     * @example Characters::returnCharacterUrl()
     * @return string
     **/
    public function returnCharacterUrl() {
        if(!$this->guid) {
            return false;
        }
        $url_string = 'r=' . urlencode($this->armoryconfig['defaultRealmName']) . '&amp;n=' . urlencode($this->name);
        if($this->GetDataField(PLAYER_GUILDID)) {
            // $guilds->guildId must be declared BEFORE this function!
            $url_string .= '&amp;gn=' . urlencode($this->cDB->selectCell("SELECT `name` FROM `guild` WHERE `guildid`=? LIMIT 1", $this->GetDataField(PLAYER_GUILDID)));
        }
        return $url_string;
    }
        
    /**
     * Returns character avatar path. !Requires $this->guid!
     * @category Characters class
     * @example Characters::characterAvatar()
     * @return string
     **/
    public function characterAvatar() {
        if($this->level == 80) {
            $avatar_path = 'wow-80/';
        }
        elseif($this->level > 70) {
            $avatar_path = 'wow-70/';
        }
        elseif($this->level > 60) {
            $avatar_path = 'wow/';
        }
        else {
            $avatar_path = 'wow-default/';
        }
        $avatar_path .= $this->gender . '-' . $this->race . '-' . $this->class . '.gif';
        return $avatar_path;
    }
    
    /**
     * Returns character class (text). !Requires $this->class!
     * @category Characters class
     * @example Characters::returnClassText()
     * @return string
     **/
    public function returnClassText($class='') {
        if($class=='') {
            if(!$this->class) {
                return false;
            }
            $class = $this->class;
        }        
        $text = $this->aDB->selectCell("
        SELECT `name_" . (isset($_SESSION['armoryLocale']) ? $_SESSION['armoryLocale'] : $this->armoryconfig['defaultLocale']) . "` 
            FROM `classes` 
                WHERE `id`=?", $class);
        return $text;
    }
    
    /**
     * Returns character race (text). !Requires $this->race!
     * @category Characters class
     * @example Characters::returnRaceText()
     * @return string
     **/
    public function returnRaceText($race='') {
        if($race=='') {
            if(!$this->race) {
                return false;
            }
            $race = $this->race;
        }
        $text = $this->aDB->selectCell("
        SELECT `name_" . (isset($_SESSION['armoryLocale']) ? $_SESSION['armoryLocale'] : $this->armoryconfig['defaultLocale']) . "` 
            FROM `races` 
                WHERE `id`=?", $race);
        return $text;
    }
    
    /**
     * Returns additional energy bar string (mana for paladins, mages, warlocks & hunters, etc.)
     * !Requires $this->class!
     * @category Characters class
     * @example Characters::assignAdditionalEnergybar()
     * @return string
     **/
    public function assignAdditionalEnergyBar() {
        if(!$this->class) {
            return false;
        }
        
        $mana = 'mana';
        $rage = 'rage';
        $energy = 'energy';
        $runic = 'runic';
        
        $mana_text = 'Мана|Mana';
        $rage_text = 'Ярость|Rage';
        $energy_text = 'Энергия|Energy';
        $runic_text = 'Сила рун|Runic power';
        
        $switch = array (
            '1' => $rage,
            '2' => $mana,
            '3' => $mana,
            '4' => $energy,
            '5' => $mana,
            '6' => $runic,
            '7' => $mana,
            '8' => $mana,
            '9' => $mana,
            '11'=> $mana
        );
        $switch_text = array (
            '1' => $rage_text,
            '2' => $mana_text,
            '3' => $mana_text,
            '4' => $energy_text,
            '5' => $mana_text,
            '6' => $runic_text,
            '7' => $mana_text,
            '8' => $mana_text,
            '9' => $mana_text,
            '11'=> $mana_text
        );
        $titles_locales = array ('en_gb' => 1, 'ru_ru' => 0);
        $text = explode('|', $switch_text[$this->class]);
        $data['title'] = (isset($_SESSION['armoryLocale'])) ? $text[$titles_locales[$_SESSION['armoryLocale']]] : $text[$titles_locales[$this->armoryconfig['defaultLocale']]];
        
        $data['class'] = $switch[$this->class];
        switch($this->class) {
            case 2:
            case 3:
            case 5:
            case 7:
            case 8:
            case 9:
            case 11:
                $data['value'] = $this->getManaValue();
                break;
            case 1:
                $data['value'] = $this->getRageValue();
                break;
            case 4:
            case 6:
                $data['value'] = $this->getEnergyValue();
                break;
        }
        return $data;
    }
    
    /*****************
    Function from MBA
    ******************/
    
    public function talentCounting($tab, $dualSpec = false, $spec='') {
        if(!$this->guid) {
            return false;
        }
        $pt = 0;
        if($dualSpec == true) {
            $resSpell = $this->cDB->select("
            SELECT `spell`
                FROM `character_talent`
                    WHERE `guid`=? AND `spec`=?", $this->guid, $spec);
        }
        else {
            $resSpell = $this->cDB->select("
            SELECT `spell`
                FROM `character_spell` 
    				WHERE `guid` = ? AND `disabled` = '0'", $this->guid);
        }
        if(!$resSpell) {
            return false;
        }
		foreach($resSpell as $getSpell) {
			$spells[] = $getSpell['spell'];
		}
		$resTal = $this->aDB->select("
		SELECT `rank1`, `rank2`, `rank3`, `rank4`, `rank5` 
			FROM `talent` 
				WHERE `ref_tab` = ?", $tab);
		foreach($resTal as $row) {
			$ranks[] = $row;
		}
		foreach($ranks as $key => $val) {
			foreach($spells as $k => $v) {
				if(in_array($v, $val)) {
					switch(array_search($v, $val)) {
						case "rank1": $pt += 1; break;
						case "rank2": $pt += 2; break;
						case "rank3": $pt += 3; break;
						case "rank4": $pt += 4; break;
						case "rank5": $pt += 5; break;
					}
				}
			}
		}
        return $pt;
	}
    
    public function getCharacterEquip($slot) {
        if(!$this->guid) {
            return false;
        }
        switch($slot) {
            case "head":
				$ItemInv = $this->GetDataField(PLAYER_VISIBLE_ITEM_1_ENTRYID);
                break;
            case "neck":
				$ItemInv = $this->GetDataField(PLAYER_VISIBLE_ITEM_2_ENTRYID);
				break;
			case "shoulder":
				$ItemInv = $this->GetDataField(PLAYER_VISIBLE_ITEM_3_ENTRYID);
				break;
			case "shirt":
				$ItemInv = $this->GetDataField(PLAYER_VISIBLE_ITEM_4_ENTRYID);
				break;
			case "chest":
				$ItemInv = $this->GetDataField(PLAYER_VISIBLE_ITEM_5_ENTRYID);
				break;
			case "wrist":
				$ItemInv = $this->GetDataField(PLAYER_VISIBLE_ITEM_6_ENTRYID);
				break;
			case "legs":
				$ItemInv = $this->GetDataField(PLAYER_VISIBLE_ITEM_7_ENTRYID);
				break;
			case "boots":
				$ItemInv = $this->GetDataField(PLAYER_VISIBLE_ITEM_8_ENTRYID);
				break;
			case "belt":
				$ItemInv = $this->GetDataField(PLAYER_VISIBLE_ITEM_9_ENTRYID);
				break;
			case "gloves":
				$ItemInv = $this->GetDataField(PLAYER_VISIBLE_ITEM_10_ENTRYID);
				break;
			case "ring1":
				$ItemInv = $this->GetDataField(PLAYER_VISIBLE_ITEM_11_ENTRYID);
				break;
			case "ring2":
				$ItemInv = $this->GetDataField(PLAYER_VISIBLE_ITEM_12_ENTRYID);
				break;
			case "trinket1":
				$ItemInv = $this->GetDataField(PLAYER_VISIBLE_ITEM_13_ENTRYID);
				break;
            case "trinket2":
				$ItemInv = $this->GetDataField(PLAYER_VISIBLE_ITEM_14_ENTRYID);
				break;
			case "back":
				$ItemInv = $this->GetDataField(PLAYER_VISIBLE_ITEM_15_ENTRYID);
				break;
			case "mainhand":
				$ItemInv = $this->GetDataField(PLAYER_VISIBLE_ITEM_16_ENTRYID);
				break;
			case "offhand":
				$ItemInv = $this->GetDataField(PLAYER_VISIBLE_ITEM_17_ENTRYID);
			    break;
			case "relic":
				$ItemInv = $this->GetDataField(PLAYER_VISIBLE_ITEM_18_ENTRYID);
				break;
			case "tabard":
				$ItemInv = $this->GetDataField(PLAYER_VISIBLE_ITEM_19_ENTRYID);
				break;
			default:
				$ItemInv = '0';
				break;
        }
        return $ItemInv;
    }
    
    public function getCharacterEnchant($slot, $guid='') {
        if(empty($guid)) {
            $guid = $this->guid;
        }
        switch($slot) {
            case "head":
				$ItemInv = $this->GetDataField(PLAYER_VISIBLE_ITEM_1_ENCHANTMENT, $guid);
                break;
            case "neck":
				$ItemInv = $this->GetDataField(PLAYER_VISIBLE_ITEM_2_ENCHANTMENT, $guid);
				break;
			case "shoulder":
				$ItemInv = $this->GetDataField(PLAYER_VISIBLE_ITEM_3_ENCHANTMENT, $guid);
				break;
			case "shirt":
				$ItemInv = $this->GetDataField(PLAYER_VISIBLE_ITEM_4_ENCHANTMENT, $guid);
				break;
			case "chest":
				$ItemInv = $this->GetDataField(PLAYER_VISIBLE_ITEM_5_ENCHANTMENT, $guid);
				break;
			case "wrist":
				$ItemInv = $this->GetDataField(PLAYER_VISIBLE_ITEM_6_ENCHANTMENT, $guid);
				break;
			case "legs":
				$ItemInv = $this->GetDataField(PLAYER_VISIBLE_ITEM_7_ENCHANTMENT, $guid);
				break;
			case "boots":
				$ItemInv = $this->GetDataField(PLAYER_VISIBLE_ITEM_8_ENCHANTMENT, $guid);
				break;
			case "belt":
				$ItemInv = $this->GetDataField(PLAYER_VISIBLE_ITEM_9_ENCHANTMENT, $guid);
				break;
			case "gloves":
				$ItemInv = $this->GetDataField(PLAYER_VISIBLE_ITEM_10_ENCHANTMENT, $guid);
				break;
			case "ring1":
				$ItemInv = $this->GetDataField(PLAYER_VISIBLE_ITEM_11_ENCHANTMENT, $guid);
				break;
			case "ring2":
				$ItemInv = $this->GetDataField(PLAYER_VISIBLE_ITEM_12_ENCHANTMENT, $guid);
				break;
			case "trinket1":
				$ItemInv = $this->GetDataField(PLAYER_VISIBLE_ITEM_13_ENCHANTMENT, $guid);
				break;
            case "trinket2":
				$ItemInv = $this->GetDataField(PLAYER_VISIBLE_ITEM_14_ENCHANTMENT, $guid);
				break;
			case "back":
				$ItemInv = $this->GetDataField(PLAYER_VISIBLE_ITEM_15_ENCHANTMENT, $guid);
				break;
			case "mainhand":
            case "stave":
				$ItemInv = $this->GetDataField(PLAYER_VISIBLE_ITEM_16_ENCHANTMENT, $guid);
				break;
			case "offhand":
            case "gun":
				$ItemInv = $this->GetDataField(PLAYER_VISIBLE_ITEM_17_ENCHANTMENT, $guid);
			    break;
			case "relic":
            case "sigil":
				$ItemInv = $this->GetDataField(PLAYER_VISIBLE_ITEM_18_ENCHANTMENT, $guid);
				break;
			case "tabard":
				$ItemInv = $this->GetDataField(PLAYER_VISIBLE_ITEM_19_ENCHANTMENT, $guid);
				break;
			default:
				$ItemInv = '0';
				break;
        }
        return $ItemInv;
    }
		
	/*****************
	Function from MBA
	******************/
	
    //get a tab from TalentTab
    public function getTabOrBuild($class, $type, $tabnum) {
        $locale = (isset($_SESSION['armoryLocale'])) ? $_SESSION['armoryLocale'] : $this->armoryconfig['defaultLocale'];
		if($type == "tab") {
			$field = $this->aDB->selectCell("
			SELECT `id`
				FROM `talenttab`
					WHERE `refmask_chrclasses` = ? AND `tab_number` = ? LIMIT 1", pow(2,($class-1)), $tabnum);
		}
		else {
			$field = $this->aDB->selectCell("
			SELECT `name_" . $locale . "`
				FROM `talenttab`
					WHERE `refmask_chrclasses` = ? AND `tab_number` = ? LIMIT 1", pow(2,($class-1)), $tabnum);
		}
		return $field;
	}
    
    /********************
	Function from CSWOWD
	********************/
    
    public function extractCharacterTalents($dualSpec=false, $specCount='') {
        if(!$this->class || !$this->guid) {
            return false;
        }
        $talentTabId = array(
            '1' => array(161,164,163), // Warior
            '2' => array(382,383,381), // Paladin
            '3' => array(361,363,362), // Hunter
            '4' => array(182,181,183), // Rogue
            '5' => array(201,202,203), // Priest
            '6' => array(398,399,400), // Death knight
            '7' => array(261,263,262), // Shaman
            '8' => array( 81, 41, 61), // Mage
            '9' => array(302,303,301), // Warlock
            '11'=> array(283,281,282), // Druid
        );
        $tab_set  = @$talentTabId[$this->class];
        if (!$tab_set){
            return;
        }
        if($dualSpec == true) {
            $spellList = $this->cDB->select("SELECT `spell` AS ARRAY_KEY  FROM `character_talent` WHERE `guid` = ?d and `spec` = ?", $this->guid, $specCount);
        }
        else {
            $spellList = $this->cDB->select("SELECT `spell` AS ARRAY_KEY  FROM `character_spell` WHERE `guid` = ?d and `disabled` = 0", $this->guid);
        }
        $bild = '';
        $tinfo = $this->aDB->select(
          "SELECT
           `TalentTab` AS ARRAY_KEY_1,
           `Row` AS ARRAY_KEY_2,
           `Col` AS ARRAY_KEY_3,
           `Rank_1`,
           `Rank_2`,
           `Rank_3`,
           `Rank_4`,
           `Rank_5`
          FROM `armory_talents` WHERE `TalentTab` IN (?a) ORDER BY `TalentTab`, `Row`, `Col`", $tab_set);
        $points = array(0, 0, 0);
        $total  = 0;
        $max    = 0;
        $name   = "Undefined";
        foreach($tab_set as $i=>$tab) {
            foreach($tinfo[$tab] as $row=>$rows)
                foreach($rows as $col=>$data) {
                    $rank = 0;
                    if (isset($spellList[$data['Rank_5']])) $rank = 5;
                    else if (isset($spellList[$data['Rank_4']])) $rank = 4;
                    else if (isset($spellList[$data['Rank_3']])) $rank = 3;
                    else if (isset($spellList[$data['Rank_2']])) $rank = 2;
                    else if (isset($spellList[$data['Rank_1']])) $rank = 1;
                    $bild.= $rank;
                    $points[$i]+=$rank;
                    $total+=$rank;
                }
            if($points[$i] > $max) {$max = $points[$i]; $name = $tab;}
        }
        return $bild;
    }
    
    public function extractCharacterGlyphs() {
        if(!$this->guid) {
            return false;
        }
        $locale = (isset($_SESSION['armoryLocale'])) ? $_SESSION['armoryLocale'] : $this->armoryconfig['defaultLocale'];
        $glyphData = array();
        $glyphData['big'] = array();
        $glyphData['small'] = array();
        $glyphFields = array('0' => 1319, '1' => 1320, '2' => 1321, '3' => 1322, '4' => 1323, '5' => 1324);
        for($i=0;$i<6;$i++) {
            $glyph_id = $this->GetDataField($glyphFields[$i]);
            $glyph_info = $this->aDB->selectRow("
            SELECT `type`, `name_".$locale."` AS `name`, `description_".$locale."` AS `description`
                FROM `glyphproperties` WHERE `id`=?", $glyph_id);
            if(!$glyph_info) {
                continue;
            }
            if($glyph_info['type'] == 0) {
                $glyphData['big'][$i] = $glyph_info;
            }
            elseif($glyph_info['type'] == 1) {
                $glyphData['small'][$i] = $glyph_info;
            }
        }
        return $glyphData;
    }
    
    public function ReturnTalentTreesNames($class, $key) {
		switch($class) {
			case 1:
				$trees = array('Оружие|Arms', 'Неистовство|Fury', 'Защита|Protection');
                break;
            case 2:
				$trees = array('Свет|Holy', 'Защита|Protection', 'Воздаяние|Retribution');
                break;
            case 3:
				$trees = array('Чувство зверя|Beast mastery', 'Стрельба|Marksmanship', 'Выживание|Survival');
                break;
            case 4:
				$trees = array('Ликвидация|Assassination', 'Бой|Combat', 'Скрытность|Subletly');
                break;
            case 5:
				$trees = array('Послушание|Discipline', 'Свет|Holy', 'Тьма|Shadow');
                break;
            case 6:
				$trees = array('Кровь|Blood', 'Лед|Frost', 'Нечестивость|Unholy');
                break;			
			case 7:
				$trees = array('Стихии|Elemental', 'Совершенствование|Enhancement', 'Исцеление|Restoration');
                break;			
			case 8:
				$trees = array('Тайная магия|Arcane', 'Огонь|Fire', 'Лед|Frost');
                break;			
			case 9:
				$trees = array('Колдовство|Affliction', 'Демонология|Demonology', 'Разрушение|Destruction');
                break;
			case 11:
				$trees = array('Баланс|Balance', 'Сила зверя|Feral Combat', 'Исцеление|Restoration');
                break;			
			default:
				$trees = array('Неизвестно|Unknown');
                break;
		}
        $name_locales = array ('en_gb' => 1, 'ru_ru' => 0);
        $name = $trees[$key];
        $name_exp = explode('|', $name);
        $tree = (isset($_SESSION['armoryLocale'])) ? $name_exp[$name_locales[$_SESSION['armoryLocale']]] : $name_exp[$name_locales[$this->armoryconfig['defaultLocale']]];
        return $tree;
	}
    
    public function ReturnTalentTreeIcon($class, $tree) {
        $icon = $this->aDB->selectCell("SELECT `icon` FROM `talent_icons` WHERE `class`=? AND `spec`=? LIMIT 1", $class, $tree);
        if($icon) {
            return $icon;
        }
        return false;
    }
    
    public function getCharacterHonorKills() {
        return $this->GetDataField(PLAYER_FIELD_LIFETIME_HONORBALE_KILLS);
    }
    
    public function extractCharacterProfessions() {
        // Извлекаем только 2 основные профессии. Первая помощь, кулинария и пр. сюда не входят
        $professions = $this->cDB->select("
        SELECT * FROM `character_skills`
            WHERE `skill` IN (164, 165, 171, 182, 186, 197, 202, 333, 393, 755, 773)
                AND `guid`=? LIMIT 2", $this->guid);
        if(!$professions) {
            return false;
        }
        $locale = (isset($_SESSION['armoryLocale'])) ? $_SESSION['armoryLocale'] : $this->armoryconfig['defaultLocale'];
        $p = array();
        $i = 0;
        foreach($professions as $prof) {
            $p[$i] = array(
                'name' => $this->aDB->selectCell("SELECT `name_" . $locale . "` FROM `professions` WHERE `id`=? LIMIT 1", $prof['skill']),
                'icon' => $this->aDB->selectCell("SELECT `icon` FROM `professions` WHERE `id`=? LIMIT 1", $prof['skill']),
                'value' => $prof['value'],
                'pct' => Utils::getPercent($prof['max'], $prof['value'])
            );
            $i++;
        }
        return $p;
    }
    
    public function getCharacterReputation() {
        if(!$this->guid) {
            return false;
        }
        $locale = (isset($_SESSION['armoryLocale'])) ? $_SESSION['armoryLocale'] : $this->armoryconfig['defaultLocale'];
        $repData = $this->cDB->select("SELECT `faction`, `standing`, `flags` FROM `character_reputation` WHERE `guid`=?", $this->guid); 
        if(!$repData) {
            return false;
        }
        $i = 0;
        foreach($repData as $faction) {
            if(!($faction['flags']&FACTION_FLAG_VISIBLE) || $faction['flags']&(FACTION_FLAG_HIDDEN|FACTION_FLAG_INVISIBLE_FORCED)) {
                continue;
            }
            $factionReputation[$i] = array(
                'name' => $this->aDB->selectCell("SELECT `name_".$locale."` FROM `faction` WHERE `id`=?", $faction['faction']),
                'descr' => $this->aDB->selectCell("SELECT `description_".$locale."` FROM `faction` WHERE `id`=?", $faction['faction']),
                'standings' => Utils::getReputation($faction['standing']),
                'standing' => $faction['standing']
            );
            $i++;
        }
        return $factionReputation;
    }
    
    /********************************************/
    /*** Grab character info from `data` blob ***/
    /********************************************/
    
    /**
     * Returns value of $fieldNum field. !Requires $this->guid or $guid as second parameter!
     * @category Characters class
     * @exapmle Characters::GetDataField(1203)
     * @return mixed
     **/
    public function GetDataField($fieldNum, $guid='') {
        if($guid=='') {
            $guid = $this->guid;
        }
        $dataField = $fieldNum+1;
        $qData = $this->cDB->selectCell("
        SELECT CAST(SUBSTRING_INDEX(SUBSTRING_INDEX(`data`, ' ', " . $dataField . "), ' ', '-1') AS UNSIGNED)  
            FROM `characters` 
				WHERE `guid`=?", $guid);
        return $qData;
    }
    
    // Health value
    public function getHealthValue() {
        return $this->GetDataField(UNIT_FIELD_HEALTH);
    }
    
    // Mana value
    public function getManaValue() {
        return $this->GetDataField(UNIT_FIELD_POWER1);
    }
    
    // Rage value
    public function getRageValue() {
        return $this->GetDataField(UNIT_FIELD_POWER2);
    }
    
    // Energy (or Runic power for DK) value
    public function getEnergyValue() {
        return $this->GetDataField(UNIT_FIELD_POWER4);
    }
    
    public function ConstructCharacterData() {
        $guid = $this->guid;
        $StatArray = array();
        $rating = Utils::GetRating($this->level);
        /* Basic data */
        $StatArray['effective_strenght'] = $this->GetDataField(UNIT_FIELD_STAT0);
        $StatArray['bonus_strenght'] = Utils::getFloatValue($this->GetDataField(UNIT_FIELD_POSSTAT0), 0);
        $StatArray['negative_strenght'] = Utils::getFloatValue($this->GetDataField(UNIT_FIELD_NEGSTAT0), 0);
        $StatArray['stat_strenght'] = $StatArray['effective_strenght']-$StatArray['bonus_strenght']-$StatArray['negative_strenght'];
        $StatArray['bonus_strenght_attackpower'] = Utils::GetAttackPowerForStat(STAT_STRENGTH, $StatArray['effective_strenght'], $this->class);
        if($this->class == CLASS_WARRIOR || $this->class == CLASS_PALADIN || $this->class == CLASS_SHAMAN) {
            $StatArray['bonus_strenght_block'] = max(0, $StatArray['effective_strenght']*BLOCK_PER_STRENGTH - 10);
        }
        else {
            $StatArray['bonus_strenght_block'] = '-1';
        }
        $StatArray['effective_agility'] =$this->GetDataField(UNIT_FIELD_STAT1);
        $StatArray['bonus_agility'] = Utils::getFloatValue($this->GetDataField(UNIT_FIELD_POSSTAT1), 0);
        $StatArray['negative_agility'] = Utils::getFloatValue($this->GetDataField(UNIT_FIELD_NEGSTAT1), 0);
        $StatArray['stat_agility'] = $StatArray['effective_agility']-$StatArray['bonus_agility']-$StatArray['negative_agility'];
        $StatArray['crit_agility'] = floor(Utils::GetCritChanceFromAgility($rating, $this->class, $StatArray['effective_agility']));
        $StatArray['bonus_agility_attackpower'] = Utils::GetAttackPowerForStat(STAT_AGILITY, $StatArray['effective_agility'], $this->class);
        $StatArray['bonus_agility_armor'] = $StatArray['effective_agility'] * ARMOR_PER_AGILITY;
        if($StatArray['bonus_agility_attackpower'] == 0) {
            $StatArray['bonus_agility_attackpower'] = '-1';
        }        
        $StatArray['effective_stamina'] = $this->GetDataField(UNIT_FIELD_STAT2);
        $StatArray['bonus_stamina'] = Utils::getFloatValue($this->GetDataField(UNIT_FIELD_POSSTAT2), 0);
        $StatArray['negative_stamina'] = Utils::getFloatValue($this->GetDataField(UNIT_FIELD_NEGSTAT2), 0);
        $StatArray['stat_stamina'] = $StatArray['effective_stamina']-$StatArray['bonus_stamina']-$StatArray['negative_stamina'];
        
        $StatArray['base_stamina'] = min(20, $StatArray['effective_stamina']);
        $StatArray['more_stamina'] = $StatArray['effective_stamina'] - $StatArray['base_stamina'];
        $StatArray['bonus_stamina_health'] = $StatArray['base_stamina'] + ($StatArray['more_stamina'] * HEALTH_PER_STAMINA);
        $StatArray['bonus_stamina_petstamina'] = Utils::ComputePetBonus(2, $StatArray['effective_stamina'], $this->class);
        if($StatArray['bonus_stamina_petstamina'] == 0) {
            $StatArray['bonus_stamina_petstamina'] = '-1';
        }
        $StatArray['effective_intellect'] =$this->GetDataField(UNIT_FIELD_STAT3);
        $StatArray['bonus_intellect'] = Utils::getFloatValue($this->GetDataField(UNIT_FIELD_POSSTAT3), 0);
        $StatArray['negative_intellect'] = Utils::getFloatValue($this->GetDataField(UNIT_FIELD_NEGSTAT3), 0);
        $StatArray['stat_intellect'] = $StatArray['effective_intellect']-$StatArray['bonus_intellect']-$StatArray['negative_intellect'];
        if($this->class != CLASS_WARRIOR && $this->class != CLASS_ROGUE && $this->class != CLASS_DK) {
            $StatArray['base_intellect'] = min(20, $StatArray['effective_intellect']);
            $StatArray['more_intellect'] = $StatArray['effective_intellect']-$StatArray['base_intellect'];
            $StatArray['mana_intellect'] = $StatArray['base_intellect']+$StatArray['more_intellect']*MANA_PER_INTELLECT;
            $StatArray['bonus_intellect_spellcrit'] = Utils::GetSpellCritChanceFromIntellect($rating, $this->class, $StatArray['effective_intellect']);
        }
        else {
            $StatArray['base_intellect'] = '-1';
            $StatArray['more_intellect'] = '-1';
            $StatArray['mana_intellect'] = '-1';
            $StatArray['bonus_intellect_spellcrit'] = '-1';
        }
        $StatArray['bonus_intellect_petintellect'] = Utils::ComputePetBonus(7, $StatArray['effective_intellect'], $this->class);
        if($StatArray['bonus_intellect_petintellect'] == 0) {
            $StatArray['bonus_intellect_petintellect'] = '-1';
        }
        
        $StatArray['effective_spirit'] =$this->GetDataField(UNIT_FIELD_STAT4);
        $StatArray['bonus_spirit'] = Utils::getFloatValue($this->GetDataField(UNIT_FIELD_POSSTAT4), 0);
        $StatArray['negative_spirit'] = Utils::getFloatValue($this->GetDataField(UNIT_FIELD_NEGSTAT4), 0);
        $StatArray['stat_spirit'] = $StatArray['effective_spirit']-$StatArray['bonus_spirit']-$StatArray['negative_spirit'];
        $baseRatio = array(0, 0.625, 0.2631, 0.2, 0.3571, 0.1923, 0.625, 0.1724, 0.1212, 0.1282, 1, 0.1389);
        $StatArray['bonus_spirit_hpregeneration'] = $StatArray['effective_spirit'] * Utils::GetHRCoefficient($rating, $this->class);
        $StatArray['base_spirit'] = $StatArray['effective_spirit'];
        if($StatArray['base_spirit'] > 50) {
            $StatArray['base_spirit'] = 50;
        }
        $StatArray['more_spirit'] = $StatArray['effective_spirit'] - $StatArray['base_spirit'];
        $StatArray['bonus_spirit_hpregeneration'] = $StatArray['base_spirit'] * $baseRatio[$this->class] + $StatArray['more_spirit'] * Utils::GetHRCoefficient($rating, $this->class);
        
        if($this->class != CLASS_WARRIOR && $this->class != CLASS_ROGUE && $this->class != CLASS_DK) {
            $StatArray['bonus_spitit_manaregeneration'] = sqrt($StatArray['effective_intellect']) * $StatArray['effective_spirit'] * Utils::GetMRCoefficient($rating, $this->class);
            $StatArray['bonus_spitit_manaregeneration'] = floor($StatArray['bonus_spitit_manaregeneration']*5);
        }
        else {
            $StatArray['bonus_spitit_manaregeneration'] = '-1';
        }
        
        $StatArray['effective_armor'] = $this->GetDataField(UNIT_FIELD_RESISTANCES);
        $StatArray['bonus_armor'] = Utils::getFloatValue($this->GetDataField(UNIT_FIELD_RESISTANCEBUFFMODSPOSITIVE), 0);
        $StatArray['negative_armor'] = Utils::getFloatValue($this->GetDataField(UNIT_FIELD_RESISTANCEBUFFMODSNEGATIVE), 0);
        $StatArray['stat_armor'] = $StatArray['effective_armor']-$StatArray['bonus_armor']-$StatArray['negative_armor'];
        if($this->level > 59 ) {
            $levelModifier = $this->level + (4.5 * ($this->level-59));
        }
        $StatArray['bonus_armor_reduction'] = 0.1*$StatArray['effective_armor']/(8.5*$levelModifier + 40);
    	$StatArray['bonus_armor_reduction'] = $StatArray['bonus_armor_reduction']/(1+$StatArray['bonus_armor_reduction'])*100;
    	if ($StatArray['bonus_armor_reduction'] > 75) $StatArray['bonus_armor_reduction'] = 75;
    	if ($StatArray['bonus_armor_reduction'] <  0) $StatArray['bonus_armor_reduction'] = 0;
        $StatArray['bonus_armor_petbonus'] = Utils::ComputePetBonus(4, $StatArray['effective_armor'], $this->class);
        if($StatArray['bonus_armor_petbonus'] == 0) {
            $StatArray['bonus_armor_petbonus'] = '-1';
        }
        
        /* Melee stats */
        $StatArray['min_melee_dmg'] = Utils::getFloatValue($this->GetDataField(UNIT_FIELD_MINDAMAGE), 0);
        $StatArray['max_melee_dmg'] = Utils::getFloatValue($this->GetDataField(UNIT_FIELD_MAXDAMAGE), 0);
        $StatArray['speed_melee_dmg'] = Utils::getFloatValue($this->GetDataField(UNIT_FIELD_BASEATTACKTIME), 2)/1000;
        $StatArray['melee_dmg'] = ($StatArray['min_melee_dmg'] + $StatArray['max_melee_dmg']) * 0.5;
        $StatArray['dps_melee_dmg'] = (max($StatArray['melee_dmg'], 1) / $StatArray['speed_melee_dmg']);
        if($StatArray['speed_melee_dmg'] < 0.1) {
            $StatArray['speed_melee_dmg'] = '0.1';
        }
        
        $StatArray['hasterating_melee_dmg'] = $this->GetDataField(1220);
        $StatArray['hastepct_melee_dmg'] = $StatArray['hasterating_melee_dmg'] / Utils::GetRatingCoefficient($rating, 19);
        
        $StatArray['multipler_melee_ap'] = Utils::getFloatValue($this->GetDataField(UNIT_FIELD_ATTACK_POWER_MULTIPLIER), 8);
        if($StatArray['multipler_melee_ap'] < 0) {
            $StatArray['multipler_melee_ap'] = 0;
        }
        else {
            $StatArray['multipler_melee_ap']+=1;
        }
        $StatArray['effective_melee_ap'] = $this->GetDataField(UNIT_FIELD_ATTACK_POWER) * $StatArray['multipler_melee_ap'];
        $StatArray['bonus_melee_ap'] = $this->GetDataField(UNIT_FIELD_ATTACK_POWER_MODS) * $StatArray['multipler_melee_ap'];
        $StatArray['stat_melee_ap'] = $StatArray['effective_melee_ap'] + $StatArray['bonus_melee_ap'];
        $StatArray['bonus_ap_dps'] = floor(max($StatArray['stat_melee_ap'], 0)/14);
                
        $StatArray['melee_hit_rating'] = $this->GetDataField(1208);
        $StatArray['melee_hit_ratingpct'] = floor($StatArray['melee_hit_rating']/Utils::GetRatingCoefficient($rating, 6));
        $StatArray['melee_hit_penetration'] = $this->GetDataField(PLAYER_FIELD_MOD_TARGET_PHYSICAL_RESISTANCE);
        
        $StatArray['melee_crit'] = Utils::getFloatValue($this->GetDataField(PLAYER_CRIT_PERCENTAGE), 2);
        $StatArray['melee_crit_rating'] = $this->GetDataField(1211);
        $StatArray['melee_crit_ratingpct'] = floor($StatArray['melee_crit_rating']/Utils::GetRatingCoefficient($rating, 9));
        
        $StatArray['melee_skill_id'] = Utils::getSkillFromItemID($this->getCharacterEquip('mainhand'));
        $character_data = $this->cDB->selectCell("SELECT `data` FROM `characters` WHERE `guid`=?", $this->guid);
        $StatArray['melee_skill'] = Utils::getSkill($StatArray['melee_skill_id'], $character_data);
        $StatArray['melee_skill_defrating'] = $this->GetDataField(1223);
        $StatArray['melee_skill_ratingadd'] = $StatArray['melee_skill_defrating']/Utils::GetRatingCoefficient($rating, 2);
        $buff = $StatArray['melee_skill'][4]+$StatArray['melee_skill'][5]+intval($StatArray['melee_skill_ratingadd']);
        $StatArray['stat_melee_skill'] = $StatArray['melee_skill'][2]+$buff;
        
        
        $StatArray['defense_rating_skill'] = Utils::getSkill(SKILL_DEFENCE, $character_data);
        $StatArray['rating_defense'] = $this->GetDataField(1204);
        $StatArray['rating_defense_add'] = $StatArray['rating_defense']/Utils::GetRatingCoefficient($rating, 2);
        $buff = $StatArray['defense_rating_skill'][4]+$StatArray['defense_rating_skill'][5]+intval($StatArray['rating_defense_add']);
        $StatArray['stat_defense_rating'] = $StatArray['rating_defense_add'][2]+$buff;
        $StatArray['defense_percent'] = DODGE_PARRY_BLOCK_PERCENT_PER_DEFENSE * ($StatArray['stat_defense_rating'] - $this->level*5);
        $StatArray['defense_percent'] = max($StatArray['defense_percent'], 0);
        unset($character_data);
        
        $rating = Utils::GetRating($this->level);
        $StatArray['dodge_chance'] = Utils::getFloatValue($this->GetDataField(PLAYER_DODGE_PERCENTAGE), 2);
        $StatArray['stat_dodge'] = $this->GetDataField(PLAYER_FIELD_DODGE_RATING);
        $StatArray['stat_dodge_pct'] = floor($StatArray['stat_dodge']/Utils::GetRatingCoefficient($rating, 3));
        
        $StatArray['parry_chance'] = Utils::getFloatValue($this->GetDataField(PLAYER_PARRY_PERCENTAGE), 2);
        $StatArray['stat_parry'] = $this->GetDataField(PLAYER_FIELD_PARRY_RATING);
        $StatArray['stat_parry_pct'] = floor($StatArray['stat_parry']/Utils::GetRatingCoefficient($rating, 4));
        
        $StatArray['melee_resilence'] = $this->GetDataField(PLAYER_FIELD_CRIT_TAKEN_MELEE_RATING);
        $StatArray['ranged_resilence'] = $this->GetDataField(PLAYER_FIELD_CRIT_TAKEN_RANGED_RATING);
        $StatArray['spell_resilence'] = $this->GetDataField(PLAYER_FIELD_CRIT_TAKEN_SPELL_RATING);
        
        $StatArray['min_resilence'] = min($StatArray['melee_resilence'], $StatArray['ranged_resilence'], $StatArray['spell_resilence']);
        
        $StatArray['melee_resilence_pct'] = $StatArray['melee_resilence']/Utils::GetRatingCoefficient($rating, 15);
        $StatArray['ranged_resilence_pct'] = $StatArray['ranged_resilence']/Utils::GetRatingCoefficient($rating, 16);
        $StatArray['spell_resilence_pct'] = $StatArray['spell_resilence']/Utils::GetRatingCoefficient($rating, 17);
        
        $StatArray['mana_regen_out_of_cast'] = $this->GetDataField(UNIT_FIELD_POWER_REGEN_FLAT_MODIFIER);
        $StatArray['mana_regen_cast'] = $this->GetDataField(UNIT_FIELD_POWER_REGEN_INTERRUPTED_FLAT_MODIFIER);
        $StatArray['mana_regen_out_of_cast'] =  Utils::getFloatValue($StatArray['mana_regen_out_of_cast'],2)*5;
        $StatArray['mana_regen_cast'] =  Utils::getFloatValue($StatArray['mana_regen_cast'],2)*5;
         
        
        $holySchool = 1;
        $minModifier = Utils::GetSpellBonusDamage($holySchool, $guid);
        for ($i=$holySchool;$i<7;$i++) {
            $bonusDamage[$i] = Utils::GetSpellBonusDamage($i, $guid);
            $minModifier = min($minModifier, $bonusDamage);
        }
        $StatArray['spd_holy'] = $bonusDamage[1];
        $StatArray['spd_fire'] = $bonusDamage[2];
        $StatArray['spd_nature'] = $bonusDamage[3];
        $StatArray['spd_frost'] = $bonusDamage[4];
        $StatArray['spd_arcane'] = $bonusDamage[5];
        $StatArray['spd_shadow'] = $bonusDamage[6];
        $StatArray['pet_bonus_ap'] = '-1';
        $StatArray['pet_bonus_dmg'] = '-1';
        if($this->class==3 || $this->class==9) {
            $shadow = Utils::GetSpellBonusDamage(5, $guid);
            $fire = Utils::GetSpellBonusDamage(2, $guid);
            $StatArray['pet_bonus_ap'] =  Utils::ComputePetBonus(6, max($shadow, $fire), $this->class);
            $StatArray['pet_bonus_dmg'] =  Utils::ComputePetBonus(5, max($shadow, $fire), $this->class);
        }
        
        // spell heal bonus
        $StatArray['heal_bonus'] = $this->GetDataField(PLAYER_FIELD_MOD_HEALING_DONE_POS);
        // spell haste
        $StatArray['spell_haste_rating'] = $this->GetDataField(1222);
        $StatArray['spell_haste_pct'] = $StatArray['spell_haste_rating']/ Utils::GetRatingCoefficient($rating, 20);
        // spell hit
        $StatArray['spell_hit_rating'] = $this->GetDataField(1210);
        $StatArray['spell_hit_pct'] = floor($StatArray['spell_hit_rating']/ Utils::GetRatingCoefficient($rating, 8));
        $StatArray['spell_hit_penetration'] = $this->GetDataField(PLAYER_FIELD_MOD_TARGET_RESISTANCE);
        // Spell crit
        $StatArray['spell_crit_rating'] = $this->GetDataField(1213);
        $StatArray['spell_crit_pct'] = $StatArray['spell_crit_rating']/ Utils::GetRatingCoefficient($rating, 11);
        $minCrit = $this->GetDataField(PLAYER_SPELL_CRIT_PERCENTAGE1+1);
        for($i=1;$i<7;$i++) {
            $scfield = PLAYER_SPELL_CRIT_PERCENTAGE1+$i;
            $s_crit_value = $this->GetDataField($scfield);
            $spellCrit[$i] =  Utils::getFloatValue($s_crit_value, 2);
            $minCrit = min($minCrit, $spellCrit[$i]);
        }
        $StatArray['spell_crit_holy'] = $spellCrit[1];
        $StatArray['spell_crit_fire'] = $spellCrit[2];
        $StatArray['spell_crit_nature'] = $spellCrit[3];
        $StatArray['spell_crit_frost'] = $spellCrit[4];
        $StatArray['spell_crit_arcane'] = $spellCrit[5];
        $StatArray['spell_crit_shadow'] = $spellCrit[6];
        
        // block
        $blockvalue = $this->GetDataField(PLAYER_BLOCK_PERCENTAGE);
        $StatArray['block_pct'] =  Utils::getFloatValue($blockvalue,2);
        $StatArray['block_rating'] = $this->GetDataField(1207);
        //TODO: block %
        $StatArray['block_chance'] = $this->GetDataField(PLAYER_SHIELD_BLOCK);
        // ranged attack power
        $multipler =  Utils::getFloatValue($this->GetDataField(UNIT_FIELD_RANGED_ATTACK_POWER_MULTIPLIER), 8);
        if($multipler < 0) {
            $multipler = 0;
        }
        else {
            $multipler+=1;
        }
        $effectiveStat = $this->GetDataField(UNIT_FIELD_RANGED_ATTACK_POWER)*$multipler;
        $buff = $this->GetDataField(UNIT_FIELD_RANGED_ATTACK_POWER_MODS)*$multipler;
        $multiple =  Utils::getFloatValue($this->GetDataField(UNIT_FIELD_RANGED_ATTACK_POWER_MULTIPLIER),2);
        $posBuff = 0;
        $negBuff = 0;
        if($buff > 0) {
            $posBuff = $buff;
        }
        elseif($buff < 0) {
            $negBuff = $buff;
        }
        $stat = $effectiveStat+$buff;
        $StatArray['ranged_base'] = floor($effectiveStat);
        $StatArray['ranged_effective'] = floor($stat);
        $StatArray['ranged_dps_ap'] = floor(max($stat, 0)/14);
        $StatArray['ranged_pet_ap'] = floor( Utils::ComputePetBonus(0, $stat, $this->class));
        $StatArray['ranged_pet_spd'] = floor( Utils::ComputePetBonus(1, $stat, $this->class));
        
        // ranged speed
        $rangedSkillID = Mangos::getSkillFromItemID($this->GetDataField(PLAYER_VISIBLE_ITEM_18_ENTRYID));
        if($rangedSkillID == SKILL_UNARMED) {
            $StatArray['ranged_speed'] = '0';
            $StatArray['ranged_speed_rating'] = '0';
            $StatArray['ranged_speed_pct'] = '0';
        }
        else {
            $StatArray['ranged_speed'] = round( Utils::getFloatValue($this->GetDataField(UNIT_FIELD_RANGEDATTACKTIME),2)/1000);
            $StatArray['ranged_speed_rating'] = round($this->GetDataField(1221));
            $StatArray['ranged_speed_pct'] = $StatArray['ranged_speed_rating']/ Utils::GetRatingCoefficient($rating, 19);
        }
        
        // ranged hit rating
        $StatArray['ranged_hit'] = $this->GetDataField(1209);
        $StatArray['ranged_hit_pct'] = floor($StatArray['ranged_hit']/ Utils::GetRatingCoefficient($rating, 7));
        $StatArray['ranged_hit_penetration'] = $this->GetDataField(PLAYER_FIELD_MOD_TARGET_PHYSICAL_RESISTANCE);
        
        // ranged crit
        $StatArray['ranged_crit'] =  Utils::getFloatValue($this->GetDataField(PLAYER_RANGED_CRIT_PERCENTAGE), 2);
        $StatArray['ranged_crit_rating'] = $this->GetDataField(1212);
        $StatArray['ranged_crit_pct'] = floor($StatArray['ranged_crit_rating']/ Utils::GetRatingCoefficient($rating, 10));
        if($rangedSkillID == SKILL_UNARMED) {
            $StatArray['ranged_dps'] = 0;
            $StatArray['ranged_dps_min'] = 0;
            $StatArray['ranged_dps_max'] = 0;
            $StatArray['ranged_dps_speed'] = 0;
            $StatArray['ranged_dps_pct'] = 0;
        }
        else {
            $StatArray['ranged_dps_min'] =  Utils::getFloatValue($this->GetDataField(UNIT_FIELD_MINRANGEDDAMAGE), 0);
            $StatArray['ranged_dps_max'] =  Utils::getFloatValue($this->GetDataField(UNIT_FIELD_MAXRANGEDDAMAGE), 0);
            $StatArray['ranged_dps_speed'] = round( Utils::getFloatValue($this->GetDataField(UNIT_FIELD_RANGEDATTACKTIME), 2)/1000, 2);
            $StatArray['ranged_dps'] = ($StatArray['ranged_dps_min'] + $StatArray['ranged_dps_max']) * 0.5;
            if($StatArray['ranged_dps_speed'] < 0.1) {
                $StatArray['ranged_dps_speed'] = 0.1;
            }
            $StatArray['ranged_dps_pct'] = round((max($StatArray['ranged_dps'], 1) / $StatArray['ranged_dps_speed']));
        }
        
        
        return $StatArray;
    }
    
    public function getCharacterSkill($skill, $guid=false) {
        if($guid) {
            $this->guid = $guid;
        }
        if(!$this->guid) {
            return false;
        }
        $skillInfo = $this->cDB->selectRow("SELECT * FROM `character_skill` WHERE `guid`=? AND `skill`=?", $this->guid, $skill);
        return $skillInfo;
    }
}
?>