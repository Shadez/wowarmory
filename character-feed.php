<?php

/**
 * @package World of Warcraft Armory
 * @version Release Candidate 1
 * @revision 160
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
if(isset($_GET['n'])) {
    $characters->name = $_GET['n'];
}
elseif(isset($_GET['cn'])) {
    $characters->name = $_GET['cn'];
}
else {
    $characters->name = false;
}
$characters->GetCharacterGuid();
$isCharacter = $characters->IsCharacter();
$characters->_structCharacter();
/** Basic info **/
$tabUrl = false;
$achievements->guid = $characters->guid;
$guilds->guid       = $characters->guid;
$arenateams->guid   = $characters->guid;
if($isCharacter && $guilds->extractPlayerGuildId()) {
    $tabUrl = sprintf('r=%s&cn=%s&gn=%s', urlencode($armory->armoryconfig['defaultRealmName']), urlencode($characters->name), urlencode($guilds->getGuildName()));
    $charTabUrl = sprintf('r=%s&cn=%s&gn=%s', urlencode($armory->armoryconfig['defaultRealmName']), urlencode($characters->name), urlencode($guilds->getGuildName()));
}
elseif($isCharacter) {
    $tabUrl = sprintf('r=%s&cn=%s', urlencode($armory->armoryconfig['defaultRealmName']), urlencode($characters->name));
    $charTabUrl = sprintf('r=%s&cn=%s', urlencode($armory->armoryconfig['defaultRealmName']), urlencode($characters->name));
}
$xml->LoadXSLT('character/feed.xsl');
/** Header **/
// Load XSLT template
$xml->XMLWriter()->startElement('page');
$xml->XMLWriter()->writeAttribute('globalSearch', 1);
$xml->XMLWriter()->writeAttribute('lang', $armory->_locale);
$xml->XMLWriter()->writeAttribute('requestUrl', 'character-feed.xml');
$xml->XMLWriter()->startElement('tabInfo');
$xml->XMLWriter()->writeAttribute('subTab', 'feed');
$xml->XMLWriter()->writeAttribute('tab', 'character');
$xml->XMLWriter()->writeAttribute('tabGroup', 'character');
$xml->XMLWriter()->writeAttribute('tabUrl', $tabUrl);
$xml->XMLWriter()->endElement(); //tabInfo
if(!$isCharacter) {
    $xml->XMLWriter()->startElement('characterInfo');
    $xml->XMLWriter()->writeAttribute('errCode', 'noCharacter');
    $xml->XMLWriter()->endElement(); // characterInfo
    $xml->XMLWriter()->endElement(); //page
    $xml_cache_data = $xml->StopXML();
    echo $xml_cache_data;
    exit;
}

$characters->GetCharacterTitle();
$character_element = array(
    // TODO: add GetLocaleString() method
    'battleGroup'  => $armory->armoryconfig['defaultBGName'],
    'charUrl'      => $charTabUrl,
    'class'        => $characters->returnClassText(),
    'classId'      => $characters->class,
    'classUrl'     => sprintf('c='),
    'faction'      => null,
    'factionId'    => $characters->GetCharacterFaction(),
    'gender'       => null,
    'genderId'     => $characters->gender,
    'guildName'    => ($guilds->guid) ? $guilds->guildName : null,
    'guildUrl'     => ($guilds->guid) ? sprintf('r=%s&gn=%s', urlencode($armory->armoryconfig['defaultRealmName']), urlencode($guilds->guildName)) : null,
    'lastModified' => null,
    'level'        => $characters->level,
    'name'         => $characters->name,
    'points'       => $achievements->CalculateAchievementPoints(),
    'prefix'       => $characters->character_title['prefix'],
    'race'         => $characters->returnRaceText(),
    'raceId'       => $characters->race,
    'realm'        => $armory->armoryconfig['defaultRealmName'],
    'suffix'       => $characters->character_title['suffix'],
    'titeId'       => $characters->character_title['titleId'],
);
$xml->XMLWriter()->startElement('characterInfo');
$xml->XMLWriter()->startElement('character');
foreach($character_element as $c_elem_name => $c_elem_value) {
    $xml->XMLWriter()->writeAttribute($c_elem_name, $c_elem_value);
}
$xml->XMLWriter()->endElement();   //character
$xml->XMLWriter()->endElement();  //characterInfo
$xml->XMLWriter()->endElement(); //page
$xml_cache_data = $xml->StopXML();
echo $xml_cache_data;
exit;
?>