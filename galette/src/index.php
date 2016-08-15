<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4: */

/**
 * Main page and login
 *
 * PHP version 5
 *
 * Copyright © 2004-2014 The Galette Team
 *
 * This file is part of Galette (http://galette.tuxfamily.org).
 *
 * Galette is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * Galette is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with Galette. If not, see <http://www.gnu.org/licenses/>.
 *
 * @category  Main
 * @package   Galette
 *
 * @author    Frédéric Jaqcuot <unknown@unknow.com>
 * @author    Johan Cwiklinski <johan@x-tnd.be>
 * @copyright 2004-2014 The Galette Team
 * @license   http://www.gnu.org/licenses/gpl-3.0.html GPL License 3.0 or (at your option) any later version
 * @version   SVN: $Id$
 * @link      http://galette.tuxfamily.org
 */

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

/** @ignore */
require_once 'includes/galette.inc.php';
//fo default, there is no login error
$loginfault = false;

if ( isset($_GET['logout']) ) {
    $login->logOut();
    $session['login'] = null;
    unset($session['login']);
    $session['history'] = null;
    unset($session['history']);
}

if (isset($_GET["sso"])) {
	
	$ch = curl_init();
	
	$post = array();

	$userId = $_GET["userId"];
	
	$post["userId"] = $userId;
	$post["secret"] = $_GET["secret"];
	$post["application"] = "galette";
	
	$defaults = array(
			CURLOPT_POST => 1,
			CURLOPT_HEADER => 0,
//			CURLOPT_URL => "https://tools.partipirate.org/do_verify_sso.php",
			CURLOPT_URL => "http://172.17.0.1:97/do_verify_sso.php",
			CURLOPT_FRESH_CONNECT => 1,
			CURLOPT_RETURNTRANSFER => 1,
			CURLOPT_FORBID_REUSE => 1,
			CURLOPT_TIMEOUT => 4,
			CURLOPT_POSTFIELDS => http_build_query($post)
	);

//	print_r($defaults);
	
//	exit();
	
	curl_setopt_array($ch, $defaults);

	if( ! $result = curl_exec($ch)) 
    { 
//     	echo "<br>ERROR<br>";
//     	echo "<br>".curl_error($ch)."<br>";
    	trigger_error(curl_error($ch)); 
    } 
    else {
//    	echo "<br>OK<br>";
    }
    curl_close($ch); 

//    print_r($result);
	
    $data = json_decode($result, true);
    
    if (isset($data["ok"])) {
    	$login->logSso($userId);
    }

    if (isset($data["ok"]) &&  $login->isLogged()) {
    	$session['login'] = serialize($login);
    	$hist->add(_T("Login"));
    	/** FIXME: users should no try to go to admin interface */
    	if ( $login->isAdmin() || $login->isStaff() ) {
    		if ( !isset($_COOKIE['show_galette_dashboard'])
    				|| $_COOKIE['show_galette_dashboard'] == 1
    				) {
    					header('location: desktop.php');
    					die();
    				} else {
    					header('location: gestion_adherents.php');
    					die();
    				}
    	} else {
    		header('location: voir_adherent.php');
    		die();
    	}
    } else {
    	$loginfault = true;
    	$hist->add(_T("Authentication failed"), $_POST['login']);
    }
}

// Authentication procedure
if (isset($_POST['ident'])) {
    $pw_superadmin = false;
    if ( $_POST['login'] == $preferences->pref_admin_login ) {
        $pw_superadmin = password_verify(
            $_POST['password'],
            $preferences->pref_admin_pass
        );
        if ( !$pw_superadmin ) {
            $pw_superadmin = (
                md5($_POST['password']) === $preferences->pref_admin_pass
            );
        }
    }
    if ( $_POST['login'] == $preferences->pref_admin_login
        && $pw_superadmin
    ) {
        $login->logAdmin($_POST['login']);
        $session['login'] = serialize($login);
        $hist->add(_T("Login"));
        if ( !isset($_COOKIE['show_galette_dashboard'])
            || $_COOKIE['show_galette_dashboard'] == 1
        ) {
            header('location: desktop.php');
            die();
        } else {
            header('location: gestion_adherents.php');
            die();
        }
    } else {
        $login->logIn($_POST['login'], $_POST['password']);

        if ( $login->isLogged() ) {
            $session['login'] = serialize($login);
            $hist->add(_T("Login"));
            /** FIXME: users should no try to go to admin interface */
            if ( $login->isAdmin() || $login->isStaff() ) {
                if ( !isset($_COOKIE['show_galette_dashboard'])
                    || $_COOKIE['show_galette_dashboard'] == 1
                ) {
                    header('location: desktop.php');
                    die();
                } else {
                    header('location: gestion_adherents.php');
                    die();
                }
            } else {
                header('location: voir_adherent.php');
                die();
            }
        } else {
            $loginfault = true;
            $hist->add(_T("Authentication failed"), $_POST['login']);
        }
    }
}

if ( !$login->isLogged() ) {
    // display page
    $tpl->assign('loginfault', $loginfault);
    $content = $tpl->fetch('index.tpl');
    $tpl->assign('page_title', _T("Login"));
    $tpl->assign('content', $content);
    $tpl->display('public_page.tpl');
} else {
    if ( isset($profiler) ) {
        $profiler->stop();
    }

    if ( $login->isAdmin() || $login->isStaff() ) {
        header('location: gestion_adherents.php');
        die();
    } else {
        header('location: voir_adherent.php');
        die();
    }
}
