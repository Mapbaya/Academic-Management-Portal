<?php
/**
 * Contrôleur index of teachers
 * 
 * Home page of the enseignants. Displays a summary et des statistiques
 * about enseignants (nombre total).
 * 
 * @package TD3
 * @subpackage Controllers
 * @author Kime Marwa
 * @since November 2, 2025
 * @version 1.0
 */
require_once dirname(__FILE__) . '/../../class/enseignant.class.php';

/**
 * Retrieval of total number d'enseignants pour affichage
 * 
 * @var int Total number d'enseignants in the database
 */
$totalEnseignants = count(Enseignant::fetchAll());


