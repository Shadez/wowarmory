<?php

/**
 * @package World of Warcraft Armory
 * @version Release Candidate 1
 * @revision 302
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

if(isset($_GET['clearLog'])) {
    @file_put_contents('tmp.dbg', null);
    header('Location: index.php');
}
echo '<html><head><title>WoWArmory Debug Log</title></head><body><a href="?clearLog">Clear log</a><br /><hr />';
if(@include('../../includes/classes/configuration.php')) {
    @include('../../includes/revision_nr.php');
    echo sprintf("<strong>Armory revision:</strong> %d<br />
    <strong>DB Version:</strong> %s<br />
    Configuration values are:<br />
    <strong>ArmoryConfig['settings']['siteCharset']</strong> = %s<br />
    <strong>ArmoryConfig['settings']['configVersion']</strong> = %d<br />
    <strong>ArmoryConfig['settings']['useCache']</strong> = %s<br />
    <strong>ArmoryConfig['settings']['cache_lifetime']</strong> = %d<br />
    <strong>ArmoryConfig['settings']['minlevel']</strong> = %d<br />
    <strong>ArmoryConfig['settings']['minGmLevelToShow']</strong> = %d<br />
    <strong>ArmoryConfig['settings']['defaultLocale']</strong> = %s<br />
    <strong>ArmoryConfig['settings']['useDebug']</strong> = %s<br />
    <strong>ArmoryConfig['settings']['logLevel']</strong> = %d<br /><br /><strong>Mulitrealm info:</strong> <br />
    ",
    ARMORY_REVISION,
    DB_VERSION,
    $ArmoryConfig['settings']['siteCharset'],
    $ArmoryConfig['settings']['configVersion'],
    ($ArmoryConfig['settings']['useCache'] == true) ? 'true' : 'false',
    $ArmoryConfig['settings']['cache_lifetime'],
    $ArmoryConfig['settings']['minlevel'],
    $ArmoryConfig['settings']['minGmLevelToShow'],
    $ArmoryConfig['settings']['defaultLocale'],
    ($ArmoryConfig['settings']['useDebug'] == true) ? 'true' : 'false',
    $ArmoryConfig['settings']['logLevel']    
    );
    if(is_array($ArmoryConfig['multiRealm'])) {
        foreach($ArmoryConfig['multiRealm'] as $realm_info) {
            echo sprintf('Realm <strong>ID</strong>: %d, <strong>name</strong>: %s, <strong>type</strong>: %s<br />', $realm_info['id'], $realm_info['name'], $realm_info['type']);
        }
    }
    echo '<br /><strong>Log</strong>:<br /><br />';
}
@include('tmp.dbg');
echo '</body></html>';
?>