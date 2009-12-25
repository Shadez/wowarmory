<?php

/**
 * @package World of Warcraft Armory
 * @version Release Candidate 1
 * @revision 36
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

define('__ARMORY__', true);
if(!@include('includes/armory_loader.php')) {
    die('<b>Fatal error:</b> can not load main system files!');
}
$armory->tpl->assign('addCssSheet', '@import "_css/int.css";');

$className = $_GET['c'];
$classId   = (int) $_GET['cid'];
$petId     = (int) $_GET['pid'];
if(isset($petId)) {
    $armory->tpl->assign('openTree', $petId);
    $tpl2include = 'talent_calc_pet_'.$_locale;
}
elseif(isset($classId)) {
    switch($classId) {
        case 1:
            $subtab = 'tab_1';
            $tpl2include = 'talent_calc_warrior_'.$_locale;
            break;
        case 2:
            $subtab = 'tab_2';
            $tpl2include = 'talent_calc_paladin_'.$_locale;
            break;
        case 3:
            $subtab = 'tab_3';
            $tpl2include = 'talent_calc_hunter_'.$_locale;
            break;
        case 4:
            $subtab = 'tab_4';
            $tpl2include = 'talent_calc_rogue_'.$_locale;
            break;
        case 5:
            $subtab = 'tab_5';
            $tpl2include = 'talent_calc_priest_'.$_locale;
            break;
        case 6:
            $subtab = 'tab_6';
            $tpl2include = 'talent_calc_dk_'.$_locale;
            break;
        case 7:
            $subtab = 'tab_7';
            $tpl2include = 'talent_calc_shaman_'.$_locale;
            break;
        case 8:
            $subtab = 'tab_8';
            $tpl2include = 'talent_calc_mage_'.$_locale;
            break;
        case 9:
            $subtab = 'tab_9';
            $tpl2include = 'talent_calc_warlock_'.$_locale;
            break;
        case 11:
            $subtab = 'tab_11';
            $tpl2include = 'talent_calc_druid_'.$_locale;
            break;
        default:
            $subtab = 'tab_6';
            $tpl2include = 'talent_calc_dk_'.$_locale;
            break;
    }
}
elseif(isset($className)) {
    switch($className) {
        case 'Warrior':
            $subtab = 'tab_1';
            $tpl2include = 'talent_calc_warrior_'.$_locale;
            break;
        case 'Paladin':
            $subtab = 'tab_2';
            $tpl2include = 'talent_calc_paladin_'.$_locale;
            break;
        case 'Hunter':
            $subtab = 'tab_3';
            $tpl2include = 'talent_calc_hunter_'.$_locale;
            break;
        case 'Rogue':
            $subtab = 'tab_4';
            $tpl2include = 'talent_calc_rogue_'.$_locale;
            break;
        case 'Priest':
            $subtab = 'tab_5';
            $tpl2include = 'talent_calc_priest_'.$_locale;
            break;
        case 'Death Knight':
            $subtab = 'tab_6';
            $tpl2include = 'talent_calc_dk_'.$_locale;
            break;
        case 'Shaman':
            $subtab = 'tab_7';
            $tpl2include = 'talent_calc_shaman_'.$_locale;
            break;
        case 'Mage':
            $subtab = 'tab_8';
            $tpl2include = 'talent_calc_mage_'.$_locale;
            break;
        case 'Warlock':
            $subtab = 'tab_9';
            $tpl2include = 'talent_calc_warlock_'.$_locale;
            break;
        case 'Druid':
            $subtab = 'tab_11';
            $tpl2include = 'talent_calc_druid_'.$_locale;
            break;
        default:
            $subtab = 'tab_6';
            $tpl2include = 'talent_calc_dk_'.$_locale;
            break;
    }
}
else {
    $subtab = 'tab_6';
    $tpl2include = 'talent_calc_dk_'.$_locale;
}
if(isset($_GET['tal'])) {
    $armory->tpl->assign('talentTree', $_GET['tal']);
}
if(isset($petId)) {
    $armory->tpl->assign('tpl2include', $tpl2include);
}
else {
    $armory->tpl->assign('tpl2includecalc', $tpl2include);
    $armory->tpl->assign('tpl2include', 'talent_calc_start');
}
$armory->tpl->assign($subtab, 'selected-subTab');
$armory->tpl->display('overall_header.tpl');
$armory->tpl->display('overall_start.tpl');
exit();
?>