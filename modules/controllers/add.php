<?php
/**
 * Add controller for a module
 * 
 * Manages the creation of a new module. Validates form data,
 * creates the module then redirects to the list with a confirmation
 * or error message.
 * 
 * @package TD3
 * @subpackage Controllers
 * @author Kime Marwa
 * @since November 2, 2025
 * @version 1.0
 */
require_once '../../class/module.class.php';

/**
 * Variable to store error messages
 * 
 * @var string Possible error message
 */
$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $mod = new Module([
            'num_module' => $_POST['num_module'],
            'name' => $_POST['name'],
            'coef' => !empty($_POST['coef']) ? (float)$_POST['coef'] : 1.0
        ]);
        $mod->create();
        header("Location: index.php?element=modules&action=list");
        exit;
    } catch (Exception $e) {
        $error = $e->getMessage();
    }
}

// Include the view
include dirname(__FILE__).'/../views/add.php';
