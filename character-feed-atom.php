<?php

/**
 * @package World of Warcraft Armory
 * @version Release 4.50
 * @revision 456
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

/*
Add
    RewriteRule character-feed.atom character-feed-atom.php?%{QUERY_STRING}
To your .htaccess file (in root folder)
*/
define('__ARMORY__', true);
define('load_characters_class', true);
define('load_achievements_class', true);
define('load_items_class', true); // For TYPE_ITEM_FEED cases
define('RSS_FEED', true);
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
$characters->SetOptions(LOAD_NOTHING);
$characters->SetOptions(array('load_feeds' => true));
$characters->BuildCharacter($name, $realmId, true, true);
$isCharacter = $characters->CheckPlayer();
if($_GET['r'] === false || !$characters->GetRealmName()) {
    $isCharacter = false;
}
header('Content-type: text/xml');
$character_feed = $characters->GetCharacterFeed(true);
if(!$character_feed) {
    $xml->StartXML();
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
$cache_name = 'character-feed-atom';
// Get page cache
if($isCharacter && Armory::$armoryconfig['useCache'] == true && !isset($_GET['skipCache'])) {
    $cache_id = $utils->GenerateCacheId($cache_name, $characters->GetName(), $characters->GetRealmName());
    if($cache_data = $utils->GetCache($cache_id)) {
        echo $cache_data;
        echo sprintf('<!-- Restored from cache; id: %s -->', $cache_id);
        exit;
    }
}
$xml->XMLWriter()->startElement('feed');
$xml->XMLWriter()->writeAttribute('xmlns', 'http://www.w3.org/2005/Atom');
$xml->XMLWriter()->writeAttribute('xml:lang', Armory::GetLocale());
$xml->XMLWriter()->startElement('author');
$xml->XMLWriter()->startElement('name');
$xml->XMLWriter()->text('Blizzard Entertainment');
$xml->XMLWriter()->endElement();  //name
$xml->XMLWriter()->endElement(); //author
$xml->XMLWriter()->startElement('link');
$xml->XMLWriter()->writeAttribute('href', sprintf('character-feed.atom?r=%s&cn=%s&locale=%s', urldecode($characters->GetRealmName()), urldecode($characters->GetName()), Armory::GetLocale()));
$xml->XMLWriter()->endElement(); //link
$xml->XMLWriter()->startElement('updated');
$xml->XMLWriter()->text(date('Y-M-d\TH:i:s\+00:00'));
$xml->XMLWriter()->endElement(); //updated
$xml->XMLWriter()->startElement('title');
$xml->XMLWriter()->writeAttribute('type', 'text');
$xml->XMLWriter()->text(sprintf('WoW News for %s@%s', $characters->GetName(), $characters->GetRealmName()));
$xml->XMLWriter()->endElement(); //title
$xml->XMLWriter()->startElement('id');
$xml->XMLWriter()->text('http://eu.wowarmory.com/');
$xml->XMLWriter()->endElement(); //id
foreach($character_feed as $feed) {
    $fdate = date('Y-m-d\TH:i:s\+00:00', $feed['hard_date']);
    $xml->XMLWriter()->startElement('entry');
    $xml->XMLWriter()->startElement('title');
    $xml->XMLWriter()->writeAttribute('type', 'text');
    $xml->XMLWriter()->text($feed['title']);
    $xml->XMLWriter()->endElement(); //title
    $xml->XMLWriter()->startElement('updated');
    $xml->XMLWriter()->text($fdate);
    $xml->XMLWriter()->endElement(); //updated
    $xml->XMLWriter()->startElement('published');
    $xml->XMLWriter()->text($fdate);
    $xml->XMLWriter()->endElement(); //published
    $xml->XMLWriter()->startElement('id');
    $xml->XMLWriter()->text(sprintf('%s@%s_%s_%s', strtolower(urlencode($characters->GetName())), strtolower(urlencode($characters->GetRealmName())), $feed['hard_data'], date('dmYHis', $feed['hard_date'])));
    $xml->XMLWriter()->endElement(); //id
    $xml->XMLWriter()->startElement('link');
    $xml->XMLWriter()->writeAttribute('href', sprintf('character-feed.xml?r=%s&cn=%s&locale=%s', urldecode($characters->GetRealmName()), urldecode($characters->GetName()), Armory::GetLocale()));
    $xml->XMLWriter()->endElement(); //link
    $xml->XMLWriter()->startElement('content');
    $xml->XMLWriter()->writeAttribute('type', 'html');
    $xml->XMLWriter()->writeCData($feed['desc']);
    $xml->XMLWriter()->endElement();  //content
    $xml->XMLWriter()->endElement(); //entry
}

$xml->XMLWriter()->endElement(); //feed
$xml_cache_data = $xml->StopXML();
echo $xml_cache_data;
if(Armory::$armoryconfig['useCache'] == true && !isset($_GET['skipCache'])) {
    // Write cache to file
    $cache_data = $utils->GenerateCacheData($characters->GetName(), $characters->GetGUID(), $cache_name);
    $cache_handler = $utils->WriteCache($cache_id, $cache_data, $xml_cache_data);
}
exit;
?>