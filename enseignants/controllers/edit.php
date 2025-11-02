<?php
/**
 * Edit controller for a teacher
 * 
 * Manages the modification of an existing teacher. Retrieves the teacher by its ID,
 * validates and updates form data, then redirects to the list
 * with a confirmation or error message.
 * 
 * @package TD3
 * @subpackage Controllers
 * @author Kime Marwa
 * @since November 2, 2025
 * @version 1.0
 */
require_once dirname(__FILE__) . '/../../class/enseignant.class.php';
require_once dirname(__FILE__) . '/../../lib/myproject.lib.php';

/**
 * Variable to store error messages
 * 
 * @var string Possible error message
 */
$error = '';

/**
 * Variable to store the teacher object
 * 
 * @var Enseignant|null Teacher object to modify
 */
$ens = null;

/**
 * Verification of the presence of ID in the URL
 */
if (!isset($_GET['id'])) {
    die('Missing ID.');
}

try {
    /**
     * Retrieves the teacher by its identifier
     * 
     * @param int|string $_GET['id'] Identifier of the teacher
     */
    $ens = Enseignant::fetch($_GET['id']);
    if (!$ens) {
        die('Teacher not found.');
    }

    /**
     * Processing of form submission for modification
     */
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        /**
         * Updates the properties of the teacher with form data
         * Names, first names and cities are automatically capitalized
         */
        $ens->firstname = !empty($_POST['firstname']) ? capitalizeName($_POST['firstname']) : $ens->firstname;
        $ens->lastname  = !empty($_POST['lastname']) ? capitalizeName($_POST['lastname']) : $ens->lastname;
        $ens->birthday  = $_POST['birthday'] ?? $ens->birthday;
        $ens->adress    = $_POST['adress'] ?? $ens->adress;
        $ens->zipcode   = $_POST['zipcode'] ?? $ens->zipcode;
        $ens->town      = !empty($_POST['town']) ? capitalizeName($_POST['town']) : $ens->town;

        /**
         * Saves the modifications in the database
         */
        $ens->update();

        /**
         * Redirects to the list of teachers after successful modification
         */
        header('Location: index.php?element=enseignants&action=list');
        exit;
    }

} catch (Exception $e) {
    $error = $e->getMessage();
}
