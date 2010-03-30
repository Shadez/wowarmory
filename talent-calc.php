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
if(!@include('includes/armory_loader.php')) {
    die('<b>Fatal error:</b> unable to load system files.');
}
header('Content-type: text/xml');
// Load XSLT template
$xml->LoadXSLT('tools/talent-calculator.xsl');
$xml->XMLWriter()->startElement('page');
$xml->XMLWriter()->writeAttribute('globalSearch', 1);
$xml->XMLWriter()->writeAttribute('lang', $armory->_locale);
$xml->XMLWriter()->writeAttribute('requestUrl', 'talent-calc.xml');
if(isset($_GET['cid'])) {
    $class_id = (int) $_GET['cid'];
}
elseif(isset($_GET['c'])) {
    $class_id = $utils->GetClassId($_GET['c']);
}
else {
    $class_id = 6;
}
if(isset($_GET['pid'])) {
    $pet_id = $_GET['pid'];
}
$xml->XMLWriter()->startElement('talents');
if(isset($_GET['pid'])) {
    $xml->XMLWriter()->writeAttribute('familyId', $_GET['pid']);
}
else {
    $xml->XMLWriter()->writeAttribute('classId', $class_id);
}

if(isset($_GET['tal'])) {
    $xml->XMLWriter()->writeAttribute('tal', $_GET['tal']);
}
$xml->XMLWriter()->endElement(); //talents
if(!isset($pet_id)) {
    $xml->XMLWriter()->startElement('talentTabs');
    for($i=1;$i<12;$i++) {
        if($i == 10) {
            continue;
        }
        $xml->XMLWriter()->startElement('talentTab');
        $xml->XMLWriter()->writeAttribute('classId', $i);
        $xml->XMLWriter()->endElement();  //talentTab
    }
}
else {
    $xml->XMLWriter()->startElement('petTalentTabs');
    
    $pet_catid = array();
    $pet_catid['cunning'][0] = array('catId' => 8, 'icon' => 'ability_hunter_pet_dragonhawk', 'id' => 30);
    $pet_catid['cunning'][1] = array('catId' => 16, 'icon' => 'spell_nature_guardianward', 'id' => 35);
    $pet_catid['cunning'][2] = array('catId' => 22, 'icon' => 'ability_hunter_pet_windserpent', 'id' => 17);
    $pet_catid['cunning'][3] = array('catId' => 0, 'icon' => 'ability_hunter_pet_bat', 'id' => 24);
    $pet_catid['cunning'][4] = array('catId' => 14, 'icon' => 'ability_hunter_pet_ravager', 'id' => 31);
    $pet_catid['cunning'][5] = array('catId' => 17, 'icon' => 'ability_hunter_pet_spider', 'id' => 13);    
    $pet_catid['cunning'][6] = array('catId' => 63, 'icon' => 'ability_hunter_pet_silithid', 'id' => 41);
    $pet_catid['cunning'][7] = array('catId' => 12, 'icon' => 'ability_hunter_pet_netherray', 'id' => 34);
    $pet_catid['cunning'][8] = array('catId' => 18, 'icon' => 'ability_hunter_pet_sporebat', 'id' => 33);
    $pet_catid['cunning'][9] = array('catId' => 24, 'icon' => 'ability_hunter_pet_chimera', 'id' => 38);    
    $pet_catid['tenacity'][0] = array('catId' => 3, 'icon' => 'ability_hunter_pet_boar', 'id' => 5);
    $pet_catid['tenacity'][1] = array('catId' => 9, 'icon' => 'ability_hunter_pet_gorilla', 'id' => 9);
    $pet_catid['tenacity'][2] = array('catId' => 6, 'icon' => 'ability_hunter_pet_crab', 'id' => 8);
    $pet_catid['tenacity'][3] = array('catId' => 7, 'icon' => 'ability_hunter_pet_crocolisk', 'id' => 6);
    $pet_catid['tenacity'][4] = array('catId' => 61, 'icon' => 'ability_hunter_pet_rhino', 'id' => 43);
    $pet_catid['tenacity'][5] = array('catId' => 1, 'icon' => 'ability_hunter_pet_bear', 'id' => 4);    
    $pet_catid['tenacity'][6] = array('catId' => 21, 'icon' => '"ability_hunter_pet_warpstalker', 'id' => 32);
    $pet_catid['tenacity'][7] = array('catId' => 15, 'icon' => 'ability_hunter_pet_scorpid', 'id' => 20);
    $pet_catid['tenacity'][8] = array('catId' => 62, 'icon' => 'ability_hunter_pet_worm', 'id' => 42);
    $pet_catid['tenacity'][9] = array('catId' => 21, 'icon' => 'ability_hunter_pet_turtle', 'id' => 21);    
    $pet_catid['ferocity'][0] = array('catId' => 23, 'icon' => 'ability_hunter_pet_wolf', 'id' => 1);
    $pet_catid['ferocity'][1] = array('catId' => 10, 'icon' => 'ability_hunter_pet_hyena', 'id' => 25);
    $pet_catid['ferocity'][2] = array('catId' => 59, 'icon' => 'ability_hunter_pet_corehound', 'id' => 45);
    $pet_catid['ferocity'][3] = array('catId' => 19, 'icon' => 'ability_hunter_pet_tallstrider', 'id' => 12);
    $pet_catid['ferocity'][4] = array('catId' => 58, 'icon' => 'ability_druid_primalprecision', 'id' => 46);
    $pet_catid['ferocity'][5] = array('catId' => 25, 'icon' => 'ability_hunter_pet_devilsaur', 'id' => 39);    
    $pet_catid['ferocity'][6] = array('catId' => 5, 'icon' => '"ability_hunter_pet_cat', 'id' => 2);
    $pet_catid['ferocity'][7] = array('catId' => 11, 'icon' => 'ability_hunter_pet_moth', 'id' => 37);
    $pet_catid['ferocity'][8] = array('catId' => 60, 'icon' => 'ability_hunter_pet_wasp', 'id' => 44);
    $pet_catid['ferocity'][9] = array('catId' => 4, 'icon' => 'ability_hunter_pet_vulture', 'id' => 7);
    $pet_catid['ferocity'][10] = array('catId' => 13, 'icon' => 'ability_hunter_pet_raptor', 'id' => 11);
    
    $xml->XMLWriter()->startElement('petTalentTab');
    $xml->XMLWriter()->writeAttribute('key', 'Cunning');
    $xml->XMLWriter()->writeAttribute('order', 2);
    foreach($pet_catid['cunning'] as $cunning) {
        $xml->XMLWriter()->startElement('family');
        foreach($cunning as $cunning_key => $cunning_value) {
            $xml->XMLWriter()->writeAttribute($cunning_key, $cunning_value);
        }
        $xml->XMLWriter()->endElement(); //family
    }
    $xml->XMLWriter()->endElement(); //petTalentTab
    
    $xml->XMLWriter()->startElement('petTalentTab');
    $xml->XMLWriter()->writeAttribute('key', 'Tenacity');
    $xml->XMLWriter()->writeAttribute('order', 1);
    foreach($pet_catid['tenacity'] as $tenacity) {
        $xml->XMLWriter()->startElement('family');
        foreach($tenacity as $tenacity_key => $tenacity_value) {
            $xml->XMLWriter()->writeAttribute($tenacity_key, $tenacity_value);
        }
        $xml->XMLWriter()->endElement(); //family
    }
    $xml->XMLWriter()->endElement(); //petTalentTab
    
    $xml->XMLWriter()->startElement('petTalentTab');
    $xml->XMLWriter()->writeAttribute('key', 'Ferocity');
    $xml->XMLWriter()->writeAttribute('order', 0);
    foreach($pet_catid['ferocity'] as $ferocity) {
        $xml->XMLWriter()->startElement('family');
        foreach($ferocity as $ferocity_key => $ferocity_value) {
            $xml->XMLWriter()->writeAttribute($ferocity_key, $ferocity_value);
        }
        $xml->XMLWriter()->endElement(); //family
    }
    $xml->XMLWriter()->endElement(); //petTalentTab
}
$xml->XMLWriter()->endElement();  //talentTabs or petTalentTabs
$xml->XMLWriter()->endElement(); //page
$xml_cache_data = $xml->StopXML();
echo $xml_cache_data;
exit;
?>