<?php

/**
 * @package World of Warcraft Armory
 * @version Release Candidate 1
 * @revision 440
 * @copyright (c) 2009-2011 Shadez
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
define('load_item_class', true);
if(!@include('includes/armory_loader.php')) {
    die('<b>Fatal error:</b> unable to load system files.');
}
header('Content-type: text/xml');
if(isset($_GET['gn'])) {
    $guilds->guildName = $utils->escape($_GET['gn']);
}
else {
    $guilds->guildName = false;
}
$serverType = Armory::$aDB->selectCell("SELECT `type` FROM `ARMORYDBPREFIX_realm_data` WHERE `name` = '%s' LIMIT 1", $utils->escape($_GET['r']));
$isGuild = $guilds->InitGuild($serverType);
if(!$isGuild) {
    // Load XSLT template
    $xml->LoadXSLT('error/error.xsl');
    $xml->XMLWriter()->startElement('page');
    $xml->XMLWriter()->writeAttribute('globalSearch', 1);
    $xml->XMLWriter()->writeAttribute('lang', Armory::GetLocale());
    $xml->XMLWriter()->startElement('errorhtml');
    $xml->XMLWriter()->endElement();  //errorhtml
    $xml->XMLWriter()->endElement(); //page
    echo $xml->StopXML();
    exit;
}
if(!isset($_SESSION['accountId'])) {
    header('Location: login.xml?ref=' . urlencode(sprintf('guild-bank-contents.xml?r=%s&gn=%s', Armory::$currentRealmInfo['name'], $guilds->guildName)));
}
elseif(!$utils->IsAllowedToGuildBank($guilds->guildId, Armory::$currentRealmInfo['id'])) {
    // Load XSLT template
    $xml->LoadXSLT('error/error.xsl');
    $xml->XMLWriter()->startElement('page');
    $xml->XMLWriter()->writeAttribute('globalSearch', 1);
    $xml->XMLWriter()->writeAttribute('lang', Armory::GetLocale());
    $xml->XMLWriter()->startElement('errorhtml');
    $xml->XMLWriter()->endElement();  //errorhtml
    $xml->XMLWriter()->endElement(); //page
    echo $xml->StopXML();
    exit;
}

// Get page cache
if($guilds->guildId > 0 && $isGuild && Armory::$armoryconfig['useCache'] == true && !isset($_GET['skipCache'])) {
    $cache_id = $utils->GenerateCacheId('guild-bank-contents', $guilds->guildName, Armory::$currentRealmInfo['name']);
    if($cache_data = $utils->GetCache($cache_id, 'guilds')) {
        echo $cache_data;
        echo sprintf('<!-- Restored from cache; id: %s -->', $cache_id);
        exit;
    }
}
// Load XSLT template
$xml->LoadXSLT('guild/bank-contents.xsl');
/** Header **/
$xml->XMLWriter()->startElement('page');
$xml->XMLWriter()->writeAttribute('globalSearch', 1);
$xml->XMLWriter()->writeAttribute('lang', Armory::GetLocale());
$xml->XMLWriter()->writeAttribute('requestUrl', 'guild-bank-contents.xml');
$xml->XMLWriter()->startElement('tabInfo');
$xml->XMLWriter()->writeAttribute('subTab', 'guildBankContents');
$xml->XMLWriter()->writeAttribute('tab', 'guild');
$xml->XMLWriter()->writeAttribute('tabGroup', 'guild');
$xml->XMLWriter()->writeAttribute('tabUrl', ($isGuild) ? sprintf('r=%s&gn=%s', urlencode(Armory::$currentRealmInfo['name']), urlencode($guilds->guildName)) : null);
$xml->XMLWriter()->endElement(); //tabInfo
/** Basic info **/
$guilds->BuildGuildInfo();
$guild_emblem = array(
    'emblemBackground'  => $guilds->bgcolor,
    'emblemBorderColor' => $guilds->bordercolor,
    'emblemBorderStyle' => $guilds->borderstyle,
    'emblemIconColor'   => $guilds->emblemcolor,
    'emblemIconStyle'   => $guilds->emblemstyle
);
$guild_header = array(
    'battleGroup'  => Armory::$armoryconfig['defaultBGName'],
    'count'        => $guilds->CountGuildMembers(),
    'faction'      => $guilds->guildFaction,
    'name'         => $guilds->guildName,
    'nameUrl'      => sprintf('r=%s&gn=%s', urlencode(Armory::$currentRealmInfo['name']), urlencode($guilds->guildName)),
    'realm'        => Armory::$currentRealmInfo['name'],
    'realmUrl'     => urlencode(Armory::$currentRealmInfo['name']),
    'url'          => sprintf('r=%s&gn=%s', urlencode(Armory::$currentRealmInfo['name']), urlencode($guilds->guildName))
);
$xml->XMLWriter()->startElement('guildInfo');
$xml->XMLWriter()->startElement('guildHeader');
foreach($guild_header as $header_key => $header_value) {
    $xml->XMLWriter()->writeAttribute($header_key, $header_value);
}
$xml->XMLWriter()->startElement('emblem');
foreach($guild_emblem as $emblem_key => $emblem_value) {
    $xml->XMLWriter()->writeAttribute($emblem_key, $emblem_value);
}
$xml->XMLWriter()->endElement();  //emblem
$xml->XMLWriter()->endElement(); //guildHeader
$xml->XMLWriter()->startElement('guildMessages');
$guild_info = $guilds->GetGuildInfo();
if(is_array($guild_info)) {
    foreach($guild_info as $info_key => $info_value) {
        $xml->XMLWriter()->writeAttribute($info_key, $info_value);
    }
}
$xml->XMLWriter()->endElement(); //guildMessages
// <guildRanks> start
$xml->XMLWriter()->startElement('guildRanks');
$guild_ranks = $guilds->GetGuildRanks();
foreach($guild_ranks as $rank) {
    $xml->XMLWriter()->startElement('rank');
    foreach($rank as $rank_key => $rank_value) {
        $xml->XMLWriter()->writeAttribute($rank_key, $rank_value);
    }
    $xml->XMLWriter()->endElement(); //rank
}
$xml->XMLWriter()->endElement(); //guildRanks
$xml->XMLWriter()->startElement('guildBank');
$xml->XMLWriter()->writeAttribute('money', $guilds->GetGuildBankMoney());
$guild_bags = $guilds->GetGuildBankTabs();
$xml->XMLWriter()->startElement('bags');
foreach($guild_bags as $bag) {
    $xml->XMLWriter()->startElement('bag');
    foreach($bag as $bag_key => $bag_value) {
        $xml->XMLWriter()->writeAttribute($bag_key, $bag_value);
    }
    $xml->XMLWriter()->endElement(); //bag
}
$xml->XMLWriter()->endElement(); //bags

$xml->XMLWriter()->startElement('items');
$bank_items = $guilds->BuildGuildBankItemList();
if(is_array($bank_items)) {
    foreach($bank_items as $item) {
        $xml->XMLWriter()->startElement('item');
        foreach($item as $item_key => $item_value) {
            $xml->XMLWriter()->writeAttribute($item_key, $item_value);
        }
        $xml->XMLWriter()->endElement(); //item
    }
}
$xml->XMLWriter()->endElement(); //items

$xml->XMLWriter()->endElement();   //guildBank
$xml->XMLWriter()->endElement();  //guildInfo
$xml->XMLWriter()->endElement(); //page
$xml_cache_data = $xml->StopXML();
echo $xml_cache_data;
if(Armory::$armoryconfig['useCache'] == true && !isset($_GET['skipCache'])) {
    // Write cache to file
    $cache_data = $utils->GenerateCacheData($guilds->guildName, $guilds->guildId, 'guild-bank-contents');
    $cache_handler = $utils->WriteCache($cache_id, $cache_data, $xml_cache_data, 'guilds');
}
exit;
?>