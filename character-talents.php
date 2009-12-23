<?php

/**
 * @package World of Warcraft Armory
 * @version Release Candidate 1
 * @revision 30
 * @copyright (c) 2009 Shadez  
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

if(!@include('includes/armory_loader.php')) {
    die('<b>Fatal error:</b> can not load main system files!');
}
// Доп. лист стилей
$armory->tpl->assign('addCssSheet', '@import "_css/int.css";');

$characters->name = Utils::escape($_GET['cn']);
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
$armory->tpl->assign('class_text', $characters->returnClassText());
$armory->tpl->assign('race_text', $characters->returnRaceText());
$armory->tpl->assign('pts', $achievements->calculateAchievementPoints());
$armory->tpl->assign('character_url_string', $characters->returnCharacterUrl());
$armory->tpl->assign('faction_string_class', ($characters->GetCharacterFaction() == '1') ? 'horde' : 'alliance');
if($guilds->extractPlayerGuildId()) {
    $armory->tpl->assign('guildName', $guilds->getGuildName());
}
//TODO: Dualspec
$talents = $characters->extractCharacterTalents();
$armory->tpl->assign('talents', $talents);
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