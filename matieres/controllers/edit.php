<?php
/**
 * Edit controller for ae matière
 * 
 * Manages the modification for ae matière existant ou la création for ae nouvelle matière.
 * Retrieves la matière par son ID (si édition), updates its information
 * and redirects to the list des matières.
 * 
 * @package TD3
 * @subpackage Controllers
 * @author Kime Marwa
 * @since November 2, 2025
 * @version 1.0
 */
require_once dirname(__FILE__) . '/../../class/matiere.class.php';

/**
 * Retrieval of identifier de la matière à modifier (null si création)
 * 
 * @var int|null Unique identifier de la matière ou null pour création
 */
$id = $_GET['id'] ?? null;
$matiere = $id ? Matiere::fetch((int)$id) : new Matiere();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $matiere->num_matiere = $_POST['num_matiere'] ?? '';
    $matiere->name = $_POST['name'] ?? '';
    $matiere->coef = !empty($_POST['coef']) ? (float)$_POST['coef'] : 0.0;
    $matiere->fk_module = !empty($_POST['fk_module']) ? (int)$_POST['fk_module'] : 0;

    if ($id) $matiere->update();
    else $matiere->create();

    header('Location: index.php?element=matieres&action=list');
    exit;
}
