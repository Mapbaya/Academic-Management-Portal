<?php
/**
 * Contrôleur index des enseignants
 * 
 * Page d'accueil du module enseignants. Affiche un résumé et des statistiques
 * sur les enseignants (nombre total).
 * 
 * @package TD3
 * @subpackage Controllers
 * @author Kime Marwa
 * @since 2 novembre 2025
 * @version 1.0
 */
require_once dirname(__FILE__) . '/../../class/enseignant.class.php';

/**
 * Retrieval du nombre total d'enseignants pour affichage
 * 
 * @var int Nombre total d'enseignants dans la base de données
 */
$totalEnseignants = count(Enseignant::fetchAll());


