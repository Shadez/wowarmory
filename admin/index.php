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

define('__ARMORY__', true);
define('ADMIN_PAGE', true);
if(!@include('../includes/armory_loader.php')) {
    die('<b>Fatal error:</b> unable to load system files.');
}
if(isset($_GET['logout'])) {
    Admin::PerformLogout();
    header('Location: .');
    exit;
}
if(isset($_POST['username']) && isset($_POST['password'])) {
    $username = $_POST['username']; // No SQL Injection
    $password = $_POST['password']; // No SQL Injection
    Admin::PerformLogin($username, $password);
}
Template::SetPageData('action',    isset($_GET['action'])    ? $_GET['action']    : 'index');
Template::SetPageData('subaction', isset($_GET['subaction']) ? $_GET['subaction'] : null);
switch(Template::GetPageData('action')) {
    case 'news':
        switch(Template::GetPageData('subaction')) {
            case 'edit':
                if(isset($_POST['date'])) {
                    $_POST['id'] = $_POST['newsid'];
                    Template::SetPageData('news_result', Utils::AddNewsItem($_POST, true));
                }
                else {
                    if(isset($_GET['itemid'])) {
                        Template::SetPageData('news_item', Utils::GetArmoryNews(false, $_GET['itemid']));
                    }
                }
                break;
            case 'add':
                if(isset($_POST['date'])) {
                    $_POST['id'] = $_POST['newsid'];
                    Template::SetPageData('news_result', Utils::AddNewsItem($_POST));
                }
                else {
                    Template::SetPageData('news_item', Utils::GetArmoryNews(0, 0, true));
                }
                break;
        }
        break;
    case 'config':
        switch(Template::GetPageData('subaction')) {
            case 'edit':
                if(isset($_POST['subm'])) {
                    Admin::UpdateConfigFile($_POST);
                    header('Location: ?action=config');
                    exit;
                }
                break;
            case 'addrealm':
                if(isset($_POST['subm'])) {
                    Admin::AddNewRealm($_POST);
                }
                break;
        }
        break;
    case 'accounts':
        Template::SetPageData('page', isset($_GET['page']) ? (int) $_GET['page'] : 1);
        switch(Template::GetPageData('subaction')) {
            default:
                Template::SetPageData('sortby', isset($_GET['sortby']) ? in_array($_GET['sortby'], array('id', 'username', 'gmlevel')) ? $_GET['sortby'] : 'username' : 'username');
                Template::SetPageData('sorttype', isset($_GET['sorttype']) ? in_array(strtoupper($_GET['sorttype']), array('ASC', 'DESC')) ? $_GET['sorttype'] : 'ASC' : 'ASC');
                if(isset($_POST['searchAccount'])) {
                    $searchAccount = $_POST['searchAccount'];
                }
                else {
                    $searchAccount = null;
                }
                switch(Template::GetPageData('sortby')) {
                    case 'username':
                    case 'gmlevel':
                        Template::SetPageData('accounts_list', Admin::GetAccountsList(Template::GetPageData('page'), Template::GetPageData('sortby'), Template::GetPageData('sorttype'), $searchAccount));
                    break;
                }
                break;
            case 'edit':
                Template::SetPageData('accountid', isset($_GET['accountid']) ? $_GET['accountid'] : 0);
                if(isset($_POST['subm'])) {
                    Admin::UpdateAccount($_POST);
                }
                break;
            case 'delete':
                if(!isset($_GET['accountid'])) {
                    $accid = 0;
                }
                else {
                    $accid = (int) $_GET['accountid'];
                }
                Admin::DeleteAccount($accid);
                header('Location: ?action=accounts');
                exit;
                break;
        }
        break;
}
if(!Admin::IsLoggedIn()) {
    Template::LoadTemplate('page_login');
}
else {
    Template::LoadTemplate('page_index');
}
?>