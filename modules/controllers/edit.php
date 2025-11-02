<?php
/**
 * Edit controller for a module
 * 
 * Manages the modification of an existing module. Retrieves the module by its ID,
 * updates its information and redirects to the list of modules.
 * 
 * @package TD3
 * @subpackage Controllers
 * @author Kime Marwa
 * @since November 2, 2025
 * @version 1.0
 */
require_once dirname(__FILE__) . '/../../class/module.class.php';

/**
 * Retrieval of the module identifier to modify
 * 
 * @var int|null Unique identifier of the module
 */
$id = $_GET['id'] ?? null;
if (!$id) {
    header('Location: index.php?element=modules&action=list');
    exit;
}

$mod = Module::fetch((int)$id);
if (!$mod) {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    $_SESSION['mesgs']['errors'][] = 'Module not found.';
    header('Location: index.php?element=modules&action=list');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $mod->num_module = trim($_POST['num_module'] ?? '');
        $mod->name = trim($_POST['name'] ?? '');
        $mod->coef = !empty($_POST['coef']) ? (float)$_POST['coef'] : 1.0;
        
        // Data validation
        if (empty($mod->num_module) || empty($mod->name)) {
            throw new Exception('Number and name of the module are required.');
        }
        
        if ($mod->coef < 0) {
            throw new Exception('Coefficient cannot be negative.');
        }
        
        $mod->update();
        
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $_SESSION['mesgs']['success'][] = 'Module updated successfully.';
        
        header('Location: index.php?element=modules&action=list');
        exit;
    } catch (Exception $e) {
        $error = $e->getMessage();
    }
}

include dirname(__FILE__) . '/../views/edit.php';
