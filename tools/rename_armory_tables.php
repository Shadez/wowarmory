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
    die('<b>Error:</b> can not load Armory class!');
}
Armory::InitializeArmory();
$wowarmory_tables = array(
    'achievement',
    'achievement_category',
    'achievement_criteria',
    'bookmarks',
    'classes',
    'db_version',
    'enchantment',
    'extended_cost',
    'faction',
    'gemproperties',
    'glyphproperties',
    'icons',
    'instance_data',
    'instance_template',
    'item_equivalents',
    'item_sources',
    'itemdisplayinfo',
    'itemsetdata',
    'itemsetinfo',
    'itemsubclass',
    'login_characters',
    'maps',
    'news',
    'petcalc',
    'professions',
    'races',
    'randomproperties',
    'randompropertypoints',
    'randomsuffix',
    'rating',
    'realm_data',
    'skills',
    'source',
    'spell',
    'spell_duration',
    'spellenchantment',
    'ssd',
    'ssv',
    'string',
    'talent_icons',
    'talents',
    'talenttab',
    'titles'
);
$update_type = 'echo'; // Set 'query' to execute all queries or set to 'echo' to display queries (you'll execute it manually)
if(isset($_GET['prefix'])) {
    $sql_query = null;
    $prefix = $_GET['prefix'];
    if(!preg_match("/^[a-zA-Z0-9]+$/", $prefix)) {
        die('Error: prefix contains not allowed symbols: ' . $prefix);
    }
    $allowed = Armory::$aDB->selectCell("SELECT `rename_status` FROM `ARMORYDBPREFIX_db_version`");
    $oldprefix = Armory::$armoryconfig['db_prefix'];
    if($allowed == 0) {
        die("Error: table rename is locked now.");
    }
    if($curprefix == $prefix) {
        die('Error: current prefix and old prefix are equal, operation is not required.');
    }
    echo 'Table rename started.<hr />';
    Armory::$aDB->query("UPDATE `ARMORYDBPREFIX_db_version` SET `rename_status`='0', `prev_name`='%s'", $prefix);
    foreach($wowarmory_tables as $table) {
        // Rename each table
        if($update_type == 'query') {
            $result = Armory::$aDB->query("ALTER TABLE `%s_%s` RENAME `%s_%s`", $oldprefix, $table, $prefix, $table);
            if($result == true) {
                echo sprintf("<br />Table `%s` was successfully renamed to `%s`.", $oldprefix.'_'.$table, $prefix.'_'.$table);
            }
            else {
                echo sprintf("<br />Error: table `%s` was not renamed to `%s`.", 'armory_'.$table, $prefix.'_'.$table);
            }
        }
        elseif($update_type == 'echo') {
            $sql_query .= sprintf("ALTER TABLE `%s_%s` RENAME `%s_%s`;
", $oldprefix, $table, $prefix, $table);
        }
    }
    if($update_type == 'echo') {
        echo '<textarea rows=40 cols=100>'.$sql_query.'</textarea><br />';
    }
    echo sprintf('<hr />Table rename finished, future rename is locked now. You need to change $ArmoryConfig[\'settings\'][\'db_prefix\'] value to %s', $prefix);
}
else {
    echo '<form action="rename_armory_tables.php" method="GET">
    Enter new armory prefix (without "_"): <input type="text" name="prefix"/><br />
    <input type="submit" value="Start rename">
    </form>';
}
?>