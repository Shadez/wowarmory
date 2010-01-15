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
define('load_items_class', true);
define('load_achievements_class', true);
define('load_items_class', true);

if(!@include('includes/armory_loader.php')) {
    die('<b>Fatal error:</b> can not load main system files!');
}
// Доп. лист стилей
$armory->tpl->assign('addCssSheet', '@import "_css/int.css";');

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
//TODO: Dualspec
// Таланты
// Отображение 2й ветки талантов будет работать, если на ядро установлен соответствующий патч
// !Поддерживается ТОЛЬКО порт от KiriX!
$tp = '';/*
if($armory->armoryconfig['useDualSpec'] == true) {
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
            $armory->tpl->assign('dualSpec', true);
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
    $armory->tpl->assign('disabledDS_0', false);
    $armory->tpl->assign('disabledDS_1', false);
    $activespec = $armory->cDB->selectCell("SELECT `activespec` FROM `characters` WHERE `guid`=? LIMIT 1", $characters->guid);
    $disabledspec = ($activespec == 1) ? 0 : 1;
    $armory->tpl->assign('disabledDS_'.$disabledspec, true);
    for($i=0;$i<2;$i++) {
        $armory->tpl->assign('talents_'.$i, $characters->extractCharacterTalents(true, $i));
    }
}
else {
    */
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
    $talents = $characters->extractCharacterTalents();
    $armory->tpl->assign('talents', $talents);
    $glyphs = $characters->extractCharacterGlyphs();
    $armory->tpl->assign('bigGlyphs', $glyphs['big']);
    $armory->tpl->assign('smallGlyphs', $glyphs['small']);
//}

switch($characters->class) {
    case 1:
        $tplName = 'warrior_'.$_locale;
        break;
    case 2:
        $tplName = 'paladin_'.$_locale;
        break;
    case 3:
        $tplName = 'hunter_'.$_locale;
        break;
    case 4:
        $tplName = 'rogue_'.$_locale;
        break;
    case 5:
        $tplName = 'priest_'.$_locale;
        break;
    case 6:
        $tplName = 'dk_'.$_locale;
        break;
    case 7:
        $tplName = 'shaman_'.$_locale;
        break;
    case 8:
        $tplName = 'mage_'.$_locale;
        break;
    case 9:
        $tplName = 'warlock_'.$_locale;
        break;
    case 11:
        $tplName = 'druid_'.$_locale;
        break;
}
$armory->tpl->assign('talentsFileName', $tplName);
$armory->tpl->assign('playerHonorKills', $characters->getCharacterHonorKills());

$charTitle = $characters->GetCharacterTitle();
$armory->tpl->assign('character_title_'.$charTitle['place'], $charTitle['title']);

$armory->tpl->display('overall_header.tpl');
$armory->tpl->display('character_talents_start.tpl');
exit();
?>