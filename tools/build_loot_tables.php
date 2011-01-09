<?php

/**
 * @package World of Warcraft Armory
 * @version Release 4.50
 * @revision 450
 * @copyright (c) 2009-2011 Shadez
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

define('__ARMORY__', true);
define('__ARMORYDIRECTORY__', dirname(dirname(__FILE__)));
if(!@include(__ARMORYDIRECTORY__ . '/includes/classes/class.armory.php')) {
    die('<b>Error:</b> unable to load Armory class!');
}
$update_type = 'echo'; // Change to 'echo' to show query in you browser. Or choose 'update' to execute all queries directly to DB.
Armory::InitializeArmory();
echo '<title>World of Warcraft Armory</title>';
$check_builded = Armory::$aDB->selectCell("SELECT `loot_builded` FROM `ARMORYDBPREFIX_db_version`");
if($check_builded === 1) {
    die("You've already builded loot tables for bosses. If you want to re-build list, change field `loot_builded` to 0 in `armory_db_version` table: <br /><code>UPDATE `armory_db_version` SET `loot_builded`=0;</code>");
}
// Select all ids
$instance_data = Armory::$aDB->select("SELECT `id`, `name_id`, `type` FROM `ARMORYDBPREFIX_instance_data`");
if(!$instance_data) {
    die('Error: can not find any boss data!');
}
foreach($instance_data as $data) {
    switch($data['type']) {
        case 'npc':
            if(isset($data['name_id']) && $data['name_id'] > 0) {
                $data['id'] = $data['name_id'];
            }
            $_tmp = Armory::$wDB->selectRow("SELECT `difficulty_entry_1`, `difficulty_entry_2`, `difficulty_entry_3` FROM `creature_template` WHERE `entry`=%d", $data['id']);
            if($_tmp) {
                if(isset($data['name_id']) && $data['name_id'] > 0) {
                    if($update_type == 'update') {
                        Armory::$aDB->query("UPDATE `armory_instance_data` SET `lootid_1`=%d, `lootid_2`=%d, `lootid_3`=%d, `lootid_4`=%d WHERE `name_id`=%d", $data['id'], $_tmp['difficulty_entry_1'], $_tmp['difficulty_entry_2'], $_tmp['difficulty_entry_3'], $data['id']);
                    }
                    elseif($update_type == 'echo') {
                        echo sprintf("UPDATE `armory_instance_data` SET `lootid_1`=%d, `lootid_2`=%d, `lootid_3`=%d, `lootid_4`=%d WHERE `name_id`=%d; <br />", $data['id'], $_tmp['difficulty_entry_1'], $_tmp['difficulty_entry_2'], $_tmp['difficulty_entry_3'], $data['id']);
                    }
                }
                else {
                    if($update_type == 'update') {
                        Armory::$aDB->query("UPDATE `armory_instance_data` SET `lootid_1`=%d, `lootid_2`=%d, `lootid_3`=%d, `lootid_4`=%d WHERE `id`=%d", $data['id'], $_tmp['difficulty_entry_1'], $_tmp['difficulty_entry_2'], $_tmp['difficulty_entry_3'], $data['id']);
                    }
                    elseif($update_type == 'echo') {
                        echo sprintf("UPDATE `armory_instance_data` SET `lootid_1`=%d, `lootid_2`=%d, `lootid_3`=%d, `lootid_4`=%d WHERE `id`=%d;<br />", $data['id'], $_tmp['difficulty_entry_1'], $_tmp['difficulty_entry_2'], $_tmp['difficulty_entry_3'], $data['id']);
                    }
                }
            }
            break;
        case 'object':
            // Queries are stored in sql/armory_instance_data.sql
            break;
    }
    
}
Armory::$aDB->query("UPDATE `armory_db_version` SET `loot_builded`=1");
echo '-- FINISHED!';
exit;
?>