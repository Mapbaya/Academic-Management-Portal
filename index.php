<?php
/**
 * Main entry point of the TD3 application
 * 
 * This file initializes the application by loading the necessary libraries
 * and enabling error display in development mode. It then loads
 * the main file that manages the MVC structure of the project.
 * 
 * @package TD3
 * @author Kime Marwa
 * @since November 2, 2025
 * @version 1.0
 */

// Load project libraries
require_once(dirname(__FILE__) . '/lib/security.lib.php');
require_once(dirname(__FILE__) . '/lib/myproject.lib.php');

// Enable PHP error display (development mode only)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Load the main core of the project (MVC structure)
include dirname(__FILE__) . '/main.inc.php';
