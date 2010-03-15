<?php

/**
 * @package World of Warcraft Armory
 * @version Release Candidate 1
 * @revision 120
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

define('load_characters_class', true);
define('load_items_class', true);
define('__ARMORY__', true);
if(!@include('includes/armory_loader.php')) {
    die('<b>Fatal error:</b> can not load main system files!');
}
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
if(isset($_GET['n'])) {
    $charname = $_GET['n'];
}
elseif(isset($_GET['cn'])) {
    $charname = $_GET['cn'];
}
else {
    $charname = false;
}
$characters->name = Utils::escape($charname);
// Check
if(!$characters->IsCharacter()) {
    $armory->ArmoryError(false, false, true);
}
// All ok, generate basic character info
header('Content-type: text/xml');   // We need to output data in XML format
$characters->_structCharacter();
$items->charGuid = $characters->guid;
$character_model_data['race'] = $armory->aDB->selectCell("SELECT `modeldata_1` FROM `armory_races` WHERE `id`=?", $characters->race);
if($characters->gender == 1) {
    $character_model_data['gender'] = 'female';
    $character_model_data['gender_1'] = 'f';
}
else {
    $character_model_data['gender'] = 'male';
    $character_model_data['gender_1'] = 'm';
}
$character_model_data['race_gender'] = $armory->aDB->selectCell("SELECT `modeldata_2` FROM `armory_races` WHERE `id`=?", $characters->race).$character_model_data['gender_1'];

$player_model = $armory->cDB->selectRow("SELECT `playerBytes`, `playerBytes2`, `playerFlags` FROM `characters` WHERE `guid`=?", $characters->guid);
$character_model_data['face_color'] = ($player_model['playerBytes']>>8)%256;
$character_model_data['hair_style'] = ($player_model['playerBytes']>>16)%256;
$character_model_data['hair_color'] = ($player_model['playerBytes']>>24)%256;
$character_model_data['skin_style'] = $player_model['playerBytes']%256;
$character_model_data['facial_hair'] = $player_model['playerBytes2']%256;
$character_model_data['hide_helm'] = 0;
$character_model_data['hide_cloak'] = 0;
if($player_model['playerFlags']&0x00000400) {
    $character_model_data['hide_helm'] = 1;
}
if($player_model['playerFlags']&0x00000800) {
    $character_model_data['hide_cloak'] = 1;
}
if(count($character_model_data['hair_color']) == 1) {
    $character_model_data['hair_color'] = '0'.$character_model_data['hair_color'];
}
if(count($character_model_data['skin_style']) == 1) {
    $character_model_data['skin_style'] = '0'.$character_model_data['skin_style'];
}
$character_model_data['class'] = $characters->class;

/**
 *  Construct our XML config file
 **/

