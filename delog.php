<?php
/**
 * Page de déconnexion de l'application
 * 
 * Déconnecte l'utilisateur en nettoyant la session, affiche un message de confirmation
 * et redirige vers la page d'accueil.
 * 
 * @package TD3
 * @author Kime Marwa
 * @since 2 novembre 2025
 * @version 1.0
 */

// Démarrage de la session si elle n'est pas déjà démarrée
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Nettoyage des valeurs de session (garde la session active mais vide les données)
session_unset();

// Ajout d'un message de confirmation à afficher après redirection
$_SESSION['mesgs']['confirm'][] = 'Vous avez été correctement déconnecté';

// Redirection vers la page d'accueil
header('Location: index.php');
exit; // Arrêt de l'exécution du script après redirection