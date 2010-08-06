<?php

/**
 * @package World of Warcraft Armory
 * @version Release Candidate 1
 * @revision 345
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
$isGuild = $guilds->initGuild();
if(!$isGuild) {
    // Load XSLT template
    $xml->LoadXSLT('error/error.xsl');
    $xml->XMLWriter()->startElement('page');
    $xml->XMLWriter()->writeAttribute('globalSearch', 1);
    $xml->XMLWriter()->writeAttribute('lang', $armory->GetLocale());
    $xml->XMLWriter()->startElement('errorhtml');
    $xml->XMLWriter()->endElement();  //errorhtml
    $xml->XMLWriter()->endElement(); //page
    echo $xml->StopXML();
    exit;
}
// Get page cache
if($guilds->guildId > 0 && $isGuild && $armory->armoryconfig['useCache'] == true && !isset($_GET['skipCache'])) {
    $cache_id = $utils->GenerateCacheId('guild-stats', $guilds->guildName, $armory->currentRealmInfo['name']);
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
$xml->XMLWriter()->writeAttribute('lang', $armory->GetLocale());
$xml->XMLWriter()->writeAttribute('requestUrl', 'guild-stats.xml');
$xml->XMLWriter()->startElement('tabInfo');
$xml->XMLWriter()->writeAttribute('subTab', 'guildStats');
$xml->XMLWriter()->writeAttribute('tab', 'guild');
$xml->XMLWriter()->writeAttribute('tabGroup', 'guild');
$xml->XMLWriter()->writeAttribute('tabUrl', ($isGuild) ? sprintf('r=%s&gn=%s', urlencode($armory->currentRealmInfo['name']), urlencode($guilds->guildName)) : null);
$xml->XMLWriter()->endElement(); //tabInfo
/** Basic info **/
$guilds->_structGuildInfo();
$guild_emblem = array(
    'emblemBackground'  => $guilds->bgcolor,
    'emblemBorderColor' => $guilds->bordercolor,
    'emblemBorderStyle' => $guilds->borderstyle,
    'emblemIconColor'   => $guilds->emblemcolor,
    'emblemIconStyle'   => $guilds->emblemstyle
);
$guild_header = array(
    'battleGroup'  => $armory->armoryconfig['defaultBGName'],
    'count'        => $guilds->CountGuildMembers(),
    'faction'      => $guilds->guildFaction,
    'name'         => $guilds->guildName,
    'nameUrl'      => sprintf('r=%s&gn=%s', urlencode($armory->currentRealmInfo['name']), urlencode($guilds->guildName)),
    'realm'        => $armory->currentRealmInfo['name'],
    'realmUrl'     => urlencode($armory->currentRealmInfo['name']),
    'url'          => sprintf('r=%s&gn=%s', urlencode($armory->currentRealmInfo['name']), urlencode($guilds->guildName))
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
if($armory->armoryconfig['useCache'] == true && !isset($_GET['skipCache'])) {
    // Write cache to file
    $cache_data = $utils->GenerateCacheData($guilds->guildName, $guilds->guildId, 'guild-stats');
    $cache_handler = $utils->WriteCache($cache_id, $cache_data, $xml_cache_data, 'guilds');
}
exit;
?>