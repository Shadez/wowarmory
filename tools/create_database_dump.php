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
if(!@include('../includes/armory_loader.php')) {
    die('<b>Fatal error:</b> unable to load system files.');
}
if(!isset($_GET['do']) || $_GET['do'] == null) {
    die('<a href="?do=save">Create SQL dump</a> (it will be saved in sql/ folder) or <a href="?do=show">display SQL dump here</a>.');
}
// Get DB version
$current_db_version = (int) substr(DB_VERSION, 8);
$new_db_version = $current_db_version + 1;
set_time_limit(0);
$allowed_tables = array(
    array(
        'name' => 'achievement',
        'internalFile' => false,
        'skipData' => false,
        'drop' => true,
        'onlyIfNotExists' => false,
    ),
    array(
        'name' => 'achievement_category',
        'internalFile' => false,
        'skipData' => false,
        'drop' => true,
        'onlyIfNotExists' => false,
    ),
    array(
        'name' => 'achievement_criteria',
        'internalFile' => false,
        'skipData' => false,
        'drop' => true,
        'onlyIfNotExists' => false,
    ),
    array(
        'name' => 'bookmarks',
        'internalFile' => false,
        'skipData' => true,
        'drop' => false,
        'onlyIfNotExists' => true,
    ),
    array(
        'name' => 'classes',
        'internalFile' => false,
        'skipData' => false,
        'drop' => true,
        'onlyIfNotExists' => false,
    ),
    array(
        'name' => 'db_version',
        'internalFile' => false,
        'skipData' => false,
        'drop' => true,
        'onlyIfNotExists' => false,
    ),
    array(
        'name' => 'enchantment',
        'internalFile' => false,
        'skipData' => false,
        'drop' => true,
        'onlyIfNotExists' => false,
    ),
    array(
        'name' => 'extended_cost',
        'internalFile' => false,
        'skipData' => false,
        'drop' => true,
        'onlyIfNotExists' => false,
    ),
    array(
        'name' => 'faction',
        'internalFile' => false,
        'skipData' => false,
        'drop' => true,
        'onlyIfNotExists' => false,
    ),
    array(
        'name' => 'gemproperties',
        'internalFile' => false,
        'skipData' => false,
        'drop' => true,
        'onlyIfNotExists' => false,
    ),
    array(
        'name' => 'glyphproperties',
        'internalFile' => false,
        'skipData' => false,
        'drop' => true,
        'onlyIfNotExists' => false,
    ),
    array(
        'name' => 'icons',
        'internalFile' => false,
        'skipData' => false,
        'drop' => true,
        'onlyIfNotExists' => false,
    ),
    array(
        'name' => 'instance_data',
        'internalFile' => false,
        'skipData' => false,
        'drop' => true,
        'onlyIfNotExists' => false,
    ),
    array(
        'name' => 'instance_template',
        'internalFile' => false,
        'skipData' => false,
        'drop' => true,
        'onlyIfNotExists' => false,
    ),
    array(
        'name' => 'item_equivalents',
        'internalFile' => false,
        'skipData' => false,
        'drop' => true,
        'onlyIfNotExists' => false,
    ),
    array(
        'name' => 'item_sources',
        'internalFile' => false,
        'skipData' => false,
        'drop' => true,
        'onlyIfNotExists' => false,
    ),
    array(
        'name' => 'itemdisplayinfo',
        'internalFile' => false,
        'skipData' => false,
        'drop' => true,
        'onlyIfNotExists' => false,
    ),
    array(
        'name' => 'itemsetdata',
        'internalFile' => false,
        'skipData' => false,
        'drop' => true,
        'onlyIfNotExists' => false,
    ),
    array(
        'name' => 'itemsetinfo',
        'internalFile' => false,
        'skipData' => false,
        'drop' => true,
        'onlyIfNotExists' => false,
    ),
    array(
        'name' => 'itemsubclass',
        'internalFile' => false,
        'skipData' => false,
        'drop' => true,
        'onlyIfNotExists' => false,
    ),
    array(
        'name' => 'login_characters',
        'internalFile' => false,
        'skipData' => true,
        'drop' => false,
        'onlyIfNotExists' => true,
    ),
    array(
        'name' => 'maps',
        'internalFile' => false,
        'skipData' => false,
        'drop' => true,
        'onlyIfNotExists' => false,
    ),
    array(
        'name' => 'news',
        'internalFile' => false,
        'skipData' => true,
        'drop' => false,
        'onlyIfNotExists' => true,
    ),
    array(
        'name' => 'petcalc',
        'internalFile' => false,
        'skipData' => false,
        'drop' => true,
        'onlyIfNotExists' => false,
    ),
    array(
        'name' => 'professions',
        'internalFile' => false,
        'skipData' => false,
        'drop' => true,
        'onlyIfNotExists' => false,
    ),
    array(
        'name' => 'races',
        'internalFile' => false,
        'skipData' => false,
        'drop' => true,
        'onlyIfNotExists' => false,
    ),
    array(
        'name' => 'randomproperties',
        'internalFile' => false,
        'skipData' => false,
        'drop' => true,
        'onlyIfNotExists' => false,
    ),
    array(
        'name' => 'randompropertypoints',
        'internalFile' => false,
        'skipData' => false,
        'drop' => true,
        'onlyIfNotExists' => false,
    ),
    array(
        'name' => 'randomsuffix',
        'internalFile' => false,
        'skipData' => false,
        'drop' => true,
        'onlyIfNotExists' => false,
    ),
    array(
        'name' => 'rating',
        'internalFile' => false,
        'skipData' => false,
        'drop' => true,
        'onlyIfNotExists' => false,
    ),
    array(
        'name' => 'realm_data',
        'internalFile' => false,
        'skipData' => true,
        'drop' => false,
        'onlyIfNotExists' => true,
    ),
    array(
        'name' => 'skills',
        'internalFile' => false,
        'skipData' => false,
        'drop' => true,
        'onlyIfNotExists' => false,
    ),
    array(
        'name' => 'source',
        'internalFile' => false,
        'skipData' => false,
        'drop' => true,
        'onlyIfNotExists' => false,
    ),
    array(
        'name' => 'spell',
        'internalFile' => 'wowarmory_spell_rc1_r' . (ARMORY_REVISION+1) . '.sql',
        'skipData' => false,
        'drop' => true,
        'onlyIfNotExists' => false,
    ),
    array(
        'name' => 'spell_duration',
        'internalFile' => false,
        'skipData' => false,
        'drop' => true,
        'onlyIfNotExists' => false,
    ),
    array(
        'name' => 'spellenchantment',
        'internalFile' => false,
        'skipData' => false,
        'drop' => true,
        'onlyIfNotExists' => false,
    ),
    array(
        'name' => 'ssd',
        'internalFile' => false,
        'skipData' => false,
        'drop' => true,
        'onlyIfNotExists' => false,
    ),
    array(
        'name' => 'ssv',
        'internalFile' => false,
        'skipData' => false,
        'drop' => true,
        'onlyIfNotExists' => false,
    ),
    array(
        'name' => 'string',
        'internalFile' => false,
        'skipData' => false,
        'drop' => true,
        'onlyIfNotExists' => false,
    ),
    array(
        'name' => 'talent_icons',
        'internalFile' => false,
        'skipData' => false,
        'drop' => true,
        'onlyIfNotExists' => false,
    ),
    array(
        'name' => 'talents',
        'internalFile' => false,
        'skipData' => false,
        'drop' => true,
        'onlyIfNotExists' => false,
    ),
    array(
        'name' => 'talenttab',
        'internalFile' => false,
        'skipData' => false,
        'drop' => true,
        'onlyIfNotExists' => false,
    ),
    array(
        'name' => 'titles',
        'internalFile' => false,
        'skipData' => false,
        'drop' => true,
        'onlyIfNotExists' => false,
    )
);
if($_GET['do'] == 'show') {
    header('Content-type: text/plain');
}
$sql_dump_text = sprintf("/*
    World of Warcraft Armory Database
    https://github.com/Shadez/wowarmory/
    Revision [%d]
    Dump date: %s
*/

/*!40101 SET NAMES utf8 */;
/*!40101 SET SQL_MODE=''*/;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO' */;", (ARMORY_REVISION+1), date('M-d-Y, H:i:s'));
foreach($allowed_tables as $table) {
    $data = array();
    if($table['skipData'] == false && $table['internalFile'] == false) {
        $data = Armory::$aDB->select("SELECT * FROM `ARMORYDBPREFIX_%s`", $table['name']);
    }
    $create_table = Armory::$aDB->selectRow("SHOW CREATE TABLE `ARMORYDBPREFIX_%s`", $table['name']);
    $create_table_query = $create_table['Create Table'];
    $sql_dump_text .= '

-- `' . Armory::$armoryconfig['db_prefix'] . '_' . $table['name'] . '`';
    if($table['internalFile'] != false) {
        $sql_dump_text .= '
-- execute from ' . $table['internalFile'];
        continue;
    }
    if($table['drop'] == true) {
        $sql_dump_text .= '
DROP TABLE IF EXISTS `' . Armory::$armoryconfig['db_prefix'] . '_' . $table['name'] . '`;
' . $create_table_query . ';';
    }
    elseif($table['onlyIfNotExists'] == true) {
        $sql_dump_text .= '
' . str_replace('CREATE TABLE', 'CREATE TABLE IF NOT EXISTS', $create_table_query) . ';';
    }
    if($table['skipData'] == false && $table['internalFile'] == false) {
        $sql_dump_text .= '
';
        foreach($data as $tbl_data) {
            $sql_dump_text .= sprintf('
INSERT INTO `%s_%s` VALUES (', Armory::$armoryconfig['db_prefix'], $table['name']);
            $count = count($tbl_data)-1;
            $i = 0;
            foreach($tbl_data as $t_value) {
                $sql_dump_text .= "'" . str_replace("'", "''", $t_value) . "'";
                if($i != $count) {
                    $sql_dump_text .= ', ';
                }
                $i++;
            }
            $sql_dump_text .= ');';
        }
    }
}
$sql_dump_text .= '

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;';
if($_GET['do'] == 'save') {
    file_put_contents('../sql/wowarmory_rc1_r' . (ARMORY_REVISION + 1) . '.sql', $sql_dump_text);
}
elseif($_GET['do'] == 'show') {
    echo $sql_dump_text;
}
unset($sql_dump_text);
?>