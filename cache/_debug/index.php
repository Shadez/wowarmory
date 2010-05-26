<?php

/**
 * @package World of Warcraft Armory
 * @version Release Candidate 1
 * @revision 210
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

if(isset($_GET['clearLog'])) {
    @file_put_contents('tmp.dbg', null);
    header('Location: index.php');
}
echo '<html><head><title>WoWArmory Debug Log</title></head><body><a href="?clearLog">Clear log</a><br /><hr />';
@include('tmp.dbg');
echo '</body></html>';
?>