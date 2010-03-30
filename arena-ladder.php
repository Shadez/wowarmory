<?php

/**
 * @package World of Warcraft Armory
 * @version Release Candidate 1
 * @revision 122
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
define('load_arenateams_class', true);
define('load_characters_class', true);
if(!@include('includes/armory_loader.php')) {
    die('<b>Fatal error:</b> unable to load system files.');
}
header('Content-type: text/xml');
// Load XSLT template
$xml->LoadXSLT('arena/ladder.xsl');
if(!isset($_GET['ts'])) {
    $current_type = 2;
}
else {
    $current_type = (int) $_GET['ts'];
}
if(!isset($_GET['p'])) {
    $page = 1;
}
else {
    $page = (int) $_GET['p'];
}
$maxPage = $arenateams->CountPageNum($current_type);
if($page > $maxPage) {
    $page = 1;
}
$xml->XMLWriter()->startElement('page');
$xml->XMLWriter()->writeAttribute('globalSearch', 1);
$xml->XMLWriter()->writeAttribute('lang', $armory->_locale);
$xml->XMLWriter()->writeAttribute('requestUrl', 'arena-ladder.xml');
$ladder_result = array(
    'battleGroup'      => $armory->armoryconfig['defaultBGName'],
    'filterField'      => '',
    'filterValue'      => '',
    'level'            => 80,
    'maxPage'          => $maxPage,
    'page'             => $page,
    'sortDir'          => 'a',
    'sortField'        => 'rank',
    'teamSize'         => $current_type,
    'url'              => sprintf('b=%s&ts=%d', urlencode($armory->armoryconfig['defaultBGName']), $current_type),
    'xmlSchemaVersion' => '1.0'
);
$xml->XMLWriter()->startElement('arenaLadderPagedResult');
foreach($ladder_result as $ladder_key => $ladder_value) {
    $xml->XMLWriter()->writeAttribute($ladder_key, $ladder_value);
}
$xml->XMLWriter()->startElement('arenaTeams');
$teams_count = $arenateams->CountArenaTeams($current_type);
if($page == 1) {
    $limit_query = 0;
}
else {
    $page--;
    $limit_query = $page*20;
}
$arenateams = $arenateams->BuildArenaLadderList($current_type, $limit_query);
if($arenateams) {
    foreach($arenateams as $team) {
        $xml->XMLWriter()->startElement('arenaTeam');
        foreach($team['data'] as $team_key => $team_value) {
            $xml->XMLWriter()->writeAttribute($team_key, $team_value);
        }
        $xml->XMLWriter()->startElement('emblem');
        foreach($team['emblem'] as $emblem_key => $emblem_value) {
            $xml->XMLWriter()->writeAttribute($emblem_key, $emblem_value);
        }
        $xml->XMLWriter()->endElement();   //emblem
        $xml->XMLWriter()->endElement();  //arenaTeam
    }
}
$xml->XMLWriter()->endElement();  //arenaTeams
$xml->XMLWriter()->endElement(); //arenaLadderPagedResult

$xml->XMLWriter()->endElement(); //page
$xml_cache_data = $xml->StopXML();
echo $xml_cache_data;
exit;
?>