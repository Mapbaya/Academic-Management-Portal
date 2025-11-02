<?php
/**
 * Application logout page
 * 
 * Logs out the user by clearing the session, displays a confirmation message
 * and redirects to the home page.
 * 
 * @package TD3
 * @author Kime Marwa
 * @since November 2, 2025
 * @version 1.0
 */

// Start session if not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Clear session values (keeps session active but clears data)
session_unset();

// Add confirmation message to display after redirect
$_SESSION['mesgs']['confirm'][] = 'You have been successfully logged out';

// Redirect to home page
header('Location: index.php');
exit; // Stop script execution after redirect