<?php

/**
 * @package World of Warcraft Armory
 * @version Release Candidate 1
 * @revision 122
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
if(isset($_GET['c'])) {
    define('load_mangos_class', true);
}
if(!@include('includes/armory_loader.php')) {
    die('<b>Fatal error:</b> unable to load system files.');
}
header('Content-type: text/xml');
// Load XSLT template
if(isset($_GET['c'])) {
    $xml->LoadXSLT('character/achievements-async.xsl');
    $achievement_category = (int) $_GET['c'];
}
else {
    $xml->LoadXSLT('character/achievements.xsl');
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
// Get page cache
if($characters->guid > 0 && $isCharacter && $armory->armoryconfig['useCache'] == true && !isset($_GET['skipCache'])) {
    if($achievement_category > 0) {
        $cache_id = $utils->GenerateCacheId('character-achievements-c'.$achievement_category, $characters->name, $armory->armoryconfig['defaultRealmName']);
    }
    else {
        $cache_id = $utils->GenerateCacheId('character-achievements', $characters->name, $armory->armoryconfig['defaultRealmName']);
    }
    if($cache_data = $utils->GetCache($cache_id)) {
        echo $cache_data;
        echo sprintf('<!-- Restored from cache; id: %s -->', $cache_id);
        exit;
    }
}
if($achievement_category > 0) {
    $xml->XMLWriter()->startElement('achievements');
    $xml->XMLWriter()->writeAttribute('lang', $armory->_locale);
    $xml->XMLWriter()->writeAttribute('requestUrl', 'character-achievements.xml');
    
    $xml->XMLWriter()->startElement('category');
    $faction = ($characters->faction == 1) ? 0 : 1;
    $achievements_page = $achievements->LoadAchievementPage($achievement_category, $faction);
    //print_r($achievements_list);
    $i = 0;
        if(isset($achievements_page['completed'])) {
            foreach($achievements_page['completed'] as $achievement) {
                if($achievement['display'] == 0) {
                    continue;
                }
                $xml->XMLWriter()->startElement('achievement');
                if(isset($achievement['data'])) {
                    foreach($achievement['data'] as $a_data_key => $a_data_value) {
                        $xml->XMLWriter()->writeAttribute($a_data_key, $a_data_value);
                    }
                }
                if(isset($achievement['criteria']) && is_array($achievement['criteria'])) {
                    foreach($achievement['criteria'] as $criteria) {
                        $xml->XMLWriter()->startElement('criteria');
                        foreach($criteria as $c_key => $c_value) {
                            $xml->XMLWriter()->writeAttribute($c_key, $c_value);
                        }
                        $xml->XMLWriter()->endElement(); //criteria
                    }
                }
                if(isset($achievement['achievement_tree'])) {
                    foreach($achievement['achievement_tree'] as $achievement_tree) {
                        $xml->XMLWriter()->startElement('achievement');
                        foreach($achievement_tree as $a_tree_key => $a_tree_value) {
                            $xml->XMLWriter()->writeAttribute($a_tree_key, $a_tree_value);
                        }
                        $xml->XMLWriter()->endElement(); //achievement
                    }
                }
                $xml->XMLWriter()->endElement(); //achievement
            }
        }
        if(isset($achievements_page['incompleted'])) {
            foreach($achievements_page['incompleted'] as $achievement) {
                if(isset($achievement['display']) && $achievement['display'] == 0) {
                    continue;
                }
                $xml->XMLWriter()->startElement('achievement');
                if(isset($achievement['data'])) {
                    foreach($achievement['data'] as $a_data_key => $a_data_value) {
                        $xml->XMLWriter()->writeAttribute($a_data_key, $a_data_value);
                    }
                }
                if(isset($achievement['criteria']) && is_array($achievement['criteria'])) {
                    foreach($achievement['criteria'] as $criteria) {
                        $xml->XMLWriter()->startElement('criteria');
                        foreach($criteria as $c_key => $c_value) {
                            $xml->XMLWriter()->writeAttribute($c_key, $c_value);
                        }
                        $xml->XMLWriter()->endElement(); //criteria
                    }
                }
                if(isset($achievement['achievement_tree'])) {
                    foreach($achievement['achievement_tree'] as $achievement_tree) {
                        $xml->XMLWriter()->startElement('achievement');
                        foreach($achievement_tree as $a_tree_key => $a_tree_value) {
                            $xml->XMLWriter()->writeAttribute($a_tree_key, $a_tree_value);
                        }
                        $xml->XMLWriter()->endElement(); //achievement
                    }
                }
                $xml->XMLWriter()->endElement(); //achievement
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

/** Header **/
$xml->XMLWriter()->startElement('page');
$xml->XMLWriter()->writeAttribute('globalSearch', 1);
$xml->XMLWriter()->writeAttribute('lang', $armory->_locale);
$xml->XMLWriter()->writeAttribute('requestUrl', 'character-achievements.xml');
$xml->XMLWriter()->startElement('tabInfo');
$xml->XMLWriter()->writeAttribute('subTab', 'achievements');
$xml->XMLWriter()->writeAttribute('tab', 'character');
$xml->XMLWriter()->writeAttribute('tabGroup', 'character');
$xml->XMLWriter()->writeAttribute('tabUrl', ($characters->IsCharacter()) ? sprintf('r=%s&cn=%s', urlencode($armory->armoryconfig['defaultRealmName']), urlencode($characters->name)) : '' );
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
/** Basic info **/
$guilds->guid = $characters->guid;
if($guilds->extractPlayerGuildId()) {
    $charTabUrl = sprintf('r=%s&cn=%s&gn=%s', urlencode($armory->armoryconfig['defaultRealmName']), urlencode($characters->name), urlencode($guilds->getGuildName()));
}
else {
    $charTabUrl = sprintf('r=%s&cn=%s', urlencode($armory->armoryconfig['defaultRealmName']), urlencode($characters->name));
}
$characters->GetCharacterTitle();
$character_element = array(
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
    'guildUrl'     => ($guilds->guid) ? sprintf('r=%s&gn=%s', urlencode($armory->armoryconfig['defaultRealmName']), urlencode($guilds->guildName)) : '',
    'lastModified' => '',
    'level'        => $characters->level,
    'name'         => $characters->name,
    'points'       => $achievements->CalculateAchievementPoints(),
    'prefix'       => $characters->character_title['prefix'],
    'race'         => $characters->returnRaceText(),
    'raceId'       => $characters->race,
    'realm'        => $armory->armoryconfig['defaultRealmName'],
    'suffix'       => $characters->character_title['suffix'],
    'titeId'       => $characters->character_title['titleId'],
);
$xml->XMLWriter()->startElement('characterInfo');
$xml->XMLWriter()->startElement('character');
foreach($character_element as $c_elem_name => $c_elem_value) {
    $xml->XMLWriter()->writeAttribute($c_elem_name, $c_elem_value);
}
$xml->XMLWriter()->endElement();   //character
$xml->XMLWriter()->endElement();  //characterInfo
$xml->XMLWriter()->startElement('achievements');
$xml->XMLWriter()->startElement('summary');
$xml->XMLWriter()->startElement('c');
$info_summary = $achievements->GetSummaryAchievementData(0);
if(is_array($info_summary)) {
    foreach($info_summary as $info_key => $info_value) {
        $xml->XMLWriter()->writeAttribute($info_key, $info_value);
    }
}
$xml->XMLWriter()->endElement();     //c
$info_categories = array(92, 96, 97, 95, 168, 169, 201, 155, 81);
foreach($info_categories as $achievement_category) {
    $xml->XMLWriter()->startElement('category');
    $current_category = $achievements->GetSummaryAchievementData($achievement_category);
    if($current_category) {
        $xml->XMLWriter()->startElement('c');
        foreach($current_category as $category_key => $category_value) {
            $xml->XMLWriter()->writeAttribute($category_key, $category_value);
        }
        $xml->XMLWriter()->endElement();  //c
    }
    $xml->XMLWriter()->endElement(); //category
}
// Last 5 achievements
$last_achievements = $achievements->GetLastAchievements();
if(is_array($last_achievements)) {
    foreach($last_achievements as $l_achievement) {
        $xml->XMLWriter()->startElement('achievement');
        foreach($l_achievement as $l_a_key => $l_a_value) {
            $xml->XMLWriter()->writeAttribute($l_a_key, $l_a_value);
        }
        $xml->XMLWriter()->endElement(); //achievement
    }
}
$xml->XMLWriter()->endElement();    //summary

// root
$xml->XMLWriter()->startElement('rootCategories');
$root_categories = $achievements->BuildCategoriesTree();
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
$xml->XMLWriter()->endElement();   //achievements
$xml->XMLWriter()->endElement(); //page
$xml_cache_data = $xml->StopXML();
echo $xml_cache_data;
if($armory->armoryconfig['useCache'] == true && !isset($_GET['skipCache'])) {
    // Write cache to file
    $cache_data = $utils->GenerateCacheData($characters->name, $characters->guid, 'character-achievements');
    $cache_handler = $utils->WriteCache($cache_id, $cache_data, $xml_cache_data);
}
exit;
?>