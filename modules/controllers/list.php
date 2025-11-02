<?php
/**
 * List controller for modules
 * 
 * Manages the display of the list of all modules. Retrieves all modules
 * from the database and passes them to the view for display.
 * 
 * @package TD3
 * @subpackage Controllers
 * @author Kime Marwa
 * @since November 2, 2025
 * @version 1.0
 */
require_once dirname(__FILE__) . '/../../class/module.class.php';

/**
 * Retrieval of tous les modules pour affichage
 * 
 * @var array<Module> Array of objects Module
 */
$modules = Module::fetchAll();
include dirname(__FILE__) . '/../views/list.php';
