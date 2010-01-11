<?php

/**
 * @package World of Warcraft Armory
 * @version Release Candidate 1
 * @revision 30
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


/**
 * Smarty plugin
 * @package Smarty
 * @subpackage plugins
 */

/**
 * Smarty {get_wow_class} function plugin
 *
 * Type:     function<br>
 * Name:     get_wow_class<br>
 * Purpose:  returns class name
 * @author Shadez (ShadezMe@gmail.com)
 * @param array Format:
 * <pre>
 * array('class' => required race ID)
 * </pre>
 * @param Smarty
 */

function smarty_function_get_wow_class($params, &$smarty)
{
    return $smarty->get_config_vars('string_class_'.$params['class']);
}
?>