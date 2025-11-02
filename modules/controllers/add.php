<?php
/**
 * Contrôleur d'ajout d'un module
 * 
 * Gère la création d'un nouveau module. Valide les données du formulaire,
 * crée le module puis redirige vers la liste avec un message de confirmation
 * ou d'erreur.
 * 
 * @package TD3
 * @subpackage Controllers
 * @author Kime Marwa
 * @since 2 novembre 2025
 * @version 1.0
 */
require_once '../../class/module.class.php';

/**
 * Variable pour stocker les messages d'erreur
 * 
 * @var string Message d'erreur éventuel
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

// Inclure la vue
include dirname(__FILE__).'/../views/add.php';
