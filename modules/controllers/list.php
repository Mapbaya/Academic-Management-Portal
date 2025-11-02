<?php
/**
 * List controller des modules
 * 
 * Manages the display of the list de tous les modules. Récupère tous les modules
 * depuis la base de données et les passe à la vue pour affichage.
 * 
 * @package TD3
 * @subpackage Controllers
 * @author Kime Marwa
 * @since 2 novembre 2025
 * @version 1.0
 */
require_once dirname(__FILE__) . '/../../class/module.class.php';

/**
 * Retrieval de tous les modules pour affichage
 * 
 * @var array<Module> Tableau d'objets Module
 */
$modules = Module::fetchAll();
include dirname(__FILE__) . '/../views/list.php';
