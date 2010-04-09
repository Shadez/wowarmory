<?php

/**
 * @package World of Warcraft Armory
 * @version Release Candidate 1
 * @revision 130
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
    public $searchQuery = false;
    public $get_array;
    public $bossSearchKey;
    public $instanceSearchKey;
    
    public function DoSearchItems($count=false) {
        if(!$this->searchQuery) {
            return false;
        }
        if($count == true) {
            $count_items = $this->wDB->selectCell("SELECT COUNT(`entry`) FROM `item_template` WHERE `name` LIKE ? OR `entry` IN (SELECT `entry` FROM `locales_item` WHERE `name_loc".$this->_loc."` LIKE ?)", '%'.$this->searchQuery.'%', '%'.$this->searchQuery.'%');
            if($count_items > 200) {
                return 200;
            }
            return $count_items;
        }
        $items = $this->wDB->select("SELECT `entry` AS `id`, `name`, `ItemLevel`, `Quality` AS `rarity` FROM `item_template` WHERE `name` LIKE ? OR `entry` IN (SELECT `entry` FROM `locales_item` WHERE `name_loc".$this->_loc."` LIKE ?)", '%'.$this->searchQuery.'%', '%'.$this->searchQuery.'%');
        if(!$items) {
            return false;
        }
        $result_data = array();
        $i = 0;
        foreach($items as $item) {
            $result_data[$i]['data'] = $item;
            $result_data[$i]['data']['icon'] = Items::getItemIcon($item['id']);
            if($this->_locale != 'en_gb' || $this->_locale != 'en_us') {
                $result_data[$i]['data']['name'] = Items::getItemName($item['id']);
            }
            $result_data[$i]['filters'] = array(
                array('name' => 'itemLevel', 'value' => $item['ItemLevel']),
                array('name' => 'relevance', 'value' => 100)
            );
            $i++;
            unset($result_data[$i]['data']['ItemLevel']);
        }
        return $result_data;
    }
    
    public function AdvancedItemsSearch($count=false) {
        if( (!$this->get_array || !is_array($this->get_array)) && !$this->searchQuery ) {
            echo 'check array fail';
            return false;
        }
        if(!isset($this->get_array['source'])) {
            return false;
        }
        switch($this->get_array['source']) {
            case 'dungeon':
            case 'all':
                if(!isset($this->get_array['dungeon'])) {
                    $this->get_array['dungeon'] = 'all';
                }
                if(!isset($this->get_array['difficulty'])) {
                    $this->get_array['difficulty'] = 'all';
                }
                if(!isset($this->get_array['boss'])) {
                    $this->get_array['boss'] = 'all';
                }
                $sql_query = null;
                switch($this->get_array['difficulty']) {
                    case 'all':
                        $difficulty = null;
                        $sql_query .= "SELECT `lootid_1`, `lootid_2`, `lootid_3`, `lootid_4`, `type` FROM `armory_instance_data`";
                        break;
                    case 'normal':
                        $difficulty = 'n';
                        $sql_query .= "SELECT `lootid_1`, `lootid_2`, `type` FROM `armory_instance_data`";
                        break;
                    case 'heroic':
                        $difficulty = 'h';
                        $sql_query .= "SELECT `lootid_3`, `lootid_4`, `type` FROM `armory_instance_data`";
                        break;
                }
                if(isset($this->get_array['dungeon']) && $this->get_array['dungeon'] != 'all' && !empty($this->get_array['dungeon'])) {
                    $instance_id = Utils::GetDungeonId($this->get_array['dungeon']);
                    $sql_query .= sprintf(" WHERE `instance_id`=%d", $instance_id);
                }
                if(isset($this->get_array['boss']) && $this->get_array['boss'] != 'all' && !empty($this->get_array['boss'])) {
                    if(is_numeric($this->get_array['boss'])) {
                        $sql_query .= sprintf(" AND `id`=%d", $this->get_array['boss']);
                    }
                    else {
                        $sql_query .= sprintf(" AND `key`='%s'", $this->get_array['boss']);
                    }
                }
                $sql_query .= ' LIMIT 10';
                $boss_lootids = $this->aDB->select($sql_query);
                if(!$boss_lootids) {
                    return false;
                }
                $loot_table = array();
                $loot_template = null;
                foreach($boss_lootids as $loot_id) {
                    for($i=1;$i<5;$i++) {
                        if(isset($loot_id['lootid_'.$i])) {
                            $loot_table[] = $loot_id['lootid_'.$i];
                            if($loot_id['type'] == 'object') {
                                $loot_template = '`gameobject_loot_template`';
                                $source_type = 'sourceType.creatureDrop';
                            }
                            elseif($loot_id['type'] == 'npc') {
                                $loot_template = '`creature_loot_template`';
                                $source_type = 'sourceType.gameObjectDrop';
                            }
                        }
                    }
                }
                if($this->get_array['boss'] != 'all') {
                    $current_instance_key = $this->get_array['dungeon'];
                    $current_dungeon_data = $this->aDB->selectRow("SELECT `id`, `map`, `name_".$this->_locale."` AS `name` FROM `armory_instance_template` WHERE `key`=? LIMIT 1", $current_instance_key);
                }
                if($this->searchQuery) {
                    $item_ids = $this->wDB->select("SELECT `entry` FROM `item_template` WHERE `name` LIKE ? OR `entry` IN (SELECT `entry` FROM `locales_item` WHERE `name_loc".$this->_loc."` LIKE ?) LIMIT 200", '%'.$this->searchQuery.'%', '%'.$this->searchQuery.'%');
                    if(!$item_ids) {
                        return false;
                    }
                    $items_entry = array();
                    foreach($item_ids as $_i_id) {
                        $items_entry[] = $_i_id['entry'];
                    }
                    $items_query = $this->wDB->select("SELECT `entry`, `item`, `ChangeOrQuestChance` FROM ".$loot_template." WHERE `entry` IN (?a) AND `item` IN (?a) LIMIT 200", $loot_table, $items_entry);
                }
                else {
                    $items_query = $this->wDB->select("SELECT `entry` ,`item`, `ChanceOrQuestChance` FROM ".$loot_template." WHERE `entry` IN (?a) LIMIT 200", $loot_table);
                }
                if(!$items_query) {
                    return false;
                }
                $items_result = array();
                $exists_items = array();
                $i = 0;
                foreach($items_query as $item) {
                    if(!$count) {
                        if(isset($exists_items[$item['item']])) {
                            continue;
                        }
                        if($this->get_array['boss'] == 'all') {
                            $current_instance_key = Utils::GetBossDungeonKey($item['entry']);
                            $current_dungeon_data = $this->aDB->selectRow("SELECT `id`, `map`, `name_".$this->_locale."` AS `name` FROM `armory_instance_template` WHERE `key`=? LIMIT 1", $current_instance_key);
                            
                        }
                        $item_data = $this->wDB->selectRow("SELECT `entry` AS `id`, `name`, `ItemLevel`, `Quality` AS `rarity`, `displayid` FROM `item_template` WHERE `entry`=?", $item['item']);
                        $items_result[$i]['data'] = array();
                        $items_result[$i]['filters'] = array();
                        $items_result[$i]['data']['id'] = $item_data['id'];
                        if($this->_locale != 'en_gb' || $this->_locale != 'en_us') {
                            $items_result[$i]['data']['name'] = Items::getItemName($item['item']);
                        }
                        else {
                            $items_result[$i]['data']['name'] = $item_data['name'];
                        }
                        $items_result[$i]['data']['rarity'] = $item_data['rarity'];
                        $items_result[$i]['data']['icon'] = $this->aDB->selectCell("SELECT `icon` FROM `armory_icons` WHERE `displayid`=?", $item_data['displayid']);
                        $items_result[$i]['filters'][0] = array('name' => 'itemLevel', 'value' => $item_data['ItemLevel']);
                        $items_result[$i]['filters'][1] = array('name' => 'relevance', 'value' => 100);
                        if($current_dungeon_data && is_array($current_dungeon_data)) {
                            $items_result[$i]['filters'][2] = array(
                                'areaId' => $current_dungeon_data['id'],
                                'areaKey' => $current_instance_key,
                                'areaName' => $current_dungeon_data['name'],
                                'name' => 'source',
                                'value' => $source_type
                            );
                        }
                        $exists_items[$item['item']] = $item['item'];
                    }
                    $i++;
                }
                if($count == true) {
                    return $i;
                }
                return $items_result;
                break;
        }
    }
    
    /** ADVANCED ITEMS SEARCH IS TEMPORARY DISABLED **/
    
    /*
    public function DoSearchItems($count = null) {
        if(!$this->get_array || !is_array($this->get_array)) {
            return false;
        }
        if(!isset($this->get_array['source'])) {
            return false;
        }
        $result_data = array();
        $isVaild = false;
        switch($this->get_array['source']) {
            case 'dungeon':
                if(!isset($this->get_array['dungeon'])) {
                    $this->get_array['dungeon'] = 'all';
                }
                if(!isset($this->get_array['boss'])) {
                    $this->get_array['boss'] = 'all';
                }
                if(!isset($this->get_array['difficulty'])) {
                    $this->get_array['difficulty'] = 'all';
                }
                if($this->get_array['dungeon'] == 'all') {
                    switch($this->get_array['difficulty']) {
                        case 'normal':
                            $loot_ids = $this->aDB->select("SELECT `lootid_1`, `lootid_2` FROM `armory_instance_data`");
                            break;
                        case 'heroic':
                            $loot_ids = $this->aDB->select("SELECT `lootid_3` AS `lootid_1`, `lootid_4` AS `lootid_2` FROM `armory_instance_data`");
                            break;
                        case 'all':
                            $loot_ids = $this->aDB->select("SELECT `lootid_1`, `lootid_2`, `lootid_3`, `lootid_4` FROM `armory_instance_data` LIMIT 50");
                            break;
                    }
                }
                else {
                    if(is_numeric($this->get_array['boss'])) {
                        $boss_key = $this->aDB->selectCell("
                        SELECT `key`
                            FROM `armory_instance_data`
                                WHERE `id`=? OR `name_id`=? OR `lootid_1`=? OR `lootid_2`=? OR `lootid_3`=? OR `lootid_4`=? LIMIT 1",
                        $this->get_array['boss'], $this->get_array['boss'], $this->get_array['boss'],
                        $this->get_array['boss'], $this->get_array['boss'], $this->get_array['boss']
                        );
                        if($boss_key) {
                            $isVaild = true;
                        }
                    }
                    else {
                        $boss_key = $this->aDB->selectCell("SELECT `key` FROM `armory_instance_data` WHERE `key`=?", $this->get_array['boss']);
                        if($boss_key == $this->get_array['boss']) {
                            $isVaild = true;
                        }
                    }
                    if(!$isVaild) {
                        return false;
                    }
                    switch($this->get_array['difficulty']) {
                        case 'normal':
                            $loot_ids = $this->aDB->select("SELECT `lootid_1`, `lootid_2` FROM `armory_instance_data` WHERE `key`=?", $boss_key);
                            break;
                        case 'heroic':
                            $loot_ids = $this->aDB->select("SELECT `lootid_3` AS `lootid_1`, `lootid_4` AS `lootid_2` FROM `armory_instance_data` WHERE `key`=?", $boss_key);
                            break;
                        case 'all':
                            $loot_ids = $this->aDB->select("SELECT `lootid_1`, `lootid_2`, `lootid_3`, `lootid_4` FROM `armory_instance_data` WHERE `key`=?", $boss_key);
                            break;
                    }
                }
                if(!$loot_ids) {
                    // We haven't any loot table.
                    return false;
                }
                $loot_table = '';   // IDs string
                $count_ids = count($loot_ids);
                for($i=0;$i<$count_ids;$i++) {
                    if($i) {
                        $loot_table .= ', ';
                    }
                    $loot_table .= $loot_ids[$i]['lootid_1'].', '.$loot_ids[$i]['lootid_2'];
                    if(isset($loot_ids[$i]['lootid_3'])) {
                        $loot_table .= ', '.$loot_ids[$i]['lootid_3'];
                    }
                    if(isset($loot_ids[$i]['lootid_4'])) {
                        $loot_table .= ', '.$loot_ids[$i]['lootid_4'];
                    }
                }
                //GENERATE ITEM DATA
                $item_id = $this->wDB->select("SELECT `item` FROM `creature_loot_template` WHERE `entry` IN (?)", $loot_table);
                if(!$item_id) {
                    return false;
                }
                $count_items = count($item_id);
                if($count == true) {
                    return $count_items;
                }
                $item_loot = '';
                for($i=0;$i<$count_items;$i++) {
                    if($i) {
                        $item_loot .= ', ';
                    }
                    $item_loot .= $item_id[$i]['item'];
                }
                $items_result = $this->wDB->select("SELECT `entry` AS `id`, `name`, `Quality` AS `rarity`, `ItemLevel` FROM `item_template` WHERE `entry` IN (?)", $item_loot);
                if(!$items_result) {
                    return false;
                }
                $i = 0;
                foreach($items_result as $item) {
                    $result_data[$i]['data'] = $item;
                    $result_data[$i]['data']['icon'] = Items::getItemIcon($item['id']);
                    if($this->_locale != 'en_gb' || $this->_locale != 'en_us') {
                        $result_data[$i]['data']['name'] = Items::getItemName($item['id']);
                    }
                    $result_data[$i]['data']['url'] = 'i='.$item['id'];
                    $result_data[$i]['filters'] = array(
                        array('name' => 'itemLevel', 'value' => $item['ItemLevel']),
                        array('name' => 'relevance', 'value' => 100)
                    );
                    $item_source = Items::GetItemSource($item['id']);
                    if($item_source == 'sourceType.creatureDrop' || $item_source == 'sourceType.gameObjectDrop') {
                        $result_data[$i]['filters'][2] = $this->aDB->selectRow("
                        SELECT `id` AS `areaId`, `key` AS `areaKey`, `name_".$this->_locale."` AS `areaName`
                            FROM `armory_instance_data` WHERE `id` IN (SELECT `instance_id` FROM `armory_instance_data` WHERE `key`=?)", $boss_key);
                        if(!$result_data[$i]['filters'][2]) {
                            unset($result_data[$i]['filters'][2]); // who knows...
                        }
                        else {
                            $tmp = $this->wDB->selectRow("SELECT `id`, `name_".$this->_locale."` AS `creatureName` FROM `armory_instance_data` WHERE `key`=?", $boss_key);
                            $drop_percent = $this->wDB->selectCell("SELECT `ChanceOrQuestChance` FROM `creature_loot_template` WHERE `item`=?", $item['id']);
                            $result_data[$i]['filters'][2]['creatureId'] = $tmp['id'];
                            $result_data[$i]['filters'][2]['creatureName'] = $tmp['creatureName'];
                            $result_data[$i]['filters'][2]['difficulty'] = ($this->get_array['difficulty'] == 'heroic') ? 'h' : 'n';
                            $result_data[$i]['filters'][2]['dropRate'] = Mangos::DropPercent($drop_percent);
                            $result_data[$i]['filters'][2]['name'] = 'source';
                            $result_data[$i]['filters'][2]['value'] = 'sourceType.creatureDrop';
                        }
                    }
                    unset($result_data[$i]['data']['ItemLevel']);
                    $i++;
                }
                return $result_data;
                break;
        }
    }
    
    public function AdvancedItemSearch($count=false) {
        if(!$this->get_array || !is_array($this->get_array)) {
            return false;
        }
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
                elseif($this->IsExtendedCost()) {
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
                                return $this->MakeUniqueArray($item_data);
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
                            return $this->MakeUniqueArray($item_data);
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
                if(!isset($this->get_array['pvp'])) {
                    return false;
                }
                
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
    */
    
    public function SearchArenaTeams($num=false) {
        if($num == true) {
            $teamsNum = $this->cDB->selectCell("
            SELECT COUNT(`arenateamid`)
                FROM `arena_team`
                    WHERE `name` LIKE ? LIMIT 200", '%'.$this->searchQuery.'%');
            return $teamsNum;
        }
        $arenateams = $this->cDB->select("
        SELECT `arena_team`.`name`, `arena_team`.`type` AS `size`, `arena_team_stats`.`rating`, `characters`.`race`
            FROM `arena_team` AS `arena_team`
                LEFT JOIN `arena_team_stats` AS `arena_team_stats` ON `arena_team`.`arenateamid`=`arena_team_stats`.`arenateamid`
                LEFT JOIN `characters` AS `characters` ON `arena_team`.`captainguid`=`characters`.`guid`
                    WHERE `arena_team`.`name` LIKE ? LIMIT 200", '%'.$this->searchQuery.'%');
        if(!$arenateams) {
            return false;
        }
        $arena_count = count($arenateams);
        for($i=0;$i<$arena_count;$i++) {
            $arenateams[$i]['teamSize'] = $arenateams[$i]['size'];
            $arenateams[$i]['realm'] = $this->armoryconfig['defaultRealmName'];
            $arenateams[$i]['battleGroup'] = $this->armoryconfig['defaultBGName'];
            $arenateams[$i]['factionId'] = Characters::GetCharacterFaction($arenateams[$i]['race']);
            $arenateams[$i]['relevance'] = 100;
            $arenateams[$i]['url'] = sprintf('r=%s&ts=%d&t=%s', urlencode($this->armoryconfig['defaultRealmName']), $arenateams[$i]['size'], urlencode($arenateams[$i]['name']));
            unset($arenateams[$i]['race']);
        }
        return $arenateams;
    }
    
    public function SearchGuilds($num=false) {
        if($num == true) {
            $guildsNum = $this->cDB->selectCell("
            SELECT COUNT(`guildid`)
                FROM `guild`
                    WHERE `name` LIKE ? LIMIT 200", '%'.$this->searchQuery.'%');
            return $guildsNum;
        }
        $guilds = $this->cDB->select("
        SELECT `guild`.`name`, `characters`.`race`
            FROM `guild` AS `guild`
                LEFT JOIN `characters` AS `characters` ON `guild`.`leaderguid`=`characters`.`guid`
                    WHERE `guild`.`name` LIKE ? LIMIT 200", '%'.$this->searchQuery.'%');
        if(!$guilds) {
            return false;
        }
        $guilds_count = count($guilds);
        for($i=0;$i<$guilds_count;$i++) {
            $guilds[$i]['battleGroup'] = $this->armoryconfig['defaultBGName'];
            $guilds[$i]['factionId'] = Characters::GetCharacterFaction($guilds[$i]['race']);
            $guilds[$i]['relevance'] = 100;
            $guilds[$i]['realm'] = $this->armoryconfig['defaultRealmName'];
            $guilds[$i]['url'] = sprintf('r=%s&gn=%s', urlencode($this->armoryconfig['defaultRealmName']), urlencode($guilds[$i]['name']));
            unset($guilds[$i]['race']);
        }
        return $guilds;
    }
    
    public function SearchCharacters($num=false) {
        if(!$this->searchQuery) {
            return false;
        }
        $results_data   = array();
        $cur_realm_data = array();
        $results_count  = 0;
        if($num == true) {
            $count_chars = $this->cDB->selectCell("SELECT COUNT(`guid`) FROM `characters` WHERE `name` LIKE ? LIMIT 200", '%'.$this->searchQuery.'%');
            $results_count = $results_count+$count_chars;
            $count_chars = 0;
        }
        else {
            $cur_realm_data = $this->cDB->select("
            SELECT `guid`, `name`, `class` AS `classId`, `gender` AS `genderId`, `race` AS `raceId`, `level`
                FROM `characters`
                    WHERE `name` LIKE ? LIMIT 200", '%'.$this->searchQuery.'%');
            $count_data = count($cur_realm_data);
            for($j=0;$j<$count_data;$j++) {
                if($cur_realm_data[$j]['guildId'] = $this->cDB->selectCell("SELECT `guildid` FROM `guild_member` WHERE `guid`=?", $cur_realm_data[$j]['guid'])) {
                    $cur_realm_data[$j]['guild'] = $this->cDB->selectCell("SELECT `name` FROM `guild` WHERE `guildid`=?", $cur_realm_data[$j]['guildId']);
                    $cur_realm_data[$j]['guildUrl'] = sprintf('r=%s&gn=%s', urlencode($this->armoryconfig['defaultRealmName']), urlencode($cur_realm_data[$j]['guild']));
                }
                $cur_realm_data[$j]['url'] = 'r='.urlencode($this->armoryconfig['defaultRealmName']).'&cn='.urlencode($cur_realm_data[$j]['name']);
                $cur_realm_data[$j]['relevance'] = 100; // TODO
                $cur_realm_data[$j]['battleGroup'] = $this->armoryconfig['defaultBGName'];
                $cur_realm_data[$j]['battleGroupId'] = 1;
                $cur_realm_data[$j]['class'] = $this->aDB->selectCell("SELECT `name_".$this->_locale."` FROM `armory_classes` WHERE `id`=?", $cur_realm_data[$j]['classId']);
                $cur_realm_data[$j]['race'] = $this->aDB->selectCell("SELECT `name_".$this->_locale."` FROM `armory_races` WHERE `id`=?", $cur_realm_data[$j]['raceId']);
                $cur_realm_data[$j]['realm'] = $this->armoryconfig['defaultRealmName'];
                $cur_realm_data[$j]['factionId'] = Characters::GetCharacterFaction($cur_realm_data[$j]['raceId']);
                $cur_realm_data[$j]['faction'] = ($cur_realm_data[$j]['factionId'] == 0) ? Utils::GetArmoryString(11) : Utils::GetArmoryString(12);
                $cur_realm_data[$j]['searchRank'] = $j+1;
                unset($cur_realm_data[$j]['guid']); // Do not show guid in XML result
            }
        }
        if($num == true) {
            return $results_count;
        }
        elseif(!$cur_realm_data) {
            return false;
        }
        else {
            return $cur_realm_data;
        }
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
        return $this->aDB->selectCell("SELECT `name_".$this->_locale."` FROM `armory_instance_template` WHERE `id` IN (SELECT `instance_id` FROM `armory_instance_data` WHERE `key`=?) LIMIT 1", $this->bossSearchKey);
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
        return $this->aDB->selectCell("SELECT `name_".$this->_locale."` FROM `armory_instance_template` WHERE `key`=? LIMIT 1", $this->instanceSearchKey);
    }
    
    public function MakeUniqueArray($array, $preserveKeys=false) {
        // Unique Array for return  
        $arrayRewrite = array();  
        // Array with the md5 hashes  
        $arrayHashes = array();  
        foreach($array as $key => $item) {
            // Serialize the current element and create a md5 hash  
            $hash = md5(serialize($item));
            // If the md5 didn't come up yet, add the element to  
            // to arrayRewrite, otherwise drop it  
            if (!isset($arrayHashes[$hash])) {
                // Save the current element hash  
                $arrayHashes[$hash] = $hash;  
                // Add element to the unique Array  
                if ($preserveKeys) {
                    $arrayRewrite[$key] = $item;
                } else {  
                    $arrayRewrite[] = $item;
                }
            }
        }
        return $arrayRewrite;  
    }
}
?>