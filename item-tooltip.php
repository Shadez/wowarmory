<?php

/**
 * @package World of Warcraft Armory
 * @version Release Candidate 1
 * @revision 55
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
define('load_characters_class', true);
define('load_mangos_class', true);

if(!@include('includes/armory_loader.php')) {
    die('<b>Fatal error:</b> can not load main system files!');
}
$itemID = (int) $_GET['i'];
if(isset($_GET['cn'])) {
    $characters->name = $_GET['cn'];
    $characters->GetCharacterGuid();
}
// Проверка
if($itemID==0 || !isset($itemID) || !$armory->wDB->selectCell("SELECT `name` FROM `item_template` WHERE `entry`=?", $itemID)) {
    die($armory->tpl->get_config_vars('armory_item_tooltip_undefined_item'));
}
if($characters->guid) {
    $utils->clearCache();
    $CacheItem = $utils->getCache($itemID, $characters->guid);
    if($CacheItem) {
        echo $CacheItem;
        exit;
    }
}
elseif(!$characters->guid) {
    $characters->guid = false;
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
// Статы вещи и зеленые бонусы
$o = '';
$j = '';
for($i=1; $i!=11; $i++) {
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
// Сокеты
$s = '';
for($ii=1; $ii<4; $ii++) {
    switch($data['socketColor_'.$ii]) {
        case 1:
            $gem = $items->extractSocketInfo($characters->guid, $itemID, $ii);
            if($gem) {
                $s .= '<img class="socketImg p" src="wow-icons/_images/21x21/'.$gem['icon'].'.png">'.$gem['enchant'].'<br>';
                $socketBonusCheck[$ii] = array('color'=> $data['socketColor_'.$ii], 'current' => $armory->aDB->selectCell("SELECT `color` FROM `gemproperties` WHERE `spellitemenchantement`=? LIMIT 1", $gem['enchant_id']));
            }
            else {
                $s .= '<span class="setItemGray"><img class="socketImg" src="shared/global/tooltip/images/icons/Socket_Meta.png">'.$armory->tpl->get_config_vars('socket_meta').'</span><br>';
            }
            break;
        case 2:
            $gem = $items->extractSocketInfo($characters->guid, $itemID, $ii);
            if($gem) {
                $s .= '<img class="socketImg p" src="wow-icons/_images/21x21/'.$gem['icon'].'.png">'.$gem['enchant'].'<br>';
                $socketBonusCheck[$ii] = array('color'=> $data['socketColor_'.$ii], 'current' => $armory->aDB->selectCell("SELECT `color` FROM `gemproperties` WHERE `spellitemenchantement`=? LIMIT 1", $gem['enchant_id']));
            }
            else {
                $s .= '<span class="setItemGray"><img class="socketImg" src="shared/global/tooltip/images/icons/Socket_Red.png">'.$armory->tpl->get_config_vars('socket_red').'</span><br>';
            }
            break;
        case 4:
            $gem = $items->extractSocketInfo($characters->guid, $itemID, $ii);
            if($gem) {
                $s .= '<img class="socketImg p" src="wow-icons/_images/21x21/'.$gem['icon'].'.png">'.$gem['enchant'].'<br>';
                $socketBonusCheck[$ii] = array('color'=> $data['socketColor_'.$ii], 'current' => $armory->aDB->selectCell("SELECT `color` FROM `gemproperties` WHERE `spellitemenchantement`=? LIMIT 1", $gem['enchant_id']));
            }
            else {
                $s .= '<span class="setItemGray"><img class="socketImg" src="shared/global/tooltip/images/icons/Socket_Yellow.png">'.$armory->tpl->get_config_vars('socket_yellow').'</span><br>';
            }
            break;
        case 8:
            $gem = $items->extractSocketInfo($characters->guid, $itemID, $ii);
            if($gem) {
                $s .= '<img class="socketImg p" src="wow-icons/_images/21x21/'.$gem['icon'].'.png">'.$gem['enchant'].'<br>';
                $socketBonusCheck[$ii] = array('color'=> $data['socketColor_'.$ii], 'current' => $armory->aDB->selectCell("SELECT `color` FROM `gemproperties` WHERE `spellitemenchantement`=? LIMIT 1", $gem['enchant_id']));
            }
            else {
                $s .= '<span class="setItemGray"><img class="socketImg" src="shared/global/tooltip/images/icons/Socket_Blue.png">'.$armory->tpl->get_config_vars('socket_blue').'</span><br>';
            }
            break;
    }
}
if(isset($socketBonusCheck)) {
    $socketBonusCheckCount = count($socketBonusCheck);
    $socketMatches = 0;
    foreach($socketBonusCheck as $socket) {
        if($socket['color'] == $socket['current']) {
            $socketMatches++;
        }
        elseif($socket['color'] == 2 && ($socket['current'] == 6 || $socket['current'] == 10 || $socket['current'] == 14)) {
            $socketMatches++;
        }
        elseif($socket['color'] == 4 && ($socket['current'] == 6 || $socket['current'] == 12 || $socket['current'] == 14)) {
            $socketMatches++;
        }
        elseif($socket['color'] == 8 && ($socket['current'] == 10 || $socket['current'] == 12 || $socket['current'] == 14)) {
            $socketMatches++;
        }
    }
    if($socketBonusCheckCount == $socketMatches) {
        $armory->tpl->assign('socketBonusEnable', true);
    }
}

$sBonus = $armory->aDB->selectCell("SELECT `text_".$_locale."` FROM `enchantment` WHERE `id`=?", $data['socketBonus']);
for($i=1;$i<4;$i++) {
    if($data['spellid_'.$i] > 0) {
        $spell_tmp = $armory->aDB->selectRow("SELECT * FROM `spell` WHERE `id`=?", $data['spellid_'.$i]);
        if(!isset($spell_tmp['Description'.$_spell_locale])) {
            $spell_tmp['Description'.$_spell_locale] = '';
        }
        $spellInfo = $items->spellReplace($spell_tmp, Utils::ValidateText($spell_tmp['Description'.$_spell_locale]));
        if($spellInfo) {
            $j .= '<br /><span class="bonusGreen"><span class="">'.$armory->tpl->get_config_vars('string_on_use').' '.$spellInfo.'&nbsp;</span><span class="">&nbsp;</span></span>';
        }
    }
}

// Enchant
$ench_array = array (
	1 => 'head',
    2 => 'neck',
    3 => 'shoulder',
    4 => 'shirt',
    5 => 'chest', 
    6 => 'belt', 
    7 => 'legs', 
    8 => 'boots',
    9 => 'wrist',
    10=> 'gloves',
    11=>'ring1',
    12=>'trinket1',
    13=>'mainhand',
    14=>'offhand',
    15=>'relic',
    16=>'back', 
    17=>'stave',
    19=>'tabard',
    20=>'chest',
    21=>'mainhand',
    25=>'thrown',
    26=>'gun',
    28=>'sigil'
);
if($characters->guid) {
    $enchantment = $characters->getCharacterEnchant($ench_array[$data['InventoryType']], $characters->guid);
    if($enchantment) {
        $armory->tpl->assign('ench', $armory->aDB->selectCell("
        SELECT `text_" . $_locale ."`
            FROM `enchantment`
                WHERE `id`=? LIMIT 1", $enchantment));
    }
}
$armory->tpl->assign('first_bonuses', $o);
$armory->tpl->assign('sockets', $s);
$armory->tpl->assign('socket_bonus', $sBonus);
if($characters->guid) {
    $armory->tpl->assign('durability', $items->getItemDurability($characters->guid, $itemID));
}
else {
    $m_durability['current'] = $data['MaxDurability'];
    $m_durability['max'] = $data['MaxDurability'];
    $armory->tpl->assign('durability', $m_durability);
    unset($m_durability);
}

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
        FROM `skills`
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
$armory->tpl->assign('green_bonuses', $j);
$armory->tpl->assign('itemLevel', $data['ItemLevel']);
if(isset($_GET['css'])) {
    $armory->tpl->display('overall_header.tpl');
}
// Write tooltip to cache
if($characters->guid) {
    $utils->writeCache($itemID, $characters->guid, $armory->tpl->fetch('item-tooltip.tpl'), $_locale);
}
$armory->tpl->display('item-tooltip.tpl');
exit();
?>