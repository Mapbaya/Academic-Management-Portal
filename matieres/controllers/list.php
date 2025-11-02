<?php
/**
 * List controller for matières
 * 
 * Manages the display of the list de toutes les subjects. Retrieves toutes les matières
 * from the database avec les informations des modules associés et les passe
 * à la vue for display.
 * 
 * @package TD3
 * @subpackage Controllers
 * @author Kime Marwa
 * @since November 2, 2025
 * @version 1.0
 */
require_once dirname(__FILE__) . '/../../class/matiere.class.php';

/**
 * Retrieval of toutes les matières pour affichage
 * 
 * @var array<Matiere> Array of objects Matiere avec informations des modules
 */
$matieres = Matiere::fetchAll();
