<?php

/**
 * @package World of Warcraft Armory
 * @version Release Candidate 1
 * @revision 168
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
define('load_guilds_class', true);
define('load_achievements_class', true);
if(!@include('includes/armory_loader.php')) {
    die('<b>Fatal error:</b> unable to load system files.');
}
header('Content-type: text/xml');
// Load XSLT template
if(isset($_GET['c'])) {
    $xml->LoadXSLT('character/statistics-async.xsl');
    $achievement_category = (int) $_GET['c'];
}
else {
    $xml->LoadXSLT('character/statistics.xsl');
    $achievement_category = 0;
}
if(isset($_GET['n'])) {
    $characters->name = $_GET['n'];
}
elseif(isset($_GET['cn'])) {
    $characters->name = $_GET['cn'];
}
else {
    $characters->name = false;
}
$characters->GetCharacterGuid();
$isCharacter = $characters->IsCharacter();
$characters->_structCharacter();
$achievements->guid = $characters->guid;
if(!isset($_GET['r']) || !$armory->currentRealmInfo) {
    $isCharacter = false;
}
// Get page cache
if($characters->guid > 0 && $isCharacter && $armory->armoryconfig['useCache'] == true && !isset($_GET['skipCache'])) {
    if($achievement_category > 0) {
        $cache_id = $utils->GenerateCacheId('character-statistics-c'.$achievement_category, $characters->name, $armory->currentRealmInfo['name']);
    }
    else {
        $cache_id = $utils->GenerateCacheId('character-statistics', $characters->name, $armory->currentRealmInfo['name']);
    }
    if($cache_data = $utils->GetCache($cache_id)) {
        echo $cache_data;
        echo sprintf('<!-- Restored from cache; id: %s -->', $cache_id);
        exit;
    }
}
if($achievement_category > 0) {    
    $xml->XMLWriter()->startElement('category');
    $faction = ($characters->faction == 1) ? 0 : 1;
    $statistics_page = $achievements->LoadStatisticsPage($achievement_category, $faction);
    $i = 0;
    if($statistics_page) {
        foreach($statistics_page as $stat) {
            $xml->XMLWriter()->startElement('statistic');
            foreach($stat as $statistic_key => $statistic_value) {
                $xml->XMLWriter()->writeAttribute($statistic_key, $statistic_value);
            }
            $xml->XMLWriter()->endElement();
        }
    }
    $xml->XMLWriter()->endElement();  //category
    $xml->XMLWriter()->endElement(); //achievements
    $xml_cache_data = $xml->StopXML();
    echo $xml_cache_data;
    if($armory->armoryconfig['useCache'] == true && !isset($_GET['skipCache'])) {
        // Write cache to file
        $cache_data = $utils->GenerateCacheData($characters->name, $characters->guid, 'character-achievements');
        $cache_handler = $utils->WriteCache($cache_id, $cache_data, $xml_cache_data);
        if($cache_handler != 0x01) {
            echo sprintf('<!-- Error occured while cache write: %s -->', $cache_handler); //debug
        }
    }
    exit;
}

/** Basic info **/
$tabUrl = false;
$guilds->guid = $characters->guid;
if($isCharacter && $guilds->extractPlayerGuildId()) {
    $tabUrl = sprintf('r=%s&cn=%s&gn=%s', urlencode($armory->currentRealmInfo['name']), urlencode($characters->name), urlencode($guilds->getGuildName()));
    $charTabUrl = sprintf('r=%s&cn=%s&gn=%s', urlencode($armory->currentRealmInfo['name']), urlencode($characters->name), urlencode($guilds->getGuildName()));
}
elseif($isCharacter) {
    $tabUrl = sprintf('r=%s&cn=%s', urlencode($armory->currentRealmInfo['name']), urlencode($characters->name));
    $charTabUrl = sprintf('r=%s&cn=%s', urlencode($armory->currentRealmInfo['name']), urlencode($characters->name));
}
/** Header **/
$xml->XMLWriter()->startElement('page');
$xml->XMLWriter()->writeAttribute('globalSearch', 1);
$xml->XMLWriter()->writeAttribute('lang', $armory->_locale);
$xml->XMLWriter()->writeAttribute('requestUrl', 'character-statistics.xml');
$xml->XMLWriter()->startElement('tabInfo');
$xml->XMLWriter()->writeAttribute('subTab', 'statistics');
$xml->XMLWriter()->writeAttribute('tab', 'character');
$xml->XMLWriter()->writeAttribute('tabGroup', 'character');
$xml->XMLWriter()->writeAttribute('tabUrl', $tabUrl);
$xml->XMLWriter()->endElement(); //tabInfo
if(!$isCharacter) {
    $xml->XMLWriter()->startElement('characterInfo');
    $xml->XMLWriter()->writeAttribute('errCode', 'noCharacter');
    $xml->XMLWriter()->endElement(); // characterInfo
    $xml->XMLWriter()->endElement(); //page
    $xml_cache_data = $xml->StopXML();
    echo $xml_cache_data;
    exit;
}
$characters->GetCharacterTitle();
$character_element = array(
    // TODO: add GetLocaleString() method
    'battleGroup' => $armory->armoryconfig['defaultBGName'],
    'charUrl'      => $charTabUrl,
    'class'        => $characters->returnClassText(),
    'classId'      => $characters->class,
    'classUrl'     => sprintf('c='),
    'faction'      => '',
    'factionId'    => $characters->GetCharacterFaction(),
    'gender'       => '',
    'genderId'     => $characters->gender,
    'guildName'    => ($guilds->guid) ? $guilds->guildName : '',
    'guildUrl'     => ($guilds->guid) ? sprintf('r=%s&gn=%s', urlencode($armory->currentRealmInfo['name']), urlencode($guilds->guildName)) : '',
    'lastModified' => '',
    'level'        => $characters->level,
    'name'         => $characters->name,
    'points'       => $achievements->CalculateAchievementPoints(),
    'prefix'       => $characters->character_title['prefix'],
    'race'         => $characters->returnRaceText(),
    'raceId'       => $characters->race,
    'realm'        => $armory->currentRealmInfo['name'],
    'suffix'       => $characters->character_title['suffix'],
    'titeId'       => $characters->character_title['titleId'],
);
// <characterInfo> start
$xml->XMLWriter()->startElement('characterInfo');
// <character> start
$xml->XMLWriter()->startElement('character');
foreach($character_element as $c_elem_name => $c_elem_value) {
    $xml->XMLWriter()->writeAttribute($c_elem_name, $c_elem_value);
}
$xml->XMLWriter()->endElement();   //character
$xml->XMLWriter()->endElement();  //characterInfo
$xml->XMLWriter()->startElement('statistics');
$xml->XMLWriter()->startElement('summary');

