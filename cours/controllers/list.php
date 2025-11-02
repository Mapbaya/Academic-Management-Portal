<?php
/**
 * List controller for cours
 * 
 * Manages the display of the cours with filtering capability.
 * Retrieves search criteria from GET parameters and displays
 * les résultats correspondants avec les informations des matières et enseignants.
 * 
 * @package TD3
 * @subpackage Controllers
 * @author Kime Marwa
 * @since November 2, 2025
 * @version 1.0
 */
require_once dirname(__FILE__) . '/../../class/cours.class.php';
require_once dirname(__FILE__) . '/../../class/matiere.class.php';
require_once dirname(__FILE__) . '/../../class/enseignant.class.php';

$criteria = [];

// Filtres
if (!empty($_GET['date_cours'])) $criteria['date_cours'] = $_GET['date_cours'];
if (!empty($_GET['fk_matiere'])) $criteria['fk_matiere'] = $_GET['fk_matiere'];
if (!empty($_GET['fk_enseignant'])) $criteria['fk_enseignant'] = $_GET['fk_enseignant'];
if (!empty($_GET['salle'])) $criteria['salle'] = $_GET['salle'];

try {
    $cours = !empty($criteria) ? Cours::find($criteria) : Cours::fetchAll();
    $matieres = Matiere::fetchAll();
    $enseignants = Enseignant::fetchAll();
} catch (Exception $e) {
    $cours = [];
    $matieres = [];
    $enseignants = [];
    $_SESSION['mesgs']['errors'][] = "Error during retrieval of courses: " . $e->getMessage();
}
