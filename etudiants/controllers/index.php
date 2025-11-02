<?php
/**
 * Contrôleur index des étudiants
 * 
 * Page d'accueil du module étudiants. Displays un résumé et des statistiques
 * sur les étudiants (nombre total).
 * 
 * @package TD3
 * @subpackage Controllers
 * @author Kime Marwa
 * @since November 2, 2025
 * @version 1.0
 */
require_once dirname(__FILE__) . '/../../class/etudiant.class.php';

/**
 * Retrieval du nombre total d'étudiants pour affichage
 * 
 * @var int Nombre total d'étudiants dans la base de données
 */
$totalEtudiants = count(Etudiant::fetchAll());
