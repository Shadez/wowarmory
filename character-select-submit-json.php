<?php

/**
 * @package World of Warcraft Armory
 * @version Release Candidate 1
 * @revision 413
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
$fail = false;
if(!isset($_GET['cn']) || !isset($_GET['r'])) {
    $fail = true;
}
else {
    $charName = $utils->escape($_GET['cn']);
    $realmName = $utils->escape($_GET['r']);
    $realmId = $utils->GetRealmIdByName($realmName);
    $charGuid = $utils->GetCharacterGUID($charName, $realmId);
    if(!$charGuid) {
        $fail = true;
    }
    else {
        // Character was found, try to set him/her as primary character.
        if(!$utils->SetNewPrimaryCharacter($charGuid, $realmId)) {
            $fail = true;
        }
        else {
            // Everything ok.
            header('Content-type: text/plain');
            die('{"success":true}');
        }
    }
}
if($fail) {
    header('Content-type: text/xml');
    // Load XSLT template
    $xml->LoadXSLT('error/error.xsl');
    $xml->XMLWriter()->startElement('page');
    $xml->XMLWriter()->writeAttribute('globalSearch', 1);
    $xml->XMLWriter()->writeAttribute('lang', $armory->GetLocale());
    $xml->XMLWriter()->startElement('errorhtml');
    $xml->XMLWriter()->endElement();  //errorhtml
    $xml->XMLWriter()->endElement(); //page
    echo $xml->StopXML();
    exit;
}
?>