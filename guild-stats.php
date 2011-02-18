<?php

/**
 * @package World of Warcraft Armory
 * @version Release 4.50
 * @revision 483
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
define('load_achievements_class', true);
if(!@include('includes/armory_loader.php')) {
    die('<b>Fatal error:</b> unable to load system files.');
}
header('Content-type: text/xml');
$isGuild = $guilds->InitGuild($_GET['gn'], Armory::$currentRealmInfo['type']);
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
// Get page cache
if($guilds->GetGuildID() > 0 && $isGuild && Armory::$armoryconfig['useCache'] == true && !isset($_GET['skipCache'])) {
    $cache_id = $utils->GenerateCacheId('guild-stats', $guilds->GetGuildName(), Armory::$currentRealmInfo['name']);
    if($cache_data = $utils->GetCache($cache_id, 'guilds')) {
        echo $cache_data;
        echo sprintf('<!-- Restored from cache; id: %s -->', $cache_id);
        exit;
    }
}
// Load XSLT template
$xml->LoadXSLT('guild/stats.xsl');
/** Header **/
$xml->XMLWriter()->startElement('page');
$xml->XMLWriter()->writeAttribute('globalSearch', 1);
$xml->XMLWriter()->writeAttribute('lang', Armory::GetLocale());
$xml->XMLWriter()->writeAttribute('requestUrl', 'guild-stats.xml');
$xml->XMLWriter()->startElement('tabInfo');
$xml->XMLWriter()->writeAttribute('subTab', 'guildStats');
$xml->XMLWriter()->writeAttribute('tab', 'guild');
$xml->XMLWriter()->writeAttribute('tabGroup', 'guild');
$xml->XMLWriter()->writeAttribute('tabUrl', ($isGuild) ? sprintf('r=%s&gn=%s', urlencode(Armory::$currentRealmInfo['name']), urlencode($guilds->GetGuildName())) : null);
$xml->XMLWriter()->endElement(); //tabInfo
/** Basic info **/
$guilds->BuildGuildInfo();
$guild_emblem = array(
    'emblemBackground'  => $guilds->GetEmblemBGColor(),
    'emblemBorderColor' => $guilds->GetBorderColor(),
    'emblemBorderStyle' => $guilds->GetBorderStyle(),
    'emblemIconColor'   => $guilds->GetEmblemColor(),
    'emblemIconStyle'   => $guilds->GetEmblemStyle()
);
$guild_header = array(
    'battleGroup'  => Armory::$armoryconfig['defaultBGName'],
    'count'        => $guilds->CountGuildMembers(),
    'faction'      => $guilds->GetGuildFaction(),
    'name'         => $guilds->GetGuildName(),
    'nameUrl'      => sprintf('r=%s&gn=%s', urlencode(Armory::$currentRealmInfo['name']), urlencode($guilds->GetGuildName())),
    'realm'        => Armory::$currentRealmInfo['name'],
    'realmUrl'     => urlencode(Armory::$currentRealmInfo['name']),
    'url'          => sprintf('r=%s&gn=%s', urlencode(Armory::$currentRealmInfo['name']), urlencode($guilds->GetGuildName()))
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
$xml->XMLWriter()->startElement('guild');
$xml->XMLWriter()->startElement('members');
$xml->XMLWriter()->writeAttribute('memberCount', $guilds->CountGuildMembers());
$guild_members = $guilds->BuildGuildList();
foreach($guild_members as $member) {
    $xml->XMLWriter()->startElement('character');
    foreach($member as $member_key => $member_value) {
        $xml->XMLWriter()->writeAttribute($member_key, $member_value);
    }
    $xml->XMLWriter()->endElement(); //character
}
$xml->XMLWriter()->endElement();    //members
$xml->XMLWriter()->endElement();   //guild
$xml->XMLWriter()->endElement();  //guildInfo
$xml->XMLWriter()->endElement(); //page
$xml_cache_data = $xml->StopXML();
echo $xml_cache_data;
if(Armory::$armoryconfig['useCache'] == true && !isset($_GET['skipCache'])) {
    // Write cache to file
    $cache_data = $utils->GenerateCacheData($guilds->GetGuildName(), $guilds->GetGuildID(), 'guild-stats');
    $cache_handler = $utils->WriteCache($cache_id, $cache_data, $xml_cache_data, 'guilds');
}
exit;
?>