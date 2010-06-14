<?php

/**
 * @package World of Warcraft Armory
 * @version Release Candidate 1
 * @revision 245
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

define('__ARMORY__', true);
if(!@include('includes/armory_loader.php')) {
    die('<b>Fatal error:</b> unable to load system files.');
}
if(!isset($_SESSION['accountId'])) {
    $armory->Log()->writeLog('character-select-submit : session not found!');
    exit;
}
if(isset($_GET)) {
    $totalCharsCount = $armory->aDB->selectCell("SELECT COUNT(`guid`) FROM `armory_login_characters` WHERE `account`=?d", $_SESSION['accountId']);
    $delete_query = sprintf("DELETE FROM `armory_login_characters` WHERE `account`='%d'", $_SESSION['accountId']);
    $armory->aDB->query($delete_query);
    for($i = 1; $i < 4; $i++) {
        if(isset($_GET['cn' . $i]) && isset($_GET['r' . $i])) {
            $realmName = urldecode($_GET['r' . $i]);
            $realm_data = $armory->aDB->selectRow("SELECT `id`, `name` FROM `armory_realm_data` WHERE `name`=? LIMIT 1", $realmName);
            if(!$realm_data) {
                $armory->Log()->writeLog('character-select-submit : realm %s not found in database!', $realmName);
                continue;
            }
            elseif(!isset($armory->realmData[$realm_data['id']])) {
                $armory->Log()->writeLog('character-select-submit : connection data to realm %s (ID: %d) not found!', $realmName, $realm_data['id']);
                continue;
            }
            $armory->connectionData = $armory->realmData[$realm_data['id']];
            $db = DbSimple_Generic::connect('mysql://'.$armory->connectionData['user_characters'].':'.$armory->connectionData['pass_characters'].'@'.$armory->connectionData['host_characters'].'/'.$armory->connectionData['name_characters']);
            if(!$db) {
                $armory->Log()->writeLog('character-select-submit : unable to connect to MySQL database (host: %s, user: %s, password: %s, name: %s)', $armory->connectionDaa['host_characters'], $armory->connectionDaa['user_characters'], $armory->connectionDaa['pass_characters'], $armory->connectionDaa['name_characters']);
                continue;
            }
            $db->query("SET NAMES UTF8");
            $char_data = $db->selectRow("SELECT `guid`, `name`, `class`, `race`, `gender`, `level`, `account` FROM `characters` WHERE `name`=? AND `account`=?d LIMIT 1", $utils->escape($_GET['cn' . $i]), $_SESSION['accountId']);
            if(!$char_data) {
                $armory->Log()->writeLog('character-select-submit : unable to get character data from DB (name: %s, accountId: %d)', $_GET['cn' . $i], $_SESSION['accountId']);
                continue;
            }
            $char_data['realm_id'] = $realm_data['id'];
            if(isset($_GET['cn1']) && $i == 1) {
                $char_data['selected'] = 1;
            }
            else {
                $char_data['selected'] = $i;
            }
            $char_data['num'] = $i;
            $add_query = sprintf("INSERT INTO `armory_login_characters` VALUES (%d, %d, %d, '%s', %d, %d, %d, %d, %d, %d)", $char_data['account'], $i, $char_data['guid'], $char_data['name'], $char_data['class'], $char_data['race'], $char_data['gender'], $char_data['level'], $realm_data['id'], $char_data['selected']);
            $armory->aDB->query($add_query);
            //echo $add_query;
        }
    }
}
$armory->Log()->writeLog('character-select-submit : $_GET variable not found!');
exit;
?>