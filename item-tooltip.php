<?php

/**
 * @package World of Warcraft Armory
 * @version Release Candidate 1
 * @revision 398
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
define('load_items_class', true);
define('load_characters_class', true);
define('load_mangos_class', true);
define('load_item_class', true);
define('load_itemprototype_class', true);
if(!@include('includes/armory_loader.php')) {
    die('<b>Fatal error:</b> unable to load system files.');
}
header('Content-type: text/xml');
$itemID = (isset($_GET['i'])) ? (int) $_GET['i'] : null;
$name = (isset($_GET['cn'])) ? $_GET['cn'] : null;
$realmId = (isset($_GET['r'])) ? $utils->GetRealmIdByName($_GET['r']) : 1;
if($name != null) {
    $characters->BuildCharacter($name, $realmId);
}
$isCharacter = $characters->CheckPlayer();
if($armory->armoryconfig['useCache'] == true && !isset($_GET['skipCache'])) {
    if($utils->IsItemComparisonAllowed()) {
        $selected_char_data = $utils->GetActiveCharacter();
        $chars_data = sprintf('%s:%s:%s:%s', ($characters->CheckPlayer()) ? $characters->GetName() : null, $characters->GetRealmName(), $selected_char_data['name'], $selected_char_data['realmName']);
        $cache_id = $utils->GenerateCacheId('item-tooltip', $itemID, $chars_data, $armory->currentRealmInfo['name']);
    }
    else {
        $cache_id = $utils->GenerateCacheId('item-tooltip', $itemID, ($characters->CheckPlayer()) ? $characters->GetName() : null, $armory->currentRealmInfo['name']);
    }
    if($cache_data = $utils->GetCache($cache_id, 'tooltips')) {
        echo $cache_data;
        echo sprintf('<!-- Restored from cache; id: %s -->', $cache_id);
        exit;
    }
}
// Load XSLT template
$xml->LoadXSLT('items/tooltip.xsl');
$xml->XMLWriter()->startElement('page');
$xml->XMLWriter()->writeAttribute('globalSearch', 1);
$xml->XMLWriter()->writeAttribute('lang', $armory->GetLocale());
$xml->XMLWriter()->writeAttribute('requestUrl', 'item-tooltip.xml');
$itemID = (int) $_GET['i'];
if(!$items->IsItemExists($itemID)) {
    $xml->XMLWriter()->startElement('itemTooltips');
    $xml->XMLWriter()->startElement('itemTooltip');        
    $xml->XMLWriter()->endElement();   //itemTooltip
    $xml->XMLWriter()->endElement();  //itemTooltips
    $xml->XMLWriter()->endElement(); //page
    echo $xml->StopXML();
    exit;
}
$xml->XMLWriter()->startElement('itemTooltips');
$xml->XMLWriter()->startElement('itemTooltip');
/** ITEM TOOLTIP DATA GENERATED IN Items::ItemTooltip(int $itemID, XMLWriter $xml, Characters $characters)**/
$items->ItemTooltip($itemID, $xml, $characters);
$xml->XMLWriter()->endElement();   //itemTooltip
if($utils->IsItemComparisonAllowed()) {
    $primaryCharacter = $utils->GetActiveCharacter();
    if(isset($primaryCharacter['name'])) {
        if($primaryCharacter['name'] != $characters->GetName() || ($primaryCharacter['name'] == $characters->GetName() && $primaryCharacter['realm_id'] != $characters->GetRealmID())) {
            $newChar = new Characters($armory);
            $newChar->BuildCharacter($primaryCharacter['name'], $primaryCharacter['realm_id']);
            if($newChar->CheckPlayer()) {
                $itemSlot = $items->GetItemSlotId($itemID);
                if(is_array($itemSlot)) {
                    if(is_array($itemSlot['slotname'])) {
                        foreach($itemSlot['slotname'] as $sId) {
                            $compItemID = $newChar->GetCharacterEquip($sId);
                            if($compItemID > 0) {
                                $xml->XMLWriter()->startElement('comparisonTooltips');
                                $xml->XMLWriter()->startElement('itemTooltip');
                                $items->ItemTooltip($compItemID, $xml, $newChar, false, true);
                                $xml->XMLWriter()->endElement();  //itemTooltip
                                $xml->XMLWriter()->endElement(); //comparisonTooltips
                            }
                        }
                    }
                    else {
                        $compItemID = $newChar->GetCharacterEquip($itemSlot['slotname']);
                        if($compItemID > 0) {
                            $xml->XMLWriter()->startElement('comparisonTooltips');
                            $xml->XMLWriter()->startElement('itemTooltip');
                            $items->ItemTooltip($compItemID, $xml, $newChar, false, true);
                            $xml->XMLWriter()->endElement();  //itemTooltip
                            $xml->XMLWriter()->endElement(); //comparisonTooltips
                        }
                    }
                }
            }
        }
    }
}
$xml->XMLWriter()->endElement();  //itemTooltips
$xml->XMLWriter()->endElement(); //page
$xml_cache_data = $xml->StopXML();
echo $xml_cache_data;
if($armory->armoryconfig['useCache'] == true && !isset($_GET['skipCache'])) {
    // Write cache to file
    $cache_data = $utils->GenerateCacheData($itemID, ($characters->CheckPlayer()) ? $characters->GetGUID() : 0, 'item-tooltip');
    $cache_handler = $utils->WriteCache($cache_id, $cache_data, $xml_cache_data, 'tooltips');
}
exit;
?>