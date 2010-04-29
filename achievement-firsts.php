<?php

/**
 * @package World of Warcraft Armory
 * @version Release Candidate 1
 * @revision 169
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
if(!@include('includes/armory_loader.php')) {
    die('<b>Fatal error:</b> unable to load system files.');
}
header('Content-type: text/xml');

if($armory->armoryconfig['useCache'] == true && !isset($_GET['skipCache'])) {
    $cache_id = $utils->GenerateCacheId('achievement-firsts', $armory->currentRealmInfo['name']);
    if($cache_data = $utils->GetCache($cache_id)) {
        echo $cache_data;
        echo sprintf('<!-- Restored from cache; id: %s -->', $cache_id);
        exit;
    }
}
// Load XSLT template
$xml->LoadXSLT('serverfirsts.xsl');

$xml->XMLWriter()->startElement('page');
$xml->XMLWriter()->writeAttribute('globalSearch', 1);
$xml->XMLWriter()->writeAttribute('lang', $armory->_locale);
$xml->XMLWriter()->writeAttribute('requestUrl', 'achievement-firsts.xml');
$isRealm = $armory->aDB->selectCell("SELECT `id` FROM `armory_realm_data` WHERE `name`=?", $_GET['r']);
if($isRealm) {
    $xml->XMLWriter()->startElement('realmInfo');
    // Get achievements
    $achievement_firsts = $utils->realmFirsts();
    if(is_array($achievement_firsts)) {
        foreach($achievement_firsts as $achievement_info) {
            $xml->XMLWriter()->startElement('achievement');
            $xml->XMLWriter()->writeAttribute('dateCompleted', $achievement_info['dateCompleted']);
            $xml->XMLWriter()->writeAttribute('desc', $achievement_info['desc']);
            $xml->XMLWriter()->writeAttribute('icon', $achievement_info['icon']);
            $xml->XMLWriter()->writeAttribute('title', $achievement_info['title']);
            $xml->XMLWriter()->writeAttribute('realm', $armory->currentRealmInfo['name']);
            $xml->XMLWriter()->startElement('character');
            $xml->XMLWriter()->writeAttribute('classId', $achievement_info['class']);
            $xml->XMLWriter()->writeAttribute('genderId', $achievement_info['gender']);
            $xml->XMLWriter()->writeAttribute('guild', $achievement_info['guildname']);
            if(isset($achievement_info['guildname'])) {
                $xml->XMLWriter()->writeAttribute('guildId', $achievement_info['guildid']);
                $xml->XMLWriter()->writeAttribute('guildUrl', sprintf('gn=%s&r=%s', urlencode($achievement_info['guildname']), urlencode($armory->currentRealmInfo['name'])));
            }
            $xml->XMLWriter()->writeAttribute('name', $achievement_info['charname']);
            $xml->XMLWriter()->writeAttribute('raceId', $achievement_info['race']);
            $xml->XMLWriter()->writeAttribute('realm', $armory->currentRealmInfo['name']);
            $xml->XMLWriter()->writeAttribute('url', sprintf('r=%s&cn=%s', urlencode($armory->currentRealmInfo['name']), urlencode($achievement_info['charname'])));
            $xml->XMLWriter()->endElement();  // character
            $xml->XMLWriter()->endElement(); // achievement
        }
    }
    
    $xml->XMLWriter()->endElement();  //realmInfo
}
else {
    $xml->XMLWriter()->startElement('error');
    $xml->XMLWriter()->writeAttribute('errCode', 'noData');
    $xml->XMLWriter()->endElement(); //error
}
$xml->XMLWriter()->endElement(); //page
$xml_cache_data = $xml->StopXML();
echo $xml_cache_data;
if($armory->armoryconfig['useCache'] == true && !isset($_GET['skipCache'])) {
    // Write cache to file
    $cache_data = $utils->GenerateCacheData(0, 0, 'achievement-firsts');
    $cache_handler = $utils->WriteCache($cache_id, $cache_data, $xml_cache_data);
    if($cache_handler != 0x01) {
        echo sprintf('<!-- Error occured while cache write: %s -->', $cache_handler); //debug
    }
}
exit;
?>