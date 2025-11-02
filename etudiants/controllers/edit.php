<?php
/**
 * Edit controller for a student
 * 
 * Manages the modification of an existing student. Retrieves the student by its ID,
 * validates and updates form data, then redirects to the list
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
require_once dirname(__FILE__) . '/../../lib/myproject.lib.php';

$error = '';
$etu = null;

// ID in GET required to identify the student to modify
$id = isset($_REQUEST['id']) ? (int)$_REQUEST['id'] : 0;
if ($id <= 0) {
    $_SESSION['mesgs']['errors'][] = 'Invalid identifier.';
    header('Location: index.php?element=etudiants&action=list');
    exit;
}

// Retrieval of the student to modify
$etu = Etudiant::fetch($id);
if (!$etu) {
    $_SESSION['mesgs']['errors'][] = 'Student not found.';
    header('Location: index.php?element=etudiants&action=list');
    exit;
}

// Processing of form submission (update)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // Update student properties
        $etu->numetu = $_POST['numetu'] ?? $etu->numetu;
        $etu->firstname = !empty($_POST['firstname']) ? capitalizeName($_POST['firstname']) : $etu->firstname;
        $etu->lastname = !empty($_POST['lastname']) ? capitalizeName($_POST['lastname']) : $etu->lastname;
        $etu->birthday = $_POST['birthday'] ?? $etu->birthday;
        $etu->diploma = $_POST['diploma'] ?? $etu->diploma;
        $etu->year = !empty($_POST['year']) ? (int)$_POST['year'] : $etu->year;
        $etu->td = $_POST['td'] ?? $etu->td;
        $etu->tp = $_POST['tp'] ?? $etu->tp;
        $etu->adress = $_POST['adress'] ?? $etu->adress;
        $etu->zipcode = $_POST['zipcode'] ?? $etu->zipcode;
        $etu->town = !empty($_POST['town']) ? capitalizeName($_POST['town']) : $etu->town;

        $etu->update();

        // Standardized confirmation message
        $_SESSION['mesgs']['confirm'][] = 'Student updated successfully.';
        header('Location: index.php?element=etudiants&action=list');
        exit;
    } catch (Exception $e) {
        $error = 'Error during update: ' . $e->getMessage();
        $_SESSION['mesgs']['errors'][] = $error;
    }
}
