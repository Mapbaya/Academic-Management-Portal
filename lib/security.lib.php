<?php
/**
 * Bibliothèque de sécurité et d'authentification
 * 
 * Ce fichier vérifie l'authentification de l'utilisateur et redirige vers
 * la page de connexion si l'utilisateur n'est pas authentifié.
 * 
 * @package TD3
 * @subpackage Lib
 * @author Kime Marwa
 * @since 2 novembre 2025
 * @version 1.0
 */

session_start(); // Démarrage de la session
error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING);
require_once(dirname(__FILE__) . '/../class/myAuthClass.php');

/**
 * Variable globale indiquant si l'utilisateur est authentifié
 * 
 * Cette variable est utilisée dans toute l'application pour vérifier
 * si l'utilisateur actuel a les droits d'accès.
 * 
 * @var bool true si l'utilisateur est authentifié, false sinon
 * @author Kime Marwa
 * @since 2 novembre 2025
 */
$authorized = myAuthClass::is_auth($_SESSION);

if (!$authorized) {
    include dirname(__FILE__).'/../login.php';
    exit(1);
}
