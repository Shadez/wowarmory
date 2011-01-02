<?php

/**
 * @package World of Warcraft Armory
 * @version Release Candidate 1
 * @revision 440
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
$page_element = array('globalSearch' => 1, 'lang' => Armory::GetLocale(), 'requestUrl' => 'login-status.xml');
$xml->XMLWriter()->startElement('page');
foreach($page_element as $page_key => $page_value) {
    $xml->XMLWriter()->writeAttribute($page_key, $page_value);
}
$xml->XMLWriter()->startElement('loginStatus');
if(isset($_SESSION['username'])) {
    $xml->XMLWriter()->writeAttribute('username', $_SESSION['username']);
}
else {
    $xml->XMLWriter()->writeAttribute('username', null);
}
$xml->XMLWriter()->endElement();  //loginStatus
$xml->XMLWriter()->endElement(); //page
echo $xml->StopXML();
exit;
?>