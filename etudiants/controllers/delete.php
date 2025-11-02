<?php
/**
 * Delete controller d'un étudiant
 * 
 * Manages la suppression d'un étudiant par son ID. Checks l'existence de l'étudiant,
 * supprime l'étudiant et associated user, puis redirige vers la liste
 * with a confirmation or error message.
 * 
 * @package TD3
 * @subpackage Controllers
 * @author Kime Marwa
 * @since November 2, 2025
 * @version 1.0
 */
if (session_status() !== PHP_SESSION_ACTIVE) session_start();

require_once dirname(__FILE__) . '/../../class/etudiant.class.php';

// Retrieval de l'ID de l'étudiant à supprimer
$id = isset($_REQUEST['id']) ? (int)$_REQUEST['id'] : 0;
if ($id <= 0) {
    $_SESSION['mesgs']['errors'][] = 'Identifiant invalide pour suppression.';
    header('Location: index.php?element=etudiants&action=list');
    exit;
}

// Verification de l'existence de l'étudiant
$etu = Etudiant::fetch($id);
if (!$etu) {
    $_SESSION['mesgs']['errors'][] = 'Étudiant introuvable.';
    header('Location: index.php?element=etudiants&action=list');
    exit;
}

try {
    // Also deletes associated user by default (parameter true)
    $etu->delete(true);
    $_SESSION['mesgs']['confirm'][] = 'Étudiant supprimé.';
} catch (Exception $e) {
    $_SESSION['mesgs']['errors'][] = 'Erreur lors de la suppression : ' . $e->getMessage();
}

header('Location: index.php?element=etudiants&action=list');
exit;
