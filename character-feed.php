<?php

/**
 * @package World of Warcraft Armory
 * @version Release Candidate 1
 * @revision 342
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
if(!@include('includes/armory_loader.php')) {
    die('<b>Fatal error:</b> unable to load system files.');
}
header('Content-type: text/xml');
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
$tabUrl = $characters->GetUrlString();
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
$character_title = $characters->GetChosenTitleInfo();
$character_element = $characters->GetHeader();
$xml->XMLWriter()->startElement('characterInfo');
if($utils->IsWriteRaw()) {
    $xml->XMLWriter()->writeRaw('<character');
    foreach($character_element as $c_elem_name => $c_elem_value) {
        if($c_elem_name == 'charUrl') {
            $xml->XMLWriter()->writeRaw(' ' . $c_elem_name .'="' .htmlspecialchars($c_elem_value).'"');
        }
        else {
            $xml->XMLWriter()->writeRaw(' ' . $c_elem_name .'="' .$c_elem_value.'"');
        }
    }
    $xml->XMLWriter()->writeRaw('>');
    $xml->XMLWriter()->writeRaw('<modelBasePath value="http://eu.media.battle.net.edgesuite.net/"/></character>');
}
else {
    $xml->XMLWriter()->startElement('character');
    foreach($character_element as $c_elem_name => $c_elem_value) {
        $xml->XMLWriter()->writeAttribute($c_elem_name, $c_elem_value);
    }
    $xml->XMLWriter()->startElement('modelBasePath');
    $xml->XMLWriter()->writeAttribute('value', 'http://eu.media.battle.net.edgesuite.net/');
    $xml->XMLWriter()->endElement();  //modelBasePath
    $xml->XMLWriter()->endElement(); //character
}
$xml->XMLWriter()->endElement();  //characterInfo
$xml->XMLWriter()->endElement(); //page
$xml_cache_data = $xml->StopXML();
echo $xml_cache_data;
exit;
?>