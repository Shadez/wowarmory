<?php

/**
 * @package World of Warcraft Armory
 * @version Release Candidate 1
 * @revision 397
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
$comparisonData = false;
$comparison = false;
// Check for achievement comparison
if($comparisonData = $utils->IsAchievementsComparison()) {
    // We got it
    $comparison = array();
    $i = 0;
    foreach($comparisonData as $char) {
        $comparison[$i] = new Characters($armory);
        $comparison[$i]->BuildCharacter($char['name'], $utils->GetRealmIdByName($char['realm']), true);
        if(!$comparison[$i]->CheckPlayer()) {
            array_pop($comparison);
        }
        else {
            $i++;
        }
    }
    //
    $name = $comparisonData[0]['name'];
}
$realmId = $utils->GetRealmIdByName($_GET['r']);
$characters->BuildCharacter($name, $realmId, true, true);
$isCharacter = $characters->CheckPlayer();
$achievements = $characters->GetAchievementMgr();
if($_GET['r'] === false || !$armory->currentRealmInfo) {
    $isCharacter = false;
}
// Get page cache
if($isCharacter && $armory->armoryconfig['useCache'] == true && !isset($_GET['skipCache'])) {
    if($achievement_category > 0) {
        if(is_array($comparisonData)) {
            $cache_id = $utils->GenerateCacheId('character-statistics-c'.$achievement_category, $utils->GenerateCacheIdForComparisons($comparisonData));
        }
        else {
            $cache_id = $utils->GenerateCacheId('character-statistics-c'.$achievement_category, $characters->GetName(), $armory->currentRealmInfo['name']);
        }
    }
    else {
        if(is_array($comparisonData)) {
            $cache_id = $utils->GenerateCacheId('character-statistics', $utils->GenerateCacheIdForComparisons($comparisonData));
        }
        else {
            $cache_id = $utils->GenerateCacheId('character-statistics', $characters->GetName(), $armory->currentRealmInfo['name']);
        }
    }
    if($cache_data = $utils->GetCache($cache_id)) {
        echo $cache_data;
        echo sprintf('<!-- Restored from cache; id: %s -->', $cache_id);
        exit;
    }
}
if($achievement_category > 0) {    
    $xml->XMLWriter()->startElement('category');
    $pages = false;
    if(is_array($comparison)) {
        $pages = array();
        $counter_comparison = 0;
        foreach($comparison as $char) {
            $pages[$counter_comparison] = $char->GetAchievementMgr()->LoadStatisticsPage($achievement_category, ($char->GetFaction() == 1) ? 0 : 1);
            $counter_comparison++;
        }
    }
    $pages_count = count($pages);
    $statistics_page = $achievements->LoadStatisticsPage($achievement_category, ($characters->GetFaction() == 1) ? 0 : 1);
    $i = 0;
    if($statistics_page) {
        foreach($statistics_page as $stat) {
            if($utils->IsWriteRaw()) {
                if(is_array($pages)) {
                    $xml->XMLWriter()->writeRaw('<statistic name="' . $stat['name'] . '">');
                    for($aCount = 0; $aCount < $pages_count; $aCount++) {
                        $tmp = $pages[$aCount];
                        $xml->XMLWriter()->writeRaw('<c');
                        if(isset($tmp[$stat['id']])) {
                            if($tmp[$stat['id']]['quantity'] == null || $tmp[$stat['id']]['quantity'] == 0) {
                                $tmp[$stat['id']]['quantity'] = '--';
                            }
                            $xml->XMLWriter()->writeRaw(' id="' . $stat['id'] . '" "quantity="' . $tmp[$stat['id']]['quantity'] . '"');
                        }
                        $xml->XMLWriter()->writeRaw('/>'); //c
                    }
                    $xml->XMLWriter()->writeRaw('</statistic>'); //achievement
                }
                else {
                    $xml->XMLWriter()->writeRaw('<statistic');
                    foreach($stat as $statistic_key => $statistic_value) {
                        $xml->XMLWriter()->writeRaw(' ' . $statistic_key . '="' . $statistic_value . '"');
                    }
                    $xml->XMLWriter()->writeRaw('/>');
                }
            }
            else {
                if(is_array($pages)) {
                    $xml->XMLWriter()->startElement('statistic');
                    $xml->XMLWriter()->writeAttribute('name', $stat['name']);
                    for($aCount = 0; $aCount < $pages_count; $aCount++) {
                        $tmp = $pages[$aCount];
                        $xml->XMLWriter()->startElement('c');
                        if(isset($tmp[$stat['id']])) {
                            if($tmp[$stat['id']]['quantity'] == null || $tmp[$stat['id']]['quantity'] == 0) {
                                $tmp[$stat['id']]['quantity'] = '--';
                            }
                            $xml->XMLWriter()->writeAttribute('id', $stat['id']);
                            $xml->XMLWriter()->writeAttribute('quantity', $tmp[$stat['id']]['quantity']);
                        }
                        $xml->XMLWriter()->endElement();  //c
                    }
                    $xml->XMLWriter()->endElement(); //statistic
                }
                else {
                    $xml->XMLWriter()->startElement('statistic');
                    foreach($stat as $statistic_key => $statistic_value) {
                        $xml->XMLWriter()->writeAttribute($statistic_key, $statistic_value);
                    }
                    $xml->XMLWriter()->endElement(); //statistic
                }
            }
        }
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
$tabUrl = $characters->GetUrlString();
/** Header **/
$xml->XMLWriter()->startElement('page');
$xml->XMLWriter()->writeAttribute('globalSearch', 1);
$xml->XMLWriter()->writeAttribute('lang', $armory->GetLocale());
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
$character_title = $characters->GetChosenTitleInfo();
$character_element = $characters->GetHeader();
$xml->XMLWriter()->startElement('characterInfo');
if($utils->IsWriteRaw()) {
    if(is_array($comparison)) {
        foreach($comparison as $char) {
            $xml->XMLWriter()->writeRaw('<character');
            $current_header = $char->GetHeader();
            foreach($current_header as $header_key => $header_value) {
                if($header_key == 'charUrl') {
                    $xml->XMLWriter()->writeRaw(' ' . $header_key . '="' . htmlspecialchars($header_value) . '"');
                }
                else {
                    $xml->XMLWriter()->writeRaw(' ' . $header_key .'="' .$header_value.'"');
                }
            }
            $xml->XMLWriter()->writeRaw('/>');
            
        }
    }
    else {
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
}
else {
    if(is_array($comparison)) {
        foreach($comparison as $char) {
            $xml->XMLWriter()->startElement('character');
            $current_header = $char->GetHeader();
            foreach($current_header as $header_key => $header_value) {
                $xml->XMLWriter()->writeAttribute($header_key, $header_value);
            }
            $xml->XMLWriter()->endElement(); //character
        }
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
}
$xml->XMLWriter()->endElement();  //characterInfo
$xml->XMLWriter()->startElement('statistics');
$xml->XMLWriter()->startElement('summary');
$summary_data = $achievements->GetSummaryDataForStatisticsPage();
if(is_array($comparison)) {
    $count_summary = 0;
    $summary = array();
    foreach($comparison as $char) {
        $summary[$count_summary] = $char->GetAchievementMgr()->GetSummaryDataForStatisticsPage();
        $count_summary++;
    }
    foreach($summary_data as $summ) {
        if($utils->IsWriteRaw()) {
            $xml->XMLWriter()->writeRaw('<statistic name="' . $summ['name'] . '">');
            foreach($summary as $sChar) {
                if(isset($sChar[$summ['id']])) {
                    $xml->XMLWriter()->writeRaw('<c id="' . $sChar[$summ['id']]['id'] . '" quantity="' . $sChar[$summ['id']]['quantity'] . '"/>');
                }
            }
            $xml->XMLWriter()->writeRaw('</statistics>');
        }
        else {
            $xml->XMLWriter()->startElement('statistic');
            $xml->XMLWriter()->writeAttribute('name', $summ['name']);
            foreach($summary as $sChar) {
                if(isset($sChar[$summ['id']])) {
                    $xml->XMLWriter()->startElement('c');
                    $xml->XMLWriter()->writeAttribute('id', $sChar[$summ['id']]['id']);
                    $xml->XMLWriter()->writeAttribute('quantity', $sChar[$summ['id']]['quantity']);
                    $xml->XMLWriter()->endElement(); //c
                }
            }
            $xml->XMLWriter()->endElement(); //statistic
        }
    }
}
else {
    foreach($summary_data as $summ) {
        if($utils->IsWriteRaw()) {
            $xml->XMLWriter()->writeRaw('<statistic id="' . $summ['id'] . '" name="' . $summ['name'] . '" quantity="' . $summ['quantity'] . '"/>');
        }
        else {
            $xml->XMLWriter()->startElement('statistic');
            $xml->XMLWriter()->writeAttribute('id', $summ['id']);
            $xml->XMLWriter()->writeAttribute('name', $summ['name']);
            $xml->XMLWriter()->writeAttribute('quantity', $summ['quantity']);
            $xml->XMLWriter()->endElement(); //statistic
        }
    }
}
$xml->XMLWriter()->endElement();    //summary
$xml->XMLWriter()->startElement('rootCategories');
$root_categories = $achievements->BuildStatisticsCategoriesTree();
foreach($root_categories as $category) {
    if($utils->IsWriteRaw()) {
        $xml->XMLWriter()->writeRaw('<category');
        $xml->XMLWriter()->writeRaw(' id="' . $category['id'] . '"');
        if($category['id'] == 14807) {
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
                $xml->XMLWriter()->writeRaw(' id="' . $category_child['id'] . '"');
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
$xml->XMLWriter()->endElement();   //rootCategories
$xml->XMLWriter()->endElement();  //statistics
$xml->XMLWriter()->endElement(); //page
$xml_cache_data = $xml->StopXML();
echo $xml_cache_data;
if($armory->armoryconfig['useCache'] == true && !isset($_GET['skipCache'])) {
    // Write cache to file
    $cache_data = $utils->GenerateCacheData($characters->GetName(), $characters->GetGUID(), 'character-statistics');
    $cache_handler = $utils->WriteCache($cache_id, $cache_data, $xml_cache_data);
}
exit;
?>