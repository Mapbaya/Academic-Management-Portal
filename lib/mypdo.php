<?php
/**
 * Gestionnaire de connexion PDO à la base de données
 * 
 * Ce fichier charge la configuration de la base de données depuis le fichier .env,
 * établit une connexion PDO et retourne l'instance de connexion.
 * Les erreurs de configuration ou de connexion sont stockées dans la session.
 * 
 * @package TD3
 * @subpackage Lib
 * @author Kime Marwa
 * @since 2 novembre 2025
 * @version 1.0
 * 
 * @return PDO|null Instance PDO de connexion à la base de données, ou null en cas d'erreur
 */

if (session_status() === PHP_SESSION_NONE){
    session_start();
}

// Autoloader
require_once(dirname(__FILE__) . '/../vendor/autoload.php');

/**
 * Charge les variables d'environnement depuis le fichier .env
 * 
 * Utilise la bibliothèque vlucas/phpdotenv pour charger les variables
 * d'environnement depuis le fichier .env situé à la racine du projet.
 * Ces variables contiennent les informations de connexion à la base de données.
 * 
 * @author Kime Marwa
 * @since 2 novembre 2025
 */
$dotenv = Dotenv\Dotenv::createImmutable(dirname(__FILE__) . '/../');
$dotenv->load();

// Récupération des informations présentes dans le fichier de conf .env
$db_host = $_ENV['DB_HOST'];
$db_name = $_ENV['DB_NAME'];
$db_port = $_ENV['DB_PORT'];
$db_username = $_ENV['DB_USER'];
$db_password = $_ENV['DB_PASS'];

/**
 * Vérifie que toutes les variables de configuration sont présentes
 * 
 * Si une variable de configuration est manquante, un message d'erreur
 * est ajouté à la session pour affichage à l'utilisateur.
 * 
 * @author Kime Marwa
 * @since 2 novembre 2025
 */
if (
    empty($db_host)
    || empty($db_name)
    || empty($db_username)
    || empty($db_password)
) {
    $_SESSION['mesgs']['errors'][] = 'ERREUR Configuration: les informations n\'ont pas pu être chargées.';
}

// ouverture de la connexion
$dsn = "mysql:host=$db_host;port=$db_port;dbname=$db_name";
$db_options = array();

/**
 * Tente d'établir la connexion PDO à la base de données
 * 
 * Crée une nouvelle instance PDO avec les paramètres de connexion.
 * En cas d'échec, un message d'erreur est stocké dans la session et
 * la variable $db est définie à null.
 * 
 * @return void
 * @throws PDOException Si la connexion à la base de données échoue
 * @author Kime Marwa
 * @since 2 novembre 2025
 */
try {
    $db = new PDO($dsn, $db_username, $db_password, $db_options);
} catch (PDOException $e) {
    $db = null;
    $_SESSION['mesgs']['errors'][] = 'ERREUR Base de données: ' . $e->getMessage();
}
return $db;
