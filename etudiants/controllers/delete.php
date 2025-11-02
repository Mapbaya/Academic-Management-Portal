<?php
/**
 * Delete controller for a étudiant
 * 
 * Manages the deletion for a étudiant by its ID. Checks l'existence de l'étudiant,
 * deletes l'étudiant et the associated user, then redirects vers the list
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

// Retrieval of l'ID de l'étudiant à deletesr
$id = isset($_REQUEST['id']) ? (int)$_REQUEST['id'] : 0;
if ($id <= 0) {
    $_SESSION['mesgs']['errors'][] = 'Invalid identifier for deletion.';
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
    // Also deletes the associated user by default (parameter true)
    $etu->delete(true);
    $_SESSION['mesgs']['confirm'][] = 'Étudiant supprimé.';
} catch (Exception $e) {
    $_SESSION['mesgs']['errors'][] = 'Erreur during deletion : ' . $e->getMessage();
}

header('Location: index.php?element=etudiants&action=list');
exit;
