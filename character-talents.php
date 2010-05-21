<?php

/**
 * @package World of Warcraft Armory
 * @version Release Candidate 1
 * @revision 203
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
// Load XSLT template
$xml->LoadXSLT('character/talents.xsl');
if(isset($_GET['n'])) {
    $name = $_GET['n'];
}
elseif(isset($_GET['cn'])) {
    $name = $_GET['cn'];
}
else {
    $name = false;
}
$characters->BuildCharacter($name);
$isCharacter = $characters->CheckPlayer();
if(!isset($_GET['r']) || !$armory->currentRealmInfo) {
    $isCharacter = false;
}
// Get page cache
if($isCharacter && $armory->armoryconfig['useCache'] == true && !isset($_GET['skipCache'])) {
    $cache_id = $utils->GenerateCacheId('character-talents', $characters->GetName(), $armory->currentRealmInfo['name']);
    if($cache_data = $utils->GetCache($cache_id)) {
        echo $cache_data;
        echo sprintf('<!-- Restored from cache; id: %s -->', $cache_id);
        exit;
    }
}
/** Basic info **/
$achievements->guid = $characters->GetGUID();
$tabUrl = $characters->GetUrlString();
/** Header **/
$xml->XMLWriter()->startElement('page');
$xml->XMLWriter()->writeAttribute('globalSearch', 1);
$xml->XMLWriter()->writeAttribute('lang', $armory->_locale);
$xml->XMLWriter()->writeAttribute('requestUrl', 'character-talents.xml');
$xml->XMLWriter()->startElement('tabInfo');
$xml->XMLWriter()->writeAttribute('subTab', 'talents');
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
$character_element = $characters->GetHeader($achievements);
$xml->XMLWriter()->startElement('characterInfo');
$xml->XMLWriter()->startElement('character');
foreach($character_element as $c_elem_name => $c_elem_value) {
    $xml->XMLWriter()->writeAttribute($c_elem_name, $c_elem_value);
}
$xml->XMLWriter()->endElement(); //character
$talent_build = $characters->CalculateCharacterTalentBuild();
$talent_points = $characters->CalculateCharacterTalents();
$build = array();
$points = array();
$talent_info = array();
$current_tree = array();
$glyphs = $characters->GetCharacterGlyphs();
for($i = 0; $i < $characters->GetSpecCount(); $i++ ) {
    $current_tree[$i] = Utils::GetMaxArray($talent_points['points'][$i]);
    $talent_info[$i] = array(
        'treeOne'   => $talent_points['points'][$i][$characters->GetTalentTab(0)],
        'treeThree' => $talent_points['points'][$i][$characters->GetTalentTab(2)],
        'treeTwo'   => $talent_points['points'][$i][$characters->GetTalentTab(1)],
        'value'     => $talent_build[$i]
    );
}
$xml->XMLWriter()->startElement('talents');
for($i = 0; $i < $characters->GetSpecCount(); $i++) {
    $xml->XMLWriter()->startElement('talentGroup');
    $xml->XMLWriter()->writeAttribute('active', ($i == $characters->GetActiveSpec()) ? 1 : 0);
    $xml->XMLWriter()->writeAttribute('group', $i+1);
    $xml->XMLWriter()->writeAttribute('icon', $characters->ReturnTalentTreeIcon($current_tree[$i]));
    $xml->XMLWriter()->writeAttribute('prim', $characters->ReturnTalentTreesNames($current_tree[$i]));
    $xml->XMLWriter()->startElement('talentSpec');
    foreach($talent_info[$i] as $tinfo_key => $tinfo_value) {
        $xml->XMLWriter()->writeAttribute($tinfo_key, $tinfo_value);
    }
    $xml->XMLWriter()->endElement(); //talentSpec
    $xml->XMLWriter()->startElement('glyphs');
    if(isset($glyphs[$i])) {
        foreach($glyphs[$i] as $_glyph) {
            $xml->XMLWriter()->startElement('glyph');
            foreach($_glyph as $glyph_key => $glyph_value) {
                $xml->XMLWriter()->writeAttribute($glyph_key, $glyph_value);
            }
            $xml->XMLWriter()->endElement(); //glyphs    
        }
    }
    $xml->XMLWriter()->endElement();  //glyphs    
    $xml->XMLWriter()->endElement(); //talentGroup
}
$xml->XMLWriter()->endElement();   //talents
$xml->XMLWriter()->endElement();  //characterInfo
$xml->XMLWriter()->endElement(); //page
$xml_cache_data = $xml->StopXML();
echo $xml_cache_data;
if($armory->armoryconfig['useCache'] == true && !isset($_GET['skipCache'])) {
    // Write cache to file
    $cache_data = $utils->GenerateCacheData($characters->GetName(), $characters->GetGUID(), 'character-talents');
    $cache_handler = $utils->WriteCache($cache_id, $cache_data, $xml_cache_data);
}
exit;
?>