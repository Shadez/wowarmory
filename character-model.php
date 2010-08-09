<?php

/**
 * @package World of Warcraft Armory
 * @version Release Candidate 1
 * @revision 352
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
define('load_items_class', true);
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
if($_GET['r'] === false || !$armory->currentRealmInfo) {
    $isCharacter = false;
}
// Get page cache
if($isCharacter && $armory->armoryconfig['useCache'] == true && !isset($_GET['skipCache'])) {
    $cache_id = $utils->GenerateCacheId('character-model', $characters->GetName(), $armory->currentRealmInfo['name']);
    if($cache_data = $utils->GetCache($cache_id)) {
        echo $cache_data;
        echo sprintf('<!-- Restored from cache; id: %s -->', $cache_id);
        exit;
    }
}
/** Header **/
$xml->XMLWriter()->startElement('page');
$xml->XMLWriter()->writeAttribute('globalSearch', 1);
$xml->XMLWriter()->writeAttribute('lang', $armory->GetLocale());
$xml->XMLWriter()->writeAttribute('requestUrl', 'character-model.xml');
$xml->XMLWriter()->startElement('tabInfo');
$xml->XMLWriter()->writeAttribute('tab', 'character');
$xml->XMLWriter()->writeAttribute('tabGroup', 'character');
$xml->XMLWriter()->writeAttribute('tabUrl', ($isCharacter) ? sprintf('r=%s&cn=%s', urlencode($armory->currentRealmInfo['name']), urlencode($characters->GetName())) : null);
$xml->XMLWriter()->endElement(); //tabInfo
if(!$isCharacter) {
    $xml->XMLWriter()->startElement('characterInfo');
    $xml->XMLWriter()->writeAttribute('errCode', 'noCharacter');
    $xml->XMLWriter()->endElement(); //characterInfo
    $xml->XMLWriter()->endElement(); //page
    $xml_cache_data = $xml->StopXML();
    echo $xml_cache_data;
    exit;
}
/** Basic info **/
$items->charGuid = $characters->GetGUID();
$character_model_data = array();
$race_model_data = $utils->RaceModelData($characters->GetRace());
$character_model_data['race'] = $race_model_data['modeldata_1'];
if($characters->GetGender() == 1) {
    $character_model_data['gender'] = 'female';
    $character_model_data['gender_1'] = 'f';
}
else {
    $character_model_data['gender'] = 'male';
    $character_model_data['gender_1'] = 'm';
}
$character_model_data['race_gender'] = $race_model_data['modeldata_2'].$character_model_data['gender_1'];
$player_model = $characters->GetPlayerBytes();
$character_model_data['face_color'] = ($player_model['playerBytes']>>8)%256;
$character_model_data['hair_style'] = ($player_model['playerBytes']>>16)%256;
$character_model_data['hair_color'] = ($player_model['playerBytes']>>24)%256;
$character_model_data['skin_style'] = $player_model['playerBytes']%256;
$character_model_data['facial_hair'] = $player_model['playerBytes2']%256;
$character_model_data['hair_style'] += 2; // Hack?

$character_model_data['hide_helm'] = 0;
$character_model_data['hide_cloak'] = 0;
if($player_model['playerFlags'] & 1024) {
    $character_model_data['hide_helm'] = 1;
}
if($player_model['playerFlags'] & 2048) {
    $character_model_data['hide_cloak'] = 1;
}
if(strlen($character_model_data['skin_style']) == 1) {
    $character_model_data['skin_style'] = '0'.$character_model_data['skin_style'];
}
$character_model_data['class'] = $characters->GetClass();
$charModelDataInfo = $characters->GetModelData();
if(!is_array($charModelDataInfo)) {
    $charModelDataInfo = array('baseY' => 0.97, 'facedY' => 1.6, 'scale' => 1.7);
}
$model_data = array(
    'baseY'    => $charModelDataInfo['baseY'],
    'facedY'   => $charModelDataInfo['facedY'],
    'hideCape' => $character_model_data['hide_cloak'],
    'hideHelm' => $character_model_data['hide_helm'],
    'id'       => 0,
    'modelFile' => sprintf('character/%s/%s/%s%s.m2', $character_model_data['race'], $character_model_data['gender'], $character_model_data['race'], $character_model_data['gender']),
    'name'      => 'base',
    'scale'     => $charModelDataInfo['scale'],
    'skinFile'  => sprintf('character/%s/%s/%s%s00.skin', $character_model_data['race'], $character_model_data['gender'], $character_model_data['race'], $character_model_data['gender']),
);

