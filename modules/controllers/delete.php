<?php
/**
 * Delete controller for a module
 * 
 * Manages the deletion for a module by its ID. Checks the existence du module,
 * verifies that it is not linked to subjects, puis le deletes and redirects to the list.
 * 
 * @package TD3
 * @subpackage Controllers
 * @author Kime Marwa
 * @since November 2, 2025
 * @version 1.0
 */
require_once dirname(__FILE__) . '/../../class/module.class.php';
require_once dirname(__FILE__) . '/../../class/matiere.class.php';

/**
 * Retrieval of identifier du module à deletesr
 * 
 * @var int|null Unique identifier du module
 */
$id = $_GET['id'] ?? null;
$error = '';

if ($id) {
    $mod = Module::fetch((int)$id);
    
    if ($mod) {
        // Check if the module is linked to subjects
        $matieres = Matiere::fetchAll();
        $moduleHasMatieres = false;
        
        foreach ($matieres as $matiere) {
            if ($matiere->fk_module == $mod->rowid) {
                $moduleHasMatieres = true;
                break;
            }
        }
        
        if ($moduleHasMatieres) {
            // Stocker l'erreur in session for display
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }
            $_SESSION['mesgs']['errors'][] = 'Impossible de deletesr ce module because it is linked to one or more matières. Veuillez d\'abord deletesr ou modifier the associated subjects.';
        } else {
            // Delete the module if no subject is linked
            try {
                $mod->delete();
                if (session_status() === PHP_SESSION_NONE) {
                    session_start();
                }
                $_SESSION['mesgs']['success'][] = 'Module deleted successfully.';
            } catch (Exception $e) {
                if (session_status() === PHP_SESSION_NONE) {
                    session_start();
                }
                $_SESSION['mesgs']['errors'][] = 'Erreur during deletion : ' . $e->getMessage();
            }
        }
    } else {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $_SESSION['mesgs']['errors'][] = 'Module not found.';
    }
}

header('Location: index.php?element=modules&action=list');
exit;
