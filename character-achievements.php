<?php

/**
 * @package World of Warcraft Armory
 * @version Release Candidate 1
 * @revision 345
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
    $name = $_GET['n'];
}
elseif(isset($_GET['cn'])) {
    $name = $_GET['cn'];
}
else {
    $name = false;
}
if(!isset($_GET['r'])) {
    $_GET['r'] = false;
}
$realmId = $utils->GetRealmIdByName($_GET['r']);
$characters->BuildCharacter($name, $realmId);
$isCharacter = $characters->CheckPlayer();
$achievements = $characters->GetAchievementMgr();
if($_GET['r'] === false || !$armory->currentRealmInfo) {
    $isCharacter = false;
}
// Get page cache
if($characters->GetGUID() > 0 && $isCharacter && $armory->armoryconfig['useCache'] == true && !isset($_GET['skipCache'])) {
    if($achievement_category > 0) {
        $cache_id = $utils->GenerateCacheId('character-achievements-c'.$achievement_category, $characters->GetName(), $armory->currentRealmInfo['name']);
    }
    else {
        $cache_id = $utils->GenerateCacheId('character-achievements', $characters->GetName(), $armory->currentRealmInfo['name']);
    }
    if($cache_data = $utils->GetCache($cache_id)) {
        echo $cache_data;
        echo sprintf('<!-- Restored from cache; id: %s -->', $cache_id);
        exit;
    }
}
if($achievement_category > 0) {
    $armory->Log()->writeLog('character-achievements.php : detected category: %d', $achievement_category);
    $xml->XMLWriter()->startElement('achievements');
    $xml->XMLWriter()->writeAttribute('lang', $armory->GetLocale());
    $xml->XMLWriter()->writeAttribute('requestUrl', 'character-achievements.xml');
    $xml->XMLWriter()->startElement('category');
    $achievements_page = $achievements->LoadAchievementPage($achievement_category, ($characters->GetFaction() == 1) ? 0 : 1);
    $i = 0;
    if(isset($achievements_page['completed'])) {
        foreach($achievements_page['completed'] as $achievement) {
            if($achievement['display'] == 0) {
                continue;
            }
            if($utils->IsWriteRaw()) {
                $xml->XMLWriter()->writeRaw('<achievement');
                if(isset($achievement['data'])) {
                    foreach($achievement['data'] as $a_data_key => $a_data_value) {
                        $xml->XMLWriter()->writeRaw(' ' . $a_data_key . '="' . $a_data_value . '"');
                    }
                }
                $xml->XMLWriter()->writeRaw('>');
                if(isset($achievement['criteria']) && is_array($achievement['criteria'])) {
                    foreach($achievement['criteria'] as $criteria) {
                        $xml->XMLWriter()->writeRaw('<criteria');
                        foreach($criteria as $c_key => $c_value) {
                            $xml->XMLWriter()->writeRaw(' ' . $c_key .'="' . $c_value .'"');
                        }
                        $xml->XMLWriter()->writeRaw('/>'); //criteria
                    }
                }
                if(isset($achievement['achievement_tree'])) {
                    foreach($achievement['achievement_tree'] as $achievement_tree) {
                        $xml->XMLWriter()->writeRaw('<achievement');
                        foreach($achievement_tree as $a_tree_key => $a_tree_value) {
                            $xml->XMLWriter()->writeRaw(' ' . $a_tree_key . '="' . $a_tree_value . '"');
                        }
                        $xml->XMLWriter()->writeRaw('/>'); //achievement
                    }
                }
                $xml->XMLWriter()->writeRaw('</achievement>'); //achievement
            }
            else {
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
    }
    else {
        $armory->Log()->writeLog('character-achievements.php : player %d (%s) does not have any completed achievements in %d category', $characters->GetGUID(), $characters->GetName(), $achievement_category);
    }
    if(isset($achievements_page['incompleted'])) {
        if($utils->IsWriteRaw()) {
            foreach($achievements_page['incompleted'] as $achievement) {
                if(isset($achievement['display']) && $achievement['display'] == 0) {
                    continue;
                }
                $xml->XMLWriter()->writeRaw('<achievement');
                if(isset($achievement['data'])) {
                    foreach($achievement['data'] as $a_data_key => $a_data_value) {
                        $xml->XMLWriter()->writeRaw(' ' . $a_data_key . '="' . $a_data_value . '"');
                    }
                }
                else {
                    $armory->Log()->writeLog('character-achievements.php : achievement[data] not found (player: %d; %s)!', $characters->GetGUID(), $characters->GetName());
                }
                $xml->XMLWriter()->writeRaw('>');
                if(isset($achievement['criteria']) && is_array($achievement['criteria'])) {
                    foreach($achievement['criteria'] as $criteria) {
                        $xml->XMLWriter()->writeRaw('<criteria');
                        foreach($criteria as $c_key => $c_value) {
                            $xml->XMLWriter()->writeRaw(' ' . $c_key . '="' . $c_value . '"');
                        }
                        $xml->XMLWriter()->writeRaw('/>'); //criteria
                    }
                }
                else {
                    $armory->Log()->writeLog('character-achievements.php : achievement[critera] not found (player: %d; %s)!', $characters->GetGUID(), $characters->GetName());
                }
                if(isset($achievement['achievement_tree'])) {
                    foreach($achievement['achievement_tree'] as $achievement_tree) {
                        $xml->XMLWriter()->writeRaw('<achievement');
                        foreach($achievement_tree as $a_tree_key => $a_tree_value) {
                            $xml->XMLWriter()->writeRaw(' ' . $a_tree_key . '="' . $a_tree_value . '"');
                        }
                        $xml->XMLWriter()->writeRaw('/>'); //achievement
                    }
                }
                $xml->XMLWriter()->writeRaw('</achievement>'); //achievement
            }
        }
        else {
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
                else {
                    $armory->Log()->writeLog('character-achievements.php : achievement[data] not found (player: %d; %s)!', $characters->GetGUID(), $characters->GetName());
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
                else {
                    $armory->Log()->writeLog('character-achievements.php : achievement[critera] not found (player: %d; %s)!', $characters->GetGUID(), $characters->GetName());
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
    }
    else {
        $armory->Log()->writeLog('character-achievements.php : player %d (%s) does not have any incompleted achievements in %d category', $characters->GetGUID(), $characters->GetName(), $achievement_category);
    }
    $xml->XMLWriter()->endElement();  //category
    $xml->XMLWriter()->endElement(); //achievements
    $xml_cache_data = $xml->StopXML();
    echo $xml_cache_data;
    if($armory->armoryconfig['useCache'] == true && !isset($_GET['skipCache'])) {
        // Write cache to file
        $cache_data = $utils->GenerateCacheData($characters->GetName(), $characters->GetGUID(), 'character-achievements');
        $cache_handler = $utils->WriteCache($cache_id, $cache_data, $xml_cache_data);
    }
    exit;
}
/** Basic info **/
$tabUrl = $characters->GetUrlString();
/** Header **/
$xml->XMLWriter()->startElement('page');
$xml->XMLWriter()->writeAttribute('globalSearch', 1);
$xml->XMLWriter()->writeAttribute('lang', $armory->GetLocale());
$xml->XMLWriter()->writeAttribute('requestUrl', 'character-achievements.xml');
$xml->XMLWriter()->startElement('tabInfo');
$xml->XMLWriter()->writeAttribute('subTab', 'achievements');
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
$character_title = $characters->GetChosenTitleInfo();
$character_element = $characters->GetHeader();
$xml->XMLWriter()->startElement('characterInfo');
if($utils->IsWriteRaw()) {
    $xml->XMLWriter()->writeRaw('<character');
    foreach($character_element as $c_elem_name => $c_elem_value) {
        if($c_elem_name == 'charUrl') {
            $xml->XMLWriter()->writeRaw(' ' . $c_elem_name .'="' .htmlspecialchars($c_elem_value).'"');
        }
        else {
            $xml->XMLWriter()->writeRaw(' ' . $c_elem_name .'="' .$c_elem_value.'"');
        }
    }
    $xml->XMLWriter()->writeRaw('>');
    $xml->XMLWriter()->writeRaw('<modelBasePath value="http://eu.media.battle.net.edgesuite.net/"/></character>');
}
else {
    $xml->XMLWriter()->startElement('character');
    foreach($character_element as $c_elem_name => $c_elem_value) {
        $xml->XMLWriter()->writeAttribute($c_elem_name, $c_elem_value);
    }
    $xml->XMLWriter()->startElement('modelBasePath');
    $xml->XMLWriter()->writeAttribute('value', 'http://eu.media.battle.net.edgesuite.net/');
    $xml->XMLWriter()->endElement();  //modelBasePath
    $xml->XMLWriter()->endElement(); //character
}
$xml->XMLWriter()->endElement(); //characterInfo
$xml->XMLWriter()->startElement('achievements');
$xml->XMLWriter()->startElement('summary');
$xml->XMLWriter()->startElement('c');
$info_summary = $achievements->GetSummaryAchievementData(0);
if(is_array($info_summary)) {
    foreach($info_summary as $info_key => $info_value) {
        $xml->XMLWriter()->writeAttribute($info_key, $info_value);
    }
}
$xml->XMLWriter()->endElement(); //c
$info_categories = array(92, 96, 97, 95, 168, 169, 201, 155, 81);
foreach($info_categories as $achievement_category) {
    $xml->XMLWriter()->startElement('category');
    $current_category = $achievements->GetSummaryAchievementData($achievement_category);
    if($current_category) {
        if($utils->IsWriteRaw()) {
            $xml->XMLWriter()->writeRaw('<c');
            foreach($current_category as $category_key => $category_value) {
                $xml->XMLWriter()->writeRaw(' ' . $category_key .'="' . $category_value . '"');
            }
            $xml->XMLWriter()->writeRaw('/>'); //c
        }
        else {
            $xml->XMLWriter()->startElement('c');
            foreach($current_category as $category_key => $category_value) {
                $xml->XMLWriter()->writeAttribute($category_key, $category_value);
            }
            $xml->XMLWriter()->endElement(); //c
        }
    }
    $xml->XMLWriter()->endElement(); //category
}
// Last 5 achievements
$last_achievements = $achievements->GetLastAchievements();
if(is_array($last_achievements)) {
    foreach($last_achievements as $l_achievement) {
        if(is_array($l_achievement)) {
            if($utils->IsWriteRaw()) {
                $xml->XMLWriter()->writeRaw('<achievement');
                foreach($l_achievement as $l_a_key => $l_a_value) {
                    $xml->XMLWriter()->writeRaw(' ' . $l_a_key .'="' . $l_a_value . '"');
                }
                $xml->XMLWriter()->writeRaw('/>'); //achievement
            }
            else {
                $xml->XMLWriter()->startElement('achievement');
                foreach($l_achievement as $l_a_key => $l_a_value) {
                    $xml->XMLWriter()->writeAttribute($l_a_key, $l_a_value);
                }
                $xml->XMLWriter()->endElement(); //achievement
            }
        }
    }
}
$xml->XMLWriter()->endElement(); //summary
// root
$xml->XMLWriter()->startElement('rootCategories');
$root_categories = $achievements->BuildCategoriesTree();
if($root_categories && is_array($root_categories)) {
    foreach($root_categories as $category) {
        if($utils->IsWriteRaw()) {
            $xml->XMLWriter()->writeRaw('<category');
            $xml->XMLWriter()->writeRaw(' id="' . $category['id'] . '"');
            if($category['id'] == 168) {
                $xml->XMLWriter()->writeRaw(' name="' . htmlspecialchars($category['name']) . '"');
            }
            else {
                $xml->XMLWriter()->writeRaw(' name="' . $category['name'] . '"');
            }
            
            $xml->XMLWriter()->writeRaw('>');
            if(isset($category['child']) && is_array($category['child'])) {
                foreach($category['child'] as $category_child) {
                    $xml->XMLWriter()->writeRaw('<category');
                    $xml->XMLWriter()->writeRaw(' name="' . $category_child['name'] . '"');
                    $xml->XMLWriter()->writeRaw(' id="' . htmlspecialchars($category_child['id']) . '"');
                    $xml->XMLWriter()->writeRaw('/>'); //category
                }
            }
            $xml->XMLWriter()->writeRaw('</category>'); //category
        }
        else {
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
    }
}
$xml->XMLWriter()->endElement();   //rootCategories
$xml->XMLWriter()->endElement();  //achievements
$xml->XMLWriter()->endElement(); //page
$xml_cache_data = $xml->StopXML();
echo $xml_cache_data;
if($armory->armoryconfig['useCache'] == true && !isset($_GET['skipCache'])) {
    // Write cache to file
    $cache_data = $utils->GenerateCacheData($characters->GetName(), $characters->GetGUID(), 'character-achievements');
    $cache_handler = $utils->WriteCache($cache_id, $cache_data, $xml_cache_data);
}
exit;
?>