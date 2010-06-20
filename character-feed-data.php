<?php

/**
 * @package World of Warcraft Armory
 * @version Release Candidate 1
 * @revision 257
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
define('load_items_class', true); // For TYPE_ITEM_FEED cases
if(!@include('includes/armory_loader.php')) {
    die('<b>Fatal error:</b> unable to load system files.');
}
if(isset($_GET['n'])) {
    $name = $_GET['n'];
}
elseif(isset($_GET['cn'])) {
    $name = $_GET['cn'];
}
else {
    $name = false;
}
if(!isset($_GET['r'])) {
    $_GET['r'] = false;
}
$realmId = $utils->GetRealmIdByName($_GET['r']);
$characters->BuildCharacter($name, $realmId);
$isCharacter = $characters->CheckPlayer();
if($_GET['r'] === false || !$armory->currentRealmInfo) {
    $isCharacter = false;
}
// Get page cache
if(isset($_GET['full'])) {
    if($isCharacter) {
        $character_feed = $characters->GetCharacterFeed(true);
    }
    $cache_name = 'character-feed-data-full';
}
else {
    if($isCharacter) {
        $character_feed = $characters->GetCharacterFeed();
    }
    $cache_name = 'character-feed-data';
}
if($isCharacter && $armory->armoryconfig['useCache'] == true && !isset($_GET['skipCache'])) {
    $cache_id = $utils->GenerateCacheId($cache_name, $characters->GetName(), $armory->currentRealmInfo['name']);
    if($cache_data = $utils->GetCache($cache_id)) {
        echo $cache_data;
        echo sprintf('<!-- Restored from cache; id: %s -->', $cache_id);
        exit;
    }
}
$feed_header = array('today' => date('d.m.Y'), 'yesterday' => date('M d, Y', strtotime('yesterday')), 'time' => date('H:i:s'), 'v' => '0.8');
$xml->XMLWriter()->startElement('feed');
foreach($feed_header as $feed_key => $feed_value) {
    $xml->XMLWriter()->writeAttribute($feed_key, $feed_value);
}
if(isset($character_feed) && is_array($character_feed) && $isCharacter) {
    foreach($character_feed as $feed_item) {
        $xml->XMLWriter()->startElement('event');
        foreach($feed_item['event'] as $f_header_key => $f_header_value) {
            $xml->XMLWriter()->startAttribute($f_header_key);
            $xml->XMLWriter()->writeRaw($f_header_value);
            $xml->XMLWriter()->endAttribute();
        }
        $xml->XMLWriter()->startElement('character');
        $xml->XMLWriter()->writeAttribute('name', $characters->GetName());
        $xml->XMLWriter()->writeAttribute('characterUrl', sprintf('r=%s&cn=%s', urlencode($armory->currentRealmInfo['name']), urlencode($characters->GetName())));
        $xml->XMLWriter()->endElement(); //character
        if(isset($feed_item['title'])) {
            $xml->XMLWriter()->startElement('title');
            $xml->XMLWriter()->writeRaw($feed_item['title']);
            $xml->XMLWriter()->endElement(); //title
        }
        if(isset($feed_item['desc'])) {
            $xml->XMLWriter()->startElement('desc');
            $xml->XMLWriter()->writeRaw($feed_item['desc']);
            $xml->XMLWriter()->endElement(); //desc
        }
        if(isset($feed_item['tooltip'])) {
            $xml->XMLWriter()->startElement('tooltip');
            $xml->XMLWriter()->writeRaw($feed_item['tooltip']);
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
    $cache_data = $utils->GenerateCacheData($characters->GetName(), $characters->GetGUID(), $cache_name);
    $cache_handler = $utils->WriteCache($cache_id, $cache_data, $xml_cache_data);
}
exit;
?>