<?php
/**
 * Contrôleur de modification d'un enseignant
 * 
 * Gère la modification d'un enseignant existant. Récupère l'enseignant par son ID,
 * valide et met à jour les données du formulaire, puis redirige vers la liste
 * avec un message de confirmation ou d'erreur.
 * 
 * @package TD3
 * @subpackage Controllers
 * @author Kime Marwa
 * @since 2 novembre 2025
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
 * Vérification de la présence de l'ID dans l'URL
 */
if (!isset($_GET['id'])) {
    die('ID manquant.');
}

try {
    /**
     * Récupère l'enseignant par son identifiant
     * 
     * @param int|string $_GET['id'] Identifiant de l'enseignant
     */
    $ens = Enseignant::fetch($_GET['id']);
    if (!$ens) {
        die('Enseignant introuvable.');
    }

    /**
     * Traitement de la soumission du formulaire de modification
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
         * Sauvegarde les modifications dans la base de données
         */
        $ens->update();

        /**
         * Redirige vers la liste des enseignants après modification réussie
         */
        header('Location: index.php?element=enseignants&action=list');
        exit;
    }

} catch (Exception $e) {
    $error = $e->getMessage();
}