$xml->XMLWriter()->endElement();    //summary

// root
$xml->XMLWriter()->startElement('rootCategories');
$root_categories = $achievements->BuildStatisticsCategoriesTree();
foreach($root_categories as $category) {
    $xml->XMLWriter()->startElement('category');
    $xml->XMLWriter()->writeAttribute('id', $category['id']);
    $xml->XMLWriter()->writeAttribute('name', $category['name']);
    if(isset($category['child']) && is_array($category['child'])) {
        foreach($category['child'] as $category_child) {
            $xml->XMLWriter()->startElement('category');
            $xml->XMLWriter()->writeAttribute('name', $category_child['name']);
            $xml->XMLWriter()->writeAttribute('id', $category_child['id']);
            $xml->XMLWriter()->endElement(); //category
        }
    }
    $xml->XMLWriter()->endElement(); //category
}
$xml->XMLWriter()->endElement();    //rootCategories
$xml->XMLWriter()->endElement();   //statistics
$xml->XMLWriter()->endElement(); //page
$xml_cache_data = $xml->StopXML();
echo $xml_cache_data;
if($armory->armoryconfig['useCache'] == true && !isset($_GET['skipCache'])) {
    // Write cache to file
    $cache_data = $utils->GenerateCacheData($characters->name, $characters->guid, 'character-statistics');
    $cache_handler = $utils->WriteCache($cache_id, $cache_data, $xml_cache_data);
}
exit;
?>