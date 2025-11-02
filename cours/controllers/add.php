<?php
/**
 * Controller forajout for a cours
 * 
 * Manages the creation for a nouveau cours. Permet également de createsr un nouveau module
 * ou une nouvelle matière if necessary lors de la création du cours.
 * 
 * @package TD3
 * @subpackage Controllers
 * @author Kime Marwa
 * @since November 2, 2025
 * @version 1.0
 */
require_once dirname(__FILE__) . '/../../class/cours.class.php';
require_once dirname(__FILE__) . '/../../class/matiere.class.php';
require_once dirname(__FILE__) . '/../../class/module.class.php';
require_once dirname(__FILE__) . '/../../class/enseignant.class.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // --- Création for a module if necessary ---
        $fk_module = $_POST['new_matiere_module'] ?? null;
        if (!empty($_POST['new_module_name'])) {
            $module = new Module([
                'name' => $_POST['new_module_name'],
                'num_module' => $_POST['new_module_num'] ?? 'M'.rand(100,999),
                'coef' => !empty($_POST['new_module_coef']) ? (float)$_POST['new_module_coef'] : 1.0
            ]);
            $module->create();
            $fk_module = $module->rowid;
        }

        // --- Création for ae matière if necessary ---
        $fk_matiere = $_POST['fk_matiere'] ?? null;
        if (empty($fk_matiere) && !empty($_POST['new_matiere_name'])) {
            $matiere = new Matiere([
                'name' => $_POST['new_matiere_name'],
                'num_matiere' => $_POST['new_matiere_num'] ?? '',
                'coef' => !empty($_POST['new_matiere_coef']) ? (float)$_POST['new_matiere_coef'] : 1.0,
                'fk_module' => !empty($fk_module) ? (int)$fk_module : 0
            ]);
            $matiere->create();
            $fk_matiere = $matiere->rowid;
        }

        // --- Création du cours ---
        $cours = new Cours([
            'date_cours' => $_POST['date_cours'] ?? null,
            'fk_matiere' => !empty($fk_matiere) ? (int)$fk_matiere : null,
            'fk_enseignant' => !empty($_POST['fk_enseignant']) ? (int)$_POST['fk_enseignant'] : null,
            'groupe_td' => $_POST['groupe_td'] ?? '',
            'groupe_tp' => $_POST['groupe_tp'] ?? '',
            'salle' => $_POST['salle'] ?? ''
        ]);
        $cours->create();

        header("Location: index.php?element=cours&action=list");
        exit;

    } catch (Exception $e) {
        $error = $e->getMessage();
    }
}

// --- Récupérer les listes pour les selects ---
$enseignants = Enseignant::fetchAll();
$matieres = Matiere::fetchAll();
$modules = Module::fetchAll();