/** MAIN TEXTURES **/
$tmpid = 0;
if($tmpid = $characters->GetCharacterEquip('shirt')) {
    if($items->GetItemModelData(0, 'texture_2', $tmpid)) {
        /**
         * Shirt (armupper)
         **/
        $model_data['shirt_au'] = array(
            'file' => 'item/texturecomponents/armuppertexture/'.$items->GetItemModelData(0, 'texture_2', $tmpid).'_u.png',
            'fileBackup' => 'item/texturecomponents/armuppertexture/'.$items->GetItemModelData(0, 'texture_2', $tmpid).'_m.png',
        );
        /**
         * Shirt (armlower)
         **/
        $model_data['shirt_al'] = array(
            'file' => 'item/texturecomponents/armlowertexture/'.$items->GetItemModelData(0, 'visual_1', $tmpid).'_u.png',
            'fileBackup' => 'item/texturecomponents/armlowertexture/'.$items->GetItemModelData(0, 'visual_1', $tmpid).'_m.png',
        );
        /**
         * Shirt (torsoupper)
         **/
        $model_data['shirt_tu'] = array(
            'file' => 'item/texturecomponents/torsouppertexture/'.$items->GetItemModelData(0, 'visual_3', $tmpid).'_u.png',
            'fileBackup' => 'item/texturecomponents/torsouppertexture/'.$items->GetItemModelData(0, 'visual_3', $tmpid).'_m.png',
        );
        /**
         * Shirt (torsolower)
         **/
        $model_data['shirt_tl'] = array(
            'file' => 'item/texturecomponents/torsolowertexture/'.$items->GetItemModelData(0, 'visual_4', $tmpid).'_u.png',
            'fileBackup' => 'item/texturecomponents/torsolowertexture/'.$items->GetItemModelData(0, 'visual_4', $tmpid).'_m.png',
        );
    }
    unset($tmpid);
}
if($tmpid = $characters->GetCharacterEquip('chest')) {
    if($items->GetItemModelData(0, 'visual_3', $tmpid)) {
        /**
         * Chest (armupper)
         **/
         $model_data['chest_au'] = array(
            'file' => 'item/texturecomponents/armuppertexture/'.$items->GetItemModelData(0, 'texture_2', $tmpid).'_u.png',
            'fileBackup' => 'item/texturecomponents/armuppertexture/'.$items->GetItemModelData(0, 'texture_2', $tmpid).'_m.png',
        );
        /**
         * Chest (torsoupper)
         **/
        $model_data['chest_tu'] = array(
            'file' => 'item/texturecomponents/torsouppertexture/'.$items->GetItemModelData(0, 'visual_3', $tmpid).'_u.png',
            'fileBackup' => 'item/texturecomponents/torsouppertexture/'.$items->GetItemModelData(0, 'visual_3', $tmpid).'_m.png',
        );
        /**
         * Chest (torsolower)
         **/
        $model_data['chest_tl'] = array(
            'file' => 'item/texturecomponents/torsolowertexture/'.$items->GetItemModelData(0, 'visual_4', $tmpid).'_u.png',
            'fileBackup' => 'item/texturecomponents/torsolowertexture/'.$items->GetItemModelData(0, 'visual_4', $tmpid).'_m.png',
        );
        /**
         * Chest (legupper)
         **/
        $model_data['chest_lu'] = array(
            'file' => 'item/texturecomponents/leguppertexture/'.$items->GetItemModelData(0, 'visual_5', $tmpid).'_u.png',
            'fileBackup' => 'item/texturecomponents/leguppertexture/'.$items->GetItemModelData(0, 'visual_5', $tmpid).'_m.png',
        );
        /**
         * Chest (leglower)
         **/
        $model_data['chest_ll'] = array(
            'file' => 'item/texturecomponents/leglowertexture/'.$items->GetItemModelData(0, 'visual_6', $tmpid).'_u.png',
            'fileBackup' => 'item/texturecomponents/leglowertexture/'.$items->GetItemModelData(0, 'visual_6', $tmpid).'_m.png',
        );
    }
    unset($tmpid);
}
if($tmpid = $characters->GetCharacterEquip('wrist')) {
    if($items->GetItemModelData(0, 'visual_1', $tmpid)) {
        /**
         * Bracers (armlower)
         **/
        $model_data['bracers_al'] = array(
            'file' => 'item/texturecomponents/armlowertexture/'.$items->GetItemModelData(0, 'visual_1', $tmpid).'_u.png',
            'fileBackup' => 'item/texturecomponents/armlowertexture/'.$items->GetItemModelData(0, 'visual_1', $tmpid).'_m.png',
        );
    }
    unset($tmpid);
}
if($tmpid = $characters->GetCharacterEquip('gloves')) {
    if($items->GetItemModelData(0, 'visual_1', $tmpid)) {
        /**
         * Gloves (armlower)
         **/
        $model_data['gloves_al'] = array(
            'file' => 'item/texturecomponents/armlowertexture/'.$items->GetItemModelData(0, 'visual_1', $tmpid).'_u.png',
            'fileBackup' => 'item/texturecomponents/armlowertexture/'.$items->GetItemModelData(0, 'visual_1', $tmpid).'_m.png',
        );
        /**
         * Hand (main)
         **/
        $model_data['hand'] = array(
            'file' => 'item/texturecomponents/handtexture/'.$items->GetItemModelData(0, 'visual_2', $tmpid).'_u.png',
            'fileBackup' => 'item/texturecomponents/handtexture/'.$items->GetItemModelData(0, 'visual_2', $tmpid).'_m.png',
        );
    }
    unset($tmpid);
}
if($tmpid = $characters->GetCharacterEquip('tabard')) {
    if($items->GetItemModelData(0, 'visual_3', $tmpid)) {
        /**
         * Tabard (torsoupper)
         **/
        $model_data['tabard_tu'] = array(
            'file' => 'item/texturecomponents/torsouppertexture/'.$items->GetItemModelData(0, 'visual_3', $tmpid).'_u.png',
            'fileBackup' => 'item/texturecomponents/torsouppertexture/'.$items->GetItemModelData(0, 'visual_3', $tmpid).'_m.png',
        );    
        /**
         * Tabard (torsolower)
         **/
        $model_data['tabard_tl'] = array(
            'file' => 'item/texturecomponents/torsolowertexture/'.$items->GetItemModelData(0, 'visual_4', $tmpid).'_u.png',
            'fileBackup' => 'item/texturecomponents/torsolowertexture/'.$items->GetItemModelData(0, 'visual_4', $tmpid).'_m.png',
        );
    }
    unset($tmpid);
}
if($tmpid = $characters->GetCharacterEquip('belt')) {
    if($items->GetItemModelData(0, 'visual_4', $tmpid)) {
        /**
         * Belt (torsolower)
         **/
        $model_data['belt_tl'] = array(
            'file' => 'item/texturecomponents/torsolowertexture/'.$items->GetItemModelData(0, 'visual_4', $tmpid).'_u.png',
            'fileBackup' => 'item/texturecomponents/torsolowertexture/'.$items->GetItemModelData(0, 'visual_4', $tmpid).'_m.png',
        );
        /**
         * Belt (legupper)
         **/
        $model_data['belt_lu'] = array(
            'file' => 'item/texturecomponents/leguppertexture/'.$items->GetItemModelData(0, 'visual_5', $tmpid).'_u.png',
            'fileBackup' => 'item/texturecomponents/leguppertexture/'.$items->GetItemModelData(0, 'visual_5', $tmpid).'_m.png',
        );
    }
    unset($tmpid);
}
if($tmpid = $characters->GetCharacterEquip('legs')) {
    if($items->GetItemModelData(0, 'visual_5', $tmpid)) {
        /**
         * Leg (legupper)
         **/
        $model_data['leg_lu'] = array(
            'file' => 'item/texturecomponents/leguppertexture/'.$items->GetItemModelData(0, 'visual_5', $tmpid).'_u.png',
            'fileBackup' => 'item/texturecomponents/leguppertexture/'.$items->GetItemModelData(0, 'visual_5', $tmpid).'_m.png',
        );
        /**
         * Leg (leglower)
         **/
        $model_data['leg_ll'] = array(
            'file' => 'item/texturecomponents/leglowertexture/'.$items->GetItemModelData(0, 'visual_6', $tmpid).'_u.png',
            'fileBackup' => 'item/texturecomponents/leglowertexture/'.$items->GetItemModelData(0, 'visual_6', $tmpid).'_m.png',
        );
    }
    unset($tmpid);
}
if($tmpid = $characters->GetCharacterEquip('boots')) {
    if($items->GetItemModelData(0, 'visual_7', $tmpid)) {
        /**
         * Boot (leglower)
         **/
        $model_data['boot_ll'] = array(
            'file' => 'item/texturecomponents/leglowertexture/'.$items->GetItemModelData(0, 'visual_6', $tmpid).'_u.png',
            'fileBackup' => 'item/texturecomponents/leglowertexture/'.$items->GetItemModelData(0, 'visual_6', $tmpid).'_m.png',
        );
        
        /**
         * Boot (foot)
         **/
        $model_data['boot_fo'] = array(
            'file' => 'item/texturecomponents/foottexture/'.$items->GetItemModelData(0, 'visual_7', $tmpid).'_u.png',
            'fileBackup' => 'item/texturecomponents/foottexture/'.$items->GetItemModelData(0, 'visual_7', $tmpid).'_m.png',
        );
    }
    unset($tmpid);
}

