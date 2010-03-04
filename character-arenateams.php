<?php

/**
 * @package World of Warcraft Armory
 * @version Release Candidate 1
 * @revision 106
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
define('load_arenateams_class', true);

if(!@include('includes/armory_loader.php')) {
    die('<b>Fatal error:</b> can not load main system files!');
}
// Additional CSS
$armory->tpl->assign('addCssSheet', '@import "_css/int.css";');

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
    $armory->ArmoryError($armory->tpl->get_config_vars('armory_error_profile_unavailable_title'), $armory->tpl->get_config_vars('armory_error_profile_unavailable_text'));
}
// All ok, generate basic character info
$characters->_structCharacter();
$achievements->guid = $characters->guid;
$guilds->guid = $characters->guid;
$arenateams->guid = $characters->guid;

// Send data to Smarty
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
$characterAT = array();
$characterAT['2x2'] = $arenateams->GetCharacterArenaTeamInfo(2);
$characterAT['3x3'] = $arenateams->GetCharacterArenaTeamInfo(3);
$characterAT['5x5'] = $arenateams->GetCharacterArenaTeamInfo(5);
/*** Character Title ***/
$charTitle = $characters->GetCharacterTitle();
$armory->tpl->assign('titleName', $characters->name);
$armory->tpl->assign('character_title_'.$charTitle['place'], $charTitle['title']);
$armory->tpl->assign('characterArenaTeamInfoButton', $characters->getCharacterArenaTeamInfo(true));
$armory->tpl->assign('characterAT', $characterAT);
$armory->tpl->assign('tpl2include', 'character_arenateams');
$armory->tpl->display('overall_header.tpl');
$armory->tpl->display('character_sheet_start.tpl');
exit();
?>