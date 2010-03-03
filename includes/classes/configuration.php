<?php

/**
 * @package World of Warcraft Armory
 * @version Release Candidate 1
 * @revision 101
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

$ArmoryConfig = array();
/* Armory Database configuration */
$ArmoryConfig['mysql']['host_armory']     = 'localhost';
$ArmoryConfig['mysql']['user_armory']     = 'root';
$ArmoryConfig['mysql']['pass_armory']     = '';
$ArmoryConfig['mysql']['name_armory']     = 'armory';
$ArmoryConfig['mysql']['charset_armory']  = 'UTF8';

/* Characters Database configuration */
$ArmoryConfig['mysql']['host_characters']     = 'localhost';
$ArmoryConfig['mysql']['user_characters']     = 'root';
$ArmoryConfig['mysql']['pass_characters']     = '';
$ArmoryConfig['mysql']['name_characters']     = 'characters';
$ArmoryConfig['mysql']['charset_characters']  = 'UTF8';

/* Accounts (realmd) Database configuration */
$ArmoryConfig['mysql']['host_realmd']         = 'localhost';
$ArmoryConfig['mysql']['user_realmd']         = 'root';
$ArmoryConfig['mysql']['pass_realmd']         = '';
$ArmoryConfig['mysql']['name_realmd']         = 'realmd';
$ArmoryConfig['mysql']['charset_realmd']      = 'UTF8';

/* World (mangos) Database configuration */
$ArmoryConfig['mysql']['host_mangos']         = 'localhost';
$ArmoryConfig['mysql']['user_mangos']         = 'root';
$ArmoryConfig['mysql']['pass_mangos']         = '';
$ArmoryConfig['mysql']['name_mangos']         = 'mangos';
$ArmoryConfig['mysql']['charset_mangos']      = 'UTF8';

/* Armory Settings */
$ArmoryConfig['settings']['server_version']   = '332'; // '322' or '332', without dots or something else
$ArmoryConfig['settings']['siteCharset']      = 'utf-8';
$ArmoryConfig['settings']['useNews']          = false;
$ArmoryConfig['settings']['defaultRealmId']   = 1;
$ArmoryConfig['settings']['defaultRealmName'] = 'MaNGOS';
$ArmoryConfig['settings']['useCache']         = false;
$ArmoryConfig['settings']['cache_lifetime']   = 2;  // In days
$ArmoryConfig['settings']['minlevel']         = 10; // Character must have this level or higher to be shown in Armory
$ArmoryConfig['settings']['minGmLevelToShow'] = 3;  // Show characters : 0 - only players, 1 - moderators, 2 - GMs, 3 - everyone
$ArmoryConfig['settings']['defaultLocale']    = 'ru_ru'; // Can be 'ru_ru' or 'en_gb'

/* 
    This is STRONGLY IMPORTANT parameter if you want to 3D Model Viewer work! 
    Write here FULL URL to you armory (without slash in the end)
    for example:

$ArmoryConfig['settings']['modelserver']      = 'http://my-super-wow-server.com/armory';

    OR

$ArmoryConfig['settings']['modelserver']      = 'http://armory.my-super-wow-server.com';
*/
$ArmoryConfig['settings']['modelserver']      = 'http://armory';    
?>