<?php
/**
 * Contrôleur index des étudiants
 * 
 * Home page of the étudiants. Displays un résumé et des statistiques
 * about étudiants (nombre total).
 * 
 * @package TD3
 * @subpackage Controllers
 * @author Kime Marwa
 * @since November 2, 2025
 * @version 1.0
 */
require_once dirname(__FILE__) . '/../../class/etudiant.class.php';

/**
 * Retrieval of total number d'étudiants pour affichage
 * 
 * @var int Total number d'étudiants in the database
 */
$totalEtudiants = count(Etudiant::fetchAll());
