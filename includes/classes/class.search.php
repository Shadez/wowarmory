<?php

/**
 * @package World of Warcraft Armory
 * @version Release Candidate 1
 * @revision 323
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
    public $heirloom = false;
    private $boss_loot_ids;
    private $results;
    private $type_results;
    
    public function DoSearchItems($count = false, $findUpgrade = false) {
        if(!$this->searchQuery && !$findUpgrade && !$this->heirloom) {
            $this->Log()->writeError('%s : unable to start search: no data provided', __METHOD__);
            return false;
        }
        if($findUpgrade > 0) {
            $source_item_data = $this->wDB->selectRow("SELECT `class`, `subclass`, `InventoryType`, `ItemLevel`, `Quality`, `bonding` FROM `item_template` WHERE `entry`=%d", $findUpgrade);
            /*
            ,
            `stat_type1`, `stat_value1`, `stat_type2`, `stat_value2`, `stat_type3`, `stat_value3`, `stat_type4`, `stat_value4`,
            `stat_type5`, `stat_value5`, `stat_type6`, `stat_value6`, `stat_type7`, `stat_value7`, `stat_type8`, `stat_value8`,
            `stat_type9`, `stat_value9`, `stat_type10`, `stat_value10`
            */
            if(!$source_item_data) {
                $this->Log()->writeError('%s : unable to item info for ID #%d (findUpgrade)', __METHOD__, $findUpgrade);
                return false;
            }
        }
        if($count == true) {
            if($findUpgrade) {
                $count_items = $this->wDB->selectCell("SELECT COUNT(`entry`) FROM `item_template` WHERE `class`=%d AND `subclass`=%d AND `InventoryType`=%d AND `Quality` >= %d AND `ItemLevel` >= %d", $source_item_data['class'], $source_item_data['subclass'], $source_item_data['InventoryType'], $source_item_data['Quality'], $source_item_data['ItemLevel']);
            }
            elseif($this->heirloom == true) {
                $count_items = $this->wDB->selectCell("SELECT COUNT(`entry`) FROM `item_template` WHERE `Quality`=7");
            }
            else {
                if($this->_loc == 0) {
                    $count_items = $this->wDB->selectCell("SELECT COUNT(`entry`) FROM `item_template` WHERE `name` LIKE '%s'", '%'.$this->searchQuery.'%');
                }
                else {
                    $count_items = $this->wDB->selectCell("SELECT COUNT(`entry`) FROM `item_template` WHERE `name` LIKE '%s' OR `entry` IN (SELECT `entry` FROM `locales_item` WHERE `name_loc%d` LIKE '%s')", '%'.$this->searchQuery.'%', $this->_loc, '%'.$this->searchQuery.'%');
                }
            }
            if($count_items > 200) {
                return 200;
            }
            return $count_items;
        }
        if($findUpgrade) {
            $items = $this->wDB->select("SELECT `entry` AS `id`, `name`, `ItemLevel`, `Quality` AS `rarity`, `displayid`, `bonding`, `flags`, `duration` FROM `item_template` WHERE `class`=%d AND `subclass`=%d AND `InventoryType`=%d AND `Quality` >= %d AND `ItemLevel` >= %d ORDER BY `ItemLevel` DESC LIMIT 200", $source_item_data['class'], $source_item_data['subclass'], $source_item_data['InventoryType'], $source_item_data['Quality'], $source_item_data['ItemLevel']);
        }
        elseif($this->heirloom == true) {
            $items = $this->wDB->select("SELECT `entry` AS `id`, `name`, `ItemLevel`, `Quality` AS `rarity`, `displayid`, `bonding`, `flags`, `duration` FROM `item_template` WHERE `Quality`=7 ORDER BY `ItemLevel` DESC LIMIT 200");
        }
        else {
            if($this->_loc == 0) {
                $items = $this->wDB->select("SELECT `entry` AS `id`, `name`, `ItemLevel`, `Quality` AS `rarity`, `displayid`, `bonding`, `flags`, `duration` FROM `item_template` WHERE `name` LIKE '%s' ORDER BY `ItemLevel` DESC LIMIT 200", '%'.$this->searchQuery.'%');
            }
            else {
                $items = $this->wDB->select("SELECT `entry` AS `id`, `name`, `ItemLevel`, `Quality` AS `rarity`, `displayid`, `bonding`, `flags`, `duration` FROM `item_template` WHERE `name` LIKE '%s' OR `entry` IN (SELECT `entry` FROM `locales_item` WHERE `name_loc%d` LIKE '%s') ORDER BY `ItemLevel` DESC LIMIT 200", '%'.$this->searchQuery.'%', $this->_loc, '%'.$this->searchQuery.'%');
            }
        }
        if(!$items) {
            $this->Log()->writeLog('%s : unable to find any items with `%s` query (current locale: %s, locId: %d)', __METHOD__, $this->searchQuery, $this->_locale, $this->_loc);
            return false;
        }
        $result_data = array();
        $i = 0;
        foreach($items as $item) {
            $result_data[$i]['data'] = $item;
            $result_data[$i]['data']['icon'] = Items::getItemIcon($item['id'], $item['displayid']);
            if(self::CanAuction($item)) {
                $result_data[$i]['data']['canAuction'] = 1;
            }
            unset($result_data[$i]['data']['flags'], $result_data[$i]['data']['duration'], $result_data[$i]['data']['bonding']);
            if($this->_locale != 'en_gb' || $this->_locale != 'en_us') {
                $result_data[$i]['data']['name'] = Items::getItemName($item['id']);
            }
            $result_data[$i]['filters'] = array(
                array('name' => 'itemLevel', 'value' => $item['ItemLevel']),
                array('name' => 'relevance', 'value' => 100)
            );
            if($this->heirloom == true) {
                $result_data[$i]['filters'][2] = array('name' => 'source', 'value' => 'sourceType.vendor');
            }
            $i++;
            unset($result_data[$i]['data']['ItemLevel']);
        }
        return $result_data;
    }
    
    public function AdvancedItemsSearch($count = false) {
        if((!$this->get_array || !is_array($this->get_array)) && !$this->searchQuery ) {
            $this->Log()->writeError('%s : start failed', __METHOD__);
            return false;
        }
        if(!isset($this->get_array['source'])) {
            $this->Log()->writeError('%s : get_array[source] not defined', __METHOD__);
            return false;
        }
        $allowedDungeon = false;
        // Get item IDs first (if $this->searchQuery)
        $item_id_array = array();
        if($this->searchQuery) {
            if($this->_loc == 0) {
                // No SQL injection - already escaped in search.php
                $_item_ids = $this->wDB->select("SELECT `entry` FROM `item_template` WHERE `name` LIKE '%s'", '%'.$this->searchQuery.'%');
            }
            else {
                $_item_ids = $this->wDB->select("SELECT `entry` FROM `item_template` WHERE `name` LIKE '%s' OR `entry` IN (SELECT `entry` FROM `locales_item` WHERE `name_loc%d` LIKE '%s')", '%'.$this->searchQuery.'%', $this->_loc, '%' . $this->searchQuery.'%');
            }
            if(is_array($_item_ids)) {
                $tmp_count_ids = count($_item_ids);
                $item_id_string = null;
                for($i = 0; $i < $tmp_count_ids; $i++) {
                    if($i) {
                        $item_id_string .= ', ' . $_item_ids[$i]['entry'];
                    }
                    else {
                        $item_id_string .= $_item_ids[$i]['entry'];
                    }
                    $item_id_array[] = $_item_ids[$i]['entry'];
                }
            }
        }
        $quality_types = array(
            'pr' => 0,
            'cn' => 1,
            'un' => 2,
            're' => 3,
            'ec' => 4,
            'lg' => 5,
            'hm' => 7
        );
        $slot_types = array(
            'head' => 1,
            'neck' => 2,
            'shoulders' => 3,
            'shirt' => 4,
            'chest' => 5,
            'waist' => 6,
            'legs' => 7,
            'feet' => 8,
            'wrists' => 9,
            'hands' => 10,
            'finger' => 11,
            'trinket' => 12,
            'back' => 16,
            'offhand' => 22
        );
        switch($this->get_array['source']) {
            case 'all':
            case 'quest':
                if($this->get_array['source'] == 'quest') {
                    $quest_items_query = $this->wDB->select("SELECT `RewChoiceItemId1`, `RewChoiceItemId2`, `RewChoiceItemId3`, `RewChoiceItemId4`, `RewChoiceItemId5`, `RewChoiceItemId6`, `RewItemId1`, `RewItemId2`, `RewItemId3`, `RewItemId4` FROM `quest_template` ORDER BY `entry` DESC LIMIT 800");
                    if(!$quest_items_query) {
                        return false;
                    }
                    $qItems = array();
                    foreach($quest_items_query as $qItem) {
                        for($i=1;$i<6;$i++) {
                            if(isset($qItem['RewChoiceItemId'.$i]) && $qItem['RewChoiceItemId'.$i] > 0) {
                                $qItems[] = $qItem['RewChoiceItemId'.$i];
                            }
                            if(isset($qItem['RewItemId'.$i]) && $qItem['RewItemId'.$i] > 0) {
                                $qItems[] = $qItem['RewItemId'.$i];
                            }
                        }
                    }
                    if(!$qItems) {
                        return false;
                    }
                }
                $sql_query = "SELECT `entry` AS `id`, `name`, `ItemLevel`, `Quality` AS `rarity`, `displayid`, `bonding`, `flags`, `duration` FROM `item_template`";
                $andor = false;
                $type_info = false;
                if(isset($this->get_array['type']) && !empty($this->get_array['type'])) {
                    /* Type */
                    if($this->get_array['type'] != 'all') {
                        if($this->get_array['type'] == 'misc') {
                            $this->get_array['type'] = 'miscellaneous';
                        }
                        $type_info = $this->aDB->selectCell("SELECT `type` FROM `armory_item_sources` WHERE `key`='%s' AND `parent`=0", $this->get_array['type']);
                        if($type_info === false) {
                            $this->Log()->writeLog('%s : type for key %s not found in `armory_item_sources`', __METHOD__, $this->get_array['type']);
                            return false;
                        }
                        $sql_query = sprintf("SELECT `entry` AS `id`, `name`, `ItemLevel`, `Quality` AS `rarity`, `displayid`, `bonding`, `flags`, `duration` FROM `item_template` WHERE `class`=%d", $type_info);
                        $andor = true;
                    }
                    /* Subtype */
                    if(isset($this->get_array['subTp']) && !empty($this->get_array['subTp'])) {
                        if($this->get_array['subTp'] != 'all' && $type_info !== false) {
                            $subtype_info = $this->aDB->selectRow("SELECT `type`, `subtype` FROM `armory_item_sources` WHERE `key`='%s' AND `parent`=%d", $this->get_array['subTp'], $type_info);
                            if($subtype_info) {
                                $sql_query .= sprintf(" AND `subclass`=%d", $subtype_info['subtype']);
                                $andor = true;
                            }
                            else {
                                $this->Log()->writeLog('%s : subtype for subTp %s not found in `armory_item_sources`', __METHOD__, $this->get_array['subTp']);
                            }
                        }
                    }
                    /* Required level */
                    if((isset($this->get_array['rqrMin']) && !empty($this->get_array['rqrMin'])) && (isset($this->get_array['rqrMax']) && !empty($this->get_array['rqrMax']))) {
                        if($andor) {
                            $sql_query .= sprintf(" AND `RequiredLevel` BETWEEN %d AND %d", (int) $this->get_array['rqrMin'], (int) $this->get_array['rqrMax']);
                        }
                        else {
                            $sql_query .= sprintf(" WHERE `RequiredLevel` BETWEEN %d AND %d", (int) $this->get_array['rqrMin'], (int) $this->get_array['rqrMax']);
                            $andor = true;
                        }                        
                    }
                    elseif(isset($this->get_array['rqrMin']) && !empty($this->get_array['rqrMin'])) {
                        if($andor) {
                            $sql_query .= sprintf(" AND `RequiredLevel` >= %d", (int) $this->get_array['rqrMin']);
                        }
                        else {
                            $sql_query .= sprintf(" WHERE `RequiredLevel` >= %d", (int) $this->get_array['rqrMin']);
                            $andor = true;
                        }
                    }
                    elseif(isset($this->get_array['rqrMax']) && !empty($this->get_array['rqrMax'])) {
                        if($andor) {
                            $sql_query .= sprintf(" AND `RequiredLevel` <= %d", (int) $this->get_array['rqrMax']);
                        }
                        else {
                            $sql_query .= sprintf(" WHERE `RequiredLevel` <= %d", (int) $this->get_array['rqrMax']);
                            $andor = true;
                        }
                    }
                    /* Quality */
                    if(isset($this->get_array['rrt']) && !empty($this->get_array['rrt'])) {
                        if(isset($quality_types[$this->get_array['rrt']])) {
                            if($andor) {
                                $sql_query .= sprintf(" AND `Quality`=%d", $quality_types[$this->get_array['rrt']]);
                            }
                            else {
                                $sql_query .= sprintf(" WHERE `Quality`=%d", $quality_types[$this->get_array['rrt']]);
                                $andor = true;
                            }
                        }
                    }
                    /* Usable by */
                    if(isset($this->get_array['usbleBy']) && !empty($this->get_array['usbleBy'])) {
                        $usable_by = (int) $this->get_array['usbleBy'];
                        $classes_mask = array(
                            1 => 1,
                            2 => 2,
                            3 => 4,
                            4 => 8,
                            5 => 16,
                            6 => 32,
                            7 => 64,
                            8 => 128,
                            9 => 256,
                            11=> 1024
                        );
                        if(isset($classes_mask[$usable_by])) {
                            if($andor) {
                                $sql_query .= sprintf(" AND `AllowableClass`&%d", $classes_mask[$usable_by]);
                            }
                            else {
                                $sql_query .= sprintf(" WHERE `AllowableClass`&%d", $classes_mask[$usable_by]);
                                $andor = true;
                            }
                        }
                    }
                    /* Class types */
                    /*
                    // TODO
                    if(isset($this->get_array['classType']) && !empty($this->get_array['classType'])) {
                        switch($this->get_array['classType']) {
                            case 'tank':
                                break;
                            case 'melee':
                                break;
                            case 'caster':
                                break;
                            case 'healer':
                                break;
                            case 'dot': // Warlock: damage only
                                break;
                            case 'dd':  // Warlock: damage + crit
                                break;
                        }
                    }*/
                    
                    /* Slot */
                    if(isset($this->get_array['slot']) && !empty($this->get_array['slot'])) {
                        if(isset($slot_types[$this->get_array['slot']])) {
                            if($andor) {
                                $sql_query .= sprintf(" AND `InventoryType`=%d", $slot_types[$this->get_array['slot']]);
                            }
                            else {
                                $sql_query .= sprintf(" WHERE `InventoryType`=%d", $slot_types[$this->get_array['slot']]);
                                $andor = true;
                            }
                        }
                    }
                    
                    /* Search string */
                    if($this->searchQuery && $item_id_string != null) {
                        if($andor) {
                            $sql_query .= sprintf(" AND `entry` IN (%s) ORDER BY `ItemLevel` LIMIT 200", $item_id_string);
                        }
                        else {
                            $sql_query .= sprintf(" WHERE `entry` IN (%s) ORDER BY `ItemLevel` LIMIT 200", $item_id_string);
                        }
                    }
                    else {
                        if($this->get_array['source'] == 'quest') {
                            $q_items_count = count($qItems);
                            if($andor) {
                                $sql_query .= " AND `entry` IN (";
                            }
                            else {
                                $sql_query .= " WHERE `entry` IN (";
                            }
                            for($i=0;$i<$q_items_count;$i++) {
                                if($i) {
                                    $sql_query .= ', ';
                                }
                                $sql_query .= $qItems[$i];
                            }
                            $sql_query .= ')';
                        }
                        $sql_query .= " ORDER BY `ItemLevel` DESC LIMIT 200";
                    }
                }
                else {
                    if(isset($this->searchQuery) && !empty($this->searchQuery)) {
                        if($this->_loc == 0) {
                            $sql_query .= sprintf(" WHERE `name` LIKE '%s'", '%'.mysql_escape_string($this->searchQuery).'%');
                        }
                        else {
                            $sql_query .= sprintf(" WHERE `name` LIKE '%s' OR `entry` IN (SELECT `entry` FROM `locales_item` WHERE `name_loc%d` LIKE '%s'", '%'.mysql_escape_string($this->searchQuery).'%', $this->_loc, '%'.mysql_escape_string($this->searchQuery).'%');
                        }
                    }
                    $sql_query .= " ORDER BY `ItemLevel` DESC LIMIT 200";
                }
                $items_query = $this->wDB->select($sql_query);
                unset($sql_query);
                break;
            case 'dungeon':
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
                if(self::IsExtendedCost()) {
                    $this->Log()->writeLog('%s : used ExtendedCost key: %s', __METHOD__, $this->get_array['dungeon']);
                    $item_extended_cost = $this->aDB->selectCell("SELECT `item` FROM `armory_item_sources` WHERE `key`='%s' LIMIT 1", $this->get_array['dungeon']);
                    if(!$item_extended_cost) {
                        $this->Log()->writeError('%s : this->get_array[dungeon] is ExtendedCost key (%s) but data for this key is missed in `armory_item_sources`', __METHOD__, $this->get_array['dungeon']);
                        return false;
                    }
                    $extended_cost = $this->aDB->select("SELECT `id` FROM `armory_extended_cost` WHERE `item1`=%d OR `item2`=%d OR `item3`=%d OR `item4`=%d OR `item5`=%d", $item_extended_cost, $item_extended_cost, $item_extended_cost, $item_extended_cost, $item_extended_cost);
                    if(!$extended_cost) {
                        $this->Log()->writeError('%s : this->get_array[dungeon] is ExtendedCost (key: %s, id: %d) but data for this id is missed in `armory_extended_cost`', __METHOD__, $this->get_array['dungeon'], $item_extended_cost);
                        return false;
                    }
                    $cost_ids = array();
                    foreach($extended_cost as $cost) {
                        $cost_ids[] = $cost['id'];
                    }
                    if($this->searchQuery && is_array($item_id_array)) {
                        $mytmpcount = count($cost_ids);
                        $str_query = null;
                        $str_query_ids = null;
                        for($i = 0; $i < $mytmpcount; $i++) {
                            if($i) {
                                $str_query .= ', ' . $cost_ids[$i] .', -' . $cost_ids[$i];
                            }
                            else {
                                $str_query .= $cost_ids[$i].', -' . $cost_ids[$i];
                            }
                        }
                        $countIds = count($item_id_array);
                        for($ii = 0; $ii < $countIds; $ii++) {
                            if($ii) {
                                $str_query_ids .= ', ' . $item_id_array[$ii];
                            }
                            else {
                                $str_query_ids .= $item_id_array[$ii];
                            }
                        }
                        $tmp_sql = sprintf("
                        SELECT DISTINCT
                        `item_template`.`entry` AS `id`,
                        `item_template`.`name`,
                        `item_template`.`ItemLevel`,
                        `item_template`.`Quality` AS `rarity`,
                        `item_template`.`displayid`,
                        `item_template`.`bonding`,
                        `item_template`.`flags`,
                        `item_template`.`duration`
                        FROM `item_template` AS `item_template`
                        LEFT JOIN `npc_vendor` AS `npc_vendor` ON `npc_vendor`.`item`=`item_template`.`entry`
                        WHERE `npc_vendor`.`ExtendedCost` IN (%s) AND `npc_vendor`.`item` IN (%s)
                        ORDER BY `item_template`.`ItemLevel` DESC LIMIT 200", $str_query, $str_query_ids);
                        $items_query = $this->wDB->select($tmp_sql);
                    }
                    else {
                        $mytmpcount = count($cost_ids);
                        $str_query = null;
                        for($i = 0; $i < $mytmpcount; $i++) {
                            if($i) {
                                $str_query .= ', ' . $cost_ids[$i] .', -' . $cost_ids[$i];
                            }
                            else {
                                $str_query .= $cost_ids[$i].', -' . $cost_ids[$i];
                            }
                        }
                        $tmp_sql = sprintf("
                        SELECT DISTINCT
                        `item_template`.`entry` AS `id`,
                        `item_template`.`name`,
                        `item_template`.`ItemLevel`,
                        `item_template`.`Quality` AS `rarity`,
                        `item_template`.`displayid`,
                        `item_template`.`bonding`,
                        `item_template`.`flags`,
                        `item_template`.`duration`
                        FROM `item_template` AS `item_template`
                        LEFT JOIN `npc_vendor` AS `npc_vendor` ON `npc_vendor`.`item`=`item_template`.`entry`
                        WHERE `npc_vendor`.`ExtendedCost` IN (%s)
                        ORDER BY `item_template`.`ItemLevel` DESC LIMIT 200", $str_query);
                        $items_query = $this->wDB->select($tmp_sql);
                    }
                }
                else {
                    $allowedDungeon = true;     
                    $instance_data = Utils::GetDungeonData($this->get_array['dungeon']);
                    if(!is_array($instance_data) || !isset($instance_data['difficulty'])) {
                        return false;
                    }
                    switch($this->get_array['difficulty']) {
                        case 'all':
                            $difficulty = null;
                            switch($instance_data['difficulty']) {
                                case 1: // 10 Man
                                    if($instance_data['is_heroic'] == 1) {
                                        $sql_query .= "SELECT `lootid_1`, `lootid_3`, `type` FROM `armory_instance_data`";
                                    }
                                    else {
                                        $sql_query .= "SELECT `lootid_1`, `type` FROM `armory_instance_data`";
                                    }
                                    break;
                                case 2: // 25 Man
                                    if($instance_data['is_heroic'] == 1) {
                                        $sql_query .= "SELECT `lootid_2`, `lootid_4`, `type` FROM `armory_instance_data`";
                                    }
                                    else {
                                        $sql_query .= "SELECT `lootid_2`, `type` FROM `armory_instance_data`";
                                    }
                                    break;
                                default:
                                    if($instance_data['is_heroic'] == 1) {
                                        $sql_query .= "SELECT `lootid_1`, `lootid_2`, `lootid_3`, `lootid_4`, `type` FROM `armory_instance_data`";
                                    }
                                    else {
                                        $sql_query .= "SELECT `lootid_1`, `lootid_2`, `type` FROM `armory_instance_data`";
                                    }
                                    break;
                            }
                            break;
                        case 'normal':
                            switch($instance_data['difficulty']) {
                                case 2:  // 25 Man (icc/toc)
                                    $sql_query .= "SELECT `lootid_2`, `type` FROM `armory_instance_data`";
                                    break;
                                case 1:  // 10 Man (icc/toc)
                                default: // All others
                                    $sql_query .= "SELECT `lootid_1`, `type` FROM `armory_instance_data`";
                                    break;
                            }
                            $difficulty = 'n';
                            break;
                        case 'heroic':
                            switch($instance_data['difficulty']) { // instance diffuclty, not related to get_array['difficulty']
                                case 1: // 10 Man (icc/toc)
                                    $sql_query .= "SELECT `lootid_3` `type` FROM `armory_instance_data`";
                                    break;
                                case 2: // 25 Man (icc/toc)
                                    $sql_query .= "SELECT `lootid_4`, `type` FROM `armory_instance_data`";
                                    break;
                                default: // All others
                                    $sql_query .= "SELECT `lootid_2`, `type` FROM `armory_instance_data`";
                                    break;
                            }
                            $difficulty = 'h';
                            break;
                    }
                    if(isset($this->get_array['dungeon']) && $this->get_array['dungeon'] != 'all' && !empty($this->get_array['dungeon'])) {
                        $instance_id = Utils::GetDungeonId($this->get_array['dungeon']);
                        $sql_query .= sprintf(" WHERE `instance_id`=%d", $instance_id);
                    }
                    if(isset($this->get_array['boss']) && $this->get_array['boss'] != 'all' && !empty($this->get_array['boss'])) {
                        if(is_numeric($this->get_array['boss'])) {
                            $sql_query .= sprintf(" AND `id`=%d OR `lootid_1`=%d OR `lootid_2`=%d OR `lootid_3`=%d OR `lootid_4`=%d", $this->get_array['boss'], $this->get_array['boss'], $this->get_array['boss'], $this->get_array['boss'], $this->get_array['boss']);
                        }
                        else {
                            $sql_query .= sprintf(" AND `key`='%s'", $this->get_array['boss']);
                        }
                    }
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
                        $current_dungeon_data = $this->aDB->selectRow("SELECT `id`, `map`, `name_%s` AS `name` FROM `armory_instance_template` WHERE `key`=%d LIMIT 1", $this->_locale, $current_instance_key);
                    }
                    if($this->searchQuery && is_array($item_id_array)) {
                        $tmp_sql = sprintf("
                        SELECT
                        `item_template`.`entry` AS `id`,
                        `item_template`.`name`,
                        `item_template`.`ItemLevel`,
                        `item_template`.`Quality` AS `rarity`,
                        `item_template`.`displayid`,
                        `item_template`.`bonding`,
                        `item_template`.`flags`,
                        `item_template`.`duration`,
                        `creature_loot_template`.`entry`,
                        `creature_loot_template`.`item`,
                        `creature_loot_template`.`ChanceOrQuestChance`
                        FROM `item_template` AS `item_template`
                        LEFT JOIN `creature_loot_template` AS `creature_loot_template` ON `creature_loot_template`.`item`=`item_template`.`entry`
                        WHERE `creature_loot_template`.`entry` IN (%s) AND `creature_loot_template`.`item` IN (%s)
                        ORDER BY `item_template`.`ItemLevel` DESC LIMIT 200",
                        $loot_table, $item_id_string);
                        $items_query = $this->wDB->select($tmp_sql);
                        if(!$items_query) {
                            $tmp_sql = sprintf("
                            SELECT
                            `item_template`.`entry` AS `id`,
                            `item_template`.`name`,
                            `item_template`.`ItemLevel`,
                            `item_template`.`Quality` AS `rarity`,
                            `item_template`.`displayid`,
                            `item_template`.`bonding`,
                            `item_template`.`flags`,
                            `item_template`.`duration`,
                            `gameobject_loot_template`.`entry`,
                            `gameobject_loot_template`.`item`,
                            `gameobject_loot_template`.`ChanceOrQuestChance`
                            FROM `item_template` AS `item_template`
                            LEFT JOIN `gameobject_loot_template` AS `gameobject_loot_template` ON `gameobject_loot_template`.`item`=`item_template`.`entry`
                            WHERE `gameobject_loot_template`.`entry` IN (%s) AND `gameobject_loot_template`.`item` IN (%s)
                            ORDER BY `item_template`.`ItemLevel` DESC LIMIT 200",
                            $loot_table, $item_id_string);
                            $items_query = $this->wDB->select($tmp_sql);
                        }
                    }
                    else {
                        $items_query = $this->wDB->select("
                        SELECT
                        `item_template`.`entry` AS `id`,
                        `item_template`.`name`,
                        `item_template`.`ItemLevel`,
                        `item_template`.`Quality` AS `rarity`,
                        `item_template`.`displayid`,
                        `item_template`.`bonding`,
                        `item_template`.`flags`,
                        `item_template`.`duration`,
                        ".$loot_template.".`entry`,
                        ".$loot_template.".`item`,
                        ".$loot_template.".`ChanceOrQuestChance`
                        FROM `item_template` AS `item_template`
                        LEFT JOIN ".$loot_template." AS ".$loot_template." ON ".$loot_template.".`item`=`item_template`.`entry`
                        WHERE ".$loot_template.".`entry` IN (%s)
                        ORDER BY `item_template`.`ItemLevel` DESC LIMIT 200",
                        $loot_table);
                    }
                }
                break;
            case 'reputation':
                if(!isset($this->get_array['faction'])) {
                    $this->get_array['faction'] = 'all';
                }
                if($this->get_array['faction'] == 'all' || $this->get_array['faction'] == -1) {
                    $items_query = $this->wDB->select("SELECT `entry` AS `id`, `name`, `ItemLevel`, `Quality` AS `rarity`, `displayid`, `bonding`, `flags`, `duration` FROM `item_template` WHERE `RequiredReputationFaction` > 0 ORDER BY `ItemLevel` DESC LIMIT 200");
                }
                else {
                    $items_query = $this->wDB->select("SELECT `entry` AS `id`, `name`, `ItemLevel`, `Quality` AS `rarity`, `displayid`, `bonding`, `flags`, `duration` FROM `item_template` WHERE `RequiredReputationFaction`=%d ORDER BY `ItemLevel` DESC LIMIT 200", $this->get_array['faction']);
                }
                break;
            case 'pvpAlliance':
            case 'pvpHorde':
                if(!isset($this->get_array['pvp'])) {
                    $this->get_array['pvp'] = 'all';
                }
                if($this->get_array['pvp'] == 'all' || $this->get_array['pvp'] == -1) {
                    $pvpVendorsId = $this->aDB->select("SELECT `item` FROM `armory_item_sources` WHERE `key` IN ('wintergrasp', 'arena8', 'arena7', 'arena6', 'arena5', 'arena4', 'arena3', 'arena2', 'arena1', 'honor', 'ab', 'av', 'wsg', 'halaa', 'honorhold', 'terrokar', 'zangarmarsh', 'thrallmar')");
                    if(!$pvpVendorsId) {
                        $this->Log()->writeError('%s : unable to get data for pvpVendors from armory_item_sources', __METHOD__);
                        return false;
                    }
                }
                else {
                    $pvpVendorsId = $this->aDB->select("SELECT `item` FROM `armory_item_sources` WHERE `key`='%s'", $this->get_array['pvp']);
                    if(!$pvpVendorsId) {
                        $this->Log()->writeError('%s : unable to get data for pvpVendors from armory_item_sources (faction: %s, key: %s)', __METHOD__, $this->get_array['source'], $this->get_array['pvp']);
                        return false;
                    }
                }
                $countVendors = count($pvpVendorsId);
                $string_vendors = null;
                for($i = 0; $i < $countVendors; $i++) {
                    $tmpVendID = explode('/', $pvpVendorsId[$i]['item']);
                    if(is_array($tmpVendID) && isset($tmpVendID[0]) && isset($tmpVendID[1])) {
                        if($this->get_array['source'] == 'pvpAlliance') {
                            $vendors_id = $tmpVendID[0];
                        }
                        else {
                            $vendors_id = $tmpVendID[1];
                        }
                    }
                    else {
                        $vendors_id = $pvpVendorsId[$i]['item'];
                    }
                    if($i) {
                        $string_vendors .= ', ' . $vendors_id; 
                    }
                    else {
                        $string_vendors .= $vendors_id;
                    }
                }
                if($this->searchQuery && is_array($item_id_array)) {
                    $tmp_sql = sprintf("
                    SELECT DISTINCT
                    `item_template`.`entry` AS `id`,
                    `item_template`.`name`,
                    `item_template`.`ItemLevel`,
                    `item_template`.`Quality` AS `rarity`,
                    `item_template`.`displayid`,
                    `item_template`.`bonding`,
                    `item_template`.`flags`,
                    `item_template`.`duration`
                    FROM `item_template` AS `item_template`
                    LEFT JOIN `npc_vendor` AS `npc_vendor` ON `npc_vendor`.`item`=`item_template`.`entry`
                    WHERE `npc_vendor`.`entry` IN (%s) AND `npc_vendor`.`item` IN (%s)
                    ORDER BY `item_template`.`ItemLevel` DESC LIMIT 200", $string_vendors, $item_id_string);
                    $items_query = $this->wDB->select($tmp_sql);
                }
                else {
                    $items_query = $this->wDB->select("
                    SELECT DISTINCT
                    `item_template`.`entry` AS `id`,
                    `item_template`.`name`,
                    `item_template`.`ItemLevel`,
                    `item_template`.`Quality` AS `rarity`,
                    `item_template`.`displayid`,
                    `item_template`.`bonding`,
                    `item_template`.`flags`,
                    `item_template`.`duration`
                    FROM `item_template` AS `item_template`
                    LEFT JOIN `npc_vendor` AS `npc_vendor` ON `npc_vendor`.`item`=`item_template`.`entry`
                    WHERE `npc_vendor`.`entry` IN (%s)
                    ORDER BY `item_template`.`ItemLevel` DESC LIMIT 200", $string_vendors);
                }
                break;
        }
        if(!isset($items_query) || !is_array($items_query)) {
            $this->Log()->writeError('%s : unable to get items for "%s" query (current locale: %s, locId: %d) ', __METHOD__, $this->searchQuery, $this->_locale, $this->_loc);
            return false;
        }
        $items_result = array();
        $exists_items = array();
        $i = 0;
        foreach($items_query as $item) {
            if(isset($exists_items[$item['id']])) {
                continue; // do not add the same items to result array
            }
            if($i >= 200) {
                if($count) {
                    return count($exists_items);
                }
                else {
                    return $items_result;
                }
            }
            elseif(!$count) {
                if($this->get_array['source'] == 'dungeon' && $allowedDungeon && isset($this->get_array['boss'])) {
                    $current_instance_key = Utils::GetBossDungeonKey($item['entry']);
                    $current_dungeon_data = $this->aDB->selectRow("SELECT `id`, `map`, `name_%s` AS `name` FROM `armory_instance_template` WHERE `key`='%s' LIMIT 1", $this->_locale, $current_instance_key);
                }
                $items_result[$i]['data'] = array();
                $items_result[$i]['filters'] = array();
                $items_result[$i]['data']['id'] = $item['id'];
                if($this->_locale != 'en_gb' || $this->_locale != 'en_us') {
                    $items_result[$i]['data']['name'] = Items::getItemName($item['id']);
                }
                else {
                    $items_result[$i]['data']['name'] = $item['name'];
                }
                if(self::CanAuction($item)) {
                    $items_result[$i]['data']['canAuction'] = 1;
                }
                $items_result[$i]['data']['rarity'] = $item['rarity'];
                $items_result[$i]['data']['icon'] = $this->aDB->selectCell("SELECT `icon` FROM `armory_icons` WHERE `displayid`=%d", $item['displayid']);
                $items_result[$i]['filters'][0] = array('name' => 'itemLevel', 'value' => $item['ItemLevel']);
                $items_result[$i]['filters'][1] = array('name' => 'relevance', 'value' => 100);
                switch($this->get_array['source']) {
                    case 'dungeon':
                        if(isset($current_dungeon_data) && $allowedDungeon && is_array($current_dungeon_data)) {
                            $items_result[$i]['filters'][2] = array(
                                'areaId' => $current_dungeon_data['id'],
                                'areaKey' => $current_instance_key,
                                'areaName' => $current_dungeon_data['name'],
                                'name' => 'source',
                                'value' => $source_type
                            );
                        }
                        elseif(!$allowedDungeon && self::IsExtendedCost()) {
                            $items_result[$i]['filters'][2] = array('name' => 'source', 'value' => 'sourceType.vendor');
                        }
                        break;
                    case 'reputation':
                        $items_result[$i]['filters'][2] = array('name' => 'source', 'value' => 'sourceType.factionReward');
                        break;
                    case 'quest':
                        $items_result[$i]['filters'][2] = array('name' => 'source', 'value' => 'sourceType.questReward');
                        break;
                    case 'pvpAlliance':
                    case 'pvpHorde':
                        $items_result[$i]['filters'][2] = array('name' => 'source', 'value' => 'sourceType.vendor');
                        break;
                }
            }
            $exists_items[$item['id']] = $item['id'];
            $i++;
        }
        if($count == true) {
            return count($exists_items);
        }
        return $items_result;
    }
    
    public function SearchArenaTeams($num = false) {
        if(!$this->searchQuery) {
            return false;
        }
        $results = array(); // Full results
        $current_realm = array();
        $count_results = 0; // All realms results
        $count_results_currrent_realm = 0; // Current realm results
        $db = null; // Temporary handler
        if($num == true) {
            foreach($this->realmData as $realm_info) {
                $count_results_currrent_realm = 0;
                $db = new ArmoryDatabaseHandler($realm_info['host_characters'], $realm_info['user_characters'], $realm_info['pass_characters'], $realm_info['name_characters'], $realm_info['charset_characters'], $this->Log());
                $count_results_currrent_realm = $db->selectCell("SELECT COUNT(`arenateamid`) FROM `arena_team` WHERE `name` LIKE '%s' LIMIT 200", '%'.$this->searchQuery.'%');
                $count_results = $count_results + $count_results_currrent_realm;
            }
            return $count_results;
        }
        foreach($this->realmData as $realm_info) {
            $db = new ArmoryDatabaseHandler($realm_info['host_characters'], $realm_info['user_characters'], $realm_info['pass_characters'], $realm_info['name_characters'], $realm_info['charset_characters'], $this->Log());
            $current_realm = $db->select("
            SELECT `arena_team`.`name`, `arena_team`.`type` AS `size`, `arena_team_stats`.`rating`, `characters`.`race`
                FROM `arena_team` AS `arena_team`
                    LEFT JOIN `arena_team_stats` AS `arena_team_stats` ON `arena_team`.`arenateamid`=`arena_team_stats`.`arenateamid`
                    LEFT JOIN `characters` AS `characters` ON `arena_team`.`captainguid`=`characters`.`guid`
                        WHERE `arena_team`.`name` LIKE '%s' LIMIT 200", '%'.$this->searchQuery.'%');
            if(!$current_realm) {
                continue;
            }
            $count_current_realm = count($current_realm);
            foreach($current_realm as $realm) {
                $realm['teamSize'] = $realm['size'];
                $realm['battleGroup'] = $this->armoryconfig['defaultBGName'];
                $realm['factionId'] = Utils::GetFactionId($realm['race']);
                $realm['relevance'] = 100;
                $realm['realm'] = $realm_info['name'];
                $realm['url'] = sprintf('r=%s&ts=%d&t=%s', urlencode($realm_info['name']), $realm['size'], urlencode($realm['name']));
                unset($realm['race']);
                $results[] = $realm;
            }
        }
        if($results) {
            return $results;
        }
        return false;
    }
    
    public function SearchGuilds($num = false) {
        if(!$this->searchQuery) {
            return false;
        }
        $results = array(); // Full results
        $current_realm = array();
        $count_results = 0; // All realms results
        $count_results_currrent_realm = 0; // Current realm results
        $db = null; // Temporary handler
        if($num == true) {
            foreach($this->realmData as $realm_info) {
                $count_results_currrent_realm = 0;
                $db = new ArmoryDatabaseHandler($realm_info['host_characters'], $realm_info['user_characters'], $realm_info['pass_characters'], $realm_info['name_characters'], $realm_info['charset_characters'], $this->Log());
                $count_results_currrent_realm = $db->selectCell("SELECT COUNT(`guildid`) FROM `guild` WHERE `name` LIKE '%s' LIMIT 200", '%'.$this->searchQuery.'%');
                $count_results = $count_results + $count_results_currrent_realm;
            }
            return $count_results;
        }
        foreach($this->realmData as $realm_info) {
            $db = new ArmoryDatabaseHandler($realm_info['host_characters'], $realm_info['user_characters'], $realm_info['pass_characters'], $realm_info['name_characters'], $realm_info['charset_characters'], $this->Log());
            $current_realm = $db->select("SELECT `guild`.`name`, `characters`.`race` FROM `guild` AS `guild` LEFT JOIN `characters` AS `characters` ON `guild`.`leaderguid`=`characters`.`guid` WHERE `guild`.`name` LIKE '%s' LIMIT 200", '%'.$this->searchQuery.'%');
            if(!$current_realm) {
                continue;
            }
            $count_current_realm = count($current_realm);
            foreach($current_realm as $realm) {
                $realm['battleGroup'] = $this->armoryconfig['defaultBGName'];
                $realm['factionId'] = Utils::GetFactionId($realm['race']);
                $realm['relevance'] = 100; // All guilds have 100% relevance
                $realm['realm'] = $realm_info['name'];
                $realm['url'] = sprintf('r=%s&gn=%s', urlencode($realm_info['name']), urlencode($realm['name']));
                unset($realm['race']);
                $results[] = $realm;
            }
        }
        if($results) {
            return $results;
        }
        return false;
    }
    
    public function SearchCharacters($num = false) {
        if(!$this->searchQuery) {
            $this->Log()->writeLog('%s : searchQuery not defined', __METHOD__);
            return false;
        }
        $currentTimeStamp = time();
        $results = array(); // Full results
        $current_realm = array();
        $count_results = 0; // All realms results
        $count_results_currrent_realm = 0; // Current realm results
        $db = null; // Temporary handler
        $countRealmData = count($this->realmData);
        if($num == true) {
            foreach($this->realmData as $realm_info) {
                $count_results_currrent_realm = 0;
                $db = new ArmoryDatabaseHandler($realm_info['host_characters'], $realm_info['user_characters'], $realm_info['pass_characters'], $realm_info['name_characters'], $realm_info['charset_characters'], $this->Log());
                $characters_data[] = $db->select("SELECT `guid`, `level`, `account` FROM `characters` WHERE `name` LIKE '%s' AND `level` >= %d LIMIT 200", '%' . $this->searchQuery . '%', $this->armoryconfig['minlevel']);
            }
            for($ii = 0; $ii < $countRealmData; $ii++) {
                $count_result_chars = count($characters_data[$ii]);
                for($i=0;$i<$count_result_chars;$i++) {
                    if(isset($characters_data[$ii][$i]) && self::IsCharacterAllowedForSearch($characters_data[$ii][$i]['guid'], $characters_data[$ii][$i]['level'], $characters_data[$ii][$i]['account'])) {
                        $count_results++;
                    }
                }
            }
            return $count_results;
        }
        $accounts_cache = array(); // For relevance calculation
        foreach($this->realmData as $realm_info) {
            $db = new ArmoryDatabaseHandler($realm_info['host_characters'], $realm_info['user_characters'], $realm_info['pass_characters'], $realm_info['name_characters'], $realm_info['charset_characters'], $this->Log());
            if(!$db) {
                continue;
            }
            $current_realm = $db->select("SELECT `guid`, `name`, `class` AS `classId`, `gender` AS `genderId`, `race` AS `raceId`, `level`, `account` FROM `characters` WHERE `name` LIKE '%s'", '%'.$this->searchQuery.'%');
            if(!$current_realm) {
                continue;
            }
            $count_current_realm = count($current_realm);
            foreach($current_realm as $realm) {
                if(!self::IsCharacterAllowedForSearch($realm['guid'], $realm['level'], $realm['account'])) {
                    continue;
                }
                if($realm['guildId'] = $db->selectCell("SELECT `guildid` FROM `guild_member` WHERE `guid`=%d", $realm['guid'])) {
                    $realm['guild'] = $db->selectCell("SELECT `name` FROM `guild` WHERE `guildid`=%d", $realm['guildId']);
                    $realm['guildUrl'] = sprintf('r=%s&gn=%s', urlencode($realm_info['name']), urlencode($realm['guild']));
                }
                $realm['url'] = sprintf('r=%s&cn=%s', urlencode($realm_info['name']), urlencode($realm['name']));
                $realm['battleGroup'] = $this->armoryconfig['defaultBGName'];
                $realm['battleGroupId'] = 1;
                $realm['class'] = $this->aDB->selectCell("SELECT `name_%s` FROM `armory_classes` WHERE `id`=%d", $this->_locale, $realm['classId']);
                $realm['race'] = $this->aDB->selectCell("SELECT `name_%s` FROM `armory_races` WHERE `id`=%d", $this->_locale, $realm['raceId']);
                $realm['realm'] = $realm_info['name'];
                $realm['factionId'] = Utils::GetFactionId($realm['raceId']);
                $realm['searchRank'] = 1; //???
                /* Calculate relevance */
                $realm['relevance'] = 100;
                // Relevance by last login date will check `realmd`.`account`.`last_login` timestamp
                // First of all - check character level
                $temp_value = $realm['level'];
                if($temp_value > 70 && $temp_value < PLAYER_MAX_LEVEL) {
                    $realm['relevance'] -= 20;
                }
                elseif($temp_value > 60 && $temp_value < 70) {
                    $realm['relevance'] -= 25;
                }
                elseif($temp_value > 50 && $temp_value < 60) {
                    $realm['relevance'] -= 30;
                }
                elseif($temp_value > 40 && $temp_value < 50) {
                    $realm['relevance'] -= 35;
                }
                elseif($temp_value > 30 && $temp_value < 40) {
                    $realm['relevance'] -= 40;
                }
                elseif($temp_value > 20 && $temp_value < 30) {
                    $realm['relevance'] -= 45;
                }
                elseif($temp_value < 20) {
                    $realm['relevance'] -= 50;
                    // characters with level < 20 have 50% relevance and other reasons can't change this value
                    unset($realm['account'], $realm['guid']);
                    $results[] = $realm;
                    continue;
                }
                // Check last login date. If it's more than 2 days, decrease relevance by 4 for every day
                if(!isset($accounts_cache[$realm['account']])) {
                    $lastLogin = $this->rDB->selectCell("SELECT `last_login` FROM `account` WHERE `id`=%d", $realm['account']);
                    $accounts_cache[$realm['account']] = $lastLogin;
                }
                else {
                    $lastLogin = $accounts_cache[$realm['account']];
                }
                $lastLoginTimestamp = strtotime($lastLogin);
                $diff = $currentTimeStamp - $lastLoginTimestamp;
                if($lastLogin && $diff > 0) {
                    // 1 day is 86400 seconds
                    $totalDays = round($diff/86400);
                    if($totalDays > 2) {
                        $decreaseRelevanceByLogin = $totalDays*4;
                        $realm['relevance'] -= $decreaseRelevanceByLogin;
                    }
                }
                // Relevance for characters can't be less than 50
                if($realm['relevance'] < 50) {
                    $realm['relevance'] = 50;
                }
                // Relevance can't be more than 100
                if($realm['relevance'] > 100) {
                    $realm['relevance'] = 100;
                }
                unset($realm['account'], $realm['guid']);
                $results[] = $realm;
            }
        }
        if($results) {
            return $results;
        }
        return false;
    }
    
    public function IsExtendedCost() {
        if(!isset($this->get_array['dungeon'])) {
            $this->Log()->writeError('%s is for `dungeon` cases only!', __METHOD__);
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
            $this->Log()->writeError('%s : bossSearchKey not defined', __METHOD__);
            return false;
        }
        return $this->aDB->selectCell("SELECT `name_%s` FROM `armory_instance_template` WHERE `id` IN (SELECT `instance_id` FROM `armory_instance_data` WHERE `key`='%s') LIMIT 1", $this->_locale, $this->bossSearchKey);
    }
    
    public function GetBossKeyById() {
        if(!isset($this->get_array['boss']) || !is_numeric($this->get_array['boss'])) {
            return false;
        }
        $this->bossSearchKey = $this->aDB->selectCell("SELECT `key` FROM `armory_instance_data` WHERE `id`=%d LIMIT 1", $this->get_array['boss']);
        return $this->bossSearchKey;
    }
    
    public function GetItemSourceByInstanceKey() {
        if(!$this->instanceSearchKey) {
            $this->Log()->writeError('%s : instanceSearchKey not defined', __METHOD__);
            return false;
        }
        return $this->aDB->selectCell("SELECT `name_%s` FROM `armory_instance_template` WHERE `key`=%d LIMIT 1", $this->_locale, $this->instanceSearchKey);
    }
    
    public function MakeUniqueArray($array, $preserveKeys = false) {
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
    
    private function IsCharacterAllowedForSearch($guid, $level, $account_id) {
        if($level < $this->armoryconfig['minlevel']) {
            return false;
        }
        $gmLevel = $this->rDB->selectCell("SELECT `gmlevel` FROM `account` WHERE `id`=%d LIMIT 1", $account_id);
        if($gmLevel <= $this->armoryconfig['minGmLevelToShow']) {
            return true;
        }
        return false;
    }
    
    /**
     * Helper
     **/
    private function CanAuction($item_data) {
        //                      Undef BoE BoU
        $allowed_bondings = array(0,   2,  3);
        if(!in_array($item_data['bonding'], $allowed_bondings)) {
            // Wrong bonding type
            return false;
        }
        elseif($item_data['flags']&0x00000002) {
            // Conjured items can't be traded via auction.
            return false;
        }
        elseif($item_data['duration'] > 0) {
            // Items with duration can't be traded via auction.
            return false;
        }
        else {
            //$this->Log()->writeLog('%s : item #%d can be traded via auction', __METHOD__, $item_data['id']);
            return true;
        }
    }
    
    /**
     * Calculates relevance for item/character/arena team in search results
     * This function is beta version!
     * If somebody have info about how it works, please PM me on getmangos.com or on github.com
     * @category Search class
     * @access   private
     * @return   bool
     * @todo     try find more correct way to generate max/min ratings (for arenateams case)
     **/
    private function CalculateRelevance() {
        if(!$this->results) {
            $this->Log()->writeError('%s can be called only after Search::$results variable assigned', __METHOD__);
            return false;
        }
        elseif(!$this->type_results) {
            $this->Log()->writeError('%s : type_results not defined, ignore.', __METHOD__);
            return false;
        }
        $accounts_cache = array(); // For last_login timestamps
        $arenateams_cache = array(
            'minRating' => array(
                'value' => 0,
                'teamSize' => 0
            ),
            'maxRating' => array(
                'value' => 0,
                'teamSize' => 0
            ),
            'minRating2' => array(
                'value' => 0,
                'loopId' => 0,
            ),
            'minRating3' => array(
                'value' => 0,
                'loopId' => 0,
            ),
            'minRating5' => array(
                'value' => 0,
                'loopId' => 0,
            ),
            'maxRating2' => array(
                'value' => 0,
                'loopId' => 0,
            ),
            'maxRating3' => array(
                'value' => 0,
                'loopId' => 0,
            ),
            'maxRating5' => array(
                'value' => 0,
                'loopId' => 0,
            )
        ); // For arenateams case
        $currentTimeStamp = time(); // For characters relevance calculation
        // Get max/min ratings value
        $i = 0;
        if($this->type_results == 'arenateams') {
            foreach($this->results as $result_temp) {
                if($result_temp['rating'] > $arenateams_cache['maxRating']['value']) {
                    $arenateams_cache['maxRating'] = array(
                        'value' => $result_temp['rating'],
                        'teamSize' => $result_temp['teamSize'],
                        'loopId' => $i,
                        'handled' => false
                    );
                }
                if($result_temp['rating'] > 0 && $arenateams_cache['minRating']['value'] > 0 && $result_temp['rating'] < $arenateams_cache['minRating']['value']) {
                    $arenateams_cache['minRating'] = array(
                        'value' => $result_temp['rating'],
                        'teamSize' => $result_temp['teamSize'],
                        'loopId' => $i,
                        'handled' => false
                    );
                }
                if($result_temp['rating'] > 0 && $arenateams_cache['maxRating' . $result_temp['teamSize']]['value'] > 0 && $result_temp['rating'] > $arenateams_cache['maxRating' . $result_temp['teamSize']]['value']) {
                    $arenateams_cache['maxRating' . $result_temp['teamSize']] = array(
                        'value' => $result_temp['rating'],
                        'loopId' => $i
                    );
                }
                if($result_temp['rating'] < $arenateams_cache['minRating' . $result_temp['teamSize']]['value']) {
                    $arenateams_cache['minRating' . $result_temp['teamSize']] = array(
                        'value' => $result_temp['rating'],
                        'loopId' => $i
                    );
                }
            }
            $i++;
        }
        $totalCount = count($this->results);
        for($i = 0; $i < $totalCount; $i++) {
            // All results have 100 relevance now. This value will be decreased through loop (if any reason for it found)
            switch($this->type_results) {
                case 'characters':
                    $this->results[$i]['relevance'] = 100;
                    // Relevance by last login date will check `realmd`.`account`.`last_login` timestamp
                    // First of all - check character level
                    $temp_value = $this->results[$i]['level'];
                    if($temp_value > 70 && $temp_value < PLAYER_MAX_LEVEL) {
                        $this->results[$i]['relevance'] -= 20;
                    }
                    elseif($temp_value > 60 && $temp_value < 70) {
                        $this->results[$i]['relevance'] -= 25;
                    }
                    elseif($temp_value > 50 && $temp_value < 60) {
                        $this->results[$i]['relevance'] -= 30;
                    }
                    elseif($temp_value > 40 && $temp_value < 50) {
                        $this->results[$i]['relevance'] -= 35;
                    }
                    elseif($temp_value > 30 && $temp_value < 40) {
                        $this->results[$i]['relevance'] -= 40;
                    }
                    elseif($temp_value > 20 && $temp_value < 30) {
                        $this->results[$i]['relevance'] -= 45;
                    }
                    elseif($temp_value < 20) {
                        $this->results[$i]['relevance'] -= 50;
                        continue; // characters with level < 20 have 50% relevance and other reasons can't change this value
                    }
                    // Check last login date. If it's more than 2 days, decrease relevance by 4 for every day
                    if(!isset($accounts_cache[$this->results[$i]['account']])) {
                        $lastLogin = $this->rDB->selectCell("SELECT `last_login` FROM `account` WHERE `id`=%d", $this->results[$i]['account']);
                        $accounts_cache[$this->results[$i]['account']] = $lastLogin;
                    }
                    else {
                        $lastLogin = $accounts_cache[$this->results[$i]['account']];
                    }
                    // unset 'account' value (for security reason)
                    if(isset($this->results[$i]['account'])) {
                        unset($this->results[$i]['account']);
                    }
                    $lastLoginTimestamp = strtotime($lastLogin);
                    $diff = $currentTimeStamp - $lastLoginTimestamp;
                    if($lastLogin && $diff > 0) {
                        // 1 day is 86400 seconds
                        $totalDays = round($diff/86400);
                        if($totalDays > 2) {
                            $decreaseRelevanceByLogin = $totalDays*4;
                            $this->results[$i]['relevance'] -= $decreaseRelevanceByLogin;
                        }
                    }
                    // Relevance for characters can't be less than 50
                    if($this->results[$i]['relevance'] < 50) {
                        $this->results[$i]['relevance'] = 50;
                    }
                    // Relevance can't be more than 100
                    if($this->results[$i]['relevance'] > 100) {
                        $this->results[$i]['relevance'] = 100;
                    }
                    break;
                case 'arenateams':
                    /*$this->results[$i]['relevance'] = 100;
                    if($this->results[$i]['rating'] == 0) {
                        $this->results[$i]['relevance'] = 50;
                        continue;
                    }
                    // 5v5>3v3>2v2
                    if($this->results[$i]['teamSize'] == 5) {
                        if($this->results[$i]['rating'] > $arenateams_cache['maxRating5']['value']) {
                            $tempRelevance = 5*5*;
                        }
                        elseif($this->results[$i]['rating'] < $arenateams_cache['maxRating5']['value']) {
                            $tempRelevance = 5*5;
                            $this->results[$arenateams_cache['maxRating5']['loopId']]['relevance'] -= FIX_ME;
                        }
                    }
                    elseif($this->results[$i]['relevance'] == 3) {
                        $tempRelevance = 5*3;
                    }
                    else {
                        $tempRelevance = 5*2;
                    }
                    if($this->results[$i]['rating'] > $arenateams_cache['maxRating']['value']) {
                        $arenateams_cache['maxRating'] = array(
                            'value' => $this->results[$i]['rating'],
                            'teamSize' => $this->results[$i]['teamSize'],
                            'loopId' => $i
                        );
                        if($this->results[$i]['teamSize'] > $arenateams_cache['maxRating']['teamSize']) {
                            $diff = ($this->results[$i]['teamSize']-$arenateams_cache['maxRating']['teamSize']);
                            $tempRelevance += $this->results[$i]['teamSize'] - $arenateams_cache['maxRating']['teamSize'];
                        }
                    }
                    // Relevance for arena teams can't be less than 50
                    if($this->results[$i]['relevance'] < 50) {
                        $this->results[$i]['relevance'] = 50;
                    }
                    // Relevance can't be more than 100
                    if($this->results[$i]['relevance'] > 100) {
                        $this->results[$i]['relevance'] = 100;
                    }
                    */
                    break;
                case 'items':
                    // Relevance can't be more than 100
                    if($this->results[$i]['relevance'] > 100) {
                        $this->results[$i]['relevance'] = 100;
                    }
                    break;
            }
        }
        return true;
    }
    
    /**
     * Do all dirty work with search filters here =)
     * Can be called only from Search::AdvancedItemsSearch()
     * @category Search class
     * @access   public
     * @return   bool
     **/
    public function HandleItemFilters() {
        if(!$this->get_array) {
            $this->Log()->writeError('%s : Search::$get_array not defined', __METHOD__);
            return false;
        }
        // First of all - convert $_SERVER['QUERY_STRING'] to array
        if(!isset($_SERVER['QUERY_STRING'])) {
            $this->Log()->writeError('%s : unable to find SERVER[QUERY_STRING] array', __METHOD__);
            return false;
        }
        $query_string = explode('&', urldecode($_SERVER['QUERY_STRING']));
        if(!is_array($query_string)) {
            $this->Log()->writeError('%s : SERVER[QUERY_STRING] exists but handler was unable to convert it to array', __METHOD__);
            return false;
        }
        $sql_query = "SELECT `entry` FROM `item_template`";
        $andor = false;
        $options_holder = explode('&', $query_string);
        $optionsCounter = count($options_holder);
        for($i = 0; $i < $optionsCounter; $i++) {
            $opt_value = $road[$i];
            $opt_value = str_replace('fl[', '', $opt_value);
            $opt_value = str_replace(']', '', $opt_value);
            $tmp_expl = explode('=', $opt_value);
            if($tmp_expl[0] == 'advOptName') {
                // We need to get next 2 values (type (gt - great than; lt - less than) and value)
                $tmpType = explode('=', $options_holder[$i+1]);
                $tmpValue = explode('=', $options_holder[$i+2]);
                $type = false;
                if(!is_array($tmpType) || !is_array($tmpValue)) {
                    continue;
                }
                elseif($tmpType[0] != 'advOptOper' || $tmpValue[0] != 'advOptValue') {
                    continue;
                }
                if($tmpType[1] == 'gt') {
                    $type = '>';
                }
                elseif($tmpType[1] == 'lt') {
                    $type = '<';
                }
                if($tmpValue[1] < 0) {
                    continue;
                }
                $tmp_data = null;
                switch($tmp_expl[1]) {
                    // All types can be found in _data/items/advoptions.xml
                    case 'strength':
                        $tmp_data = ' WHERE (';
                        for($a=1;$a<11;$a++) {
                            if($a) {
                                $tmp_data .= 'OR `stat_type' . $a .'`' . $type .'=' . $tmpValue[1];
                            }
                            else {
                                $tmp_data .= '`stat_type' . $a .'`' . $type .'=' . $tmpValue[1];
                            }
                        }
                        break;
                }
            }
        }
    }
}
?>