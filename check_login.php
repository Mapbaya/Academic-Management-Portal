<?php
/**
 * User authentication verification
 * 
 * This file handles login credentials verification.
 * It uses the myAuthClass class to authenticate the user and
 * creates a session if authentication succeeds.
 * 
 * @package TD3
 * @author Kime Marwa
 * @since November 2, 2025
 * @version 1.0
 */
session_start();

/**
 * Error display configuration
 * 
 * Enables error display in development mode.
 * Warnings and notices are hidden for better readability.
 * 
 * @author Kime Marwa
 * @since November 2, 2025
 */
error_reporting(E_ALL & ~E_WARNING & ~E_NOTICE);
require_once(dirname(__FILE__) . '/lib/myproject.lib.php');

/**
 * Enables error display if debug parameter is present
 * 
 * Allows activating a more detailed debug mode if the GET/POST
 * 'debug' parameter is present and equals true.
 * 
 * @author Kime Marwa
 * @since November 2, 2025
 */
if (GETPOST('debug') == true) {
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
}

require_once(dirname(__FILE__) . '/class/myAuthClass.php');

/**
 * Handles login form submission
 * 
 * Retrieves credentials from the form, verifies their validity
 * with the myAuthClass class and creates a user session if authentication succeeds.
 * On failure, an error message is added to the session.
 * 
 * @author Kime Marwa
 * @since November 2, 2025
 */
if (isset($_POST['connect'])) {
    $uname = $_POST['uname'];
    $psw = $_POST['psw'];
    
    /**
     * Authenticates the user with username and password
     * 
     * @var array<string, mixed>|false $user Authenticated user information
     *                                         (rowid, username, firstname, lastname) or false on failure
     */
    $user = myAuthClass::authenticate($uname, $psw);
    
    if ($user && isset($user["rowid"]) && $user["rowid"] > 0) {
        $_SESSION['mesgs']['confirm'][] = 'Login successful ' . $user['username'];
        $_SESSION['login'] = $user['username'];
        $_SESSION['user'] = $user;
    } else {
        $_SESSION['mesgs']['errors'][] = 'Authentication failed';
    }
}

/**
 * Redirects to home page after processing
 * 
 * Redirects the user to the home page (index.php) after processing
 * the login attempt, whether it succeeded or failed.
 * 
 * @author Kime Marwa
 * @since November 2, 2025
 */
header('Location:index.php');
