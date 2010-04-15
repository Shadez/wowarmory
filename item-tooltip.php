<?php

/**
 * @package World of Warcraft Armory
 * @version Release Candidate 1
 * @revision 142
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
define('load_items_class', true);
define('load_characters_class', true);
define('load_mangos_class', true);
if(!@include('includes/armory_loader.php')) {
    die('<b>Fatal error:</b> unable to load system files.');
}
header('Content-type: text/xml');
$itemID = (isset($_GET['i'])) ? (int) $_GET['i'] : null;
$characters->name = (isset($_GET['cn'])) ? $_GET['cn'] : null;
if($characters->name) {
    $characters->GetCharacterGuid();
}
if(!$characters->guid) {
    $characters->guid = false;
}
if($armory->armoryconfig['useCache'] == true && !isset($_GET['skipCache'])) {
    $cache_id = $utils->GenerateCacheId('item-tooltip', $itemID, $characters->name, $armory->armoryconfig['defaultRealmName']);
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
$xml->XMLWriter()->writeAttribute('lang', $armory->_locale);
$xml->XMLWriter()->writeAttribute('requestUrl', 'item-tooltip.xml');
$itemID = (int) $_GET['i'];
if($itemID == 0 || !$armory->wDB->selectCell("SELECT `name` FROM `item_template` WHERE `entry`=?", $itemID)) {
    $xml->XMLWriter()->startElement('itemTooltips');
    $xml->XMLWriter()->startElement('itemTooltip');        
    $xml->XMLWriter()->endElement();   //itemTooltip
    $xml->XMLWriter()->endElement();  //itemTooltips
    $xml->XMLWriter()->endElement(); //page
    $xml->StopXML();
    exit;
}
$data = $armory->wDB->selectRow("SELECT * FROM `item_template` WHERE `entry`=? LIMIT 1", $itemID);
$xml->XMLWriter()->startElement('itemTooltips');
$xml->XMLWriter()->startElement('itemTooltip');
$xml->XMLWriter()->startElement('id');
$xml->XMLWriter()->text($itemID);
$xml->XMLWriter()->endElement(); //id
$xml->XMLWriter()->startElement('name');
if($armory->_locale == 'en_gb') {
    $xml->XMLWriter()->text($data['name']);
}
else {
    $xml->XMLWriter()->text($items->getItemName($itemID));
}
$xml->XMLWriter()->endElement(); //name
$xml->XMLWriter()->startElement('icon');
$xml->XMLWriter()->text($items->getItemIcon($itemID));
$xml->XMLWriter()->endElement(); //icon
// 3.2.x heroic item flag
if($data['Flags'] == 8 || ($data['Flags'] == 4104 && $data['itemset'] > 0)) {
    $xml->XMLWriter()->startElement('heroic');
    $xml->XMLWriter()->text('1');
    $xml->XMLWriter()->endElement();//heroic
}
$xml->XMLWriter()->startElement('overallQualityId');
$xml->XMLWriter()->text($data['Quality']);
$xml->XMLWriter()->endElement();//overallQualityId
$xml->XMLWriter()->startElement('bonding');
$xml->XMLWriter()->text($data['bonding']);
$xml->XMLWriter()->endElement();//bonding
if($data['startquest'] > 0) {
    $xml->XMLWriter()->startElement('startQuestId');
    $xml->XMLWriter()->text($data['startquest']);
    $xml->XMLWriter()->endElement(); //startQuestId
}
$xml->XMLWriter()->startElement('classId');
$xml->XMLWriter()->text($data['class']);
$xml->XMLWriter()->endElement();//classId
$xml->XMLWriter()->startElement('equipData');
$xml->XMLWriter()->startElement('inventoryType');
$xml->XMLWriter()->text($data['InventoryType']);
$xml->XMLWriter()->endElement();  //inventoryType
$xml->XMLWriter()->startElement('subclassName');
$xml->XMLWriter()->text($items->GetItemSubTypeInfo($itemID, true));
$xml->XMLWriter()->endElement();  //subclassName
if($data['class'] == ITEM_CLASS_CONTAINER) {
    $xml->XMLWriter()->startElement('containerSlots');
    $xml->XMLWriter()->text($data['ContainerSlots']);
    $xml->XMLWriter()->endElement(); //containerSlots
}
$xml->XMLWriter()->endElement(); //equipData
if($data['class'] == ITEM_CLASS_WEAPON) {
    $xml->XMLWriter()->startElement('damageData');
    $xml->XMLWriter()->startElement('damage');
    $xml->XMLWriter()->startElement('type');
    $xml->XMLWriter()->text('0');
    $xml->XMLWriter()->endElement(); //type
    $xml->XMLWriter()->startElement('min');
    $xml->XMLWriter()->text($data['dmg_min1']);
    $xml->XMLWriter()->endElement(); //min
    $xml->XMLWriter()->startElement('max');
    $xml->XMLWriter()->text($data['dmg_max1']);
    $xml->XMLWriter()->endElement();   //max
    $xml->XMLWriter()->endElement();  //damage
    
    $xml->XMLWriter()->startElement('speed');
    $xml->XMLWriter()->text(round($data['delay']/1000, 2));
    $xml->XMLWriter()->endElement(); //speed
    $xml->XMLWriter()->startElement('dps');
    $dps = null;
    for($jj=1;$jj<=2;$jj++) {
        $d_type = $data['dmg_type'.$jj];
        $d_min = $data['dmg_min'.$jj];
        $d_max = $data['dmg_max'.$jj];
        if(($d_max>0) && ($data['class'] != ITEM_CLASS_PROJECTILE)) {
            $delay = $data['delay'] / 1000;
            if($delay>0) {
                $dps = $dps + round(($d_max+$d_min) / (2*$delay), 1);
            }
            if($jj>1) {
                $delay=0;
            }
       	}
    }
    $xml->XMLWriter()->text($dps);
    $xml->XMLWriter()->endElement(); //dps
    
    $xml->XMLWriter()->endElement(); //damageData
    
}
if($data['block'] > 0) {
    $xml->XMLWriter()->startElement('blockValue');
    $xml->XMLWriter()->text($data['block']);
    $xml->XMLWriter()->endElement(); //blockValue
}
if($data['fire_res'] > 0) {
    $xml->XMLWriter()->startElement('fireResist');
    $xml->XMLWriter()->text($data['fire_res']);
    $xml->XMLWriter()->endElement(); //fireResist
}
if($data['nature_res'] > 0) {
    $xml->XMLWriter()->startElement('natureResist');
    $xml->XMLWriter()->text($data['nature_res']);
    $xml->XMLWriter()->endElement(); //natureResist
}
if($data['frost_res'] > 0) {
    $xml->XMLWriter()->startElement('frostResist');
    $xml->XMLWriter()->text($data['frost_res']);
    $xml->XMLWriter()->endElement(); //frostResist
}
if($data['shadow_res'] > 0) {
    $xml->XMLWriter()->startElement('shadowResist');
    $xml->XMLWriter()->text($data['shadow_res']);
    $xml->XMLWriter()->endElement(); //shadowResist
}
if($data['arcane_res'] > 0) {
    $xml->XMLWriter()->startElement('arcaneResist');
    $xml->XMLWriter()->text($data['arcane_res']);
    $xml->XMLWriter()->endElement(); //arcaneResist
}
for($i=1;$i<11;$i++) {
    if($data['stat_type'.$i] > 0 && $data['stat_value'.$i] > 0) {
        switch($data['stat_type'.$i]) {
            case 3:
                $bonus_template = 'bonusAgility';
                break;
            case 4:
                $bonus_template = 'bonusStrength';
                break;
            case 5:
                $bonus_template = 'bonusIntellect';
                break;
            case 6:
                $bonus_template = 'bonusSpirit';
                break;
            case 7:
                $bonus_template = 'bonusStamina';
                break;
            case 12:
                $bonus_template = 'bonusDefenseSkillRating';
                break;
            case 13:
                $bonus_template = 'bonusDodgeRating';
                break;
            case 14:
                $bonus_template = 'bonusParryRating';
                break;
            case 15:
            case 48:
                $bonus_template = 'bonusBlockRating';
                break;
            case 16:
                $bonus_template = 'bonusHitMeleeRating';
                break;
            case 17:
                $bonus_template = 'bonusHitRangedRating';
                break;
            case 18:
                $bonus_template = 'bonusHitSpellRating';
                break;
            case 19:
                $bonus_template = 'bonusCritMeleeRating';
                break;
            case 20:
                $bonus_template = 'bonusCritRangedRating';
                break;
            case 21:
                $bonus_template = 'bonusCritSpellRating';
                break;
            case 22:
                $bonus_template = 'bonusHitTakenMeleeRating';
                break;
            case 23:
                $bonus_template = 'bonusHitTakenRangedRating';
                break;
            case 24:
                $bonus_template = 'bonusHitTakenSpellRating';
                break;
            case 25:
                $bonus_template = 'bonusCritTakenMeleeRating';
                break;                
            case 26:
                $bonus_template = 'bonusCritTakenRangedRating';
                break;
            case 27:
                $bonus_template = 'bonusCritTakenSpellRating';
                break;
            case 28:
                $bonus_template = 'bonusHasteMeleeRating';
                break;
            case 29:
                $bonus_template = 'bonusHasteRangedRating';
                break;
            case 30:
                $bonus_template = 'bonusHasteSpellRating';
                break;
            case 31:
                $bonus_template = 'bonusHitRating';
                break;
            case 32:
                $bonus_template = 'bonusCritRating';
                break;
            case 33:
                $bonus_template = 'bonusHitTakenRating';
                break;
            case 34:
                $bonus_template = 'bonusCritTakenRating';
                break;
            case 35:
                $bonus_template = 'bonusResilienceRating';
                break;
            case 36:
                $bonus_template = 'bonusHasteRating';
                break;
            case 37:
                $bonus_template = 'bonusExpertiseRating';
                break;
            case 38:
            case 39:
                $bonus_template = 'bonusAttackPower';
                break;
            case 40:
                $bonus_template = 'bonusFeralAttackPower';
                break;
            case 41:
            case 42:
            case 45:
                $bonus_template = 'bonusSpellPower';
                break;
            case 43:
                $bonus_template = 'bonusManaRegen';
                break;
            case 44:
                $bonus_template = 'bonusArmorPenetration';
                break;
            case 46:
                $bonus_template = 'bonusHealthRegen';
                break;
            case 47:
                $bonus_template = 'bonusSpellPenetration';
                break;
        }
        $xml->XMLWriter()->startElement($bonus_template);
        $xml->XMLWriter()->text($data['stat_value'.$i]);
        $xml->XMLWriter()->endElement();
    }
}
$xml->XMLWriter()->startElement('armor');
if($data['ArmorDamageModifier'] > 0) {
    $xml->XMLWriter()->writeAttribute('armorBonus', 1);
}
$xml->XMLWriter()->text($data['armor']);
$xml->XMLWriter()->endElement(); //armor
$ench_array = array (
	1 => 'head',
    2 => 'neck',
    3 => 'shoulder',
    4 => 'shirt',
    5 => 'chest', 
    6 => 'belt', 
    7 => 'legs', 
    8 => 'boots',
    9 => 'wrist',
    10=> 'gloves',
    11=>'ring1',
    12=>'trinket1',
    13=>'mainhand',
    14=>'offhand',
    15=>'relic',
    16=>'back', 
    17=>'stave',
    19=>'tabard',
    20=>'chest',
    21=>'mainhand',
    22=>'',
    23=>'offhand',
    24=>'',
    25=>'thrown',
    26=>'gun',
    28=>'sigil'
);
if($characters->guid) {
    $enchantment = $characters->getCharacterEnchant($ench_array[$data['InventoryType']], $characters->guid);
    if($enchantment) {
        $xml->XMLWriter()->startElement('enchant');
        $xml->XMLWriter()->text($armory->aDB->selectCell("SELECT `text_" . $armory->_locale ."` FROM `armory_enchantment` WHERE `id`=? LIMIT 1", $enchantment));
        $xml->XMLWriter()->endElement(); //enchant
    }
}

$xml->XMLWriter()->startElement('socketData');
$socket_data = false;
$socketBonusCheck = array();
for($i=1;$i<4;$i++) {
    if($data['socketColor_'.$i] > 0) {
        switch($data['socketColor_'.$i]) {
            case 1:
                $color = 'Meta';
                $socket_data = array('color' => 'Meta');
                $gem = $items->extractSocketInfo($characters->guid, $itemID, $i);
                if($gem) {
                    $socket_data['enchant'] = $gem['enchant'];
                    $socket_data['icon'] = $gem['icon'];
                    $currentColor = $armory->aDB->selectCell("SELECT `color` FROM `armory_gemproperties` WHERE `spellitemenchantement`=? LIMIT 1", $gem['enchant_id']);
                    if($currentColor == 1) {
                        $socket_data['match'] = '1';
                    }
                }
                break;
            case 2:
                $socket_data = array('color' => 'Red');
                $gem = $items->extractSocketInfo($characters->guid, $itemID, $i);
                if($gem) {
                    $socket_data['enchant'] = $gem['enchant'];
                    $socket_data['icon'] = $gem['icon'];
                    $currentColor = $armory->aDB->selectCell("SELECT `color` FROM `armory_gemproperties` WHERE `spellitemenchantement`=? LIMIT 1", $gem['enchant_id']);
                    if($currentColor == 6 || $currentColor == 10 || $currentColor == 14) {
                        $socket_data['match'] = '1';
                    }
                }
                break;
            case 4:
                $socket_data = array('color' => 'Yellow');
                $gem = $items->extractSocketInfo($characters->guid, $itemID, $i);
                if($gem) {
                    $socket_data['enchant'] = $gem['enchant'];
                    $socket_data['icon'] = $gem['icon'];
                    $currentColor = $armory->aDB->selectCell("SELECT `color` FROM `armory_gemproperties` WHERE `spellitemenchantement`=? LIMIT 1", $gem['enchant_id']);
                    if($currentColor == 6 || $currentColor == 12 || $currentColor == 14) {
                        $socket_data['match'] = '1';
                    }
                }
                break;
            case 8:
                $socket_data = array('color' => 'Blue');
                $gem = $items->extractSocketInfo($characters->guid, $itemID, $i);
                if($gem) {
                    $socket_data['enchant'] = $gem['enchant'];
                    $socket_data['icon'] = $gem['icon'];
                    $currentColor = $armory->aDB->selectCell("SELECT `color` FROM `armory_gemproperties` WHERE `spellitemenchantement`=? LIMIT 1", $gem['enchant_id']);
                    if($currentColor == 10 || $currentColor == 12 || $currentColor == 14) {
                        $socket_data['match'] = '1';
                    }
                }
                break;
        }
        if(is_array($socket_data)) {
            $xml->XMLWriter()->startElement('socket');
            foreach($socket_data as $socket_key => $socket_value) {
                $xml->XMLWriter()->writeAttribute($socket_key, $socket_value);
            }
            $xml->XMLWriter()->endElement(); //socket
            $color = false;
        }
    }
}
if(isset($socketBonusCheck)) {
    $socketBonusCheckCount = count($socketBonusCheck);
    $socketMatches = 0;
    foreach($socketBonusCheck as $socket) {
        if($socket['color'] == $socket['current']) {
            $socketMatches++;
        }
        elseif($socket['color'] == 2 && ($socket['current'] == 6 || $socket['current'] == 10 || $socket['current'] == 14)) {
            $socketMatches++;
        }
        elseif($socket['color'] == 4 && ($socket['current'] == 6 || $socket['current'] == 12 || $socket['current'] == 14)) {
            $socketMatches++;
        }
        elseif($socket['color'] == 8 && ($socket['current'] == 10 || $socket['current'] == 12 || $socket['current'] == 14)) {
            $socketMatches++;
        }
    }
    if($socketBonusCheckCount == $socketMatches) {
        $socket_data['match'] = '1';
    }
}
if($data['socketBonus'] > 0) {
    $bonus_text = $armory->aDB->selectCell("SELECT `text_".$armory->_locale."` FROM `armory_enchantment` WHERE `id`=?", $data['socketBonus']);
    $xml->XMLWriter()->startElement('socketMatchEnchant');
    $xml->XMLWriter()->text($bonus_text);
    $xml->XMLWriter()->endElement();  //socketMatchEnchant
}
$xml->XMLWriter()->endElement(); //socketData

$allowable_classes = $items->AllowableClasses($data['AllowableClass']);
if($allowable_classes) {
    $xml->XMLWriter()->startElement('allowableClasses');
    foreach($allowable_classes as $al_class) {
        $xml->XMLWriter()->startElement('class');
        $xml->XMLWriter()->text($al_class);
        $xml->XMLWriter()->endElement(); //class
    }
    $xml->XMLWriter()->endElement(); //allowableClasses
}
$allowable_races = $items->AllowableRaces($data['AllowableRace']);
if($allowable_races) {
    $xml->XMLWriter()->startElement('allowableRaces');
    foreach($allowable_races as $al_race) {
        $xml->XMLWriter()->startElement('race');
        $xml->XMLWriter()->text($al_race);
        $xml->XMLWriter()->endElement(); //race
    }
    $xml->XMLWriter()->endElement(); //allowableRaces
}

if($data['RequiredSkill'] > 0) {
    $xml->XMLWriter()->startElement('requiredSkill');
    $xml->XMLWriter()->writeAttribute('name', $armory->aDB->selectCell("SELECT `name_".$armory->_locale."` FROM `armory_skills` WHERE `id`=?", $data['RequiredSkill']));
    $xml->XMLWriter()->writeAttribute('rank', $data['RequiredSkillRank']);
    $xml->XMLWriter()->endElement(); //requiredSkill
}

if($data['RequiredReputationFaction'] > 0) {    
    $xml->XMLWriter()->startElement('requiredFaction');
    $xml->XMLWriter()->writeAttribute('name', $armory->aDB->selectCell("SELECT `name_".$armory->_locale."` FROM `armory_faction` WHERE `id`=?", $data['RequiredReputationFaction']));
    $xml->XMLWriter()->writeAttribute('rep', $data['RequiredReputationRank']);
    $xml->XMLWriter()->endElement(); //requiredFaction
}

$xml->XMLWriter()->startElement('requiredLevel');
$xml->XMLWriter()->text($data['RequiredLevel']);
$xml->XMLWriter()->endElement(); //requiredLevel

$xml->XMLWriter()->startElement('itemLevel');
$xml->XMLWriter()->text($data['ItemLevel']);
$xml->XMLWriter()->endElement(); //itemLevel

if($data['itemset'] > 0) {
    $xml->XMLWriter()->startElement('setData');
    $setdata = $armory->aDB->selectRow("SELECT * FROM `armory_itemsetinfo` WHERE `id`=?", $data['itemset']);
    $xml->XMLWriter()->startElement('name');
    $xml->XMLWriter()->text($setdata['name_'.$armory->_locale]);
    $xml->XMLWriter()->endElement();
    
    for($i=1;$i<11;$i++) {
        if($setdata['item'.$i] > 0 && $items->IsItemExists($setdata['item'.$i])) {
            $xml->XMLWriter()->startElement('item');
            $xml->XMLWriter()->writeAttribute('name', $items->getItemName($setdata['item'.$i]));
            $xml->XMLWriter()->endElement(); //item
        }
    }
    
    $itemsetbonus = $items->GetItemSetBonusInfo($setdata);
    if(is_array($itemsetbonus)) {
        foreach($itemsetbonus as $item_bonus) {
            $xml->XMLWriter()->startElement('setBonus');
            $xml->XMLWriter()->writeAttribute('desc', $item_bonus['desc']);
            $xml->XMLWriter()->writeAttribute('threshold', $item_bonus['threshold']);
            $xml->XMLWriter()->endElement(); //setBonus
        }
    }    
    $xml->XMLWriter()->endElement(); //setData
}
if(!empty($data['description'])) {
    $xml->XMLWriter()->startElement('desc');
    $xml->XMLWriter()->text($items->GetItemDescription($itemID));
    $xml->XMLWriter()->endElement(); //desc
}
$xml->XMLWriter()->startElement('spellData');
for($i=1;$i<4;$i++) {
    if($data['spellid_'.$i] > 0) {
        $spell_tmp = $armory->aDB->selectRow("SELECT * FROM `armory_spell` WHERE `id`=?", $data['spellid_'.$i]);
        if(!isset($spell_tmp['Description_'.$armory->_locale])) {
            continue;
        }
        $spellInfo = $items->spellReplace($spell_tmp, Utils::ValidateText($spell_tmp['Description_'.$_locale]));
        if($spellInfo) {
            $spellInfo = str_replace('&quot;', '"', $spellInfo);
            $xml->XMLWriter()->startElement('spell');
            
            $xml->XMLWriter()->startElement('trigger');
            $xml->XMLWriter()->text($data['spelltrigger_'.$i]);
            $xml->XMLWriter()->endElement();  //trigger
            
            $xml->XMLWriter()->startElement('desc');
            $xml->XMLWriter()->text($spellInfo);
            $xml->XMLWriter()->endElement();  //desc
            
            $xml->XMLWriter()->endElement(); //spell
        }
    }
}
$xml->XMLWriter()->endElement(); //spellData
$itemSource = $items->GetItemSource($itemID);
if(is_array($itemSource)) {
    $xml->XMLWriter()->startElement('itemSource');
    foreach($itemSource as $source_key => $source_value) {
        $xml->XMLWriter()->writeAttribute($source_key, $source_value);
    }    
    $xml->XMLWriter()->endElement(); //itemSource
}
if($itemSource['value'] == 'sourceType.vendor' && $reqArenaRating = $items->IsRequiredArenaRating($itemID)) {
    $xml->XMLWriter()->startElement('requiredPersonalArenaRating');
    $xml->XMLWriter()->writeAttribute('personalArenaRating', $reqArenaRating);
    $xml->XMLWriter()->endElement(); //requiredPersonalArenaRating
}
$xml->XMLWriter()->endElement();   //itemTooltip
$xml->XMLWriter()->endElement();  //itemTooltips
$xml->XMLWriter()->endElement(); //page
$xml_cache_data = $xml->StopXML();
echo $xml_cache_data;
// echo htmlspecialchars_decode($xml_cache_data); // F@#K
if($armory->armoryconfig['useCache'] == true && !isset($_GET['skipCache'])) {
    // Write cache to file
    $cache_data = $utils->GenerateCacheData($itemID, ($characters->guid) ? $characters->guid : 0, 'item-toolip');
    $cache_handler = $utils->WriteCache($cache_id, $cache_data, $xml_cache_data, 'tooltips');
}
exit;
?>