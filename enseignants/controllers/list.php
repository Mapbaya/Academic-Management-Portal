<?php
/**
 * List controller for enseignants
 * 
 * Manages the display of the enseignants with filtering capability.
 * Retrieves search criteria from GET parameters and displays
 * the corresponding results.
 * 
 * @package TD3
 * @subpackage Controllers
 * @author Kime Marwa
 * @since November 2, 2025
 * @version 1.0
 */
require_once dirname(__FILE__).'/../../class/enseignant.class.php';

/**
 * Retrieval of filtering criteria from GET parameters
 * 
 * @var array<string, string> Associative array of search criteria de recherche
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

// Execute search
$enseignants = !empty($criteria)
    ? Enseignant::find($criteria)
    : Enseignant::fetchAll();
