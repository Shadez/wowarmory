<?php

/**
 * @package World of Warcraft Armory
 * @version Release Candidate 1
 * @revision 30
 * @copyright (c) 2009 Shadez  
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
error_reporting(0);
if(!@include('classes/class.connector.php')) {
    die('<b>Error:</b> can not load connector class!');
}

$armory = new Connector;

$armory->tpl->template_dir    = 'includes/template/';
$armory->tpl->compile_dir     = 'includes/cache/';
$armory->tpl->config_dir      = 'includes/locales/';
$armory->tpl->left_delimiter  = '{{'; // remove JS brackets conflict
$armory->tpl->right_delimiter = '}}'; // remove JS brackets conflict

include('defines.php');
include('UpdateFields.php');
include('classes/class.utils.php');
$utils = new Utils;

/** Login **/
/*if(isset($_GET['login']) && $_GET['login'] == 1) {
    header('Location: login.xml?rrid=' . rand());
}*/

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
    header('Location: '.($_SERVER['HTTP_REFERER'] ? $_SERVER['HTTP_REFERER'] : '.'));
}
$_locale = (isset($_SESSION['armoryLocale'])) ? $_SESSION['armoryLocale'] : $armory->armoryconfig['defaultLocale'];
$armory->_locale = $_locale;
$armory->tpl->assign('menu_file', 'overall_menu_'.$_locale);
$armory->tpl->config_load($_locale . '.conf' );

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
?>