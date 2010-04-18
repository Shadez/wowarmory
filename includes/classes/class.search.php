<?php

/**
 * @package World of Warcraft Armory
 * @version Release Candidate 1
 * @revision 148
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
        if((!$this->get_array || !is_array($this->get_array)) && !$this->searchQuery ) {
            return false;
        }
        if(!isset($this->get_array['source'])) {
            return false;
        }
        $allowedDungeon = false;
        // Get item IDs first (if $this->searchQuery)
        $item_id_array = array();
        if($this->searchQuery) {
            $_item_ids = $this->wDB->select("SELECT `entry` FROM `item_template` WHERE `name` LIKE ? OR `entry` IN (SELECT `entry` FROM `locales_item` WHERE `name_loc".$this->_loc."` LIKE ?) LIMIT 200", '%'.$this->searchQuery.'%', '%'.$this->searchQuery.'%');
            if($_item_ids) {
                foreach($_item_ids as $id) {
                    $item_id_array[] = $id['entry'];
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
                $sql_query = "SELECT `entry` AS `item` FROM `item_template`";
                $andor = false;
                if(isset($this->get_array['type']) && !empty($this->get_array['type'])) {
                    /* Type */
                    if($this->get_array['type'] != 'all') {
                        $type_info = $this->aDB->selectCell("SELECT `type` FROM `armory_item_sources` WHERE `key`=? AND `parent`=0", $this->get_array['type']);
                        if(!$type_info) {
                            return false;
                        }
                        $sql_query = sprintf("SELECT `entry` AS `item` FROM `item_template` WHERE `class`=%d", $type_info);
                        $andor = true;
                    }
                    /* Subtype */
                    if(isset($this->get_array['subTp']) && !empty($this->get_array['subTp'])) {
                        if($this->get_array['subTp'] != 'all' && isset($type_info) && $type_info) {
                            $subtype_info = $this->aDB->selectRow("SELECT `type`, `subtype` FROM `armory_item_sources` WHERE `key`=? AND `parent`=?", $this->get_array['subTp'], $type_info);
                            if($subtype_info) {
                                $sql_query .= sprintf(" AND `subclass`=%d", $subtype_info['subtype']);
                                $andor = true;
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
                        }
                    }
                    elseif(isset($this->get_array['rqrMax']) && !empty($this->get_array['rqrMax'])) {
                        if($andor) {
                            $sql_query .= sprintf(" AND `RequiredLevel` <= %d", (int) $this->get_array['rqrMax']);
                        }
                        else {
                            $sql_query .= sprintf(" WHERE `RequiredLevel` <= %d", (int) $this->get_array['rqrMax']);
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
                            case 'dd': // Warlock: damage + crit
                                break;
                        }
                    }*/
                    
                    /* Search string */
                    if(isset($this->searchQuery)&& !empty($this->searchQuery)) {
                        if($andor) {
                            $sql_query .= sprintf(" AND `name` LIKE '%s' OR `entry` IN (SELECT `entry` FROM `locales_item` WHERE `name_loc%d` LIKE '%s') ORDER BY `ItemLevel` LIMIT 200", '%'.mysql_escape_string($this->searchQuery).'%', $this->_loc, '%'.mysql_escape_string($this->searchQuery).'%');
                        }
                        else {
                            $sql_query .= sprintf(" WHERE `name` LIKE '%s' OR `entry` IN (SELECT `entry` FROM `locales_item` WHERE `name_loc%d` LIKE '%s') ORDER BY `ItemLevel` LIMIT 200", '%'.mysql_escape_string($this->searchQuery).'%', $this->_loc, '%'.mysql_escape_string($this->searchQuery).'%');
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
                        $sql_query .= sprintf(" WHERE `name` LIKE '%s' OR `entry` IN (SELECT `entry` FROM `locales_item` WHERE `name_loc%d` LIKE '%s'", '%'.mysql_escape_string($this->searchQuery).'%', $this->_loc, '%'.mysql_escape_string($this->searchQuery).'%');
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
                    $item_extended_cost = $this->aDB->selectCell("SELECT `item` FROM `armory_item_sources` WHERE `key`=? LIMIT 1", $this->get_array['dungeon']);
                    if(!$item_extended_cost) {
                        return false;
                    }
                    $extended_cost = $this->aDB->select("SELECT `id` FROM `armory_extended_cost` WHERE `item1`=? OR `item2`=? OR `item3`=? OR `item4`=? OR `item5`=?", $item_extended_cost, $item_extended_cost, $item_extended_cost, $item_extended_cost, $item_extended_cost);
                    if(!$extended_cost) {
                        return false;
                    }
                    $cost_ids = array();
                    foreach($extended_cost as $cost) {
                        $cost_ids[] = $cost['id'];
                    }
                    if($this->searchQuery && is_array($item_id_array)) {
                        $items_query = $this->wDB->select("SELECT DISTINCT `item` FROM `npc_vendor` WHERE `ExtendedCost` IN (?a) AND `item` IN (?a) ORDER BY `item` DESC LIMIT 200", $cost_ids, $item_id_array);
                    }
                    else {
                        $items_query = $this->wDB->select("SELECT DISTINCT `item` FROM `npc_vendor` WHERE `ExtendedCost` IN (?a) ORDER BY `item` DESC LIMIT 200", $cost_ids);
                    }
                }
                else {
                    $allowedDungeon = true;
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
                        $current_dungeon_data = $this->aDB->selectRow("SELECT `id`, `map`, `name_".$this->_locale."` AS `name` FROM `armory_instance_template` WHERE `key`=? LIMIT 1", $current_instance_key);
                    }
                    if($this->searchQuery && is_array($item_id_array)) {
                        $items_query = $this->wDB->select("SELECT `entry`, `item`, `ChanceOrQuestChance` FROM `creature_loot_template` WHERE `entry` IN (?a) AND `item` IN (?a) LIMIT 200", $loot_table, $item_id_array);
                        if(!$items_query) {
                            $items_query = $this->wDB->select("SELECT `entry`, `item`, `ChanceOrQuestChance` FROM `gameobject_loot_template` WHERE `entry` IN (?a) AND `item` IN (?a) LIMIT 200", $loot_table, $item_id_array);
                        }
                    }
                    else {
                        $items_query = $this->wDB->select("SELECT `entry` ,`item`, `ChanceOrQuestChance` FROM ".$loot_template." WHERE `entry` IN (?a) LIMIT 200", $loot_table);
                    }
                }
                break;
            case 'reputation':
                if(!isset($this->get_array['faction'])) {
                    $this->get_array['faction'] = 'all';
                }
                if($this->get_array['faction'] == 'all' || $this->get_array['faction'] == -1) {
                    $items_query = $this->wDB->select("SELECT `entry` AS `item` FROM `item_template` WHERE `RequiredReputationFaction` > 0 ORDER BY `ItemLevel` DESC LIMIT 200", $this->get_array['faction']);
                }
                else {
                    $items_query = $this->wDB->select("SELECT `entry` AS `item` FROM `item_template` WHERE `RequiredReputationFaction`=? ORDER BY `ItemLevel` DESC LIMIT 200", $this->get_array['faction']);
                }
                break;
        }
        if(!isset($items_query) || !$items_query) {
            return false;
        }
        $items_result = array();
        $exists_items = array();
        $i = 0;
        foreach($items_query as $item) {
            if($i >= 200) {
                if($count) {
                    return $i;
                }
                else {
                    return $items_result;
                }
            }
            elseif(!$count) {
                if(isset($exists_items[$item['item']])) {
                    continue; // do not add the same items to result array
                }
                if($this->get_array['source'] == 'dungeon' && $allowedDungeon && isset($this->get_array['boss']) && $this->get_array['boss'] == 'all') {
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
                        break;
                }
                $exists_items[$item['item']] = $item['item'];
            }
            $i++;
        }
        if($count == true) {
            return $i;
        }
        return $items_result;        
    }
    
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