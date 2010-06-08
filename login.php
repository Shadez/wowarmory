<?php

/**
 * @package World of Warcraft Armory
 * @version Release Candidate 1
 * @revision 235
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

define('__ARMORY__', true);
if(!@include('includes/armory_loader.php')) {
    die('<b>Fatal error:</b> unable to load system files.');
}
$strings = array(
    'ru_ru' => array(
        'login_title' => 'Авторизация учетной записи World of Warcraft',
        'jquery_processing' => 'Выполняется',
        'username_label' => 'Имя пользователя WoW',
        'password_label' => 'Пароль',
        'auth_button'   => 'Авторизация',
        'return_to_armory' => 'Вернуться в Оружейную',
        'error_username' => '<div class="errorTooltip"><div class="tooltipBg"><p>Необходимо указать имя пользователя.<br /></p><div class="arrow"></div></div></div>',
        'error_password' => '<div class="errorTooltip"><div class="tooltipBg"><p>Необходимо указать пароль.<br /></p><div class="arrow"></div></div></div>',
        'error_incorrect_password' => '<div class="errorTooltip"><div class="tooltipBg"><p>Пароль недействителен.<br /></p><div class="arrow"></div></div></div>'
    ),
    'en_gb' => array(
        'login_title' => 'World of Warcraft Account Login',
        'jquery_processing' => 'Processing',
        'username_label' => 'WoW Account Name',
        'password_label' => 'Password',
        'auth_button'   => 'Log In',
        'return_to_armory' => 'Back to Armory',
        'error_username' => '<div class="errorTooltip"><div class="tooltipBg"><p>Account name required.<br /></p><div class="arrow"></div></div></div>',
        'error_password' => '<div class="errorTooltip"><div class="tooltipBg"><p>Password required.<br /></p><div class="arrow"></div></div></div>',
        'error_incorrect_password' => '<div class="errorTooltip"><div class="tooltipBg"><p>Password invalid.<br /></p><div class="arrow"></div></div></div>'
    ),
    'de_de' => array(
        'login_title' => 'World of Warcraft Account - Anmeldung',
        'jquery_processing' => 'In Bearbeitung',
        'username_label' => 'WoW-Accountname',
        'password_label' => 'Passwort',
        'auth_button'   => 'Anmeldung',
        'return_to_armory' => 'Back to Armory',
        'error_username' => '<div class="errorTooltip"><div class="tooltipBg"><p>Accountname ben&ouml;tigt.<br /></p><div class="arrow"></div></div></div>',
        'error_password' => '<div class="errorTooltip"><div class="tooltipBg"><p>Passwort ben&ouml;tigt.<br /></p><div class="arrow"></div></div></div>',
        'error_incorrect_password' => '<div class="errorTooltip"><div class="tooltipBg"><p>Ung&uuml;ltiges Passwort.<br /></p><div class="arrow"></div></div></div>'
    ),
    'fr_fr' => array(
        'login_title' => 'Identifiant de compte World of Warcraft',
        'jquery_processing' => 'Connexion en cours...',
        'username_label' => 'Compte WoW',
        'password_label' => 'Mot de passe',
        'auth_button'   => 'Se connecter',
        'return_to_armory' => 'Back to Armory',
        'error_username' => '<div class="errorTooltip"><div class="tooltipBg"><p>Nom de compte requis.<br /></p><div class="arrow"></div></div></div>',
        'error_password' => '<div class="errorTooltip"><div class="tooltipBg"><p>Mot de passe requis.<br /></p><div class="arrow"></div></div></div>',
        'error_incorrect_password' => '<div class="errorTooltip"><div class="tooltipBg"><p>Mot de passe invalide.<br /></p><div class="arrow"></div></div></div>'
    ),
    'es_es' => array(
        'login_title' => 'Inicia sesi&oacute;n en tu cuenta de World of Warcraft',
        'jquery_processing' => 'En proceso',
        'username_label' => 'Cuenta de Wo',
        'password_label' => 'Contrase&ntilde;a',
        'auth_button'   => 'Iniciar sesi&oacute;n',
        'return_to_armory' => 'Back to Armory',
        'error_username' => '<div class="errorTooltip"><div class="tooltipBg"><p>El nombre de cuenta es obligatorio.<br /></p><div class="arrow"></div></div></div>',
        'error_password' => '<div class="errorTooltip"><div class="tooltipBg"><p>La contrase&ntilde;a es obligatoria.<br /></p><div class="arrow"></div></div></div>',
        'error_incorrect_password' => '<div class="errorTooltip"><div class="tooltipBg"><p>Contrase&ntilde;a no v&aacute;lida.<br /></p><div class="arrow"></div></div></div>'
    ),
    
);
ob_start();
if(!isset($strings[$armory->_locale])) {
    $strings[$armory->_locale] = $strings['ru_ru'];
}
$template = file_get_contents('includes/template/login-page.html');
foreach($strings[$armory->_locale] as $str_key => $str_value) {
    if($str_key != 'error_username' && $str_key != 'error_password') {
        $template = str_replace('<!-- [$'.$str_key.'] -->', $str_value, $template);
    }
}
if(isset($_POST['accountName'])) {
    $utils->username = $_POST['accountName'];
    $utils->password = $_POST['password'];
    if(!empty($utils->username) && !empty($utils->password)) {
        $template = str_replace('<!-- [$error_username] -->', '', $template);
        $template = str_replace('<!-- [$username] -->', $utils->username, $template);
        if($utils->authUser()) {
            if(!isset($_GET['ref'])) {
                header('Location: index.xml');
            }
            else {
                header('Location: ' . $_GET['ref']);
            }
        }
        else {
            $template = str_replace('<!-- [$username] -->', $utils->username, $template);
            $template = str_replace('<!-- [$error_password] -->', $strings[$armory->_locale]['error_incorrect_password'], $template);
        }
    }
    if(empty($utils->username)) {
        $template = str_replace('<!-- [$error_username] -->', $strings[$armory->_locale]['error_username'], $template);
        $template = str_replace('<!-- [$username] -->', '', $template);
    }
    if(empty($utils->password)) {
        $template = str_replace('<!-- [$username] -->', $utils->username, $template);
        $template = str_replace('<!-- [$error_password] -->', $strings[$armory->_locale]['error_password'], $template);
    }
}
else {
    $template = str_replace('<!-- [$username] -->', '', $template);
}
echo $template;
echo ob_flush();
ob_clean();
?>