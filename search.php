<?php

/**
 * @package World of Warcraft Armory
 * @version Release 4.50
 * @revision 456
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
define('load_characters_class', true);
define('load_mangos_class', true);
define('load_items_class', true);
define('load_search_class', true);
if(!@include('includes/armory_loader.php')) {
    die('<b>Fatal error:</b> unable to load system files.');
}
header('Content-type: text/xml');
$advancedItemsSearch = false;
$findGearUpgrade     = false;
if(isset($_GET['searchQuery'])) {
    if(mb_strlen(urldecode($_GET['searchQuery']), 'UTF-8') < 2) {
        $xml->LoadXSLT('error/error.xsl');
        $xml->XMLWriter()->startElement('page');
        $xml->XMLWriter()->writeAttribute('globalSearch', 1);
        $xml->XMLWriter()->writeAttribute('lang', Armory::GetLocale());
        $xml->XMLWriter()->startElement('errorhtml');
        $xml->XMLWriter()->endElement();  //errorhtml
        $xml->XMLWriter()->endElement(); //page
        echo $xml->StopXML();
        exit;
    }
    elseif(mb_strlen(urldecode($_GET['searchQuery']), 'UTF-8') < 4) {
        // Search items with mb_strlen() > 4 only (offlike).
        $search->itemSearchSkip = true;
    }
    $search->SetSearchQuery($utils->escape($_GET['searchQuery']));
}
if(isset($_GET['source'])) {
    $advancedItemsSearch = true;
    $search->get_array = $_GET;
}
if(isset($_GET['pi']) && is_numeric($_GET['pi']) && $_GET['pi'] > 0) {
    $findGearUpgrade = true;
    $itemID = (int) $_GET['pi'];
    $characters->SetOptions(LOAD_NOTHING);
    $characters->BuildCharacter($_GET['pn'], $utils->GetRealmIdByName($_GET['pr']), false);
    if(!$characters->CheckPlayer()) {
        $plLevel = 80;
    }
    else {
        $plLevel = $characters->GetLevel();
    }
}
if(isset($_GET['rrt']) && $_GET['rrt'] == 'hm') {
    $search->heirloom = true;
}
if(!isset($_GET['searchQuery']) && !isset($_GET['source']) && !isset($_GET['pi']) && !isset($_GET['rrt'])) {
    $xml->LoadXSLT('error/error.xsl');
    $xml->XMLWriter()->startElement('page');
    $xml->XMLWriter()->writeAttribute('globalSearch', 1);
    $xml->XMLWriter()->writeAttribute('lang', Armory::GetLocale());
    $xml->XMLWriter()->startElement('errorhtml');
    $xml->XMLWriter()->endElement();  //errorhtml
    $xml->XMLWriter()->endElement(); //page
    echo $xml->StopXML();
    exit;
}
// Load XSLT template
$xml->LoadXSLT('search/search.xsl');
$totalCount = 0;
$xml->XMLWriter()->startElement('page');
$xml->XMLWriter()->writeAttribute('globalSearch', 1);
$xml->XMLWriter()->writeAttribute('lang', Armory::GetLocale());
$xml->XMLWriter()->writeAttribute('requestUrl', 'search.xml');
$xml->XMLWriter()->writeAttribute('requestQuery', ($search->GetSearchQuery()) ? $search->GetSearchQuery().'&amp;searchType='.$_GET['searchType'] : null);
$xml->XMLWriter()->startElement('armorySearch');
$selected = null;
if($count_characters = $search->PerformCharactersSearch(true)) {
    $totalCount = $totalCount+$count_characters;
    $selected = 'characters';
}
if($count_guilds = $search->PerformGuildsSearch(true)) {
    $totalCount = $totalCount+$count_guilds;
    if($selected != 'characters') {
        $selected = 'guilds';
    }
}
if($count_teams = $search->PerformArenaTeamsSearch(true)) {
    $totalCount = $totalCount+$count_teams;
    if($selected != 'characters') {
        $selected = 'arenateams';
    }
}
if($advancedItemsSearch) {
    if($count_items = $search->PerformAdvancedItemsSearch(true)) {
        $totalCount = $totalCount+$count_items;
        if($selected != 'characters') {
            $selected = 'items';
        }
    }
}
elseif($findGearUpgrade) {
    if($count_items = $search->PerformItemsSearch(true, $itemID, $plLevel)) {
        $totalCount = $totalCount+$count_items;
        if($selected != 'characters') {
            $selected = 'items';
        }
    }
}
else {
    if($count_items = $search->PerformItemsSearch(true)) {
        $totalCount = $totalCount+$count_items;
        if($selected != 'characters') {
            $selected = 'items';
        }
    }
}
if(isset($_GET['selectedTab'])) {
    $selected = $_GET['selectedTab'];
}
$xml->XMLWriter()->startElement('tabs');
$xml->XMLWriter()->writeAttribute('count', $totalCount);
$xml->XMLWriter()->writeAttribute('selected', $selected);

$xml->XMLWriter()->startElement('tab');
$xml->XMLWriter()->writeAttribute('count', $count_characters);
$xml->XMLWriter()->writeAttribute('label', 'armory.tabs.characters');
$xml->XMLWriter()->writeAttribute('type', 'characters');
$xml->XMLWriter()->endElement(); //tab
$xml->XMLWriter()->startElement('tab');
$xml->XMLWriter()->writeAttribute('count', $count_teams);
$xml->XMLWriter()->writeAttribute('label', 'armory.tabs.arenateams');
$xml->XMLWriter()->writeAttribute('type', 'arenateams');
$xml->XMLWriter()->endElement(); //tab
$xml->XMLWriter()->startElement('tab');
$xml->XMLWriter()->writeAttribute('count', $count_items);
$xml->XMLWriter()->writeAttribute('label', 'armory.tabs.items');
$xml->XMLWriter()->writeAttribute('type', 'items');
$xml->XMLWriter()->endElement(); //tab
$xml->XMLWriter()->startElement('tab');
$xml->XMLWriter()->writeAttribute('count', $count_guilds);
$xml->XMLWriter()->writeAttribute('label', 'armory.tabs.guilds');
$xml->XMLWriter()->writeAttribute('type', 'guilds');
$xml->XMLWriter()->endElement();  //tab
$xml->XMLWriter()->endElement(); //tabs

$searchType = (isset($_GET['searchType'])) ? $_GET['searchType'] : 'characters';
$xml->XMLWriter()->startElement('searchResults');
$results_info = array('pageCount' => 1, 'pageCurrent' => 1, 'searchError' => null, 'searchMsg' => null, 'searchFilter' => null, 'searchText' => urlencode($search->GetSearchQuery()), 'searchString' => $search->GetSearchQuery(), 'searchType' => $searchType, 'url' => 'searchType='.$searchType.'&amp;searchQuery='.$search->GetSearchQuery(), 'version' => '1.0');
foreach($results_info as $result_key => $result_value) {
    $xml->XMLWriter()->writeAttribute($result_key, $result_value);
}
if(isset($_GET['source'])) {
    $xml->XMLWriter()->startElement('filters');
    $maxCount = 30;
    $filtersCount = 0;
    foreach($_GET as $filter_get_key => $filter_get_value) {
        if($filtersCount >= $maxCount) {
            break;
        }
        if(is_string($filter_get_key) && is_string($filter_get_value)) {
            if(Utils::IsWriteRaw()) {
                $xml->XMLWriter()->writeRaw('<filter name="' . $filter_get_key . '" value="' . $filter_get_value . '" />');
            }
            else {
                $xml->XMLWriter()->startElement('filter');
                $xml->XMLWriter()->writeAttribute('name', $filter_get_key);
                $xml->XMLWriter()->writeAttribute('value', $filter_get_value);
                $xml->XMLWriter()->endElement();
            }
        }
        $filtersCount++;
    }
    $xml->XMLWriter()->endElement();
}
if($count_characters > 0 && $selected == 'characters') {
    $characters_search = $search->PerformCharactersSearch();
    if(is_array($characters_search)) {
        $xml->XMLWriter()->startElement('characters');
        foreach($characters_search as $_results_characters) {
            $xml->XMLWriter()->startElement('character');
            foreach($_results_characters as $character_key => $character_value) {
                $xml->XMLWriter()->writeAttribute($character_key, $character_value);
            }
            $xml->XMLWriter()->endElement(); //character
        }
        $xml->XMLWriter()->endElement(); //characters
    }
}
if($count_guilds > 0 && $selected == 'guilds') {
    $guilds_search = $search->PerformGuildsSearch();
    if(is_array($guilds_search)) {
        $xml->XMLWriter()->startElement('guilds');
        foreach($guilds_search as $_results_guilds) {
            $xml->XMLWriter()->startElement('guild');
            foreach($_results_guilds as $guild_key => $guild_value) {
                $xml->XMLWriter()->writeAttribute($guild_key, $guild_value);
            }
            $xml->XMLWriter()->endElement(); //guild
        }
        $xml->XMLWriter()->endElement(); //guilds
    }
}
if($count_teams && $selected == 'arenateams') {
    $teams_search = $search->PerformArenaTeamsSearch();
    if(is_array($teams_search)) {
        $xml->XMLWriter()->startElement('arenaTeams');
        foreach($teams_search as $_results_teams) {
            $xml->XMLWriter()->startElement('arenaTeam');
            foreach($_results_teams as $team_key => $team_value) {
                $xml->XMLWriter()->writeAttribute($team_key, $team_value);
            }
            $xml->XMLWriter()->startElement('emblem');
            $xml->XMLWriter()->endElement();  //emblem
            $xml->XMLWriter()->endElement(); //arenaTeam
        }
        $xml->XMLWriter()->endElement(); //arenaTeams
    }
}
if($count_items > 0 && $selected == 'items') {
    if($advancedItemsSearch) {
        $items_search = $search->PerformAdvancedItemsSearch();
    }
    elseif($findGearUpgrade) {
        $items_search = $search->PerformItemsSearch(false, $itemID, $plLevel);
    }
    else {
        $items_search = $search->PerformItemsSearch();
    }
    if(is_array($items_search)) {
        $xml->XMLWriter()->startElement('items');
        foreach($items_search as $item) {
            $xml->XMLWriter()->startElement('item');
            foreach($item['data'] as $itemdata_key => $itemdata_value) {
                $xml->XMLWriter()->writeAttribute($itemdata_key, $itemdata_value);
            }
            foreach($item['filters'] as $filter) {
                if(Utils::IsWriteRaw()) {
                    $xml->XMLWriter()->writeRaw('<filter');
                }
                else {
                    $xml->XMLWriter()->startElement('filter');
                }
                foreach($filter as $filter_key => $filter_value) {
                    if(Utils::IsWriteRaw()) {
                        $xml->XMLWriter()->writeRaw(' ' . $filter_key . '="' . $filter_value . '"');
                    }
                    else {
                        $xml->XMLWriter()->writeAttribute($filter_key, $filter_value);
                    }
                }
                if(Utils::IsWriteRaw()) {
                    $xml->XMLWriter()->writeRaw(' />'); //filter
                }
                else {
                    $xml->XMLWriter()->endElement(); //filter
                }
            }
            $xml->XMLWriter()->endElement(); //item
        }
        $xml->XMLWriter()->endElement(); //items
    }
}
$xml->XMLWriter()->endElement(); //searchResult
$xml->XMLWriter()->endElement();  //armorySearch
$xml->XMLWriter()->endElement(); //page
$xml_cache_data = $xml->StopXML();
echo $xml_cache_data;
exit;
?>