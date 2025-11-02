<?php
/**
 * Delete controller for a enseignant
 * 
 * Manages the deletion of a teacher by its ID. Checks the existence of the teacher,
 * deletes the teacher and the associated user, then redirects to the list
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

// Retrieval of the teacher identifier to delete
$id = isset($_REQUEST['id']) ? (int)$_REQUEST['id'] : 0;

// Verification of ID validity
if ($id <= 0) {
    $_SESSION['mesgs']['errors'][] = 'Invalid identifier for deletion.';
    header("Location: index.php?element=enseignants&action=list");
    exit;
}

try {
    // Retrieval of the teacher to delete
    $ens = Enseignant::fetch($id);

    if ($ens) {
        // Deletion of the teacher and the associated user
        $ens->delete();
        $_SESSION['mesgs']['confirm'][] = 'Teacher deleted successfully.';
    } else {
        $_SESSION['mesgs']['errors'][] = 'Teacher not found.';
    }
} catch (Exception $e) {
    // Error handling during deletion
    $_SESSION['mesgs']['errors'][] = "Error during deletion: " . $e->getMessage();
}

// Redirect to list of teachers
header("Location: index.php?element=enseignants&action=list");
exit;
