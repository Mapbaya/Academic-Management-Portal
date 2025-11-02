<?php
/**
 * Contrôleur index des cours
 * 
 * Page d'accueil du module cours. Affiche un résumé et des statistiques
 * sur les cours, matières et enseignants (nombre total).
 * 
 * @package TD3
 * @subpackage Controllers
 * @author Kime Marwa
 * @since 2 novembre 2025
 * @version 1.0
 */
require_once dirname(__FILE__).'/../../class/cours.class.php';
require_once dirname(__FILE__).'/../../class/matiere.class.php';
require_once dirname(__FILE__).'/../../class/enseignant.class.php';

/**
 * Récupération des statistiques pour affichage
 * 
 * @var int Nombre total de cours dans la base de données
 * @var int Nombre total de matières dans la base de données
 * @var int Nombre total d'enseignants dans la base de données
 */
$totalCours = count(Cours::fetchAll());
$totalMatieres = count(Matiere::fetchAll());
$totalEnseignants = count(Enseignant::fetchAll());
