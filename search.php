<?php

/**
 * @package World of Warcraft Armory
 * @version Release Candidate 1
 * @revision 38
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
define('load_characters_class', true);
define('load_mangos_class', true);
define('load_items_class', true);
if(!@include('includes/armory_loader.php')) {
    die('<b>Fatal error:</b> can not load main system files!');
}
$searchQuery = isset($_GET['searchQuery']) ? $_GET['searchQuery'] : false;
$queryLen = strlen($searchQuery);
if(!$searchQuery || $queryLen < 2) {
    $armory->ArmoryError(false, false, true);
}
$armory->tpl->assign('searchQuery', $searchQuery);
$armory->tpl->assign('realmName', $armory->armoryconfig['defaultRealmName']);
if(isset($_GET['selectedTab'])) {
    switch($_GET['selectedTab']) {
        case 'characters':
        case 'items':
        case 'arenateams':
        case 'guilds':
            $forced_tab = 'search_'.$_GET['selectedTab'];
            $forced_cur_tab = $_GET['selectedTab'].'_tab';
            break;
        default:
            break;
    }
}
$itemsResNum = false;
$charsResNum = false;
$guildsResNum = false;
$arenateamsResNum = false;
$currentTab = false;

//if($queryLen > 7 ) {
    $itemsResNum = $utils->SearchItems($searchQuery, true);
    if($itemsResNum > 0) {
        $armory->tpl->assign('itemsResultNum', $itemsResNum);
        $armory->tpl->assign('itemResults', $utils->SearchItems($searchQuery));
        $currentTab = 'items_tab';
        $tpl2include = 'search_items';
    }
//}
$arenateamsResNum = $utils->SearchArenaTeams($searchQuery, true);
if($arenateamsResNum > 0) {
    $armory->tpl->assign('arenateamsResultNum', $arenateamsResNum);
    $armory->tpl->assign('arenateamsResult', $utils->SearchArenaTeams($searchQuery));
    $currentTab = 'arenateams_tab';
    $tpl2include = 'search_arenateams';
}
$guildsResNum = $utils->SearchGuilds($searchQuery, true);
if($guildsResNum > 0) {
    $armory->tpl->assign('guildsResultNum', $guildsResNum);
    $armory->tpl->assign('guildsResult', $utils->SearchGuilds($searchQuery));
    $currentTab = 'guilds_tab';
    $tpl2include = 'search_guilds';
}
$charsResNum = $utils->SearchCharacters($searchQuery, true);
if($charsResNum > 0) {
    $armory->tpl->assign('charactersResultNum', $charsResNum);
    $armory->tpl->assign('charactersResult', $utils->SearchCharacters($searchQuery));
    $currentTab = 'characters_tab';
    $tpl2include = 'search_characters';
}
if($itemsResNum == 0 && $arenateamsResNum == 0 && $charsResNum == 0 && $guildsResNum == 0) {
    $tpl2include = 'search_error';
}
$armory->tpl->assign('addCssSheet', '@import "_css/int.css";');
$armory->tpl->assign('tpl2include', (isset($forced_tab)) ? $forced_tab : $tpl2include);
$armory->tpl->assign((isset($forced_cur_tab)) ? $forced_cur_tab : $currentTab, 'selected-');
$armory->tpl->display('overall_header.tpl');
$armory->tpl->display('character_sheet_start.tpl');
exit();
?>