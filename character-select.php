<?php

/**
 * @package World of Warcraft Armory
 * @version Release Candidate 1
 * @revision 168
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
if(!isset($_SESSION['username'])) {
    header('Location: index.xml?logout=1');
}
header('Content-type: text/xml');
// Load XSLT template
$xml->LoadXSLT('character-select.xsl');
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
$characters->_structCharacter();
$achievements->guid = $characters->guid;
if(!isset($_GET['r']) || !$armory->currentRealmInfo) {
    $isCharacter = false;
}
/** Header **/
$xml->XMLWriter()->startElement('page');
$xml->XMLWriter()->writeAttribute('globalSearch', 1);
$xml->XMLWriter()->writeAttribute('lang', $armory->_locale);
$xml->XMLWriter()->writeAttribute('requestUrl', 'character-select.xml');
$xml->XMLWriter()->startElement('accounts');
$xml->XMLWriter()->startElement('account');
$xml->XMLWriter()->writeAttribute('active', 1);
$xml->XMLWriter()->writeAttribute('characters', $utils->CountAllCharacters());
$xml->XMLWriter()->writeAttribute('selected', $utils->CountSelectedCharacters());
$xml->XMLWriter()->writeAttribute('username', strtoupper($_SESSION['username']));
$xml->XMLWriter()->endElement();  //account
$xml->XMLWriter()->endElement(); //accounts
$xml->XMLWriter()->startElement('characters');
$my_characters = $utils->GetAllCharacters();
if($my_characters) {
    foreach($my_characters as $vault_character) {
        $xml->XMLWriter()->startElement('character');
        foreach($vault_character as $vault_key => $vault_value) {
            $xml->XMLWriter()->writeAttribute($vault_key, $vault_value);
        }
        $xml->XMLWriter()->endElement(); //character
    }
}

$xml->XMLWriter()->endElement();  //characters
$xml->XMLWriter()->endElement(); //page
$xml_cache_data = $xml->StopXML();
echo $xml_cache_data;
exit;
?>