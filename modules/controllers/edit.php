<?php
/**
 * Modification controller d'un module
 * 
 * Manages la modification d'un module existant. Récupère le module par son ID,
 * met à jour ses informations and redirects to the list des modules.
 * 
 * @package TD3
 * @subpackage Controllers
 * @author Kime Marwa
 * @since 2 novembre 2025
 * @version 1.0
 */
require_once dirname(__FILE__) . '/../../class/module.class.php';

/**
 * Retrieval de l'identifiant du module à modifier
 * 
 * @var int|null Identifiant unique du module
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
    $_SESSION['mesgs']['errors'][] = 'Module introuvable.';
    header('Location: index.php?element=modules&action=list');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $mod->num_module = trim($_POST['num_module'] ?? '');
        $mod->name = trim($_POST['name'] ?? '');
        $mod->coef = !empty($_POST['coef']) ? (float)$_POST['coef'] : 1.0;
        
        // Validation des données
        if (empty($mod->num_module) || empty($mod->name)) {
            throw new Exception('Le numéro et le nom du module sont obligatoires.');
        }
        
        if ($mod->coef < 0) {
            throw new Exception('Le coefficient ne peut pas être négatif.');
        }
        
        $mod->update();
        
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $_SESSION['mesgs']['success'][] = 'Module modifié avec succès.';
        
        header('Location: index.php?element=modules&action=list');
        exit;
    } catch (Exception $e) {
        $error = $e->getMessage();
    }
}

include dirname(__FILE__) . '/../views/edit.php';
