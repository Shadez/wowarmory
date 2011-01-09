<?php

/**
 * @package World of Warcraft Armory
 * @version Release 4.50
 * @revision 450
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
$loginError = '';
$passwordError = '';
$logout = '';
if(isset($_POST['accountName']) && !isset($_SESSION['accountId'])) {
    $utils->username = $_POST['accountName'];
    $utils->password = $_POST['password'];
    if(!$utils->username && !$utils->password) {
        $loginError = 1;
        $passwordError = 1;
    }
    elseif(!$utils->username) {
        $loginError = 1;
    }
    elseif(!$utils->password) {
        $passwordError = 1;
    }
    elseif(!$utils->AuthUser()) {
        $passwordError = 2;
    }
    else {
        if(!isset($_GET['ref'])) {
            header('Location: index.xml');
        }
        else {
            header('Location: ' . $_GET['ref']);
        }
    }
}
elseif(isset($_GET['logoff']) && isset($_SESSION['accountId'])) {
    $loginError = '';
    $passwordError = '';
    $utils->CloseSession();
    $logout = '1';
}
elseif(isset($_SESSION['accountId'])) {
    if(isset($_GET['ref'])) {
        header('Location: ' . $_GET['ref']);
    }
    else {
        header('Location: index.xml');
    }
}
$xml->LoadXSLT('login.xsl');
$xml->XMLWriter()->startElement('page');
$xml->XMLWriter()->writeAttribute('globalSearch', 1);
$xml->XMLWriter()->writeAttribute('lang', Armory::GetLocale());
$xml->XMLWriter()->writeAttribute('requestUrl', 'login.xml');
$xml->XMLWriter()->writeAttribute('loginError', $loginError);
$xml->XMLWriter()->writeAttribute('passwordError', $passwordError);
$xml->XMLWriter()->writeAttribute('username', $utils->username);
$xml->XMLWriter()->writeAttribute('logout', $logout);
$xml->XMLWriter()->endElement(); //page
echo $xml->StopXML();
exit;
?>