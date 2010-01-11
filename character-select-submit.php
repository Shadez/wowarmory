<?php

/**
 * @package World of Warcraft Armory
 * @version Release Candidate 1
 * @revision 37
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

/** Profile functions are in development! **/

if(isset($_GET['n2'])) {
    $guid = $armory->cDB->selectCell("SELECT `guid` FROM `characters` WHERE `name`=? AND `account`=?", $_GET['n2'], $_SESSION['accountId']);
    $armory->aDB->query("DELETE FROM `login_characters` WHERE `guid`=? AND `account`=?", $guid, $_SESSION['accountId']);
}
elseif(isset($_GET['n4'])) {
    $num = $armory->aDB->selectCell("SELECT MAX(`num`) FROM `login_characters` WHERE `account`=?", $_SESSION['accountId']);
    if($num == 3) {
        exit();
    }
    $charInfo = $armory->cDB->selectRow("
    SELECT `account`, `guid`, `name`, `class`, `race`, `gender`, `level`
        FROM `characters`
            WHERE `account`=? AND `name`=? LIMIT 1", $_SESSION['accountId'], $_GET['n4']);
    $charInfo['num'] = $num+1;
    $charInfo['selected'] = 0;
    $armory->aDB->query("INSERT INTO `login_characters` (?#) VALUES (?a)", array_keys($charInfo), array_values($charInfo));
}
exit();
?>