/** ATTACHMENT TEXTURES **/

if($tmpid = $characters->GetCharacterEquip('head')) {
    if($items->GetItemModelData(0, 'modelName_1', $tmpid)) {
        /**
         * Helm (texture)
         **/
        $model_data['helm_texture'] = array(
            'modelFile' => 'item/objectcomponents/head/'.$items->GetItemModelData(0, 'modelName_1', $tmpid).'_'.$character_model_data['race_gender'].'.m2',
            'skinFile' => 'item/objectcomponents/head/'.$items->GetItemModelData(0, 'modelName_1', $tmpid).'_'.$character_model_data['race_gender'].'00.skin',
            'texture' => 'item/objectcomponents/head/'.$items->GetItemModelData(0, 'modelTexture_1', $tmpid).'.png',
        );
    }
    unset($tmpid);
}
if($tmpid = $characters->GetCharacterEquip('back')) {
    if($items->GetItemModelData(0, 'modelTexture_1', $tmpid)) {
        /**
         * Back (texture)
         **/
        $model_data['back_texture'] = array(
            'file' => 'item/objectcomponents/cape/'.$items->GetItemModelData(0, 'modelTexture_1', $tmpid).'.png'
        );
    }
    unset($tmpid);
}
if($tmpid = $characters->GetCharacterEquip('shoulder')) {
    /**
     * Shoulders (texture)
     **/
    if($items->GetItemModelData(0, 'modelName_1', $tmpid)) {
        $model_data['left_shoulder_texture'] = array(
            'modelFile' => 'item/objectcomponents/shoulder/'.$items->GetItemModelData(0, 'modelName_1', $tmpid).'.m2',
            'skinFile' => 'item/objectcomponents/shoulder/'.$items->GetItemModelData(0, 'modelName_1', $tmpid).'00.skin',   // What does 00 means?
            'texture' => 'item/objectcomponents/shoulder/'.$items->GetItemModelData(0, 'modelTexture_1', $tmpid).'.png',
        );
        $model_data['right_shoulder_texture'] = array(
            'modelFile' => 'item/objectcomponents/shoulder/'.$items->GetItemModelData(0, 'modelName_2', $tmpid).'.m2',
            'skinFile' => 'item/objectcomponents/shoulder/'.$items->GetItemModelData(0, 'modelName_2', $tmpid).'00.skin',   // What does 00 means?
            'texture' => 'item/objectcomponents/shoulder/'.$items->GetItemModelData(0, 'modelTexture_2', $tmpid).'.png',
        );
    }
    unset($tmpid);
}
if($tmpid = $characters->GetCharacterEquip('mainhand')) {
    if($items->GetItemModelData(0, 'modelName_1', $tmpid)) {
        /**
         * Main hand (texture)
         **/
        $model_data['main_hand_texture'] = array(
            'modelFile' => 'item/objectcomponents/weapon/'.$items->GetItemModelData(0, 'modelName_1', $tmpid).'.m2',
            'skinFile' => 'item/objectcomponents/weapon/'.$items->GetItemModelData(0, 'modelName_1', $tmpid).'00.skin',   // What does 00 means?
            'texture' => 'item/objectcomponents/weapon/'.$items->GetItemModelData(0, 'modelTexture_1', $tmpid).'.png',
        );
    }
    unset($tmpid);
}
/**
 * Off hand (texture)
 **/
