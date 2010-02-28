<?php

/**
 * @package World of Warcraft Armory
 * @version Release Candidate 1
 * @revision 94
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
error_reporting(E_ALL);
if(!@include('classes/class.connector.php')) {
    die('<b>Error:</b> can not load connector class!');
}

define('DB_VERSION', 'armory_r94');
$armory = new Connector;
$armory->tpl->template_dir    = 'includes/template/';
$armory->tpl->compile_dir     = 'includes/cache/';
$armory->tpl->config_dir      = 'includes/locales/';
$armory->tpl->left_delimiter  = '{';
$armory->tpl->right_delimiter = '}';

if($armory->armoryconfig['server_version']) {
    if(!@include('UpdateFields'.$armory->armoryconfig['server_version'].'.php')) {
        die('<b>Error:</b> can not load UpdateFields'.$armory->armoryconfig['server_version'].'.php.!');
    }
}
else {
    if(!@include('UpdateFields.php')) {
        die('<b>Error:</b> can not load UpdateFields.php!');
    }
}
if(!@include('defines.php')) {
    die('<b>Error:</b> can not load defines.php!');
}
if(!@include('classes/class.utils.php')) {
    die('<b>Error:</b> can not load utils class!');
}

$utils = new Utils;

/** Login **/
if(isset($_GET['login']) && $_GET['login'] == 1) {
    header('Location: login.xml');
}
elseif(isset($_GET['logout']) && $_GET['logout'] == 1) {
    $utils->logoffUser();
    header('Location: index.xml');
}
if(isset($_SESSION['wow_login'])) {
    $armory->tpl->assign('_wow_login', $_SESSION['username']);
    $armory->tpl->assign('realm', $armory->armoryconfig['defaultRealmName']);
    $armory->tpl->assign('myVaultCharacters', $utils->getCharsArray());
    $selectedVaultCharacter = $utils->getCharacter();
    if(!$selectedVaultCharacter) {
        $armory->tpl->assign('noCharacters', true);
    }
    else {
        $armory->tpl->assign('selectedVaultCharacter', $selectedVaultCharacter);
    }
    $character_bookmarks = $utils->getCharacterBookmarks();
    if($character_bookmarks) {
        $armory->tpl->assign('myVaultBookmarkCharacters', $character_bookmarks);
    }
    unset($selectedVaultCharacter);
    unset($character_bookmarks);
}
/** End login **/

if(isset($_GET['locale'])) {
    $tmp = strtolower($_GET['locale']);
    switch($tmp) {
        case 'ru_ru':
        case 'ruru':
            $_SESSION['armoryLocale'] = 'ru_ru';
            break;
        case 'en_gb':
        case 'engb':
            $_SESSION['armoryLocale'] = 'en_gb';
            break;
    }
    $_locale = (isset($_SESSION['armoryLocale'])) ? $_SESSION['armoryLocale'] : $armory->armoryconfig['defaultLocale'];
    $armory->_locale = $_locale;
    if(isset($_SERVER['HTTP_REFERER'])) {
        $returnUrl = $_SERVER['HTTP_REFERER'];
    }
    else {
        $returnUrl = '.';
    }
    header('Location: '.$returnUrl);
}
$_locale = (isset($_SESSION['armoryLocale'])) ? $_SESSION['armoryLocale'] : $armory->armoryconfig['defaultLocale'];
$armory->_locale = $_locale;
$armory->tpl->assign('menu_file', 'overall_menu_'.$_locale);
$armory->tpl->config_load($_locale . '.conf');

$tpl_config_vars = array (
    'siteCharset' => $armory->armoryconfig['siteCharset'],
    'locale'      => $_locale
);
$armory->tpl->assign('ArmoryConfig', $tpl_config_vars);
unset($tpl_config_vars);

if(defined('load_characters_class')) {
    if(!@include('classes/class.characters.php')) {
        die('<b>Error:</b> can not load characters class!');
    }
    $characters = new Characters;
}
if(defined('load_guilds_class')) {
    if(!@include('classes/class.guilds.php')) {
        die('<b>Error:</b> can not load guilds class!');
    }
    $guilds = new Guilds;
}
if(defined('load_achievements_class')) {
    if(!@include('classes/class.achievements.php')) {
        die('<b>Error:</b> can not load achievements class!');
    }
    $achievements = new Achievements;
}
if(defined('load_items_class')) {
    if(!@include('classes/class.items.php')) {
        die('<b>Error:</b> can not load items class!');
    }
    $items = new Items;
}
if(defined('load_mangos_class')) {
    if(!@include('classes/class.mangos.php')) {
        die('<b>Error:</b> can not load Mangos class!');
    }
    $mangos = new Mangos;
}
if(defined('load_arenateams_class')) {
    if(!@include('classes/class.arenateams.php')) {
        die('<b>Error:</b> can not load arenateams class!');
    }
    $arenateams = new Arenateams;
}
if(defined('load_search_class')) {
    if(!@include('classes/class.search.php')) {
        die('<b>Error:</b> can not load search engine class!');
    }
    $search = new SearchMgr;
}

$dbVersion = $armory->aDB->selectCell("SELECT `version` FROM `armory_db_version`");
if($dbVersion != DB_VERSION) {
    $armory->ArmoryError('DbVersion Error', sprintf($armory->tpl->get_config_vars('armory_dbversion_error'), $dbVersion, DB_VERSION));
}
?>