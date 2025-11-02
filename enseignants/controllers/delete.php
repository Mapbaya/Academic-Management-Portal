<?php
/**
 * Delete controller for a enseignant
 * 
 * Manages the deletion for a enseignant by its ID. Checks the existence de l'enseignant,
 * deletes l'enseignant et the associated user, then redirects vers the list
 * with a confirmation or error message.
 * 
 * @package TD3
 * @subpackage Controllers
 * @author Kime Marwa
 * @since November 2, 2025
 * @version 1.0
 */
require_once dirname(__FILE__) . '/../../class/enseignant.class.php';

// Start session if necessary
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

// Retrieval of identifier de l'enseignant à deletesr
$id = isset($_REQUEST['id']) ? (int)$_REQUEST['id'] : 0;

// Verification of validity de l'ID
if ($id <= 0) {
    $_SESSION['mesgs']['errors'][] = 'Invalid identifier for deletion.';
    header("Location: index.php?element=enseignants&action=list");
    exit;
}

try {
    // Retrieval of l'enseignant à deletesr
    $ens = Enseignant::fetch($id);

    if ($ens) {
        // Deletion of l'enseignant et de the associated user
        $ens->delete();
        $_SESSION['mesgs']['confirm'][] = 'Teacher deleted successfully.';
    } else {
        $_SESSION['mesgs']['errors'][] = 'Teacher not found.';
    }
} catch (Exception $e) {
    // Error handling during deletion
    $_SESSION['mesgs']['errors'][] = "Erreur during deletion : " . $e->getMessage();
}

// Redirect to list of teachers
header("Location: index.php?element=enseignants&action=list");
exit;
