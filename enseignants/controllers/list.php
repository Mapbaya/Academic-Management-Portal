<?php
/**
 * Contrôleur de liste des enseignants
 * 
 * Gère l'affichage de la liste des enseignants avec possibilité de filtrage.
 * Récupère les critères de recherche depuis les paramètres GET et affiche
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
 * Récupération des critères de filtrage depuis les paramètres GET
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
