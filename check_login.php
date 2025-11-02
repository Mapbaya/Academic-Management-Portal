<?php
/**
 * Vérification de l'authentification utilisateur
 * 
 * Ce fichier gère la vérification des identifiants de connexion.
 * Il utilise la classe myAuthClass pour authentifier l'utilisateur et
 * crée une session si l'authentification réussit.
 * 
 * @package TD3
 * @author Kime Marwa
 * @since 2 novembre 2025
 * @version 1.0
 */
session_start();

/**
 * Configuration de l'affichage des erreurs
 * 
 * Active l'affichage des erreurs en mode développement.
 * Les avertissements et notices sont masqués pour une meilleure lisibilité.
 * 
 * @author Kime Marwa
 * @since 2 novembre 2025
 */
error_reporting(E_ALL & ~E_WARNING & ~E_NOTICE);
require_once(dirname(__FILE__) . '/lib/myproject.lib.php');

/**
 * Active l'affichage des erreurs si le paramètre debug est présent
 * 
 * Permet d'activer un mode debug plus détaillé si le paramètre GET/POST
 * 'debug' est présent et égal à true.
 * 
 * @author Kime Marwa
 * @since 2 novembre 2025
 */
if (GETPOST('debug') == true) {
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
}

require_once(dirname(__FILE__) . '/class/myAuthClass.php');

/**
 * Traite la soumission du formulaire de connexion
 * 
 * Récupère les identifiants depuis le formulaire, vérifie leur validité
 * avec la classe myAuthClass et crée une session utilisateur si l'authentification réussit.
 * En cas d'échec, un message d'erreur est ajouté à la session.
 * 
 * @author Kime Marwa
 * @since 2 novembre 2025
 */
if (isset($_POST['connect'])) {
    $uname = $_POST['uname'];
    $psw = $_POST['psw'];
    
    /**
     * Authentifie l'utilisateur avec le nom d'utilisateur et le mot de passe
     * 
     * @var array<string, mixed>|false $user Informations de l'utilisateur authentifié
     *                                         (rowid, username, firstname, lastname) ou false si échec
     */
    $user = myAuthClass::authenticate($uname, $psw);
    
    if ($user && isset($user["rowid"]) && $user["rowid"] > 0) {
        $_SESSION['mesgs']['confirm'][] = 'Connexion réussie ' . $user['username'];
        $_SESSION['login'] = $user['username'];
        $_SESSION['user'] = $user;
    } else {
        $_SESSION['mesgs']['errors'][] = 'Identification impossible';
    }
}

/**
 * Redirige vers la page d'accueil après traitement
 * 
 * Redirige l'utilisateur vers la page d'accueil (index.php) après avoir traité
 * la tentative de connexion, que celle-ci ait réussi ou échoué.
 * 
 * @author Kime Marwa
 * @since 2 novembre 2025
 */
header('Location:index.php');
