<?php

/**
 * @package World of Warcraft Armory
 * @version Release 4.50
 * @revision 450
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
define('load_arenateams_class', true);
define('load_characters_class', true);
if(!@include('includes/armory_loader.php')) {
    die('<b>Fatal error:</b> unable to load system files.');
}
header('Content-type: text/xml');
if(!isset($_GET['ts'])) {
    $current_type = 2;
}
else {
    $current_type = (int) $_GET['ts'];
}
$page_fail = false;
if(isset($_GET['t'])) {
    $arenateams->teamname = $utils->escape($_GET['t']);
}
elseif(isset($_GET['select'])) {
    $arenateams->teamname = $utils->escape($_GET['select']);
}
$isTeam = $arenateams->IsTeam();
if(!$isTeam || !$arenateams->teamname) {
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
if($arenateams->teamname && $isTeam && Armory::$armoryconfig['useCache'] == true && !isset($_GET['skipCache'])) {
    $cache_id = $utils->GenerateCacheId('arena-team-report-opposing-teams', $arenateams->teamname, Armory::$currentRealmInfo['name']);
    if($cache_data = $utils->GetCache($cache_id, 'arena')) {
        echo $cache_data;
        echo sprintf('<!-- Restored from cache; id: %s -->', $cache_id);
        exit;
    }
}
// Load XSLT template
$xml->LoadXSLT('arena/opposing-teams.xsl');
$xml->XMLWriter()->startElement('page');
$xml->XMLWriter()->writeAttribute('globalSearch', 1);
$xml->XMLWriter()->writeAttribute('lang', Armory::GetLocale());
$xml->XMLWriter()->writeAttribute('requestUrl', 'arena-team-report-opposing-teams.xml');
$arenateams->InitTeam();
$team_info = $arenateams->GetArenaTeamInfo();
$xml->XMLWriter()->startElement('arenaGameOpposingTeamsReport');
$xml->XMLWriter()->startElement('arenaTeam');
foreach($team_info['data'] as $team_key => $team_value) {
    $xml->XMLWriter()->writeAttribute($team_key, $team_value);
}
$xml->XMLWriter()->startElement('emblem');
foreach($team_info['emblem'] as $emblem_key => $emblem_value) {
    $xml->XMLWriter()->writeAttribute($emblem_key, $emblem_value);
}
$xml->XMLWriter()->endElement();  //emblem
$xml->XMLWriter()->endElement(); //arenaTeam
$games_chart = $arenateams->BuildOpposingTeamList();
if(is_array($games_chart)) {
    foreach($games_chart as $games) {
        $xml->XMLWriter()->startElement('opposingTeam');
        if(is_array($games)) {
            foreach($games as $game_key => $game_value) {
                $xml->XMLWriter()->writeAttribute($game_key, $game_value);
            }
        }
        $xml->XMLWriter()->endElement(); //opposingTeam
    }
}
$xml->XMLWriter()->endElement(); //arenaGameOpposingTeamsReport
$xml->XMLWriter()->startElement('season');
$xml->XMLWriter()->writeAttribute('end', 'today');
$xml->XMLWriter()->writeAttribute('id', 8);
$xml->XMLWriter()->writeAttribute('start', 1265068800000);
$xml->XMLWriter()->endElement();  //season
$xml->XMLWriter()->endElement(); //page
$xml_cache_data = $xml->StopXML();
echo $xml_cache_data;
if(Armory::$armoryconfig['useCache'] == true && !isset($_GET['skipCache'])) {
    // Write cache to file
    $cache_data = $utils->GenerateCacheData($arenateams->teamname, $arenateams->arenateamid, 'arena-team-report-opposing-teams');
    $cache_handler = $utils->WriteCache($cache_id, $cache_data, $xml_cache_data, 'arena');
}
exit;
?>