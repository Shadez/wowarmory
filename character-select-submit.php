<?php

/**
 * @package World of Warcraft Armory
 * @version Release Candidate 1
 * @revision 49
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
    die('<b>Fatal error:</b> can not load main system files!');
}

if(!isset($_SESSION['accountId'])) {
    header('Location: login.xml');
    exit;
}

if(isset($_GET['action'])) {
    switch($_GET['action']) {
        case 'add':
            if(!$armory->aDB->selectCell("SELECT `guid` FROM `login_characters` WHERE `name`=? AND `account`=? LIMIT 1", $_GET['name'], $_SESSION['accountId'])) {
                if($data = $armory->cDB->selectRow("SELECT `guid`, `account`, `name`, `level`, `race`, `class`, `gender` FROM `characters` WHERE `name`=? AND `account`=? LIMIT 1", $_GET['name'], $_SESSION['accountId'])) {
                    $data['selected'] = 0;
                    $armory->aDB->query("INSERT IGNORE INTO `login_characters` (?#) VALUES (?a)", array_keys($data), array_values($data));
                }
            }
            break;
        case 'delete':
            if($data = $armory->aDB->selectCell("SELECT `guid` FROM `login_characters` WHERE `name`=? AND `account`=? LIMIT 1", $_GET['name'], $_SESSION['accountId'])) {
                $armory->aDB->query("DELETE FROM `login_characters` WHERE `name`=? AND `account`=? LIMIT 1", $_GET['name'], $_SESSION['accountId']);
            }
            break;
        case 'setmain':
            if($data = $armory->aDB->selectCell("SELECT `guid` FROM `login_characters` WHERE `name`=? AND `account`=? LIMIT 1", $_GET['name'], $_SESSION['accountId'])) {
                $armory->aDB->query("UPDATE `login_characters` SET `selected`=0 WHERE `account`=?", $_SESSION['accountId']);
                $armory->aDB->query("UPDATE `login_characters` SET `selected`=1 WHERE `name`=? AND `account`=?", $_GET['name'], $_SESSION['accountId']);
            }
            break;
    }
}
header('Location: character-select.xml');
?>