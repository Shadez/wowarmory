<?php

/**
 * @package World of Warcraft Armory
 * @version Release Candidate 1
 * @revision 65
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
define('load_guilds_class', true);
define('load_items_class', true);

if(!@include('includes/armory_loader.php')) {
    die('<b>Fatal error:</b> can not load main system files!');
}
$guilds->guildName = Utils::escape($_GET['gn']);
if(!$guilds->initGuild()) {
    $armory->tpl->display('error_sheet.tpl');
    die();
}
if(!isset($_SESSION['accountId']) || !$utils->guildBankRights($guilds->guildId)) {
    header('Location: login.xml?guild-bank-contents');
}
$guilds->_structGuildInfo();
// Additional CSS
$armory->tpl->assign('addCssSheet', '@import "_css/int.css";');

$armory->tpl->assign('guildName', $guilds->guildName);
if(isset($_GET['cn'])) {
    $armory->tpl->assign('name', $_GET['cn']);
}
$armory->tpl->assign('realm', $armory->armoryconfig['defaultRealmName']);
$armory->tpl->assign('guildMembersCount', $guilds->countGuildMembers());
$armory->tpl->assign('guildEmblemStyle', $guilds->guildtabard);
$armory->tpl->assign('guildMotd', $guilds->getGuildMotd());
$armory->tpl->assign('guildInfoText', $guilds->getGuildInfo());
$armory->tpl->assign('guildBankTabs', $guilds->getGuildBankTabs());
$armory->tpl->assign('GuildBankContents', $guilds->showGuildBankContents());
$armory->tpl->assign('GuildBankMoney', $guilds->getGuildBankMoney());
$armory->tpl->assign('GuildBankItemList', $guilds->BuildGuildBankItemList());

$armory->tpl->assign('titleName', $guilds->guildName);
$armory->tpl->assign('tpl2include', 'guild_bank_contents');
$armory->tpl->display('overall_header.tpl');
$armory->tpl->display('overall_start.tpl');
exit();
?>