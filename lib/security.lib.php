<?php
/**
 * Security and authentication library
 * 
 * This file verifies user authentication and redirects to
 * the login page if the user is not authenticated.
 * 
 * @package TD3
 * @subpackage Lib
 * @author Kime Marwa
 * @since November 2, 2025
 * @version 1.0
 */

session_start(); // Start session
error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING);
require_once(dirname(__FILE__) . '/../class/myAuthClass.php');

/**
 * Global variable indicating if the user is authenticated
 * 
 * This variable is used throughout the application to verify
 * if the current user has access rights.
 * 
 * @var bool true if the user is authenticated, false otherwise
 * @author Kime Marwa
 * @since November 2, 2025
 */
$authorized = myAuthClass::is_auth($_SESSION);

if (!$authorized) {
    include dirname(__FILE__).'/../login.php';
    exit(1);
}
