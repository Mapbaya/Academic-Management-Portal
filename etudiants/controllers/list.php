<?php
/**
 * List controller des étudiants
 * 
 * Manages the display of the list des étudiants with filtering capability.
 * Retrieves les critères de recherche from GET parameters et affiche
 * les résultats correspondants.
 * 
 * @package TD3
 * @subpackage Controllers
 * @author Kime Marwa
 * @since November 2, 2025
 * @version 1.0
 */
require_once dirname(__FILE__) . '/../../class/etudiant.class.php';

// Retrieval of filters
$criteria = [];
if (!empty($_GET['lastname']))  $criteria['lastname'] = $_GET['lastname'];
if (!empty($_GET['firstname'])) $criteria['firstname'] = $_GET['firstname'];
if (!empty($_GET['diploma']))   $criteria['diploma'] = $_GET['diploma'];
if (!empty($_GET['year']))      $criteria['year'] = $_GET['year'];

// Retrieval des étudiants
$etudiants = !empty($criteria) ? Etudiant::find($criteria) : Etudiant::fetchAll();
