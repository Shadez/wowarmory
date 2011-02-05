<?php

/**
 * @package World of Warcraft Armory
 * @version Release 4.50
 * @revision 468
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
if(Armory::$armoryconfig['useCache'] == true && !isset($_GET['skipCache'])) {
    $cache_id = $utils->GenerateCacheId('achievement-firsts', Armory::$currentRealmInfo['name']);
    if($cache_data = $utils->GetCache($cache_id)) {
        echo $cache_data;
        echo sprintf('<!-- Restored from cache; id: %s -->', $cache_id);
        exit;
    }
}
// Load XSLT template
$xml->LoadXSLT('serverfirsts.xsl');
$xml->XMLWriter()->startElement('page');
$xml->XMLWriter()->writeAttribute('globalSearch', 1);
$xml->XMLWriter()->writeAttribute('lang', Armory::GetLocale());
$xml->XMLWriter()->writeAttribute('requestUrl', 'achievement-firsts.xml');
$realmName = (isset($_GET['r'])) ? urldecode($_GET['r']) : Armory::$currentRealmInfo['name'];
$isRealm = $utils->IsRealm($realmName);
if($isRealm) {
    Armory::Log()->writeLog('achievement-firsts.php : realm %s defined', $realmName);
    $xml->XMLWriter()->startElement('realmInfo');
    $xml->XMLWriter()->writeAttribute('realm', $realmName);
    // Get achievements
    $achievement_firsts = $utils->GetRealmFirsts();
    
    if(is_array($achievement_firsts)) {
        foreach($achievement_firsts as $achievement_info) {
            $xml->XMLWriter()->startElement('achievement');
            foreach($achievement_info as $ach_key => $ach_value) {
                if($ach_key != 'characters') {
                    $xml->XMLWriter()->writeAttribute($ach_key, $ach_value);
                }
                else {
                    if(isset($ach_value[0])) {
                        // Non-guilded players.
                        foreach($ach_value[0] as $player) {
                            $xml->XMLWriter()->startElement('character');
                            foreach($player as $player_key => $player_value) {
                                $xml->XMLWriter()->writeAttribute($player_key, $player_value);
                            }
                            $xml->XMLWriter()->endElement(); //character
                        }
                    }
                    else {
                        // Only guilded players.
                        foreach($ach_value as $guild) {
                            $xml->XMLWriter()->startElement('guild');
                            $xml->XMLWriter()->writeAttribute('count', count($guild));
                            $xml->XMLWriter()->writeAttribute('guildUrl', $guild[0]['guildUrl']);
                            $xml->XMLWriter()->writeAttribute('name', $guild[0]['guild']);
                            $xml->XMLWriter()->writeAttribute('realm', $guild[0]['realm']);
                            foreach($guild as $member) {
                                $xml->XMLWriter()->startElement('character');
                                foreach($member as $member_key => $member_value) {
                                    $xml->XMLWriter()->writeAttribute($member_key, $member_value);
                                }
                                $xml->XMLWriter()->endElement(); //character
                            }
                            $xml->XMLWriter()->endElement(); //guild
                        }
                    }
                }
            }
            $xml->XMLWriter()->endElement(); //achievement
        }
    }
    else {
        Armory::Log()->writeError('achievement-firsts.php : achievement_firsts variable must be in array!');
    }
    $xml->XMLWriter()->endElement();  //realmInfo
}
else {
    Armory::Log()->writeLog('Unable to find any achievement firsts');
    $xml->XMLWriter()->startElement('error');
    $xml->XMLWriter()->writeAttribute('errCode', 'noData');
    $xml->XMLWriter()->endElement(); //error
}
$xml->XMLWriter()->endElement(); //page
$xml_cache_data = $xml->StopXML();
echo $xml_cache_data;
if(Armory::$armoryconfig['useCache'] == true && !isset($_GET['skipCache'])) {
    // Write cache to file
    $cache_data = $utils->GenerateCacheData(0, 0, 'achievement-firsts');
    $cache_handler = $utils->WriteCache($cache_id, $cache_data, $xml_cache_data);
}
exit;
?>