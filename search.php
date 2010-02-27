<?php

/**
 * @package World of Warcraft Armory
 * @version Release Candidate 1
 * @revision 87
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
define('load_search_class', true);
define('load_characters_class', true);
define('load_mangos_class', true);
define('load_items_class', true);
if(!@include('includes/armory_loader.php')) {
    die('<b>Fatal error:</b> can not load main system files!');
}
$armory->tpl->assign('locale', $_locale); // hack
$search->searchQuery = isset($_GET['searchQuery']) ? $_GET['searchQuery'] : false;
$queryLen = strlen($search->searchQuery);
if( (!$search->searchQuery && !isset($_GET['source'])) || ($queryLen < 2 && !isset($_GET['source']))) {
    $armory->ArmoryError(false, false, true);
}
$armory->tpl->assign('searchQuery', $search->searchQuery);
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
$itemsResNum = 0;
$charsResNum = 0;
$guildsResNum = 0;
$arenateamsResNum = 0;
$currentTab = false;
if(isset($_GET['source'])) {
    $search->get_array = $_GET;
    $itemsResNum = $search->AdvancedItemSearch($_GET, true);
    if($itemsResNum > 0) {
        $armory->tpl->assign('itemsResultNum', $itemsResNum);
        $armory->tpl->assign('itemResults', $search->AdvancedItemSearch());
        $currentTab = 'items_tab';
        $armory->tpl->assign('search_filters', $_GET);
        $tpl2include = 'search_items';
    }
}
elseif(!isset($_GET['source'])) {
    $itemsResNum = $search->SearchItems(true);
    if($itemsResNum > 0) {
        $armory->tpl->assign('itemsResultNum', $itemsResNum);
        $armory->tpl->assign('itemResults', $search->SearchItems());
        $currentTab = 'items_tab';
        $tpl2include = 'search_items';
    }
    $arenateamsResNum = $search->SearchArenaTeams(true);
    if($arenateamsResNum > 0) {
        $armory->tpl->assign('arenateamsResultNum', $arenateamsResNum);
        $armory->tpl->assign('arenateamsResult', $search->SearchArenaTeams());
        $currentTab = 'arenateams_tab';
        $tpl2include = 'search_arenateams';
    }
    $guildsResNum = $search->SearchGuilds(true);
    if($guildsResNum > 0) {
        $armory->tpl->assign('guildsResultNum', $guildsResNum);
        $armory->tpl->assign('guildsResult', $search->SearchGuilds());
        $currentTab = 'guilds_tab';
        $tpl2include = 'search_guilds';
    }
    $charsResNum = $search->SearchCharacters(true);
    if($charsResNum > 0) {
        $armory->tpl->assign('charactersResultNum', $charsResNum);
        $armory->tpl->assign('charactersResult', $search->SearchCharacters());
        $currentTab = 'characters_tab';
        $tpl2include = 'search_characters';
    }
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