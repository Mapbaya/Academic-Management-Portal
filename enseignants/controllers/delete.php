<?php
/**
 * Delete controller d'un enseignant
 * 
 * Manages la suppression d'un enseignant par son ID. Vérifie l'existence de l'enseignant,
 * supprime l'enseignant et associated user, puis redirige vers la liste
 * with a confirmation or error message.
 * 
 * @package TD3
 * @subpackage Controllers
 * @author Kime Marwa
 * @since 2 novembre 2025
 * @version 1.0
 */
require_once dirname(__FILE__) . '/../../class/enseignant.class.php';

// Démarrage de la session si nécessaire
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

// Retrieval de l'identifiant de l'enseignant à supprimer
$id = isset($_REQUEST['id']) ? (int)$_REQUEST['id'] : 0;

// Verification of validity de l'ID
if ($id <= 0) {
    $_SESSION['mesgs']['errors'][] = 'Identifiant invalide pour suppression.';
    header("Location: index.php?element=enseignants&action=list");
    exit;
}

try {
    // Retrieval de l'enseignant à supprimer
    $ens = Enseignant::fetch($id);

    if ($ens) {
        // Suppression de l'enseignant et de associated user
        $ens->delete();
        $_SESSION['mesgs']['confirm'][] = 'Enseignant supprimé avec succès.';
    } else {
        $_SESSION['mesgs']['errors'][] = 'Enseignant introuvable.';
    }
} catch (Exception $e) {
    // Gestion de l'erreur lors de la suppression
    $_SESSION['mesgs']['errors'][] = "Erreur lors de la suppression : " . $e->getMessage();
}

// Redirection vers la liste des enseignants
header("Location: index.php?element=enseignants&action=list");
exit;
