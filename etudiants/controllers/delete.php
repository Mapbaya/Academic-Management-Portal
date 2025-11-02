<?php
/**
 * Contrôleur de suppression d'un étudiant
 * 
 * Gère la suppression d'un étudiant par son ID. Vérifie l'existence de l'étudiant,
 * supprime l'étudiant et l'utilisateur associé, puis redirige vers la liste
 * avec un message de confirmation ou d'erreur.
 * 
 * @package TD3
 * @subpackage Controllers
 * @author Kime Marwa
 * @since 2 novembre 2025
 * @version 1.0
 */
if (session_status() !== PHP_SESSION_ACTIVE) session_start();

require_once dirname(__FILE__) . '/../../class/etudiant.class.php';

// Récupération de l'ID de l'étudiant à supprimer
$id = isset($_REQUEST['id']) ? (int)$_REQUEST['id'] : 0;
if ($id <= 0) {
    $_SESSION['mesgs']['errors'][] = 'Identifiant invalide pour suppression.';
    header('Location: index.php?element=etudiants&action=list');
    exit;
}

// Vérification de l'existence de l'étudiant
$etu = Etudiant::fetch($id);
if (!$etu) {
    $_SESSION['mesgs']['errors'][] = 'Étudiant introuvable.';
    header('Location: index.php?element=etudiants&action=list');
    exit;
}

try {
    // Supprime aussi l'utilisateur associé par défaut (paramètre true)
    $etu->delete(true);
    $_SESSION['mesgs']['confirm'][] = 'Étudiant supprimé.';
} catch (Exception $e) {
    $_SESSION['mesgs']['errors'][] = 'Erreur lors de la suppression : ' . $e->getMessage();
}

header('Location: index.php?element=etudiants&action=list');
exit;