$xml->XMLWriter()->startElement('character');
if($utils->IsAccountHaveCurrentCharacter($characters->GetGUID(), $armory->currentRealmInfo['id'])) {
    $xml->XMLWriter()->writeAttribute('owned', 1);
}
$xml->XMLWriter()->startElement('models');
$xml->XMLWriter()->startElement('model');
foreach($model_data as $model_key => $model_value) {
    $xml->XMLWriter()->writeAttribute($model_key, $model_value);
}
$xml->XMLWriter()->startElement('components');
$components = array(100, 200, 801, 401, 601, $character_model_data['hair_style'], 901, 302, 1600, 1201, 702, 1001, 1401, 1501, 0, 101, 301, 1101, 502, 1502);
if($characters->GetGender() == 1) {
    $components[count($components)+1] = 1302; // Legs type
}
else {
    $components[count($components)+1] = 1301; // Legs type
}
if($characters->GetRace() == RACE_BLOODELF) {
    $components[count($components)+1] = 1702; // Eyes
}
if($characters->GetClass() == CLASS_DK) {
    $components[count($components)+1] = 1703; // Eyes
}
foreach($components as $component) {
    $xml->XMLWriter()->startElement('component');
    $xml->XMLWriter()->writeAttribute('n', $component);
    $xml->XMLWriter()->endElement();
}
$xml->XMLWriter()->endElement(); //components
$subtexture_data = array();
/** MAIN TEXTURES **/
/*
    TEXTURE NAME STRUCTURE:
        *_au - ARM UPPER    `armory_itemdisplayinfo`.`texture_2`
        *_al - ARM LOWER    `armory_itemdisplayinfo`.`visual_1`
        *_ha - HANDS        `armory_itemdisplayinfo`.`visual_2`
        *_tu - TORSO UPPER  `armory_itemdisplayinfo`.`visual_3`
        *_tl - TORSO LOWER  `armory_itemdisplayinfo`.`visual_4`
        *_lu - LEG UPPER    `armory_itemdisplayinfo`.`visual_5`
        *_ll - LEG LOWER    `armory_itemdisplayinfo`.`visual_6`
        *_fo - FOOT         `armory_itemdisplayinfo`.`visual_7`
*/
$tmpid = 0;
if($tmpid = $characters->GetCharacterEquip('shirt')) {
    if($items->GetItemModelData(0, 'texture_2', $tmpid)) {
        /**
         * Shirt (armupper)
         **/
        $subtexture_data['shirt_au'] = array(
            'prefix' => 'item/texturecomponents/armuppertexture/',
            'file'   => $items->GetItemModelData(0, 'texture_2', $tmpid),
            'fileBackup' => $items->GetItemModelData(0, 'texture_2', $tmpid),
            'h' => 0.25,
            'w' => 0.5,
            'x' => '0.0',
            'y' => '0.0'
        );
        $subtexture_data['shirt_au']['suffixFile'] = $items->GetModelSuffix($subtexture_data['shirt_au']['prefix'] . $subtexture_data['shirt_au']['file']);
        $subtexture_data['shirt_au']['suffixFileBackup'] = $items->GetModelSuffix($subtexture_data['shirt_au']['prefix'] . $subtexture_data['shirt_au']['fileBackup']);
            
        /**
         * Shirt (armlower)
         **/
        $subtexture_data['shirt_al'] = array(
            'prefix' => 'item/texturecomponents/armlowertexture/',
            'file'   => $items->GetItemModelData(0, 'visual_1', $tmpid),
            'fileBackup' => $items->GetItemModelData(0, 'visual_1', $tmpid),
            'h' => 0.25,
            'w' => 0.5,
            'x' => '0.0',
            'y' => 0.25
        );
        $subtexture_data['shirt_al']['suffixFile'] = $items->GetModelSuffix($subtexture_data['shirt_al']['prefix'] . $subtexture_data['shirt_al']['file']);
        $subtexture_data['shirt_al']['suffixFileBackup'] = $items->GetModelSuffix($subtexture_data['shirt_al']['prefix'] . $subtexture_data['shirt_al']['fileBackup']);
        
        /**
         * Shirt (torsoupper)
         **/
        $subtexture_data['shirt_tu'] = array(
            'prefix' => 'item/texturecomponents/torsouppertexture/',
            'file'   => $items->GetItemModelData(0, 'visual_3', $tmpid),
            'fileBackup' => $items->GetItemModelData(0, 'visual_3', $tmpid),
            'h' => 0.25,
            'w' => 0.5,
            'x' => 0.5,
            'y' => '0.0'
        );
        $subtexture_data['shirt_tu']['suffixFile'] = $items->GetModelSuffix($subtexture_data['shirt_tu']['prefix'] . $subtexture_data['shirt_tu']['file']);
        $subtexture_data['shirt_tu']['suffixFileBackup'] = $items->GetModelSuffix($subtexture_data['shirt_tu']['prefix'] . $subtexture_data['shirt_tu']['fileBackup']);
        
        /**
         * Shirt (torsolower)
         **/
        $subtexture_data['shirt_tl'] = array(
            'prefix' => 'item/texturecomponents/torsolowertexture/',
            'file'   => $items->GetItemModelData(0, 'visual_4', $tmpid),
            'fileBackup' => $items->GetItemModelData(0, 'visual_4', $tmpid),
            'h' => 0.125,
            'w' => 0.5,
            'x' => 0.5,
            'y' => 0.25
        );
        
        $subtexture_data['shirt_tl']['suffixFile'] = $items->GetModelSuffix($subtexture_data['shirt_tl']['prefix'] . $subtexture_data['shirt_tl']['file']);
        $subtexture_data['shirt_tl']['suffixFileBackup'] = $items->GetModelSuffix($subtexture_data['shirt_tl']['prefix'] . $subtexture_data['shirt_tl']['fileBackup']);
    }
    unset($tmpid);
}
if($tmpid = $characters->GetCharacterEquip('chest')) {
    if($items->GetItemModelData(0, 'visual_3', $tmpid)) {
        /**
         * Chest (armupper)
         **/
        $subtexture_data['chest_au'] = array(
            'prefix' => 'item/texturecomponents/armuppertexture/',
            'file'   => $items->GetItemModelData(0, 'texture_2', $tmpid),
            'fileBackup' => $items->GetItemModelData(0, 'texture_2', $tmpid),
            'h' => 0.25,
            'w' => 0.5,
            'x' => '0.0',
            'y' => '0.0'
        );
        $subtexture_data['chest_au']['suffixFile'] = $items->GetModelSuffix($subtexture_data['chest_au']['prefix'] . $subtexture_data['chest_au']['file']);
        $subtexture_data['chest_au']['suffixFileBackup'] = $items->GetModelSuffix($subtexture_data['chest_au']['prefix'] . $subtexture_data['chest_au']['fileBackup']);
        
        /**
         * Chest (armlower)
         **/
        $subtexture_data['chest_al'] = array(
            'prefix' => 'item/texturecomponents/armlowertexture/',
            'file'   => $items->GetItemModelData(0, 'visual_1', $tmpid),
            'fileBackup' => $items->GetItemModelData(0, 'visual_1', $tmpid),
            'h' => 0.25,
            'w' => 0.5,
            'x' => '0.0',
            'y' => 0.25
        );
        $subtexture_data['chest_al']['suffixFile'] = $items->GetModelSuffix($subtexture_data['chest_al']['prefix'] . $subtexture_data['chest_al']['file']);
        $subtexture_data['chest_al']['suffixFileBackup'] = $items->GetModelSuffix($subtexture_data['chest_al']['prefix'] . $subtexture_data['chest_al']['fileBackup']);
        
        /**
         * Chest (torsoupper)
         **/        
        $subtexture_data['chest_tu'] = array(
            'prefix' => 'item/texturecomponents/torsouppertexture/',
            'file'   => $items->GetItemModelData(0, 'visual_3', $tmpid),
            'fileBackup' => $items->GetItemModelData(0, 'visual_3', $tmpid),
            'h' => 0.25,
            'w' => 0.5,
            'x' => '0.5',
            'y' => '0.0'
        );
        $subtexture_data['chest_tu']['suffixFile'] = $items->GetModelSuffix($subtexture_data['chest_tu']['prefix'] . $subtexture_data['chest_tu']['file']);
        $subtexture_data['chest_tu']['suffixFileBackup'] = $items->GetModelSuffix($subtexture_data['chest_tu']['prefix'] . $subtexture_data['chest_tu']['fileBackup']);
        
        /**
         * Chest (torsolower)
         **/        
        $subtexture_data['chest_tl'] = array(
            'prefix' => 'item/texturecomponents/torsolowertexture/',
            'file'   => $items->GetItemModelData(0, 'visual_4', $tmpid),
            'fileBackup' => $items->GetItemModelData(0, 'visual_4', $tmpid),
            'h' => 0.125,
            'w' => 0.5,
            'x' => 0.5,
            'y' => 0.25
        );
        $subtexture_data['chest_tl']['suffixFile'] = $items->GetModelSuffix($subtexture_data['chest_tl']['prefix'] . $subtexture_data['chest_tl']['file']);
        $subtexture_data['chest_tl']['suffixFileBackup'] = $items->GetModelSuffix($subtexture_data['chest_tl']['prefix'] . $subtexture_data['chest_tl']['fileBackup']);
        
        /**
         * Chest (legupper)
         **/        
        $subtexture_data['chest_lu'] = array(
            'prefix' => 'item/texturecomponents/leguppertexture/',
            'file'   => $items->GetItemModelData(0, 'visual_5', $tmpid),
            'fileBackup' => $items->GetItemModelData(0, 'visual_5', $tmpid),
            'h' => 0.25,
            'w' => 0.5,
            'x' => 0.5,
            'y' => 0.375
        );
        $subtexture_data['chest_lu']['suffixFile'] = $items->GetModelSuffix($subtexture_data['chest_lu']['prefix'] . $subtexture_data['chest_lu']['file']);
        $subtexture_data['chest_lu']['suffixFileBackup'] = $items->GetModelSuffix($subtexture_data['chest_lu']['prefix'] . $subtexture_data['chest_lu']['fileBackup']);
        
        /**
         * Chest (leglower)
         **/
        $subtexture_data['chest_ll'] = array(
            'prefix' => 'item/texturecomponents/leglowertexture/',
            'file'   => $items->GetItemModelData(0, 'visual_6', $tmpid),
            'fileBackup' => $items->GetItemModelData(0, 'visual_6', $tmpid),
            'h' => 0.25,
            'w' => 0.5,
            'x' => 0.5,
            'y' => 0.625
        );
        $subtexture_data['chest_ll']['suffixFile'] = $items->GetModelSuffix($subtexture_data['chest_ll']['prefix'] . $subtexture_data['chest_ll']['file']);
        $subtexture_data['chest_ll']['suffixFileBackup'] = $items->GetModelSuffix($subtexture_data['chest_ll']['prefix'] . $subtexture_data['chest_ll']['fileBackup']);
    }
    unset($tmpid);
}
if($tmpid = $characters->GetCharacterEquip('wrist')) {
    if($items->GetItemModelData(0, 'visual_1', $tmpid)) {
        /**
         * Bracers (armlower)
         **/        
        $subtexture_data['bracers_al'] = array(
            'prefix' => 'item/texturecomponents/armlowertexture/',
            'file'   => $items->GetItemModelData(0, 'visual_1', $tmpid),
            'fileBackup' => $items->GetItemModelData(0, 'visual_1', $tmpid),
            'h' => 0.25,
            'w' => 0.5,
            'x' => '0.0',
            'y' => 0.25
        );
        $subtexture_data['bracers_al']['suffixFile'] = $items->GetModelSuffix($subtexture_data['bracers_al']['prefix'] . $subtexture_data['bracers_al']['file']);
        $subtexture_data['bracers_al']['suffixFileBackup'] = $items->GetModelSuffix($subtexture_data['bracers_al']['prefix'] . $subtexture_data['bracers_al']['fileBackup']);
    }
    unset($tmpid);
}
if($tmpid = $characters->GetCharacterEquip('gloves')) {
    if($items->GetItemModelData(0, 'visual_1', $tmpid)) {
        /**
         * Gloves (armlower)
         **/
        $subtexture_data['gloves_al'] = array(
            'prefix' => 'item/texturecomponents/armlowertexture/',
            'file'   => $items->GetItemModelData(0, 'visual_1', $tmpid),
            'fileBackup' => $items->GetItemModelData(0, 'visual_1', $tmpid),
            'h' => 0.25,
            'w' => 0.5,
            'x' => '0.0',
            'y' => 0.25
        );
        $subtexture_data['gloves_al']['suffixFile'] = $items->GetModelSuffix($subtexture_data['gloves_al']['prefix'] . $subtexture_data['gloves_al']['file']);
        $subtexture_data['gloves_al']['suffixFileBackup'] = $items->GetModelSuffix($subtexture_data['gloves_al']['prefix'] . $subtexture_data['gloves_al']['fileBackup']);
        
        /**
         * Hand (main)
         **/
        $subtexture_data['hand'] = array(
            'prefix' => 'item/texturecomponents/handtexture/',
            'file'   => $items->GetItemModelData(0, 'visual_2', $tmpid),
            'fileBackup' => $items->GetItemModelData(0, 'visual_2', $tmpid),
            'h' => 0.125,
            'w' => 0.5,
            'x' => '0.0',
            'y' => 0.5
        );
        $subtexture_data['hand']['suffixFile'] = $items->GetModelSuffix($subtexture_data['hand']['prefix'] . $subtexture_data['hand']['file']);
        $subtexture_data['hand']['suffixFileBackup'] = $items->GetModelSuffix($subtexture_data['hand']['prefix'] . $subtexture_data['hand']['fileBackup']);
    }
    unset($tmpid);
}
if($tmpid = $characters->GetCharacterEquip('tabard')) {
    if($items->GetItemModelData(0, 'visual_3', $tmpid)) {
        /**
         * Tabard (torsoupper)
         **/
        $subtexture_data['tabard_tu'] = array(
            'prefix' => 'item/texturecomponents/torsouppertexture/',
            'file'   => $items->GetItemModelData(0, 'visual_3', $tmpid),
            'fileBackup' => $items->GetItemModelData(0, 'visual_3', $tmpid),
            'h' => 0.25,
            'w' => 0.5,
            'x' => 0.5,
            'y' => '0.0'
        );
        $subtexture_data['tabard_tu']['suffixFile'] = $items->GetModelSuffix($subtexture_data['tabard_tu']['prefix'] . $subtexture_data['tabard_tu']['file']);
        $subtexture_data['tabard_tu']['suffixFileBackup'] = $items->GetModelSuffix($subtexture_data['tabard_tu']['prefix'] . $subtexture_data['tabard_tu']['fileBackup']);
        
        /**
         * Tabard (torsolower)
         **/        
        $subtexture_data['tabard_tl'] = array(
            'prefix' => 'item/texturecomponents/torsolowertexture/',
            'file'   => $items->GetItemModelData(0, 'visual_4', $tmpid),
            'fileBackup' => $items->GetItemModelData(0, 'visual_4', $tmpid),
            'h' => 0.125,
            'w' => 0.5,
            'x' => 0.5,
            'y' => 0.25
        );
        $subtexture_data['tabard_tl']['suffixFile'] = $items->GetModelSuffix($subtexture_data['tabard_tl']['prefix'] . $subtexture_data['tabard_tl']['file']);
        $subtexture_data['tabard_tl']['suffixFileBackup'] = $items->GetModelSuffix($subtexture_data['tabard_tl']['prefix'] . $subtexture_data['tabard_tl']['fileBackup']);
    }
    unset($tmpid);
}
if($tmpid = $characters->GetCharacterEquip('belt')) {
    if($items->GetItemModelData(0, 'visual_4', $tmpid)) {
        /**
         * Belt (torsolower)
         **/
        $subtexture_data['belt_tl'] = array(
            'prefix' => 'item/texturecomponents/torsolowertexture/',
            'file'   => $items->GetItemModelData(0, 'visual_4', $tmpid),
            'fileBackup' => $items->GetItemModelData(0, 'visual_4', $tmpid),
            'h' => 0.125,
            'w' => 0.5,
            'x' => 0.5,
            'y' => 0.25
        );
        $subtexture_data['belt_tl']['suffixFile'] = $items->GetModelSuffix($subtexture_data['belt_tl']['prefix'] . $subtexture_data['belt_tl']['file']);
        $subtexture_data['belt_tl']['suffixFileBackup'] = $items->GetModelSuffix($subtexture_data['belt_tl']['prefix'] . $subtexture_data['belt_tl']['fileBackup']);
        
        /**
         * Belt (legupper)
         **/
        $subtexture_data['belt_lu'] = array(
            'prefix' => 'item/texturecomponents/leguppertexture/',
            'file'   => $items->GetItemModelData(0, 'visual_5', $tmpid),
            'fileBackup' => $items->GetItemModelData(0, 'visual_5', $tmpid),
            'h' => 0.25,
            'w' => 0.5,
            'x' => 0.5,
            'y' => 0.375
        );
        $subtexture_data['belt_lu']['suffixFile'] = $items->GetModelSuffix($subtexture_data['belt_lu']['prefix'] . $subtexture_data['belt_lu']['file']);
        $subtexture_data['belt_lu']['suffixFileBackup'] = $items->GetModelSuffix($subtexture_data['belt_lu']['prefix'] . $subtexture_data['belt_lu']['fileBackup']);
    }
    unset($tmpid);
}
if($tmpid = $characters->GetCharacterEquip('legs')) {
    if($items->GetItemModelData(0, 'visual_5', $tmpid) && (!isset($subtexture_data['chest_lu']) || !isset($subtexture_data['chest_lu']['file']) || $subtexture_data['chest_lu']['file'] === false || $subtexture_data['chest_lu']['file'] === null) ) {
        /**
         * Leg (legupper)
         **/
        $subtexture_data['leg_lu'] = array(
            'prefix' => 'item/texturecomponents/leguppertexture/',
            'file'   => $items->GetItemModelData(0, 'visual_5', $tmpid),
            'fileBackup' => $items->GetItemModelData(0, 'visual_5', $tmpid),
            'h' => 0.25,
            'w' => 0.5,
            'x' => 0.5,
            'y' => 0.375
        );
        $subtexture_data['leg_lu']['suffixFile'] = $items->GetModelSuffix($subtexture_data['leg_lu']['prefix'] . $subtexture_data['leg_lu']['file']);
        $subtexture_data['leg_lu']['suffixFileBackup'] = $items->GetModelSuffix($subtexture_data['leg_lu']['prefix'] . $subtexture_data['leg_lu']['fileBackup']);
        
        /**
         * Leg (leglower)
         **/
        $subtexture_data['leg_ll'] = array(
            'prefix' => 'item/texturecomponents/leglowertexture/',
            'file'   => $items->GetItemModelData(0, 'visual_6', $tmpid),
            'fileBackup' => $items->GetItemModelData(0, 'visual_6', $tmpid),
            'h' => 0.25,
            'w' => 0.5,
            'x' => 0.5,
            'y' => 0.625
        );
        $subtexture_data['leg_ll']['suffixFile'] = $items->GetModelSuffix($subtexture_data['leg_ll']['prefix'] . $subtexture_data['leg_ll']['file']);
        $subtexture_data['leg_ll']['suffixFileBackup'] = $items->GetModelSuffix($subtexture_data['leg_ll']['prefix'] . $subtexture_data['leg_ll']['fileBackup']);
    }
    unset($tmpid);
}
if($tmpid = $characters->GetCharacterEquip('boots')) {
    if($items->GetItemModelData(0, 'visual_7', $tmpid)) {
        /**
         * Boot (leglower)
         **/
        $subtexture_data['boot_ll'] = array(
            'prefix' => 'item/texturecomponents/leglowertexture/',
            'file'   => $items->GetItemModelData(0, 'visual_6', $tmpid),
            'fileBackup' => $items->GetItemModelData(0, 'visual_6', $tmpid),
            'h' => 0.25,
            'w' => 0.5,
            'x' => 0.5,
            'y' => 0.625
        );
        $subtexture_data['boot_ll']['suffixFile'] = $items->GetModelSuffix($subtexture_data['boot_ll']['prefix'] . $subtexture_data['boot_ll']['file']);
        $subtexture_data['boot_ll']['suffixFileBackup'] = $items->GetModelSuffix($subtexture_data['boot_ll']['prefix'] . $subtexture_data['boot_ll']['fileBackup']);
        
        /**
         * Boot (foot)
         **/
        $subtexture_data['boot_fo'] = array(
            'prefix' => 'item/texturecomponents/foottexture/',
            'file'   => $items->GetItemModelData(0, 'visual_7', $tmpid),
            'fileBackup' => $items->GetItemModelData(0, 'visual_7', $tmpid),
            'h' => 0.125,
            'w' => 0.5,
            'x' => 0.5,
            'y' => 0.875
        );
        $subtexture_data['boot_fo']['suffixFile'] = $items->GetModelSuffix($subtexture_data['boot_fo']['prefix'] . $subtexture_data['boot_fo']['file']);
        $subtexture_data['boot_fo']['suffixFileBackup'] = $items->GetModelSuffix($subtexture_data['boot_fo']['prefix'] . $subtexture_data['boot_fo']['fileBackup']);
    }
    unset($tmpid);
}

