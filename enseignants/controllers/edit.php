<?php
/**
 * Edit controller for a enseignant
 * 
 * Manages the modification for a enseignant existing. Retrieves l'enseignant by its ID,
 * valide et met à jour les données du formulaire, then redirects vers the list
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
 * Variable pour stocker les messages d'erreur
 * 
 * @var string Message d'erreur éventuel
 */
$error = '';

/**
 * Variable pour stocker l'objet enseignant
 * 
 * @var Enseignant|null Objet enseignant à modifier
 */
$ens = null;

/**
 * Verification de la présence de l'ID dans l'URL
 */
if (!isset($_GET['id'])) {
    die('ID manquant.');
}

try {
    /**
     * Retrieves l'enseignant par son identifiant
     * 
     * @param int|string $_GET['id'] Identifiant de l'enseignant
     */
    $ens = Enseignant::fetch($_GET['id']);
    if (!$ens) {
        die('Teacher not found.');
    }

    /**
     * Processing of submission du formulaire of modification
     */
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        /**
         * Met à jour les propriétés de l'enseignant avec les données du formulaire
         * Les noms, prénoms et villes sont automatiquement capitalisés
         */
        $ens->firstname = !empty($_POST['firstname']) ? capitalizeName($_POST['firstname']) : $ens->firstname;
        $ens->lastname  = !empty($_POST['lastname']) ? capitalizeName($_POST['lastname']) : $ens->lastname;
        $ens->birthday  = $_POST['birthday'] ?? $ens->birthday;
        $ens->adress    = $_POST['adress'] ?? $ens->adress;
        $ens->zipcode   = $_POST['zipcode'] ?? $ens->zipcode;
        $ens->town      = !empty($_POST['town']) ? capitalizeName($_POST['town']) : $ens->town;

        /**
         * Sauvegarde les modifications in the database
         */
        $ens->update();

        /**
         * Redirige vers the list of teachers après modification réussie
         */
        header('Location: index.php?element=enseignants&action=list');
        exit;
    }

} catch (Exception $e) {
    $error = $e->getMessage();
}
