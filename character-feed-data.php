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
define('load_characters_class', true);
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
// Get page cache
if($characters->guid > 0 && $isCharacter && $armory->armoryconfig['useCache'] == true && !isset($_GET['skipCache'])) {
    $cache_id = $utils->GenerateCacheId('character-feed-data', $characters->name, $armory->armoryconfig['defaultRealmName']);
    if($cache_data = $utils->GetCache($cache_id)) {
        echo $cache_data;
        echo sprintf('<!-- Restored from cache; id: %s -->', $cache_id);
        exit;
    }
}
$feed_header = array('today' => date('d.m.Y'), 'yesterday' => date('m d, Y'), 'time' => date('H:i:s'), 'v' => '0.8');
$xml->XMLWriter()->startElement('feed');
foreach($feed_header as $feed_key => $feed_value) {
    $xml->XMLWriter()->writeAttribute($feed_key, $feed_value);
}
$character_feed = $characters->GetCharacterFeed();
if(is_array($character_feed)) {
    foreach($character_feed as $feed_item) {
        $xml->XMLWriter()->startElement('event');
        foreach($feed_item['header'] as $f_header_key => $f_header_value) {
            $xml->XMLWriter()->writeAttribute($f_header_key, $f_header_value);
        }
        $xml->XMLWriter()->startElement('character');
        $xml->XMLWriter()->writeAttribute('name', $characters->name);
        $xml->XMLWriter()->writeAttribute('characterurl', sprintf('r=%s&cn=%s', urlencode($armory->armoryconfig['defaultRealmName']), urlencode($characters->name)));
        $xml->XMLWriter()->endElement(); //character
        $xml->XMLWriter()->startElement('title');
        $xml->XMLWriter()->text($feed_item['data']['title']);
        $xml->XMLWriter()->endElement(); //title
        $xml->XMLWriter()->startElement('desc');
        $xml->XMLWriter()->text($feed_item['data']['desc']);
        $xml->XMLWriter()->endElement();  //desc
        if(isset($feed_item['data']['tooltip'])) {
            $xml->XMLWriter()->startElement('tooltip');
            $xml->XMLWriter()->text($feed_item['data']['tooltip']);
            $xml->XMLWriter()->endElement(); //tooltip
        }
        $xml->XMLWriter()->endElement(); //event
    }
}
$xml->XMLWriter()->endElement(); //feed
$xml_cache_data = $xml->StopXML();
echo $xml_cache_data;
if($armory->armoryconfig['useCache'] == true && !isset($_GET['skipCache'])) {
    // Write cache to file
    $cache_data = $utils->GenerateCacheData($characters->name, $characters->guid, 'character-feed-data');
    $cache_handler = $utils->WriteCache($cache_id, $cache_data, $xml_cache_data);
}
exit;
?>