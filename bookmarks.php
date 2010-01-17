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
    if(isset($_GET['cn'])) {
        $name = $_GET['cn'];
    }
    elseif(isset($_GET['n'])) {
        $name = $_GET['n'];
    }
    else {
        $name = false;
    }
    $guid = $armory->cDB->selectCell("SELECT `guid` FROM `characters` WHERE `name`=? LIMIT 1", $name);
    switch($_GET['action']) {
        case 1: // Add new character bookmark
            if($guid) {
                $armory->aDB->query("INSERT IGNORE INTO `character_bookmarks` (`account`, `guid`) VALUES (?, ?)", $_SESSION['accountId'], $guid);
            }
            break;
        case 2: // Delete character bookmark
            if($guid) {
                $armory->aDB->query("DELETE FROM `character_bookmarks` WHERE `account`=? AND `guid`=? LIMIT 1", $_SESSION['accountId'], $guid);
            }
            break;
    }
}
if(isset($_SERVER['HTTP_REFERER'])) {
    $urlReturn = $_SERVER['HTTP_REFERER'];
}
else {
    $urlReturn = 'character-sheet.xml?r='.$armory->armoryconfig['defaultRealmName'].'&amp;n='.$name;
}
header('Location: '.$urlReturn);
?>