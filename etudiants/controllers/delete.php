<?php
/**
 * Delete controller for a student
 * 
 * Manages the deletion of a student by its ID. Checks the existence of the student,
 * deletes the student and the associated user, then redirects to the list
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

// Retrieval of the student ID to delete
$id = isset($_REQUEST['id']) ? (int)$_REQUEST['id'] : 0;
if ($id <= 0) {
    $_SESSION['mesgs']['errors'][] = 'Invalid identifier for deletion.';
    header('Location: index.php?element=etudiants&action=list');
    exit;
}

// Verification of student existence
$etu = Etudiant::fetch($id);
if (!$etu) {
    $_SESSION['mesgs']['errors'][] = 'Student not found.';
    header('Location: index.php?element=etudiants&action=list');
    exit;
}

try {
    // Also deletes the associated user by default (parameter true)
    $etu->delete(true);
    $_SESSION['mesgs']['confirm'][] = 'Student deleted.';
} catch (Exception $e) {
    $_SESSION['mesgs']['errors'][] = 'Error during deletion: ' . $e->getMessage();
}

header('Location: index.php?element=etudiants&action=list');
exit;
