<?php

/**
 * @package World of Warcraft Armory
 * @version Release Candidate 1
 * @revision 195
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
define('load_arenateams_class', true);
if(!@include('includes/armory_loader.php')) {
    die('<b>Fatal error:</b> unable to load system files.');
}
header('Content-type: text/xml');
// Load XSLT template
$xml->LoadXSLT('character/arenateams.xsl');
if(isset($_GET['n'])) {
    $name = $_GET['n'];
}
elseif(isset($_GET['cn'])) {
    $name = $_GET['cn'];
}
else {
    $name = false;
}
$characters->BuildCharacter($name);
$isCharacter = $characters->CheckPlayer();
if(!isset($_GET['r']) || !$armory->currentRealmInfo) {
    $isCharacter = false;
}
// Get page cache
if($characters->GetGUID() > 0 && $isCharacter && $armory->armoryconfig['useCache'] == true && !isset($_GET['skipCache'])) {
    $cache_id = $utils->GenerateCacheId('character-arenateams', $characters->GetName(), $armory->currentRealmInfo['name']);
    if($cache_data = $utils->GetCache($cache_id)) {
        echo $cache_data;
        echo sprintf('<!-- Restored from cache; id: %s -->', $cache_id);
        exit;
    }
}/** Basic info **/
$achievements->guid = $characters->GetGUID();
$arenateams->guid   = $characters->GetGUID();
$tabUrl = false;
if($isCharacter && $characters->GetGuildID() > 0) {
    $tabUrl = sprintf('r=%s&cn=%s&gn=%s', urlencode($armory->currentRealmInfo['name']), urlencode($characters->GetName()), urlencode($characters->GetGuildName()));
    $charTabUrl = sprintf('r=%s&cn=%s&gn=%s', urlencode($armory->currentRealmInfo['name']), urlencode($characters->GetName()), urlencode($characters->GetGuildName()));
}
elseif($isCharacter) {
    $tabUrl = sprintf('r=%s&cn=%s', urlencode($armory->currentRealmInfo['name']), urlencode($characters->GetName()));
    $charTabUrl = sprintf('r=%s&cn=%s', urlencode($armory->currentRealmInfo['name']), urlencode($characters->GetName()));
}
/** Header **/
$xml->XMLWriter()->startElement('page');
$xml->XMLWriter()->writeAttribute('globalSearch', 1);
$xml->XMLWriter()->writeAttribute('lang', $armory->_locale);
$xml->XMLWriter()->writeAttribute('requestUrl', 'character-arenateams.xml');
$xml->XMLWriter()->startElement('tabInfo');
$xml->XMLWriter()->writeAttribute('subTab', 'arena');
$xml->XMLWriter()->writeAttribute('tab', 'character');
$xml->XMLWriter()->writeAttribute('tabGroup', 'character');
$xml->XMLWriter()->writeAttribute('tabUrl', $tabUrl);
$xml->XMLWriter()->endElement(); //tabInfo
if(!$isCharacter) {
    $xml->XMLWriter()->startElement('characterInfo');
    $xml->XMLWriter()->writeAttribute('errCode', 'noCharacter');
    $xml->XMLWriter()->endElement();  //characterInfo
    $xml->XMLWriter()->endElement(); //page
    $xml_cache_data = $xml->StopXML();
    echo $xml_cache_data;
    exit;
}
$character_title = $characters->GetChosenTitleInfo();
$character_element = array(
    'battleGroup' => $armory->armoryconfig['defaultBGName'],
    'charUrl'      => $charTabUrl,
    'class'        => $characters->GetClassText(),
    'classId'      => $characters->GetClass(),
    'classUrl'     => null,
    'faction'      => null,
    'factionId'    => $characters->GetFaction(),
    'gender'       => null,
    'genderId'     => $characters->GetGender(),
    'guildName'    => ($characters->GetGuildID() > 0) ? $characters->GetGuildName() : null,
    'guildUrl'     => ($characters->GetGuildID() > 0) ? sprintf('r=%s&gn=%s', urlencode($armory->currentRealmInfo['name']), urlencode($characters->GetGuildName())) : null,
    'lastModified' => null,
    'level'        => $characters->GetLevel(),
    'name'         => $characters->GetName(),
    'points'       => $achievements->CalculateAchievementPoints(),
    'prefix'       => $character_title['prefix'],
    'race'         => $characters->GetRaceText(),
    'raceId'       => $characters->GetRace(),
    'realm'        => $armory->currentRealmInfo['name'],
    'suffix'       => $character_title['suffix'],
    'titleId'      => $character_title['titleId'],
);
$xml->XMLWriter()->startElement('characterInfo');
$xml->XMLWriter()->startElement('character');
foreach($character_element as $c_elem_name => $c_elem_value) {
    $xml->XMLWriter()->writeAttribute($c_elem_name, $c_elem_value);
}
$character_arenateams = $arenateams->GetCharacterArenaTeamInfo();
if(is_array($character_arenateams)) {
    $xml->XMLWriter()->startElement('arenaTeams');
    foreach($character_arenateams as $arenateam) {
        $xml->XMLWriter()->startElement('arenaTeam');
        foreach($arenateam['data'] as $team_key => $team_value) {
            $xml->XMLWriter()->writeAttribute($team_key, $team_value);
        }
        $xml->XMLWriter()->startElement('emblem');
        foreach($arenateam['emblem'] as $emblem_key => $emblem_value) {
            $xml->XMLWriter()->writeAttribute($emblem_key, $emblem_value);
        }
        $xml->XMLWriter()->endElement();  //emblem
        $xml->XMLWriter()->startElement('members');
        foreach($arenateam['members'] as $member) {
            $xml->XMLWriter()->startElement('character');
            foreach($member as $member_key => $member_value) {
                $xml->XMLWriter()->writeAttribute($member_key, $member_value);
            }
            $xml->XMLWriter()->endElement(); //character
        }
        $xml->XMLWriter()->endElement();  //members
        $xml->XMLWriter()->endElement(); //arenaTeam
    }
    $xml->XMLWriter()->endElement(); //arenaTeams
}
$xml->XMLWriter()->endElement();   //character
$xml->XMLWriter()->endElement();  //characterInfo
$xml->XMLWriter()->endElement(); //page
$xml_cache_data = $xml->StopXML();
echo $xml_cache_data;
if($armory->armoryconfig['useCache'] == true && !isset($_GET['skipCache'])) {
    // Write cache to file
    $cache_data = $utils->GenerateCacheData($characters->GetName(), $characters->GetGUID(), 'character-arenateams');
    $cache_handler = $utils->WriteCache($cache_id, $cache_data, $xml_cache_data);
}
exit;
?>