if($characters->class == CLASS_PALADIN || $characters->class == CLASS_WARRIOR || $characters->class == CLASS_SHAMAN) {
    if($tmpid = $characters->GetCharacterEquip('offhand')) {
        $model_data['off_hand_texture'] = array(
            'modelFile' => 'item/objectcomponents/shield/'.$items->GetItemModelData(0, 'modelName_1', $tmpid).'.m2',
            'skinFile' => 'item/objectcomponents/shield/'.$items->GetItemModelData(0, 'modelName_1', $tmpid).'00.skin',   // What does 00 means?
            'texture' => 'item/objectcomponents/shield/'.$items->GetItemModelData(0, 'modelTexture_1', $tmpid).'.png',
        );
        $model_data['use_shield'] = true;
    }
    unset($tmpid);
}
else {
    if($tmpid = $characters->GetCharacterEquip('offhand')) {
        $model_data['off_hand_texture'] = array(
            'modelFile' => 'item/objectcomponents/weapon/'.$items->GetItemModelData(0, 'modelName_1', $tmpid).'.m2',
            'skinFile'  => 'item/objectcomponents/weapon/'.$items->GetItemModelData(0, 'modelName_1', $tmpid).'00.skin',   // What does 00 means?
            'texture'   => 'item/objectcomponents/weapon/'.$items->GetItemModelData(0, 'modelTexture_1', $tmpid).'.png',
        );
    }
    unset($tmpid);
}
if($tmpid = $characters->GetCharacterEquip('relic')) {
    if($items->GetItemModelData(0, 'modelName_1', $tmpid)) {
        /**
         * Relic/ranged (texture)
         **/
        $model_data['relic_ranged_texture'] = array(
            'modelFile' => 'item/objectcomponents/weapon/'.$items->GetItemModelData(0, 'modelName_1', $tmpid).'.m2',
            'skinFile' => 'item/objectcomponents/weapon/'.$items->GetItemModelData(0, 'modelName_1', $tmpid).'00.skin',   // What does 00 means?
            'texture' => 'item/objectcomponents/weapon/'.$items->GetItemModelData(0, 'modelTexture_1', $tmpid).'.png',
        );
    }
    unset($tmpid);
}
$armory->tpl->assign('character_model_data', $character_model_data);
$armory->tpl->assign('model_data', $model_data);
$armory->tpl->assign('realm', $armory->armoryconfig['defaultRealmName']);
$armory->tpl->assign('name', $characters->name);
$armory->tpl->assign('urlName', 'r='.urlencode($armory->armoryconfig['defaultRealmName']).'&amp;cn='.urlencode($characters->name));
$armory->tpl->display('character_model.tpl');
exit();
?>