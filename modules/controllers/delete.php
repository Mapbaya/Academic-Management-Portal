<?php
/**
 * Contrôleur de suppression d'un module
 * 
 * Gère la suppression d'un module par son ID. Vérifie l'existence du module,
 * vérifie qu'il n'est pas lié à des matières, puis le supprime et redirige vers la liste.
 * 
 * @package TD3
 * @subpackage Controllers
 * @author Kime Marwa
 * @since 2 novembre 2025
 * @version 1.0
 */
require_once dirname(__FILE__) . '/../../class/module.class.php';
require_once dirname(__FILE__) . '/../../class/matiere.class.php';

/**
 * Récupération de l'identifiant du module à supprimer
 * 
 * @var int|null Identifiant unique du module
 */
$id = $_GET['id'] ?? null;
$error = '';

if ($id) {
    $mod = Module::fetch((int)$id);
    
    if ($mod) {
        // Vérifier si le module est lié à des matières
        $matieres = Matiere::fetchAll();
        $moduleHasMatieres = false;
        
        foreach ($matieres as $matiere) {
            if ($matiere->fk_module == $mod->rowid) {
                $moduleHasMatieres = true;
                break;
            }
        }
        
        if ($moduleHasMatieres) {
            // Stocker l'erreur dans la session pour l'affichage
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }
            $_SESSION['mesgs']['errors'][] = 'Impossible de supprimer ce module car il est lié à une ou plusieurs matières. Veuillez d\'abord supprimer ou modifier les matières associées.';
        } else {
            // Supprimer le module si aucune matière n'est liée
            try {
                $mod->delete();
                if (session_status() === PHP_SESSION_NONE) {
                    session_start();
                }
                $_SESSION['mesgs']['success'][] = 'Module supprimé avec succès.';
            } catch (Exception $e) {
                if (session_status() === PHP_SESSION_NONE) {
                    session_start();
                }
                $_SESSION['mesgs']['errors'][] = 'Erreur lors de la suppression : ' . $e->getMessage();
            }
        }
    } else {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $_SESSION['mesgs']['errors'][] = 'Module introuvable.';
    }
}

header('Location: index.php?element=modules&action=list');
exit;
