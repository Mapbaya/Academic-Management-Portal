<?php
/**
 * Contrôleur de liste des matières
 * 
 * Gère l'affichage de la liste de toutes les matières. Récupère toutes les matières
 * depuis la base de données avec les informations des modules associés et les passe
 * à la vue pour affichage.
 * 
 * @package TD3
 * @subpackage Controllers
 * @author Kime Marwa
 * @since 2 novembre 2025
 * @version 1.0
 */
require_once dirname(__FILE__) . '/../../class/matiere.class.php';

/**
 * Récupération de toutes les matières pour affichage
 * 
 * @var array<Matiere> Tableau d'objets Matiere avec informations des modules
 */
$matieres = Matiere::fetchAll();