/** ATTACHMENT TEXTURES **/

if($tmpid = $characters->GetCharacterEquip('head') && $character_model_data['hide_helm'] == 0) {
    if($items->GetItemModelData(0, 'modelName_1', $tmpid)) {
        /**
         * Helm (texture)
         **/
        $model_data_attachment['helm_texture'] = array(
            'linkPoint' => 11,
            'type' => 'none',
            'modelFile' => 'item/objectcomponents/head/'.$items->GetItemModelData(0, 'modelName_1', $tmpid).'_'.$character_model_data['race_gender'].'.m2',
            'skinFile' => 'item/objectcomponents/head/'.$items->GetItemModelData(0, 'modelName_1', $tmpid).'_'.$character_model_data['race_gender'].'00.skin',
            'texture' => 'item/objectcomponents/head/'.$items->GetItemModelData(0, 'modelTexture_1', $tmpid).'.png',
        );
        if($model_data_attachment['helm_texture']['texture'] == 'item/objectcomponents/head/.png') {
            //unset($model_data_attachment['helm_texture']);
        }
    }
    unset($tmpid);
}
if($tmpid = $characters->GetCharacterEquip('back')) {
    if($items->GetItemModelData(0, 'modelTexture_1', $tmpid)) {
        /**
         * Back (texture)
         **/
        $model_data_texture['back_texture'] = array(
            'file' => 'item/objectcomponents/cape/'.$items->GetItemModelData(0, 'modelTexture_1', $tmpid).'.png'
        );
        if($model_data_texture['back_texture']['file'] == 'item/objectcomponents/cape/.png') {
            unset($model_data_texture['back_texture']);
        }
    }
    unset($tmpid);
}
if($tmpid = $characters->GetCharacterEquip('shoulder')) {
    /**
     * Shoulders (texture)
     **/
    if($items->GetItemModelData(0, 'modelName_1', $tmpid)) {
        $model_data_attachment['left_shoulder_texture'] = array(
            'linkPoint' => 6,
            'type' => 'none',
            'modelFile' => 'item/objectcomponents/shoulder/'.$items->GetItemModelData(0, 'modelName_1', $tmpid).'.m2',
            'skinFile' => 'item/objectcomponents/shoulder/'.$items->GetItemModelData(0, 'modelName_1', $tmpid).'00.skin',   // What does 00 means?
            'texture' => 'item/objectcomponents/shoulder/'.$items->GetItemModelData(0, 'modelTexture_1', $tmpid).'.png',
        );
        $model_data_attachment['right_shoulder_texture'] = array(
            'linkPoint' => 5,
            'type' => 'none',
            'modelFile' => 'item/objectcomponents/shoulder/'.$items->GetItemModelData(0, 'modelName_2', $tmpid).'.m2',
            'skinFile' => 'item/objectcomponents/shoulder/'.$items->GetItemModelData(0, 'modelName_2', $tmpid).'00.skin',   // What does 00 means?
            'texture' => 'item/objectcomponents/shoulder/'.$items->GetItemModelData(0, 'modelTexture_2', $tmpid).'.png',
        );
        if($model_data_attachment['left_shoulder_texture']['texture'] == 'item/objectcomponents/shoulder/.png') {
            unset($model_data_attachment['left_shoulder_texture']);
            unset($model_data_attachment['right_shoulder_texture']);
        }
    }
    unset($tmpid);
}
if($tmpid = $characters->GetCharacterEquip('mainhand')) {
    if($items->GetItemModelData(0, 'modelName_1', $tmpid)) {
        /**
         * Main hand (texture)
         **/
        $model_data_attachment['main_hand_texture'] = array(
            'linkPoint' => 1,
            'type' => 'none',
            'modelFile' => 'item/objectcomponents/weapon/'.$items->GetItemModelData(0, 'modelName_1', $tmpid).'.m2',
            'skinFile' => 'item/objectcomponents/weapon/'.$items->GetItemModelData(0, 'modelName_1', $tmpid).'00.skin',   // What does 00 means?
            'texture' => 'item/objectcomponents/weapon/'.$items->GetItemModelData(0, 'modelTexture_1', $tmpid).'.png',
        );
        if($model_data_attachment['main_hand_texture']['texture'] == 'item/objectcomponents/weapon/.png') {
            unset($model_data_attachment['main_hand_texture']);
        }
    }
    unset($tmpid);
}
/**
 * Off hand (texture)
 **/
