<?php

/**
 * @package World of Warcraft Armory
 * @version Release Candidate 1
 * @revision 64
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
define('load_items_class', true);
define('load_mangos_class', true);

if(!@include('includes/armory_loader.php')) {
    die('<b>Fatal error:</b> can not load main system files!');
}
$itemID = (int) $_GET['i'];

// Check
if($itemID == 0 || !isset($itemID) || !$armory->wDB->selectCell("SELECT `name` FROM `item_template` WHERE `entry`=?", $itemID)) {
    $armory->ArmoryError($armory->tpl->get_config_vars('armory_error_item_not_exists_title'), $armory->tpl->get_config_vars('armory_error_item_not_exists_text'));
}

$quality_colors = array (
	0 => 'myGray',
 	1 => 'myWhite',
 	2 => 'myGreen',
 	3 => 'myBlue',
	4 => 'myPurple',
 	5 => 'myOrange',
 	6 => 'myGold',
    7 => 'myGold'
);
// TODO: remove * from query
$data = $armory->wDB->selectRow("SELECT * FROM `item_template` WHERE `entry`=? LIMIT 1", $itemID);
$data['name'] = $items->getItemName($itemID);
if(isset($_GET['data'])) {
    die('DisplayID: '.$data['displayid']);
}
// `Quality`, `bonding`, `subclass`, `InventoryType` 
$armory->tpl->assign('quality_color', $quality_colors[$data['Quality']]);
$armory->tpl->assign('item_name', $data['name']);
$armory->tpl->assign('bonding', $armory->tpl->get_config_vars('bonding_' . $data['bonding']));

// Spell Locale
if($_locale == 'en_gb') {
    $_spell_locale = '_1';
}
else {
    $_spell_locale = false;
}
// Item stats & green bonuses
$o = '';
$j = '';
for($i=1; $i<11; $i++) {
    if($data['stat_type'.$i]>0 && $data['stat_value'.$i]>0) {
        switch($data['stat_type' . $i]) {
            case 3:
                $o .= '<span class="">+' . $data['stat_value' . $i] . '&nbsp;</span><span class="">' . $armory->tpl->get_config_vars('bonus_name_3') . '</span><br>';
                break;
            case 4:
                $o .= '<span class="">+' . $data['stat_value' . $i] . '&nbsp;</span><span class="">' . $armory->tpl->get_config_vars('bonus_name_4') . '</span><br>';
                break;
            case 5:
                $o .= '<span class="">+' . $data['stat_value' . $i] . '&nbsp;</span><span class="">' . $armory->tpl->get_config_vars('bonus_name_5') . '</span><br>';
                break;
            case 6:
                $o .= '<span class="">+' . $data['stat_value' . $i] . '&nbsp;</span><span class="">' . $armory->tpl->get_config_vars('bonus_name_6') . '</span><br>';
                break;
            case 7:
                $o .= '<span class="">+' . $data['stat_value' . $i] . '&nbsp;</span><span class="">' . $armory->tpl->get_config_vars('bonus_name_7') . '</span><br>';
                break;
            case 43: // 
                if($_locale == 'en_gb') {
                    $j .= '<br /><span class="bonusGreen"><span class="">' . sprintf($armory->tpl->get_config_vars('bonus_name_43'), $data['stat_value'.$i]) . '&nbsp;</span><span class=""></span></span>';
                }
                else {
                    $j .= '<br /><span class="bonusGreen"><span class="">' . $armory->tpl->get_config_vars('bonus_name_43') . '&nbsp;</span><span class="">' . $data['stat_value'.$i] . '</span></span>';
                }
                break;
            case 20:
                $j .= '<br /><span class="bonusGreen"><span class="">' . $armory->tpl->get_config_vars('bonus_name_'.$data['stat_type'.$i]) . '&nbsp;</span><span class="">' . $data['stat_value'.$i] . '%</span></span>';
                break;
            default:
                $j .= '<br /><span class="bonusGreen"><span class="">' . $armory->tpl->get_config_vars('bonus_name_'.$data['stat_type'.$i]) . '&nbsp;</span><span class="">' . $data['stat_value'.$i] . '</span></span>';
                break;
	   }
	}
}

switch($data['class']) {
    case 1:
        if($data['InventoryType'] == 18) {
            $armory->tpl->assign('item_equip', $data['ContainerSlots'].$armory->tpl->get_config_vars('string_slot_bag').' '. $armory->tpl->get_config_vars('equip_slot_'.$data['InventoryType']));
        }
        else {
            $armory->tpl->assign('item_equip', $armory->tpl->get_config_vars('equip_slot_'.$data['InventoryType']));
        }
    break;
    case 2:
        $armory->tpl->assign('item_equip', $armory->tpl->get_config_vars('weapon_inventory_' . $data['subclass']));
        $armory->tpl->assign('armor_type', $armory->tpl->get_config_vars('weapon_name_' . $data['subclass']));
        $armory->tpl->assign('weapon_damage', true);
        $armory->tpl->assign('minDmg', $data['dmg_min1']);
        $armory->tpl->assign('maxDmg', $data['dmg_max1']);
        $armory->tpl->assign('dmg_speed', round($data['delay']/1000, 2));
        // AoWoW code
        $dps = '';
        for($jj=1;$jj<=2;$jj++) {
        	$d_type = $data['dmg_type'.$jj];
        	$d_min = $data['dmg_min'.$jj];
        	$d_max = $data['dmg_max'.$jj];
        	if(($d_max>0) && ($data['class']!=6)) {
                $delay = $data['delay'] / 1000;
                if($delay>0) {
                    $dps = $dps + round(($d_max+$d_min) / (2*$delay), 1);
                }
                if($jj>1) {
                    $delay=0;
                }
        	}
        }
        $armory->tpl->assign('dmg_per_sec', $dps);
        break;
    case 4:
        $armory->tpl->assign('item_equip', $armory->tpl->get_config_vars('equip_slot_'.$data['InventoryType']));
        $armory->tpl->assign('armor_type', $armory->tpl->get_config_vars('armor_name_'.$data['subclass']));
        if($data['armor'] > 0) {
        	$armory->tpl->assign('item_armor', $data['armor']);
        }
        break;
}
// Sockets
$s = '';
for($ii=1; $ii<4; $ii++) {
    switch($data['socketColor_'.$ii]) {
        case 1:
            $s .= '<span class="setItemGray"><img class="socketImg" src="shared/global/tooltip/images/icons/Socket_Meta.png">'.$armory->tpl->get_config_vars('socket_meta').'</span><br>';
            break;
        case 2:
            $s .= '<span class="setItemGray"><img class="socketImg" src="shared/global/tooltip/images/icons/Socket_Red.png">'.$armory->tpl->get_config_vars('socket_red').'</span><br>';
            break;
        case 4:
            $s .= '<span class="setItemGray"><img class="socketImg" src="shared/global/tooltip/images/icons/Socket_Yellow.png">'.$armory->tpl->get_config_vars('socket_yellow').'</span><br>';
            break;
        case 8:
            $s .= '<span class="setItemGray"><img class="socketImg" src="shared/global/tooltip/images/icons/Socket_Blue.png">'.$armory->tpl->get_config_vars('socket_blue').'</span><br>';
            break;
    }
}
for($i=1;$i<4;$i++) {
    if($data['spellid_'.$i] > 0) {
        $spell_tmp = $armory->aDB->selectRow("SELECT * FROM `armory_spell` WHERE `id`=?", $data['spellid_'.$i]);
        if(!isset($spell_tmp['Description_'.$_locale])) {
            continue;
        }
        $spellInfo = $items->spellReplace($spell_tmp, Utils::ValidateText($spell_tmp['Description_'.$_locale]));
        if($spellInfo) {
            $j .= '<br /><span class="bonusGreen"><span class="">'.$armory->tpl->get_config_vars('string_on_use').' '.$spellInfo.'&nbsp;</span><span class="">&nbsp;</span></span>';
        }
    }
}

$armory->tpl->assign('first_bonuses', $o);
$armory->tpl->assign('sockets', $s);
$armory->tpl->assign('durability', $data['MaxDurability']);

if($data['AllowableRace'] > 0) {
    $armory->tpl->assign('races', $items->AllowableRaces($data['AllowableRace']));
}
if($data['AllowableClass'] > 0) {
    $armory->tpl->assign('classes', $items->AllowableClasses($data['AllowableClass']));
}
if($data['RequiredLevel'] > 0) {
    $armory->tpl->assign('need_level', $data['RequiredLevel']);
}
if($data['RequiredSkill'] > 0) {
    $req_skill = $armory->aDB->selectCell("
    SELECT `name_".$_locale."`
        FROM `armory_skills`
            WHERE `id`=? LIMIT 1", $data['RequiredSkill']);
    $armory->tpl->assign('need_skill', $req_skill);
    $armory->tpl->assign('need_skill_rank', $data['RequiredSkillRank']);
}
if($data['RequiredReputationFaction'] > 0) {
    $armory->tpl->assign('need_reputation_rank', $armory->tpl->get_config_vars('reputation_required_'.$data['RequiredReputationRank']));
    $armory->tpl->assign('need_reputation_faction', $armory->tpl->get_config_vars('faction_name_'.$data['RequiredReputationFaction']));
}
if($data['itemset'] > 0) {
    $armory->tpl->assign('itemsetInfo', $items->BuildItemSetInfo($data['itemset']));
}
if(!empty($data['description'])) {
    $armory->tpl->assign('description', $items->getItemDescription($itemID));
}
// Heroic item (3.2.x)
if($data['Flags'] == 4104) {
    $armory->tpl->assign('is_heroic', true);
}
if($data['startquest'] > 0) {
    $armory->tpl->assign('startquest', true);
}
if($data['ItemLevel'] > 1) {
    $armory->tpl->assign('source', $items->GetItemSource($itemID));
}
if($data['RequiredDisenchantSkill'] > 0) {
    $armory->tpl->assign('disenchant_info', $data['RequiredDisenchantSkill']);
}
$armory->tpl->assign('green_bonuses', $j);
$armory->tpl->assign('buyPrice',  $mangos->getMoney($data['BuyPrice']));
$armory->tpl->assign('sellPrice', $mangos->getMoney($data['SellPrice']));
$armory->tpl->assign('item_icon',  $items->getItemIcon($itemID));
/** Loot tables **/
$armory->tpl->assign('boss_loot',  $items->BuildLootTable($itemID, 'boss'));
$armory->tpl->assign('vendor_loot',$items->BuildLootTable($itemID, 'vendor'));
$armory->tpl->assign('chest_loot', $items->BuildLootTable($itemID, 'chest'));
$armory->tpl->assign('quest_loot', $items->BuildLootTable($itemID, 'questreward'));
$armory->tpl->assign('queststart', $items->BuildLootTable($itemID, 'queststart'));
$armory->tpl->assign('providedfor', $items->BuildLootTable($itemID, 'providedfor'));
$armory->tpl->assign('objectiveof', $items->BuildLootTable($itemID, 'objectiveof'));
$armory->tpl->assign('item_loot',  $items->BuildLootTable($itemID, 'item'));
$armory->tpl->assign('disenchant_loot', $items->BuildLootTable($itemID, 'disenchant'));
$armory->tpl->assign('craft_loot', $items->BuildLootTable($itemID, 'craft'));
$armory->tpl->assign('reagent_loot', $items->BuildLootTable($itemID, 'reagent'));
/** Loot tables **/
$extended_cost = $armory->wDB->selectCell("SELECT `ExtendedCost` FROM `npc_vendor` WHERE `item`=? LIMIT 1", $itemID);
if($extended_cost > 0) {
    $armory->tpl->assign('price', $mangos->GetExtendedCost($extended_cost));
}
$armory->tpl->assign('item_level', $data['ItemLevel']);
$armory->tpl->assign('tpl2include', 'item_info');
$armory->tpl->assign('addCssSheet', '@import "_css/int.css";
    @import "_css/_region/eu/region.css";');
$armory->tpl->display('overall_header.tpl');
$armory->tpl->display('overall_start.tpl');
exit();
?>