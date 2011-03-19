<?php

/**
 * @package World of Warcraft Armory
 * @version Release 4.50
 * @revision 467
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

if(!defined('__ARMORY__')) {
    die('Direct access to this file not allowed!');
}

Class Template {
    private static $is_initialized = false;
    private static $page_index = null;
    private static $page_data = array();
    private static $main_menu = array();
    private static $carousel_data = array();
    private static $menu_index = null;
    private static $template_theme = null;
    private static $template_locale = array();
    
    public static function InitializeTemplate() {
        
    }
    
    public static function LoadLocale($locale) {
        if(!@include(__ARMORYDIRECTORY__ . '/includes/locales/admin_locale_' . $locale . '.php')) {
            die('Unable to load locale ' . $locale . ': file does not exists!');
        }
        self::$template_locale = $ArmoryAdminLocale;
        return true;
    }
    
    public static function GetString($string) {
        if(!is_array(self::$template_locale)) {
            Armory::Log()->writeError('%s : unable to find localization for string "%s": locale storage is empty!', __METHOD__, $string);
            return $string;
        }
        if(!isset(self::$template_locale[$string])) {
            Armory::Log()->writeError('%s : string "%s" was not found in locale storage!', __METHOD__, $string);
            return $string;
        }
        return self::$template_locale[$string];
    }
    
    public static function SetTemplateTheme($theme) {
        self::$template_theme = $theme;
    }
    
    public static function GetTemplateTheme() {
        return self::$template_theme != null ? self::$template_theme : 'overall';
    }
    
    public static function LoadTemplate($template_name, $overall = false) {
        if($overall) {
            $template = __ARMORYDIRECTORY__ . '/admin/template/overall/overall_' . $template_name . '.php';
        }
        else {
            $template = __ARMORYDIRECTORY__ . '/admin/template/' . $template_name . '.php';
        }
        if(file_exists($template)) {
            include($template);
        }
        else {
            Armory::Log()->writeError('%s : unable to find template "%s" (template theme: %s, overall: %d, path: %s)!', __METHOD__, $template_name, self::GetTemplateTheme(), (int) $overall, $template);
        }
    }
    
    public static function GetPageIndex() {
        return self::$page_index;
    }
    
    public static function SetPageIndex($index) {
        self::$page_index = $index;
    }
    
    public static function GetPageData($index) {
        return (isset(self::$page_data[$index])) ? self::$page_data[$index] : null;
    }
    
    public static function SetPageData($index, $data) {
        self::$page_data[$index] = $data;
    }
    
    public static function AddToPageData($index, $data) {
        if(!isset(self::$page_data[$index])) {
            return true;
        }
        self::$page_data[$index] .= $data;
    }
}
?>