if($characters->GetClass() == CLASS_PALADIN || $characters->GetClass() == CLASS_WARRIOR || $characters->GetClass() == CLASS_SHAMAN) {
    if($tmpid = $characters->GetCharacterEquip('offhand')) {
        $model_data_attachment['off_hand_texture'] = array(
            'linkPoint' => 0,
            'type' => 'melee',
            'modelFile' => 'item/objectcomponents/shield/'.$items->GetItemModelData(0, 'modelName_1', $tmpid).'.m2',
            'skinFile' => 'item/objectcomponents/shield/'.$items->GetItemModelData(0, 'modelName_1', $tmpid).'00.skin',   // What does 00 means?
            'texture' => 'item/objectcomponents/shield/'.$items->GetItemModelData(0, 'modelTexture_1', $tmpid).'.png',
        );
        if($model_data_attachment['off_hand_texture']['texture'] == 'item/objectcomponents/shield/.png') {
            unset($model_data_attachment['off_hand_texture']);
            $model_data['use_shield'] = false;
        }
        else {
            $model_data['use_shield'] = true;
        }
    }
    unset($tmpid);
}
else {
    if($tmpid = $characters->GetCharacterEquip('offhand')) {
        $model_data_attachment['off_hand_texture'] = array(
            'linkPoint' => 1,
            'type' => 'ranged',
            'modelFile' => 'item/objectcomponents/weapon/'.$items->GetItemModelData(0, 'modelName_1', $tmpid).'.m2',
            'skinFile'  => 'item/objectcomponents/weapon/'.$items->GetItemModelData(0, 'modelName_1', $tmpid).'00.skin',   // What does 00 means?
            'texture'   => 'item/objectcomponents/weapon/'.$items->GetItemModelData(0, 'modelTexture_1', $tmpid).'.png',
        );
        if($model_data_attachment['off_hand_texture']['texture'] == 'item/objectcomponents/weapon/.png') {
            unset($model_data_attachment['off_hand_texture']);
        }
    }
    unset($tmpid);
}
$xml->XMLWriter()->startElement('textures');
$xml->XMLWriter()->startElement('texture');
$xml->XMLWriter()->writeAttribute('file', sprintf('character/%s/%s/%s%sskin00_%s.png', $character_model_data['race'], $character_model_data['gender'], $character_model_data['race'], $character_model_data['gender'], $character_model_data['skin_style']));
$xml->XMLWriter()->writeAttribute('id', 1);
foreach($subtexture_data as $model) {
    if(is_array($model) && !empty($model['file']) && !empty($model['fileBackup'])) {
        $xml->XMLWriter()->startElement('subTexture');    
        $xml->XMLWriter()->writeAttribute('file', sprintf('%s%s%s', $model['prefix'], $model['file'], $model['suffixFile']));
        $xml->XMLWriter()->writeAttribute('fileBackup', sprintf('%s%s%s', $model['prefix'], $model['fileBackup'], $model['suffixFileBackup']));
        $xml->XMLWriter()->writeAttribute('h', $model['h']);
        $xml->XMLWriter()->writeAttribute('w', $model['w']);
        $xml->XMLWriter()->writeAttribute('x', $model['x']);
        $xml->XMLWriter()->writeAttribute('y', $model['y']);
        $xml->XMLWriter()->endElement(); //subTexture
    }
}
$xml->XMLWriter()->endElement(); //texture
if(strlen($character_model_data['hair_color']) == 1) {
    $character_model_data['hair_color'] = '0'.$character_model_data['hair_color'];
}
$xml->XMLWriter()->startElement('texture');
$xml->XMLWriter()->writeAttribute('file', 'character/'.$character_model_data['race'].'/hair00_'.$character_model_data['hair_color'].'.png');
$xml->XMLWriter()->writeAttribute('id', 6);
$xml->XMLWriter()->endElement(); //texture
if($character_model_data['hide_cloak'] == 0 && isset($model_data_texture['back_texture'])) {
    $xml->XMLWriter()->startElement('texture');
    $xml->XMLWriter()->writeAttribute('file', $model_data_texture['back_texture']['file']);
    $xml->XMLWriter()->writeAttribute('id', 2);
    $xml->XMLWriter()->endElement(); //texture
}
$xml->XMLWriter()->endElement(); //textures
if(isset($model_data_attachment) && is_array($model_data_attachment)) {
    $xml->XMLWriter()->startElement('attachments');
    foreach($model_data_attachment as $attachment) {
        $xml->XMLWriter()->startElement('attachment');
        foreach($attachment as $attachment_key => $attachment_value) {
            $xml->XMLWriter()->writeAttribute($attachment_key, $attachment_value);
        }
        $xml->XMLWriter()->endElement(); //attachment
    }
    $xml->XMLWriter()->endElement(); //attachments
}
$animation_data = array(
    array('id' => 0,    'key' => 'stand',              'weapons' => 'melee'),
    array('id' => 69,   'key' => 'dance',              'weapons' => 'no'),
    array('id' => 70,   'key' => 'laugh',              'weapons' => 'no'),
    array('id' => 82,   'key' => 'flex',               'weapons' => 'no'),
    array('id' => 78,   'key' => 'chicken',            'weapons' => 'no'),
    array('id' => 120,  'key' => 'crouch',             'weapons' => 'no'),
    array('id' => 60,   'key' => 'talk',               'weapons' => 'no'),
    array('id' => 67,   'key' => 'wave',               'weapons' => 'no'),
    array('id' => 73,   'key' => 'rude',               'weapons' => 'no'),
    array('id' => 76,   'key' => 'kiss',               'weapons' => 'no'),
    array('id' => 77,   'key' => 'cry',                'weapons' => 'no'),
    array('id' => 84,   'key' => 'point',              'weapons' => 'no'),
    array('id' => 113,  'key' => 'salute',             'weapons' => 'melee'),
    array('id' => 185,  'key' => 'yes',                'weapons' => 'no'),
    array('id' => 186,  'key' => 'no',                 'weapons' => 'no'),
    array('id' => 195,  'key' => 'train',              'weapons' => 'no'),
    array('id' => 51,   'key' => 'readyspelldirected', 'weapons' => 'no'),
    array('id' => 52,   'key' => 'readyspellomni',     'weapons' => 'no'),
    array('id' => 53,   'key' => 'castdirected',       'weapons' => 'no'),
    array('id' => 54,   'key' => 'castomni',           'weapons' => 'no'),
    array('id' => 108,  'key' => 'readythrown',        'weapons' => 'no'),
    array('id' => 107,  'key' => 'attackthrown',       'weapons' => 'no')
);
$xml->XMLWriter()->startElement('animations');
foreach($animation_data as $anim) {
    $xml->XMLWriter()->startElement('animation');
    foreach($anim as $anim_key => $anim_value) {
        $xml->XMLWriter()->writeAttribute($anim_key, $anim_value);
    }
    $xml->XMLWriter()->endElement(); //animation
}
$xml->XMLWriter()->endElement();   //animations
$xml->XMLWriter()->endElement();  //character
$xml->XMLWriter()->endElement(); //page
$xml_cache_data = $xml->StopXML();
echo $xml_cache_data;
if($armory->armoryconfig['useCache'] == true && !isset($_GET['skipCache'])) {
    // Write cache to file
    $cache_data = $utils->GenerateCacheData($characters->GetName(), $characters->GetGUID(), 'character-model');
    $cache_handler = $utils->WriteCache($cache_id, $cache_data, $xml_cache_data);
}
exit;
?>