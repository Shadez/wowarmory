<?php

/**
 * @package World of Warcraft Armory
 * @version Release Candidate 1
 * @revision 101
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
define('load_achievements_class', true);
define('load_guilds_class', true);
if(!@include('includes/armory_loader.php')) {
    die('<b>Fatal error:</b> can not load main system files!');
}
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
$characters->_structCharacter();
$achievements->guid = $characters->guid;
$guilds->guid = $characters->guid;
$armory->tpl->assign('class', $characters->class);
$armory->tpl->assign('race', $characters->race);
$armory->tpl->assign('name', $characters->name);
$armory->tpl->assign('level', $characters->level);
$armory->tpl->assign('realm', $armory->armoryconfig['defaultRealmName']);
$armory->tpl->assign('char_achievement_points', $achievements->calculateAchievementPoints());
$armory->tpl->assign('faction_string_class', ($characters->GetCharacterFaction() == '1') ? 'Horde' : 'Alliance');
if($guilds->extractPlayerGuildId()) {
    $armory->tpl->assign('guildName', $guilds->getGuildName());
}
// Sometimes browser incorrectly recognize character/realm name (if they are cyrillic) and this is a fix for this issue.
$armory->tpl->assign('urlName', 'r='.urlencode($armory->armoryconfig['defaultRealmName']).'&cn='.urlencode($characters->name));
$armory->tpl->display('character_model_embed.tpl');
exit();
?>