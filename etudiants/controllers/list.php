<?php
/**
 * List controller for étudiants
 * 
 * Manages the display of the étudiants with filtering capability.
 * Retrieves les critères de recherche from GET parameters and displays
 * the corresponding results.
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

// Retrieval ofs étudiants
$etudiants = !empty($criteria) ? Etudiant::find($criteria) : Etudiant::fetchAll();
