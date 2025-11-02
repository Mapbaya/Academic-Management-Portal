<?php
/**
 * List controller des enseignants
 * 
 * Manages the display of the list des enseignants with filtering capability.
 * Récupère les critères de recherche from GET parameters et affiche
 * les résultats correspondants.
 * 
 * @package TD3
 * @subpackage Controllers
 * @author Kime Marwa
 * @since 2 novembre 2025
 * @version 1.0
 */
require_once dirname(__FILE__).'/../../class/enseignant.class.php';

/**
 * Retrieval des critères de filtrage from GET parameters
 * 
 * @var array<string, string> Tableau associatif des critères de recherche
 */
$criteria = [];

if (!empty($_GET['lastname'])) {
    $criteria['lastname'] = $_GET['lastname'];
}
if (!empty($_GET['firstname'])) {
    $criteria['firstname'] = $_GET['firstname'];
}
if (!empty($_GET['town'])) { // 🔥 ajout du filtre ville
    $criteria['town'] = $_GET['town'];
}

// On exécute la recherche
$enseignants = !empty($criteria)
    ? Enseignant::find($criteria)
    : Enseignant::fetchAll();
