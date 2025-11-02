<?php
/**
 * Contrôleur index des cours
 * 
 * Home page of the cours. Displays un résumé et des statistiques
 * about cours, matières et enseignants (nombre total).
 * 
 * @package TD3
 * @subpackage Controllers
 * @author Kime Marwa
 * @since November 2, 2025
 * @version 1.0
 */
require_once dirname(__FILE__).'/../../class/cours.class.php';
require_once dirname(__FILE__).'/../../class/matiere.class.php';
require_once dirname(__FILE__).'/../../class/enseignant.class.php';

/**
 * Retrieval ofs statistiques pour affichage
 * 
 * @var int Total number de cours in the database
 * @var int Total number de matières in the database
 * @var int Total number d'enseignants in the database
 */
$totalCours = count(Cours::fetchAll());
$totalMatieres = count(Matiere::fetchAll());
$totalEnseignants = count(Enseignant::fetchAll());
