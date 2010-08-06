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
if(!@include('includes/armory_loader.php')) {
    die('<b>Fatal error:</b> unable to load system files.');
}
header('Content-type: text/xml');
// Load XSLT template
$xml->LoadXSLT('tools/talent-calculator.xsl');
$xml->XMLWriter()->startElement('page');
$xml->XMLWriter()->writeAttribute('globalSearch', 1);
$xml->XMLWriter()->writeAttribute('lang', $armory->GetLocale());
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
    $pet_id = (int) $_GET['pid'];
}
$xml->XMLWriter()->startElement('talents');
if(isset($_GET['pid'])) {
    $xml->XMLWriter()->writeAttribute('familyId', $pet_id);
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
    $xml->XMLWriter()->startElement('petTalentTab');
    $xml->XMLWriter()->writeAttribute('key', 'Cunning');
    $xml->XMLWriter()->writeAttribute('name', $armory->aDB->selectCell("SELECT `name_".$armory->GetLocale()."` FROM `armory_petcalc` WHERE `id` < 0 AND `key`='cunning'"));
    $xml->XMLWriter()->writeAttribute('order', 2);
    $pet_cunning = $utils->PetTalentCalcData('cunning');
    foreach($pet_cunning as $cunning) {
        $xml->XMLWriter()->startElement('family');
        foreach($cunning as $cunning_key => $cunning_value) {
            $xml->XMLWriter()->writeAttribute($cunning_key, $cunning_value);
        }
        $xml->XMLWriter()->endElement(); //family
    }
    $xml->XMLWriter()->endElement(); //petTalentTab
    
    $xml->XMLWriter()->startElement('petTalentTab');
    $xml->XMLWriter()->writeAttribute('key', 'Tenacity');
    $xml->XMLWriter()->writeAttribute('name', $armory->aDB->selectCell("SELECT `name_".$armory->GetLocale()."` FROM `armory_petcalc` WHERE `id` < 0 AND `key`='tenacity'"));
    $xml->XMLWriter()->writeAttribute('order', 1);
    $pet_tenacity = $utils->PetTalentCalcData('tenacity');
    foreach($pet_tenacity as $tenacity) {
        $xml->XMLWriter()->startElement('family');
        foreach($tenacity as $tenacity_key => $tenacity_value) {
            $xml->XMLWriter()->writeAttribute($tenacity_key, $tenacity_value);
        }
        $xml->XMLWriter()->endElement(); //family
    }
    $xml->XMLWriter()->endElement(); //petTalentTab
    
    $xml->XMLWriter()->startElement('petTalentTab');
    $xml->XMLWriter()->writeAttribute('key', 'Ferocity');
    $xml->XMLWriter()->writeAttribute('name', $armory->aDB->selectCell("SELECT `name_".$armory->GetLocale()."` FROM `armory_petcalc` WHERE `id` < 0 AND `key`='ferocity'"));
    $xml->XMLWriter()->writeAttribute('order', 0);
    $pet_ferocity = $utils->PetTalentCalcData('ferocity');
    foreach($pet_ferocity as $ferocity) {
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