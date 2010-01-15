<?php

/**
 * @package World of Warcraft Armory
 * @version Release Candidate 1
 * @revision 47
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
define('load_guilds_class', true);
define('load_achievements_class', true);
define('load_items_class', true);
define('load_mangos_class', true);

if(!@include('includes/armory_loader.php')) {
    die('<b>Fatal error:</b> can not load main system files!');
}
// Доп. лист стилей
$armory->tpl->assign('addCssSheet', '@import "_css/int.css";
        @import "_css/character/sheet.css";');
if(isset($_GET['n'])) {
    $charname = $_GET['n'];
}
elseif(isset($_GET['cn'])) {
    $charname = $_GET['cn'];
}
$characters->name = Utils::escape($charname);
// Проверка
if(!$characters->IsCharacter()) {
    $armory->ArmoryError($armory->tpl->get_config_vars('armory_error_profile_unavailable_title'), $armory->tpl->get_config_vars('armory_error_profile_unavailable_text'));
}
// Все нормально, генерируем основные параметры чарактера
$characters->_structCharacter();
$achievements->guid = $characters->guid;
$guilds->guid = $characters->guid;

// Информация для тултипов
$_SESSION['char_guid'] = $characters->guid;
$items->charGuid = $characters->guid;

// Передаем параметры шаблонизатору
$armory->tpl->assign('class', $characters->class);
$armory->tpl->assign('race', $characters->race);
$armory->tpl->assign('name', $characters->name);
$armory->tpl->assign('level', $characters->level);
$armory->tpl->assign('realm', $armory->armoryconfig['defaultRealmName']);
$armory->tpl->assign('portrait_path', $characters->characterAvatar());
$armory->tpl->assign('pts', $achievements->calculateAchievementPoints());
$armory->tpl->assign('character_url_string', $characters->returnCharacterUrl());
$armory->tpl->assign('faction_string_class', ($characters->GetCharacterFaction() == '1') ? 'Horde' : 'Alliance');
if($guilds->extractPlayerGuildId()) {
    $armory->tpl->assign('guildName', $guilds->getGuildName());
}
$tp = '';
/*
if($armory->armoryconfig['useDualSpec'] == true) {
    $armory->tpl->assign('dualSpec', true);
    $ds = 0;
    while($ds<2) {
        for($i=0;$i<3;$i++) {
            if($i) {
                $tp .= " / ";
            }
            $tp .= $characters->talentCounting($characters->getTabOrBuild($characters->class, 'tab', $i), true, $ds);
        }
        // Если у персонажа ещё нет двойной специализации
        if($tp == ' /  / ') {
            $armory->tpl->assign('dualSpecError', true);
        }
        else {
            $talent_trees = explode(' / ', $tp);
            $currentTree = Utils::GetMaxArray($talent_trees);
            $currentTreeName = $characters->ReturnTalentTreesNames($characters->class, $currentTree);
            $currentTreeIcon = $characters->ReturnTalentTreeIcon($characters->class, $currentTree);
            $armory->tpl->assign('talents_builds_'.$ds, $tp);
            $armory->tpl->assign('treeName_'.$ds, $currentTreeName);
            $armory->tpl->assign('treeIcon_'.$ds, $currentTreeIcon);
            $armory->tpl->assign('ds_'.$ds, $talent_trees);
            $tp = ''; // Очищаем предыдущую ветку
            $ds++;
        }
    }
    $activespec = $armory->cDB->selectCell("SELECT `activespec` FROM `characters` WHERE `guid`=? LIMIT 1", $characters->guid);
    $disabledspec = ($activespec == 1) ? 0 : 1;
    $armory->tpl->assign('disabledDS_'.$disabledspec, ' disabledSpec');
}
else {*/
    for($i=0;$i<3;$i++) {
        if($i) {
            $tp .= " / ";
        }
        $tp .= $characters->talentCounting($characters->getTabOrBuild($characters->class, 'tab', $i));
    }
    $talent_trees = explode(' / ', $tp);
    $currentTree = Utils::GetMaxArray($talent_trees);
    $currentTreeName = $characters->ReturnTalentTreesNames($characters->class, $currentTree);
    $currentTreeIcon = $characters->ReturnTalentTreeIcon($characters->class, $currentTree);
    $armory->tpl->assign('talents_builds', $tp);
    $armory->tpl->assign('treeName', $currentTreeName);
    $armory->tpl->assign('tree_js', $talent_trees);
    $armory->tpl->assign('disabledDS_1', ' disabledSpec');
    $armory->tpl->assign('currentTreeIcon', $currentTreeIcon);
//}
// Профессии
$trade_skills = $characters->extractCharacterProfessions();
// Обрезаем кол-во профессий до 2х (в случае, если на сервере выставлено
// нестандартное кол-во первичных профессий, т.е. > 2)
$armory->tpl->assign('primary_trade_skill_1', $trade_skills[0]);
$armory->tpl->assign('primary_trade_skill_2', $trade_skills[1]);

// Здоровье
$armory->tpl->assign('healthValue', $characters->getHealthValue());
$armory->tpl->assign('additionalBarInfo', $characters->assignAdditionalEnergyBar());

/*** Одежда персонажа ***/
$gear_array = array('head', 'neck', 'shoulder', 'back', 'chest', 'shirt', 'tabard', 'wrist', 'gloves', 'belt', 'legs', 'boots', 
'ring1', 'ring2', 'trinket1', 'trinket2', 'mainhand', 'offhand', 'relic');
$i = 0;
$characterItems = array();
foreach($gear_array as $gear) {
    $gear_tmp = $characters->GetCharacterEquip($gear);
    $characterItems[$i] = array(
        'entry' => $gear_tmp,
        'icon' => $items->getItemIcon($gear_tmp),
        'rarity' => $items->GetItemInfo($gear_tmp, 'quality'),
        'ilevel' => $armory->wDB->selectCell("SELECT `ItemLevel` FROM `item_template` WHERE `entry`=? LIMIT 1", $gear_tmp),
        'i' => $i,
        'name' => $items->GetItemName($gear_tmp)
    );
    $i++;
}
$armory->tpl->assign('characterItems', $characterItems);
$armory->tpl->assign('characterStat', $characters->ConstructCharacterData());

/*** Звание ***/
// TODO: расставить запятые
$charTitle = $characters->GetCharacterTitle();
$armory->tpl->assign('character_title_'.$charTitle['place'], $charTitle['title']);
$armory->tpl->assign('playerHonorKills', $characters->getCharacterHonorKills());
$armory->tpl->assign('tpl2include', 'character_sheet_info');
$armory->tpl->display('overall_header.tpl');
$armory->tpl->display('character_sheet_start.tpl');
exit();
?>