<?php
/**
 * Contrôleur de liste des cours
 * 
 * Gère l'affichage de la liste des cours avec possibilité de filtrage.
 * Récupère les critères de recherche depuis les paramètres GET et affiche
 * les résultats correspondants avec les informations des matières et enseignants.
 * 
 * @package TD3
 * @subpackage Controllers
 * @author Kime Marwa
 * @since 2 novembre 2025
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
    $_SESSION['mesgs']['errors'][] = "Erreur lors de la récupération des cours : " . $e->getMessage();
}
