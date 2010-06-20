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
define('load_items_class', true);
define('load_mangos_class', true);
define('load_arenateams_class', true);
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
// Get page cache
if($isCharacter && $armory->armoryconfig['useCache'] == true && !isset($_GET['skipCache'])) {
    $cache_id = $utils->GenerateCacheId('character-sheet', $characters->GetName(), $armory->currentRealmInfo['name']);
    if($cache_data = $utils->GetCache($cache_id)) {
        echo $cache_data;
        echo sprintf('<!-- Restored from cache; id: %s -->', $cache_id);
        exit;
    }
}
// Load XSLT template
$xml->LoadXSLT('character/sheet.xsl');
/** Basic info **/
$achievements->guid = $characters->GetGUID();
$arenateams->guid   = $characters->GetGUID();
$tabUrl = $characters->GetUrlString();
/** Header **/
$xml->XMLWriter()->startElement('page');
$xml->XMLWriter()->writeAttribute('globalSearch', 1);
$xml->XMLWriter()->writeAttribute('lang', $armory->_locale);
$xml->XMLWriter()->writeAttribute('requestUrl', 'character-sheet.xml');
$xml->XMLWriter()->startElement('tabInfo');
$xml->XMLWriter()->writeAttribute('subTab', 'profile');
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
$character_element = $characters->GetHeader($achievements);
$xml->XMLWriter()->startElement('characterInfo');
$xml->XMLWriter()->startElement('character');
foreach($character_element as $c_elem_name => $c_elem_value) {
    $xml->XMLWriter()->writeAttribute($c_elem_name, $c_elem_value);
}
$character_arenateams = $arenateams->GetCharacterArenaTeamInfo();
if($character_arenateams && is_array($character_arenateams)) {
    $xml->XMLWriter()->startElement('arenaTeams');
    foreach($character_arenateams as $arenateam) {
        $xml->XMLWriter()->startElement('arenaTeam');
        foreach($arenateam['data'] as $team_key => $team_value) {
            $xml->XMLWriter()->writeAttribute($team_key, $team_value);
        }
        $xml->XMLWriter()->startElement('emblem');
        foreach($arenateam['emblem'] as $emblem_key => $emblem_value) {
            $xml->XMLWriter()->writeAttribute($emblem_key, $emblem_value);
        }
        $xml->XMLWriter()->endElement();  //emblem
        $xml->XMLWriter()->startElement('members');
        foreach($arenateam['members'] as $member) {
            $xml->XMLWriter()->startElement('character');
            foreach($member as $member_key => $member_value) {
                $xml->XMLWriter()->writeAttribute($member_key, $member_value);
            }
            $xml->XMLWriter()->endElement(); //character
        }
        $xml->XMLWriter()->endElement();  //members
        $xml->XMLWriter()->endElement(); //arenaTeam
    }
    $xml->XMLWriter()->endElement(); //arenaTeams
}
$xml->XMLWriter()->startElement('modelBasePath');
$xml->XMLWriter()->writeAttribute('value', 'http://eu.media.battle.net.edgesuite.net/');
$xml->XMLWriter()->endElement();  //modelBasePath
$xml->XMLWriter()->endElement(); //character
/** Character tab **/
$xml->XMLWriter()->startElement('characterTab');
$xml->XMLWriter()->startElement('talentSpecs');
$talent_data = $characters->CalculateCharacterTalents();
$current_tree = array();
$activeSpec = $characters->GetActiveSpec();
if($talent_data && is_array($talent_data)) {
    $specCount = $characters->GetSpecCount();
    for($i=0;$i<$specCount;$i++) {
        $current_tree[$i] = Utils::GetMaxArray($talent_data['points'][$i]);
        $talent_spec[$i] = array(
            'group' => $i+1,
            'icon'  => $characters->ReturnTalentTreeIcon($current_tree[$i]),
            'prim'  => $characters->ReturnTalentTreesNames($current_tree[$i]),
            'treeOne' => $talent_data['points'][$i][$characters->GetTalentTab(0)],
            'treeTwo' => $talent_data['points'][$i][$characters->GetTalentTab(1)],
            'treeThree' => $talent_data['points'][$i][$characters->GetTalentTab(2)]
        );    
        if($activeSpec == $i) {
            $talent_spec[$i]['active'] = 1;
        }
    }
    foreach($talent_spec as $m_spec) {
        $xml->XMLWriter()->startElement('talentSpec');
        foreach($m_spec as $spec_key => $spec_value) {
            $xml->XMLWriter()->writeAttribute($spec_key, $spec_value);
        }
        $xml->XMLWriter()->endElement(); //talentSpec
    }
}
else {
    $talent_spec = array(
        'group' => 1,
        'icon' => 'ability_seal',
        'prim' => null,
        'treeOne' => 0,
        'treeTwo' => 0,
        'treeThree' => 0
    );
    $xml->XMLWriter()->startElement('talentSpec');
    foreach($talent_spec as $spec_key => $spec_value) {
        $xml->XMLWriter()->writeAttribute($spec_key, $spec_value);
    }
    $xml->XMLWriter()->endElement(); //talentSpec
}
$xml->XMLWriter()->endElement();  //talentSpecs
/* Character professions */
$xml->XMLWriter()->startElement('professions');
$character_professions = $characters->extractCharacterProfessions();
if($character_professions) {
    foreach($character_professions as $char_professions) {
        $xml->XMLWriter()->startElement('skill');
        foreach($char_professions as $profs_elem_name => $profs_elem_value) {
            $xml->XMLWriter()->writeAttribute($profs_elem_name, $profs_elem_value);
        }
        $xml->XMLWriter()->endElement(); //skill
    }
}
$xml->XMLWriter()->endElement(); //professions
/* Character bars */
$xml->XMLWriter()->startElement('characterBars');
$xml->XMLWriter()->startElement('health');
$xml->XMLWriter()->writeAttribute('effective', $characters->GetMaxHealth());
$xml->XMLWriter()->endElement(); //health
$xml->XMLWriter()->startElement('secondBar');
$second_bar = $characters->GetSecondBar();
foreach($second_bar as $sb_elem_name => $sb_elem_value) {
    $xml->XMLWriter()->writeAttribute($sb_elem_name, $sb_elem_value);
}
$xml->XMLWriter()->endElement();  //secondbar
$xml->XMLWriter()->endElement(); //characterBars
/** Character stats **/
/* Base stats */
$xml->XMLWriter()->startElement('baseStats');
$base_stats = array('strength', 'agility', 'stamina', 'intellect', 'spirit', 'armor');
foreach($base_stats as $stat) {
    $xml->XMLWriter()->startElement($stat);
    $player_stat = $characters->GetCharacterStat($stat);
    if($player_stat) {
        foreach($player_stat as $stat_name => $stat_value) {
            $xml->XMLWriter()->writeAttribute($stat_name, $stat_value);
        }
    }
    $xml->XMLWriter()->endElement(); //<$stat>
}
$xml->XMLWriter()->endElement(); //baseStats
/* Resistance stats */
$xml->XMLWriter()->startElement('resistances');
$resistance_stats = array('arcane', 'fire', 'frost', 'holy', 'nature', 'shadow');
foreach($resistance_stats as $stat) {
    $xml->XMLWriter()->startElement($stat);
    $xml->XMLWriter()->writeAttribute('petBonus', -1);
    $xml->XMLWriter()->writeAttribute('value', 0);
    $xml->XMLWriter()->endElement();
}
$xml->XMLWriter()->endElement(); //resistances
/* Melee stats */
$xml->XMLWriter()->startElement('melee');
$melee_stats = array('mainHandDamage', 'offHandDamage', 'mainHandSpeed', 'offHandSpeed', 'power', 'hitRating', 'critChance', 'expertise');
foreach($melee_stats as $stat) {
    $xml->XMLWriter()->startElement($stat);
    $player_stat = $characters->GetCharacterStat($stat);
    if($player_stat) {
        foreach($player_stat as $stat_name => $stat_value) {
            $xml->XMLWriter()->writeAttribute($stat_name, $stat_value);
        }
    }
    $xml->XMLWriter()->endElement();
}
$xml->XMLWriter()->endElement(); //melee
/* Ranged stats */
$xml->XMLWriter()->startElement('ranged');
$ranged_stats = array('weaponSkill', 'damage', 'speed', 'power', 'hitRating', 'critChance');
foreach($ranged_stats as $stat) {
    $xml->XMLWriter()->startElement($stat);
    $player_stat = $characters->GetCharacterStat($stat, 1);
    if($player_stat) {
        foreach($player_stat as $stat_name => $stat_value) {
            $xml->XMLWriter()->writeAttribute($stat_name, $stat_value);
        }
    }
    $xml->XMLWriter()->endElement();
}
$xml->XMLWriter()->endElement(); //ranged
/* Spell stats */
$xml->XMLWriter()->startElement('spell');
$spells_stats_tw = array('bonusDamage', 'critChance');
$bonus_damage = array('arcane', 'fire', 'frost', 'holy', 'nature', 'shadow', 'petBonus');
$pet_defined = false;
$pet_closed  = 0;
foreach($spells_stats_tw as $stat_tw) {
    $xml->XMLWriter()->startElement($stat_tw);
    $player_stat_tw = $characters->GetCharacterStat($stat_tw, 2);
    if($player_stat_tw) {
        foreach($player_stat_tw as $stat_name_tw => $stat_value_tw) {
            if($stat_tw == 'critChance') {
                $xml->XMLWriter()->writeAttribute('rating', $stat_value_tw);
            }
            if($stat_tw == 'bonusDamage' && ($stat_name_tw == 'attack' || $stat_name_tw == 'damage' || $stat_name_tw == 'fromType')) {
                if(!$pet_defined) {
                    $xml->XMLWriter()->startElement('petBonus');
                    $pet_defined = true;
                }
                $xml->XMLWriter()->writeAttribute($stat_name_tw, $stat_value_tw);
                $pet_closed++;
                if($pet_closed == 3) {
                    $xml->XMLWriter()->endElement();
                    $pet_closed = 0;
                }
            }
            else {
                $xml->XMLWriter()->startElement($stat_name_tw);
                $xml->XMLWriter()->writeAttribute(($stat_tw == 'bonusDamage') ? 'value' : 'percent', $stat_value_tw);
                $xml->XMLWriter()->endElement();
            }
        }
    }
    $xml->XMLWriter()->endElement();
}
$spells_stats = array('bonusHealing', 'hitRating', 'penetration', 'manaRegen', 'hasteRating');
foreach($spells_stats as $stat) {
    $xml->XMLWriter()->startElement($stat);
    $player_stat = $characters->GetCharacterStat($stat, 2);
    if($player_stat) {
        foreach($player_stat as $stat_name => $stat_value) {
            $xml->XMLWriter()->writeAttribute($stat_name, $stat_value);
        }
    }
    $xml->XMLWriter()->endElement();
}
$xml->XMLWriter()->endElement(); //spell
/* Defence stats */
$xml->XMLWriter()->startElement('defenses');
$defense_stats = array('armor', 'defense', 'dodge', 'parry', 'block', 'resilience');
foreach($defense_stats as $stat) {
    $xml->XMLWriter()->startElement($stat);
    $player_stat = $characters->GetCharacterStat($stat, 1);
    if($player_stat) {
        foreach($player_stat as $stat_name => $stat_value) {
            $xml->XMLWriter()->writeAttribute($stat_name, $stat_value);
        }
    }
    $xml->XMLWriter()->endElement();
}
$xml->XMLWriter()->endElement(); //defense
/** Character items **/
$xml->XMLWriter()->startElement('items');
$gear_array = array(
    array('slot' => 'head', 'slotid'     => INV_HEAD),
    array('slot' => 'neck', 'slotid'     => INV_NECK),
    array('slot' => 'shoulder', 'slotid' => INV_SHOULDER),
    array('slot' => 'shirt', 'slotid'    => INV_SHIRT),
    array('slot' => 'chest', 'slotid'    => INV_CHEST),
    array('slot' => 'wrist', 'slotid'    => INV_BRACERS),
    array('slot' => 'legs', 'slotid'     => INV_LEGS),
    array('slot' => 'boots', 'slotid'    => INV_BOOTS),
    array('slot' => 'belt', 'slotid'     => INV_BELT),
    array('slot' => 'gloves', 'slotid'   => INV_GLOVES),
    array('slot' => 'ring1', 'slotid'    => INV_RING_1),
    array('slot' => 'ring2', 'slotid'    => INV_RING_2),
    array('slot' => 'trinket1', 'slotid' => INV_TRINKET_1),
    array('slot' => 'trinket2', 'slotid' => INV_TRINKET_2),
    array('slot' => 'back', 'slotid'     => INV_BACK),
    array('slot' => 'mainhand', 'slotid' => INV_MAIN_HAND),
    array('slot' => 'offhand', 'slotid'  => INV_OFF_HAND),
    array('slot' => 'relic', 'slotid'    => INV_RANGED_RELIC),
    array('slot' => 'tabard', 'slotid'   => INV_TABARD),
);
foreach($gear_array as $gear) {
    $item_info = $characters->GetCharacterItemInfo($gear);
    if($item_info && is_array($item_info)) {
        $xml->XMLWriter()->startElement('item');
        foreach($item_info as $iteminfo_key => $iteminfo_value) {
            $xml->XMLWriter()->writeAttribute($iteminfo_key, $iteminfo_value);
        }
        $xml->XMLWriter()->endElement(); //item
    }
}
$xml->XMLWriter()->endElement();  //items
$xml->XMLWriter()->endElement(); //characterTab
$xml->XMLWriter()->startElement('summary');
$xml->XMLWriter()->endElement();   //summary
$xml->XMLWriter()->endElement();  //characterInfo
$xml->XMLWriter()->endElement(); //page
$xml_cache_data = $xml->StopXML();
echo $xml_cache_data;
if($armory->armoryconfig['useCache'] == true && !isset($_GET['skipCache'])) {
    // Write cache to file
    $cache_data = $utils->GenerateCacheData($characters->GetName(), $characters->GetGUID(), 'character-sheet');
    $cache_handler = $utils->WriteCache($cache_id, $cache_data, $xml_cache_data);
}
exit;
?>