<?php

/**
 * @package World of Warcraft Armory
 * @version Release Candidate 1
 * @revision 322
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
    $totalCharsCount = $armory->aDB->selectCell("SELECT COUNT(`guid`) FROM `armory_login_characters` WHERE `account`=%d", $_SESSION['accountId']);
    $armory->aDB->query("DELETE FROM `armory_login_characters` WHERE `account`='%d'", $_SESSION['accountId']);
    for($i = 1; $i < 4; $i++) {
        if(isset($_GET['cn' . $i]) && isset($_GET['r' . $i])) {
            $realmName = urldecode($_GET['r' . $i]);
            $realm_id = $utils->GetRealmIdByName($realmName);
            if(!$realm_id) {
                $armory->Log()->writeLog('character-select-submit : realm %s not found in database!', $realmName);
                continue;
            }
            elseif(!isset($armory->realmData[$realm_id])) {
                $armory->Log()->writeLog('character-select-submit : connection data to realm %s (ID: %d) not found!', $realmName, $realm_id);
                continue;
            }
            $realm_info = $armory->realmData[$realm_id];
            $db = new ArmoryDatabaseHandler($realm_info['host_characters'], $realm_info['user_characters'], $realm_info['pass_characters'], $realm_info['name_characters'], $realm_info['charset_characters'], $armory->Log());
            if(!$db) {
                $armory->Log()->writeLog('character-select-submit : unable to connect to MySQL database (host: %s, user: %s, password: %s, name: %s)', $realm_info['host_characters'], $realm_infoa['user_characters'], $realm_info['pass_characters'], $realm_info['name_characters']);
                continue;
            }
            $char_data = $db->selectRow("SELECT `guid`, `name`, `class`, `race`, `gender`, `level`, `account` FROM `characters` WHERE `name`='%s' AND `account`=%d LIMIT 1", $utils->escape($_GET['cn' . $i]), $_SESSION['accountId']);
            if(!$char_data) {
                $armory->Log()->writeLog('character-select-submit : unable to get character data from DB (name: %s, accountId: %d)', $_GET['cn' . $i], $_SESSION['accountId']);
                continue;
            }
            $char_data['realm_id'] = $realm_id;
            if(isset($_GET['cn1']) && $i == 1) {
                $char_data['selected'] = 1;
            }
            else {
                $char_data['selected'] = $i;
            }
            $char_data['num'] = $i;
            $armory->aDB->query("INSERT INTO `armory_login_characters` VALUES (%d, %d, %d, '%s', %d, %d, %d, %d, %d, %d)", $char_data['account'], $i, $char_data['guid'], $char_data['name'], $char_data['class'], $char_data['race'], $char_data['gender'], $char_data['level'], $realm_id, $char_data['selected']);
        }
    }
}
else {
    $armory->Log()->writeLog('character-select-submit : $_GET variable not found!');
}
exit;
?>