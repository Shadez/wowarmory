<?php

/**
 * @package World of Warcraft Armory
 * @version Release Candidate 1
 * @revision 271
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
$page_fail = false;
if(isset($_GET['gid'])) {
    $gID = (int) $_GET['gid'];
    $arenateams->SetGameID($gID);
}
$game_data = $arenateams->GetGameInfo();
if($arenateams->GetGameID() === false || !is_array($game_data)) {
    // Load XSLT template
    $xml->LoadXSLT('error/error.xsl');
    $xml->XMLWriter()->startElement('page');
    $xml->XMLWriter()->writeAttribute('globalSearch', 1);
    $xml->XMLWriter()->writeAttribute('lang', $armory->_locale);
    $xml->XMLWriter()->startElement('errorhtml');
    $xml->XMLWriter()->endElement();  //errorhtml
    $xml->XMLWriter()->endElement(); //page
    echo $xml->StopXML();
    exit;
}
if($arenateams->GetGameID() > 0 && $armory->armoryconfig['useCache'] == true && !isset($_GET['skipCache'])) {
    $cache_id = $utils->GenerateCacheId('arena-game', $arenateams->GetGameID(), $armory->currentRealmInfo['name']);
    if($cache_data = $utils->GetCache($cache_id, 'arena')) {
        echo $cache_data;
        echo sprintf('<!-- Restored from cache; id: %s -->', $cache_id);
        exit;
    }
}
// Load XSLT template
$xml->LoadXSLT('arena/arena-game.xsl');
$xml->XMLWriter()->startElement('page');
$xml->XMLWriter()->writeAttribute('globalSearch', 1);
$xml->XMLWriter()->writeAttribute('lang', $armory->_locale);
$xml->XMLWriter()->writeAttribute('requestUrl', 'arena-game.xml');
$xml->XMLWriter()->startElement('game');
if(is_array($game_data['gameData'])) {
    foreach($game_data['gameData'] as $game_key => $game_value) {
        $xml->XMLWriter()->writeAttribute($game_key, $game_value);
    }
}
foreach($game_data as $chart) {
    if(isset($chart['teamData'])) {
        $xml->XMLWriter()->startElement('team');
        foreach($chart['teamData'] as $team_key => $team_value) {
            $xml->XMLWriter()->writeAttribute($team_key, $team_value);
        }
        if(isset($chart['members']) && is_array($chart['members'])) {
            foreach($chart['members'] as $tmp_memeber) {
                $xml->XMLWriter()->startElement('member');
                foreach($tmp_memeber as $member_key => $member_value) {
                    $xml->XMLWriter()->writeAttribute($member_key, $member_value);
                }
                $xml->XMLWriter()->endElement(); //member
            }
        }
        $xml->XMLWriter()->endElement(); //team
    }
}
$xml->XMLWriter()->endElement();  //game
$xml->XMLWriter()->endElement(); //page
$xml_cache_data = $xml->StopXML();
echo $xml_cache_data;
if($armory->armoryconfig['useCache'] == true && !isset($_GET['skipCache'])) {
    // Write cache to file
    $cache_data = $utils->GenerateCacheData($arenateams->GetGameID(), $arenateams->arenateamid, 'arena-game');
    $cache_handler = $utils->WriteCache($cache_id, $cache_data, $xml_cache_data, 'arena');
}
exit;
?>