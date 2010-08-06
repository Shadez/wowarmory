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
if(!@include('includes/armory_loader.php')) {
    die('<b>Fatal error:</b> unable to load system files.');
}
header('Content-type: text/xml');
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
if($isCharacter && $armory->armoryconfig['useCache'] == true && !isset($_GET['skipCache'])) {
    $cache_id = $utils->GenerateCacheId('character-reputation', $characters->GetName(), $armory->currentRealmInfo['name']);
    if($cache_data = $utils->GetCache($cache_id)) {
        echo $cache_data;
        echo sprintf('<!-- Restored from cache; id: %s -->', $cache_id);
        exit;
    }
}
// Load XSLT template
$xml->LoadXSLT('character/reputation.xsl');
$tabUrl = $characters->GetUrlString();
/** Header **/
$xml->XMLWriter()->startElement('page');
$xml->XMLWriter()->writeAttribute('globalSearch', 1);
$xml->XMLWriter()->writeAttribute('lang', $armory->GetLocale());
$xml->XMLWriter()->writeAttribute('requestUrl', 'character-reputation.xml');
$xml->XMLWriter()->startElement('tabInfo');
$xml->XMLWriter()->writeAttribute('subTab', 'reputation');
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
$xml->XMLWriter()->startElement('reputationTab');
$character_reputation = $characters->GetCharacterReputation();
if($character_reputation) {
    if($utils->IsWriteRaw()) {
        $xml->XMLWriter()->writeRaw('<faction');
        $header_faction = array(
            'header' => 1, 'iconKey' => 'classic', 'id' => 1118, 'key' => 'classic', 'name' => 'World of Warcraft' // hack
        );
        foreach($header_faction as $head_key => $head_value) {
            $xml->XMLWriter()->writeRaw(' ' . $head_key .'="' . $head_value .'"');
        }
        $xml->XMLWriter()->writeRaw('>');
        foreach($character_reputation as $faction) {
            $xml->XMLWriter()->writeRaw('<faction');
            foreach($faction as $rep_key => $rep_value) {
                $xml->XMLWriter()->writeRaw(' ' . $rep_key .'="' . $rep_value .'"');
            }
            $xml->XMLWriter()->writeRaw('/>');
        }
        $xml->XMLWriter()->writeRaw('</faction>');
    }
    else {
        $xml->XMLWriter()->startElement('faction');
        $header_faction = array(
            'header' => 1, 'iconKey' => 'classic', 'id' => 1118, 'key' => 'classic', 'name' => 'World of Warcraft' // hack
        );
        foreach($header_faction as $head_key => $head_value) {
            $xml->XMLWriter()->writeAttribute($head_key, $head_value);
        }
        foreach($character_reputation as $faction) {
            $xml->XMLWriter()->startElement('faction');
            foreach($faction as $rep_key => $rep_value) {
                $xml->XMLWriter()->writeAttribute($rep_key, $rep_value);
            }
            $xml->XMLWriter()->endElement(); //faction
        }
        $xml->XMLWriter()->endElement(); //faction
    }
}
$xml->XMLWriter()->endElement();  //reputationTab
$xml->XMLWriter()->endElement(); //page
$xml_cache_data = $xml->StopXML();
echo $xml_cache_data;
if($armory->armoryconfig['useCache'] == true && !isset($_GET['skipCache'])) {
    // Write cache to file
    $cache_data = $utils->GenerateCacheData($characters->GetName(), $characters->GetGUID(), 'character-reputation');
    $cache_handler = $utils->WriteCache($cache_id, $cache_data, $xml_cache_data);
}
exit;
?>