<?php
/**
 * Contrôleur de liste des étudiants
 * 
 * Gère l'affichage de la liste des étudiants avec possibilité de filtrage.
 * Récupère les critères de recherche depuis les paramètres GET et affiche
 * les résultats correspondants.
 * 
 * @package TD3
 * @subpackage Controllers
 * @author Kime Marwa
 * @since 2 novembre 2025
 * @version 1.0
 */
require_once dirname(__FILE__) . '/../../class/etudiant.class.php';

// Récupération des filtres
$criteria = [];
if (!empty($_GET['lastname']))  $criteria['lastname'] = $_GET['lastname'];
if (!empty($_GET['firstname'])) $criteria['firstname'] = $_GET['firstname'];
if (!empty($_GET['diploma']))   $criteria['diploma'] = $_GET['diploma'];
if (!empty($_GET['year']))      $criteria['year'] = $_GET['year'];

// Récupération des étudiants
$etudiants = !empty($criteria) ? Etudiant::find($criteria) : Etudiant::fetchAll();
