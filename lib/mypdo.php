<?php
/**
 * PDO database connection handler
 * 
 * This file loads database configuration from the .env file,
 * establishes a PDO connection and returns the connection instance.
 * Configuration or connection errors are stored in the session.
 * 
 * @package TD3
 * @subpackage Lib
 * @author Kime Marwa
 * @since November 2, 2025
 * @version 1.0
 * 
 * @return PDO|null PDO database connection instance, or null on error
 */

if (session_status() === PHP_SESSION_NONE){
    session_start();
}

// Autoloader
require_once(dirname(__FILE__) . '/../vendor/autoload.php');

/**
 * Loads environment variables from the .env file
 * 
 * Uses the vlucas/phpdotenv library to load environment
 * variables from the .env file located at the project root.
 * These variables contain database connection information.
 * 
 * @author Kime Marwa
 * @since November 2, 2025
 */
$dotenv = Dotenv\Dotenv::createImmutable(dirname(__FILE__) . '/../');
$dotenv->load();

// Retrieve information from the .env configuration file
$db_host = $_ENV['DB_HOST'];
$db_name = $_ENV['DB_NAME'];
$db_port = $_ENV['DB_PORT'];
$db_username = $_ENV['DB_USER'];
$db_password = $_ENV['DB_PASS'];

/**
 * Verifies that all configuration variables are present
 * 
 * If a configuration variable is missing, an error message
 * is added to the session for user display.
 * 
 * @author Kime Marwa
 * @since November 2, 2025
 */
if (
    empty($db_host)
    || empty($db_name)
    || empty($db_username)
    || empty($db_password)
) {
    $_SESSION['mesgs']['errors'][] = 'ERROR Configuration: information could not be loaded.';
}

// Open connection
$dsn = "mysql:host=$db_host;port=$db_port;dbname=$db_name";
$db_options = array();

/**
 * Attempts to establish PDO connection to the database
 * 
 * Creates a new PDO instance with connection parameters.
 * On failure, an error message is stored in the session and
 * the $db variable is set to null.
 * 
 * @return void
 * @throws PDOException If database connection fails
 * @author Kime Marwa
 * @since November 2, 2025
 */
try {
    $db = new PDO($dsn, $db_username, $db_password, $db_options);
} catch (PDOException $e) {
    $db = null;
    $_SESSION['mesgs']['errors'][] = 'ERROR Database: ' . $e->getMessage();
}
return $db;
