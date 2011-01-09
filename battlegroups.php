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
header('Content-type: text/xml');
// Load XSLT template
$xml->LoadXSLT('arena/battlegroups.xsl');
/** Header **/
$xml->XMLWriter()->startElement('page');
$xml->XMLWriter()->writeAttribute('globalSearch', 1);
$xml->XMLWriter()->writeAttribute('lang', Armory::GetLocale());
$xml->XMLWriter()->writeAttribute('requestUrl', 'battlegroups.xml');
$xml->XMLWriter()->startElement('battlegroups');
$xml->XMLWriter()->startElement('battlegroup');
$current_BG = array(
    'display'      => Armory::$armoryconfig['defaultBGName'],
    'ladderUrl'    => sprintf('b=%s', urlencode(Armory::$armoryconfig['defaultBGName'])),
    'name'         => strtolower(Armory::$armoryconfig['defaultBGName']),
    'sortPosition' => 1
);
foreach($current_BG as $bg_key => $bg_value) {
    $xml->XMLWriter()->writeAttribute($bg_key, $bg_value);
}
$xml->XMLWriter()->startElement('realms');
if(is_array(Armory::$realmData)) {
    foreach(Armory::$realmData as $realm) {
        $xml->XMLWriter()->startElement('realm');
        $xml->XMLWriter()->writeAttribute('name', $realm['name']);
        $xml->XMLWriter()->writeAttribute('nameEn', $realm['name']);
        $xml->XMLWriter()->writeAttribute('nameUrl', 'r='.urlencode($realm['name']));
        $xml->XMLWriter()->endElement(); //realm
    }
}
$xml->XMLWriter()->endElement();  //realms
$xml->XMLWriter()->endElement(); //battlegroup
$xml->XMLWriter()->endElement();  //battlegroups
$xml->XMLWriter()->endElement(); //page
$xml_cache_data = $xml->StopXML();
echo $xml_cache_data;
exit;
?>