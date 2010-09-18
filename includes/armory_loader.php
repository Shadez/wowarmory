<?php

/**
 * @package World of Warcraft Armory
 * @version Release Candidate 1
 * @revision 392
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

if(!defined('__ARMORY__')) {
    die('Direct access to this file not allowed!');
}
session_start();
if(!@include('classes/class.armory.php')) {
    die('<b>Error:</b> unable to load Armory class!');
}
if(!@include('revision_nr.php')) {
    die('<b>Error:</b> unable to load revision_nr.php!');
}
$_SESSION['last_url'] = str_replace('.php', '.xml', $_SERVER['PHP_SELF']) . '?' .str_replace('locale=', 'l=', $_SERVER['QUERY_STRING']);
$armory = new Armory();
/* Check DbVersion */
$dbVersion = $armory->aDB->selectCell("SELECT `version` FROM `ARMORYDBPREFIX_db_version`");
if($dbVersion != DB_VERSION) {
    if(!$dbVersion) {
        if(isset($armory->armoryconfig['checkVersionType']) && $armory->armoryconfig['checkVersionType'] == 'log') {
            $armory->Log()->writeError('ArmoryChecker: wrong Armory DB name!');
        }
        else {
            echo '<b>Fatal error</b>: wrong Armory DB name<br/>';
        }
    }
    $errorDBVersion = sprintf('Current version is %s but expected %s.<br />
    Apply all neccessary updates from \'sql/updates\' folder and refresh this page.', ($dbVersion) ? "'" . $dbVersion . "'" : 'not defined', "'" . DB_VERSION . "'");
    if(isset($armory->armoryconfig['checkVersionType']) && $armory->armoryconfig['checkVersionType'] == 'log') {
        $armory->Log()->writeError('ArmoryChecker : DB_VERSION error: %s', (defined('DB_VERSION')) ? $errorDBVersion : 'DB_VERSION constant not defined!');
    }
    else {
        echo '<b>DB_VERSION error</b>:<br />';
        if(!defined('DB_VERSION')) {
            die('DB_VERSION constant not defined!');
        }
        die($errorDBVersion);
    }
}
/* Check revision */
if(!defined('ARMORY_REVISION')) {
    if(isset($armory->armoryconfig['checkVersionType']) && $armory->armoryconfig['checkVersionType'] == 'log') {
        $armory->Log()->writeError('ArmoryChecker : unable to detect Armroy revision!');
    }
    else {
        die('<b>Revision error:</b> unable to detect Armory revision!');
    }
}
/* Check config version */
if(!defined('CONFIG_VERSION') || !isset($armory->armoryconfig['configVersion'])) {
    if(isset($armory->armoryconfig['checkVersionType']) && $armory->armoryconfig['checkVersionType'] == 'log') {
        $armory->Log()->writeError('ArmoryChecker : unable to detect Configuration version!');
    }
    else {
        die('<b>ConfigVersion error:</b> unable to detect Configuration version!');
    }
}
elseif(CONFIG_VERSION != $armory->armoryconfig['configVersion']) {
    $CfgError = sprintf('<b>ConfigVersion error:</b> your config version is outdated (current: %d, expected: %d).<br />
    Please, update your config file from configuration.php.default', $armory->armoryconfig['configVersion'], CONFIG_VERSION);
    if(isset($armory->armoryconfig['checkVersionType']) && $armory->armoryconfig['checkVersionType'] == 'log') {
        $armory->Log()->writeError('ArmoryChecker : %s', $CfgError);
    }
    else {
        die($CfgError);
    }
}
error_reporting(E_ALL);
/* Check maintenance */
if($armory->armoryconfig['maintenance'] == true && !defined('MAINTENANCE_PAGE')) {
    header('Location: maintenance.xml');
}
if(!@include('UpdateFields.php')) {
    die('<b>Error:</b> unable to load UpdateFields.php!');
}
if(!@include('defines.php')) {
    die('<b>Error:</b> unable to load defines.php!');
}
if(!defined('skip_utils_class')) {
    if(!@include('classes/class.utils.php')) {
        die('<b>Error:</b> unable to load utils class!');
    }
    $utils = new Utils($armory);
    /** 
     * Check realm data
     * This will automaticaly add missing realms to `armory_realm_data` table (if MySQL user have "INSERT" access to Armory database)
     **/
    $utils->CheckConfigRealmData();
}
/** Login **/
if(isset($_GET['login']) && $_GET['login'] == 1) {
    header('Location: login.xml');
}
elseif(isset($_GET['logout']) && $_GET['logout'] == 1) {
    header('Location: login.xml?logoff');
}

/** Locale change **/
if(isset($_GET['locale'])) {
    $tmp = strtolower($_GET['locale']);
    $_SESSION['armoryLocaleId'] = $armory->GetLoc();
    switch($tmp) {
        case 'ru_ru':
        case 'ruru':
        case 'ru':
            $_SESSION['armoryLocale'] = 'ru_ru';
            $_SESSION['armoryLocaleId'] = 8;
            break;
        case 'en_gb':
        case 'engb':
        case 'en':
            $_SESSION['armoryLocale'] = 'en_gb';
            $_SESSION['armoryLocaleId'] = 0;
            break;
        case 'es_es':
        case 'es_mx':
        case 'eses':
        case 'es':
            $_SESSION['armoryLocale'] = 'es_es';
            $_SESSION['armoryLocaleId'] = 6;
            break;
        case 'de_de':
        case 'dede':
        case 'de':
            $_SESSION['armoryLocale'] = 'de_de';
            $_SESSION['armoryLocaleId'] = 3;
            break;
        case 'fr_fr':
        case 'frfr':
        case 'fr':
            $_SESSION['armoryLocale'] = 'fr_fr';
            $_SESSION['armoryLocaleId'] = 2;
            break;
        case 'en_us':
        case 'enus':
            $_SESSION['armoryLocale'] = 'en_us';
            $_SESSION['armoryLocaleId'] = 0;
            break;
    }
    $_locale = (isset($_SESSION['armoryLocale'])) ? $_SESSION['armoryLocale'] : $armory->GetLocale();
    $armory->SetLocale($_locale, $_SESSION['armoryLocaleId']);
    if(isset($_SERVER['HTTP_REFERER'])) {
        $returnUrl = $_SERVER['HTTP_REFERER'];
    }
    else {
        $returnUrl = $_SESSION['last_url'];
    }
    header('Location: ' . $returnUrl);
}
$_locale = (isset($_SESSION['armoryLocale'])) ? $_SESSION['armoryLocale'] : $armory->GetLocale();
if(defined('load_characters_class')) {
    if(!@include('classes/class.characters.php')) {
        die('<b>Error:</b> unable to load characters class!');
    }
    $characters = new Characters($armory);
}
if(defined('load_guilds_class')) {
    if(!@include('classes/class.guilds.php')) {
        die('<b>Error:</b> unable to load guilds class!');
    }
    $guilds = new Guilds($armory);
}
if(defined('load_achievements_class')) {
    if(!@include('classes/class.achievements.php')) {
        die('<b>Error:</b> unable to load achievements class!');
    }
    // Do not create class instance here. It should be created in Characters::GetAchievementMgr().
}
if(defined('load_items_class')) {
    if(!@include('classes/class.items.php')) {
        die('<b>Error:</b> unable to load items class!');
    }
    $items = new Items($armory);
}
if(defined('load_mangos_class')) {
    if(!@include('classes/class.mangos.php')) {
        die('<b>Error:</b> unable to load Mangos class!');
    }
    $mangos = new Mangos($armory);
}
if(defined('load_arenateams_class')) {
    if(!@include('classes/class.arenateams.php')) {
        die('<b>Error:</b> unable to load arenateams class!');
    }
    $arenateams = new Arenateams($armory);
}
if(defined('load_search_class')) {
    if(!@include('classes/class.search.php')) {
        die('<b>Error:</b> unable to load search engine class!');
    }
    $search = new SearchMgr($armory);
}
if(defined('load_itemprototype_class')) {
    if(!@include('classes/class.itemprototype.php')) {
        die('<b>Error:</b> unable to load ItemPrototype Class!');
    }
    // Do not create class instance here. It should be created in Characters or Items classes.
}
if(defined('load_item_class')) {
    if(!@include('classes/class.item.php')) {
        die('<b>Error:</b> unable to load Item Class!');
    }
    // Do not create class instance here. It should be created in Characters or Items classes.
}
// Start XML parser
if(!@include('classes/class.xmlhandler.php')) {
    die('<b>Error:</b> unable to load XML handler class!');
}
$xml = new XMLHandler($armory->GetLocale());
$xml->StartXML();
?>