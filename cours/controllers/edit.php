<?php
/**
 * Edit controller for a cours
 * 
 * Manages the modification for a cours existing. Retrieves le cours by its ID,
 * updates its information and redirects to the list des cours.
 * 
 * @package TD3
 * @subpackage Controllers
 * @author Kime Marwa
 * @since November 2, 2025
 * @version 1.0
 */
require_once dirname(__FILE__) . '/../../class/cours.class.php';

$id = $_GET['id'] ?? null;
$cours = Cours::fetch((int)$id);

if (!$cours) {
    header("Location: index.php?element=cours&action=list");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $cours->date_cours = $_POST['date_cours'] ?? null;
    $cours->fk_matiere = !empty($_POST['fk_matiere']) ? (int)$_POST['fk_matiere'] : null;
    $cours->fk_enseignant = !empty($_POST['fk_enseignant']) ? (int)$_POST['fk_enseignant'] : null;
    $cours->groupe_td = $_POST['groupe_td'] ?? '';
    $cours->groupe_tp = $_POST['groupe_tp'] ?? '';
    $cours->salle = $_POST['salle'] ?? '';
    $cours->update();
    header("Location: index.php?element=cours&action=list");
    exit;
}


