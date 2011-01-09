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
if(!@include('includes/armory_loader.php')) {
    die('<b>Fatal error:</b> unable to load system files.');
}
if(!isset($_SESSION['username'])) {
    header('Location: index.xml?login=1');
}
if(isset($_GET['action']) && isset($_GET['r']) && isset($_GET['cn'])) {
    $name = $utils->escape($_GET['cn']);
    $realm = $utils->escape($_GET['r']);
    switch($_GET['action']) {
        case 1: //add bookmark
            $utils->AddBookmark($name, $realm);
            break;
        case 2: //delete bookmark
            $utils->DeleteBookmark($name, $realm);
            break;
    }
    exit;
}
header('Content-type: text/xml');
// Load XSLT template
$xml->LoadXSLT('nav/bookmarks.xsl');
/** Header **/
$xml->XMLWriter()->startElement('page');
$xml->XMLWriter()->writeAttribute('globalSearch', 1);
$xml->XMLWriter()->writeAttribute('lang', Armory::GetLocale());
$xml->XMLWriter()->writeAttribute('requestUrl', 'bookmarks.xml');
$bookmarks_count = $utils->GetBookmarksCount();
$xml->XMLWriter()->startElement('characters');
$xml->XMLWriter()->writeAttribute('count', $bookmarks_count);
$xml->XMLWriter()->writeAttribute('max', MAX_BOOKMARKS_COUNT);
$character_bookmarks = $utils->GetBookmarks();
if(is_array($character_bookmarks)) {
    foreach($character_bookmarks as $bookmark) {
        $xml->XMLWriter()->startElement('character');
        foreach($bookmark as $b_key => $b_value) {
            $xml->XMLWriter()->writeAttribute($b_key, $b_value);
        }
        $xml->XMLWriter()->endElement(); //character
    }
}
$xml->XMLWriter()->endElement();  //characters
$xml->XMLWriter()->endElement(); //page
echo $xml->StopXML();
?>