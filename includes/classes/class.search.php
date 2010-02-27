<?php

/**
 * @package World of Warcraft Armory
 * @version Release Candidate 1
 * @revision 87
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

Class SearchMgr extends Connector {
    public $searchQuery;
    public $get_array;
    public $bossSearchKey;
    public $instanceSearchKey;
    
    public function AdvancedItemSearch($count=false) {
        if(!$this->get_array || !is_array($this->get_array)) {
            echo 'get_array fail';
            return false;
        }
        $locale = (isset($_SESSION['armoryLocale'])) ? $_SESSION['armoryLocale'] : $this->armoryconfig['defaultLocale'];
        $bosses_array = array();
        $bosses_keys = array();
        $extended_array = array(); // Extended costs for badges
        $item_data_tmp = array();
        $item_data = array(); // Our search results will be stored here
        if(!isset($this->get_array['difficulty'])) {
            $this->get_array['difficulty'] = 'all';
        }
        if(!isset($this->get_array['boss'])) {
            $this->get_array['boss'] = 'all';
        }
        if(isset($this->get_array['searchQuery'])) {
            $this->searchQuery = $this->get_array['searchQuery'];
            $itemIDs = $this->wDB->select("SELECT `entry` FROM `item_template` WHERE `name` LIKE ? OR `entry` IN (SELECT `entry` FROM `locales_item` WHERE `name_loc8` LIKE ?) LIMIT 200", '%'.$this->searchQuery.'%', '%'.$this->searchQuery.'%');
            $ids_count = count($itemIDs);
            $ids_str = false;
            for($i=0;$i<$ids_count;$i++) {
                if($ids_str) {
                    $ids_str .= ', ';
                }
                $ids_str .= $itemIDs[$i]['entry'];
            }
            unset($itemIDs);
            unset($ids_count);
        }
        switch($this->get_array['source']) {
            case 'dungeon':
                if($this->get_array['dungeon'] == 'all') {
                    switch($this->get_array['difficulty']) {
                        case 'normal':
                            $bosses_array = $this->aDB->select("SELECT `lootid_1` AS `0`, `lootid_2` AS `1` FROM `armory_instance_data`");
                            break;
                        case 'heroic':
                            $bosses_array = $this->aDB->select("SELECT `lootid_3` AS `0`, `lootid_4` AS `1` FROM `armory_instance_data`");
                            break;
                        case 'all':
                            $bosses_array = $this->aDB->select("SELECT `lootid_1` AS `0`, `lootid_2` AS `1`, `lootid_3` AS `2`, `lootid_4` AS `3` FROM `armory_instance_data` LIMIT 50");
                            break;
                    }
                }
                elseif($this->IsExtendedCost($this->get_array['dungeon'])) {
                    $item_id = $this->aDB->selectCell("SELECT `item` FROM `armory_item_sources` WHERE `key`=?", $this->get_array['dungeon']);
                    if(!$item_id) {
                        return false;
                    }
                    $extended_array = $this->aDB->select("SELECT `id` AS `0` FROM `armory_extended_cost` WHERE `item1`=? OR `item2`=? OR `item3`=? OR `item4`=? OR `item5`=?", $item_id, $item_id, $item_id, $item_id, $item_id);
                    if(!$extended_array) {
                        return false;
                    }
                    $extended_count = count($extended_array);
                    $ids_array = array();
                    $o = 0;
                    for($i=0;$i<$extended_count;$i++) {
                        if($this->searchQuery) {
                            $ids_array[$i] = $this->wDB->select("SELECT `item` AS `0` FROM `npc_vendor` WHERE `ExtendedCost` IN (?a) AND `item` IN (?)", $extended_array[$i], $ids_str);
                        }
                        else {
                            $ids_array[$i] = $this->wDB->select("SELECT `item` AS `0` FROM `npc_vendor` WHERE `ExtendedCost` IN (?a)", $extended_array[$i]);
                        }
                        foreach($ids_array[$i] as $id) {
                            if($o > 199 && !$count) {
                                return $item_data;
                            }
                            elseif($o > 199 && $count == true) {
                                return $o;
                            }
                            if(!$count) {
                                $item_data_tmp[$o] = $this->wDB->select("SELECT `entry`, `ItemLevel`, `Quality` FROM `item_template` WHERE `entry` IN (?a)", $id);
                                $item_data_tmp[$o][0]['name'] = Items::getItemName($item_data_tmp[$o][0]['entry']);
                                $item_data_tmp[$o][0]['icon'] = Items::getItemIcon($item_data_tmp[$o][0]['entry']);
                                $item_data[$o] = $item_data_tmp[$o][0];
                            }
                            $o++;
                        }
                    }
                    if($count == true) {
                        return $o;
                    }
                }
                else {
                    if($this->get_array['boss'] == 'all') {
                        $instance_data = $this->aDB->selectRow("SELECT `id`, `is_heroic` FROM `armory_instance_template` WHERE `key`=?", $this->get_array['dungeon']);
                        if(!$instance_data) {
                            return false;
                        }
                        switch($this->get_array['difficulty']) {
                            case 'normal':
                                $bosses_array = $this->aDB->select("SELECT `lootid_1` AS `0`, `lootid_2` AS `1` FROM `armory_instance_data` WHERE `instance_id`=?", $instance_data['id']);
                            break;
                            case 'heroic':
                                if($instance_data['is_heroic'] == 1) {
                                    $bosses_array = $this->aDB->select("SELECT `lootid_3` AS `0`, `lootid_4` AS `1` FROM `armory_instance_data` WHERE `instance_id`=?", $instance_data['id']);
                                }
                                else {
                                    $bosses_array = $this->aDB->select("SELECT `lootid_2` AS `0` FROM `armory_instance_data` WHERE `instance_id`=?", $instance_data['id']);
                                }
                            break;
                            case 'all':
                                $bosses_array = $this->aDB->select("SELECT `lootid_1` AS `0`, `lootid_2` AS `1`, `lootid_3` AS `2`, `lootid_4` AS `3` FROM `armory_instance_data` WHERE `instance_id`=?", $instance_data['id']);
                            break;
                        }
                    }
                    else {
                        $instance_data = $this->aDB->selectRow("SELECT `id`, `is_heroic` FROM `armory_instance_template` WHERE `key`=?", $this->get_array['dungeon']);
                        if(!$instance_data) {
                            return false;
                        }
                        switch($this->get_array['difficulty']) {
                            case 'normal':
                                if(is_numeric($this->get_array['boss'])) {
                                    $bosses_array[0] = $this->aDB->selectRow("SELECT `lootid_1` AS `0`, `lootid_2` AS `1` FROM `armory_instance_data` WHERE `id`=? AND `instance_id`=?", $this->get_array['boss'], $instance_data['id']);
                                }
                                else {
                                   $bosses_array[0] = $this->aDB->selectRow("SELECT `lootid_1` AS `0`, `lootid_2` AS `1` FROM `armory_instance_data` WHERE `key`=? AND `instance_id`=?", $this->get_array['boss'], $instance_data['id']);
                                }
                                break;
                            case 'heroic':
                                if($instance_data['is_heroic'] == '1') {
                                    if(is_numeric($this->get_array['boss'])) {
                                        $bosses_array[0] = $this->aDB->selectRow("SELECT `lootid_3` AS `0`, `lootid_4` AS `1` FROM `armory_instance_data` WHERE `id`=? AND `instance_id`=?", $this->get_array['boss'], $instance_data['id']);
                                    }
                                    else {
                                        $bosses_array[0] = $this->aDB->selectRow("SELECT `lootid_3` AS `0`, `lootid_4` AS `1` FROM `armory_instance_data` WHERE `key`=? AND `instance_id`=?", $this->get_array['boss'], $instance_data['id']);
                                    }
                                }
                                else {
                                    if(is_numeric($this->get_array['boss'])) {
                                        $bosses_array[0] = $this->aDB->selectRow("SELECT `lootid_2` AS `0` FROM `armory_instance_data` WHERE `id`=? AND `instance_id`=?", $this->get_array['boss'], $instance_data['id']);
                                    }
                                    else {
                                        $bosses_array[0] = $this->aDB->selectRow("SELECT `lootid_2` AS `0` FROM `armory_instance_data` WHERE `key`=? AND `instance_id`=?", $this->get_array['boss'], $instance_data['id']);
                                    }
                                }
                                break;
                            case 'all':
                                if(is_numeric($this->get_array['boss'])) {
                                    $bosses_array[0] = $this->aDB->selectRow("SELECT `lootid_1` AS `0`, `lootid_2` AS `1`, `lootid_3` AS `2`, `lootid_4` AS `3` FROM `armory_instance_data` WHERE `id`=? AND `instance_id`=?", $this->get_array['boss'], $instance_data['id']);
                                }
                                else {
                                    $bosses_array[0] = $this->aDB->selectRow("SELECT `lootid_1` AS `0`, `lootid_2` AS `1`, `lootid_3` AS `2`, `lootid_4` AS `3` FROM `armory_instance_data` WHERE `key`=? AND `instance_id`=?", $this->get_array['boss'], $instance_data['id']);
                                }                                
                                break;
                        }
                    }
                }
                if(!$bosses_array) {
                    return false;
                }
                $count_bosses = count($bosses_array);
                $ids_array = array();
                $o = 0;
                for($i=0;$i<$count_bosses;$i++) {
                    if($this->searchQuery) {
                        if(is_numeric($this->get_array['boss']) && $this->get_array['boss'] > 100000) {
                            // We got Gobject
                            $ids_array[$i] = $this->wDB->select("SELECT `item` AS `0` FROM `gameobject_loot_template` WHERE `entry` IN (?a) AND `item` IN (?)", $bosses_array[$i], $ids_str);
                        }
                        else {
                            $ids_array[$i] = $this->wDB->select("SELECT `item` AS `0` FROM `creature_loot_template` WHERE `entry` IN (?a) AND `item` IN (?)", $bosses_array[$i], $ids_str);
                        }
                    }
                    else {
                        if(is_numeric($this->get_array['boss']) && $this->get_array['boss'] > 100000) {
                            $ids_array[$i] = $this->wDB->select("SELECT `item` AS `0` FROM `gameobject_loot_template` WHERE `entry` IN (?a)", $bosses_array[$i]);
                        }
                        else {
                            $ids_array[$i] = $this->wDB->select("SELECT `item` AS `0` FROM `creature_loot_template` WHERE `entry` IN (?a)", $bosses_array[$i]);
                        }
                    }
                    foreach($ids_array[$i] as $id) {
                        if($o > 199 && !$count) {
                            return $item_data;
                        }
                        elseif($o > 199 && $count == true) {
                            return $o;
                        }
                        if(!$count) {
                            $item_data_tmp[$o] = $this->wDB->select("SELECT `entry`, `ItemLevel`, `Quality` FROM `item_template` WHERE `entry` IN (?a)", $id);
                            $item_data_tmp[$o][0]['name'] = Items::getItemName($item_data_tmp[$o][0]['entry']);
                            $item_data_tmp[$o][0]['icon'] = Items::getItemIcon($item_data_tmp[$o][0]['entry']);
                            if(is_numeric($this->get_array['boss'])) {
                                $this->GetBossKeyById();
                                $this->instanceSearchKey = $this->get_array['dungeon'];
                                $item_data_tmp[$o][0]['source'] = $this->GetItemSourceByKey();
                                $item_data_tmp[$o][0]['source_instance_key'] = $this->instanceSearchKey;
                                $item_data_tmp[$o][0]['source_boss_key'] = $this->get_array['boss'];
                            }
                            else {
                                if($this->get_array['boss'] != 'all' && !$this->IsExtendedCost()) {
                                    $this->bossSearchKey = $this->get_array['boss'];
                                    $this->instanceSearchKey = $this->get_array['dungeon'];
                                    $item_data_tmp[$o][0]['source'] = $this->GetItemSourceByKey();
                                    $item_data_tmp[$o][0]['source_instance_key'] = $this->instanceSearchKey;
                                    $item_data_tmp[$o][0]['source_boss_key'] = $this->get_array['boss'];
                                }
                                elseif($this->get_array['source'] == 'dungeon' && !$this->IsExtendedCost()) {
                                    $this->instanceSearchKey = $this->get_array['dungeon'];
                                    $item_data_tmp[$o][0]['source'] = $this->GetItemSourceByInstanceKey();
                                    $item_data_tmp[$o][0]['source_instance_key'] = $this->instanceSearchKey;
                                }
                                else {
                                    $item_data_tmp[$o][0]['source'] = false;
                                }                                
                            }
                            $item_data[$o] = $item_data_tmp[$o][0];
                        }
                        $o++;
                    }
                }
                if($count == true) {
                    return $o;
                }
                break;
                
            case 'pvpAlliance':
                break;
                
            case 'pvpHorde':
                break;
                
            case 'reputation':
                if(!isset($this->get_array['faction']) || $this->get_array['faction'] == 0 || $this->get_array['faction'] == '-1') {
                    $item_data = $this->wDB->select("SELECT `entry`, `ItemLevel`, `Quality` FROM `item_template` WHERE `RequiredReputationFaction` > 0 LIMIT 200 ORDER BY `ItemLevel` DESC");
                }
                else {
                    $item_data = $this->wDB->select("SELECT `entry`, `ItemLevel`, `Quality` FROM `item_template` WHERE `RequiredReputationFaction`=? LIMIT 200 ORDER BY `ItemLevel` DESC", $this->get_array['faction']);
                }
                $count = count($item_data);
                if($count == true) {
                    return $count;
                }
                else {
                    for($i=0;$i<$count;$i++) {
                        $item_data[$i]['name'] = Items::getItemName($item_data[$i]['entry']);
                        $item_data[$i]['icon'] = Items::getItemIcon($item_data[$i]['entry']);
                    }
                    return $item_data;
                }
                break;
            
            case 'quest':
                break;
        }
        if($item_data) {
            return $item_data;
        }
        return false;
    }
    
    public function SearchArenaTeams($num=false) {
        if($num == true) {
            $teamsNum = $this->cDB->selectCell("
            SELECT COUNT(`arenateamid`)
                FROM `arena_team`
                    WHERE `name` LIKE ? LIMIT 200", '%'.$this->searchQuery.'%');
            return $teamsNum;
        }
        $xQuery = $this->cDB->select("
        SELECT `arena_team`.`name`, `arena_team`.`type`, `arena_team_stats`.`rating`, `characters`.`race`
            FROM `arena_team` AS `arena_team`
                LEFT JOIN `arena_team_stats` AS `arena_team_stats` ON `arena_team`.`arenateamid`=`arena_team_stats`.`arenateamid`
                LEFT JOIN `characters` AS `characters` ON `arena_team`.`captainguid`=`characters`.`guid`
                    WHERE `arena_team`.`name` LIKE ? LIMIT 200", '%'.$this->searchQuery.'%');
        if($xQuery) {
            return $xQuery;
        }
        return false;
    }
    
    public function SearchGuilds($num=false) {
        if($num == true) {
            $guildsNum = $this->cDB->selectCell("
            SELECT COUNT(`guildid`)
                FROM `guild`
                    WHERE `name` LIKE ? LIMIT 200", '%'.$this->searchQuery.'%');
            return $guildsNum;
        }
        $xQuery = $this->cDB->select("
        SELECT `guild`.`name`, `characters`.`race`
            FROM `guild` AS `guild`
                LEFT JOIN `characters` AS `characters` ON `guild`.`leaderguid`=`characters`.`guid`
                    WHERE `guild`.`name` LIKE ? LIMIT 200", '%'.$this->searchQuery.'%');
        if($xQuery) {
            return $xQuery;
        }
        return false;
    }

    public function SearchItems($num=false) {
        if($num == true) {
            $itemsNum = $this->wDB->selectCell("SELECT COUNT(`entry`) FROM `item_template` WHERE `name` LIKE ? LIMIT 200", '%' . $this->searchQuery .'%');
            $itemsNumRuRU = $this->wDB->selectCell("SELECT COUNT(`entry`) FROM `locales_item` WHERE `name_loc8` LIKE ? LIMIT 200", '%' . $this->searchQuery . '%');
            $rNum = $itemsNum + $itemsNumRuRU;
            if($rNum > 200) {
                $rNum = 200;
            }
            return $rNum;
        }
        $searchResults = $this->wDB->select("
        SELECT `entry`, `Quality`, `ItemLevel`
            FROM `item_template`
                WHERE `name` LIKE ? OR `entry` IN 
                (
                    SELECT `entry`
                    FROM `locales_item`
                    WHERE `name_loc8` LIKE ?
                )
                LIMIT 200", '%' . $this->searchQuery . '%', '%' . $this->searchQuery . '%');
        if(!$searchResults) {
            return false;
        }
        $countItems = count($searchResults);
        for($i=0;$i<$countItems;$i++) {
            $searchResults[$i]['name'] = Items::GetItemName($searchResults[$i]['entry']);
            $searchResults[$i]['icon'] = Items::GetItemIcon($searchResults[$i]['entry']);
        }
        return $searchResults;
    }
    
    public function SearchCharacters($num=false) {
        if($num == true) {
            $charsNum = $this->cDB->selectCell("
            SELECT COUNT(`guid`)
                FROM `characters`
                    WHERE `name` LIKE ? AND `level`>=?", '%'.$this->searchQuery.'%', $this->armoryconfig['minlevel']);
            return $charsNum;
        }
        $xQuery = $this->cDB->select("
        SELECT `guid`, `name`, `race`, `class`, `gender`, `level`
            FROM `characters`
                WHERE `name` LIKE ? AND `level`>=?", '%'.$this->searchQuery.'%', $this->armoryconfig['minlevel']);
        if($xQuery) {
            $countChars = count($xQuery);
            for($i=0;$i<$countChars;$i++) {
                $xQuery[$i]['faction'] = Characters::GetCharacterFaction($xQuery[$i]['race']);
                $xQuery[$i]['guild'] = $this->cDB->selectCell("SELECT `name` FROM `guild` WHERE `guildid`=?", Characters::GetDataField(PLAYER_GUILDID, $xQuery[$i]['guid']));
            }
            return $xQuery;
        }
        return false;
    }
    
    public function IsExtendedCost() {
        if(!isset($this->get_array['dungeon'])) {
            return false;
        }
        $key = $this->get_array['dungeon'];
        if($key == 'emblemoffrost' || $key == 'emblemoftriumph' || $key == 'emblemofconquest' || $key == 'emblemofvalor' || $key == 'emblemofheroism' || $key == 'badgeofjustice') {
            return true;
        }
        return false;
    }
    
    public function GetItemSourceByKey() {
        if(!$this->bossSearchKey) {
            return false;
        }
        $locale = (isset($_SESSION['armoryLocale'])) ? $_SESSION['armoryLocale'] : $this->armoryconfig['defaultLocale'];
        return $this->aDB->selectCell("SELECT `name_".$locale."` FROM `armory_instance_template` WHERE `id` IN (SELECT `instance_id` FROM `armory_instance_data` WHERE `key`=?) LIMIT 1", $this->bossSearchKey);
    }
    
    public function GetBossKeyById() {
        if(!isset($this->get_array['boss']) || !is_numeric($this->get_array['boss'])) {
            return false;
        }
        $this->bossSearchKey = $this->aDB->selectCell("SELECT `key` FROM `armory_instance_data` WHERE `id`=? LIMIT 1", $this->get_array['boss']);
        return $this->bossSearchKey;
    }
    
    public function GetItemSourceByInstanceKey() {
        if(!$this->instanceSearchKey) {
            return false;
        }
        $locale = (isset($_SESSION['armoryLocale'])) ? $_SESSION['armoryLocale'] : $this->armoryconfig['defaultLocale'];
        return $this->aDB->selectCell("SELECT `name_".$locale."` FROM `armory_instance_template` WHERE `key`=? LIMIT 1", $this->instanceSearchKey);
    }
}

?>