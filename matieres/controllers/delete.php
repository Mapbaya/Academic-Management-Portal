<?php
/**
 * Delete controller d'une matière
 * 
 * Manages la suppression d'une matière par son ID. Checks l'existence de la matière,
 * la supprime puis redirige vers la liste des matières.
 * 
 * @package TD3
 * @subpackage Controllers
 * @author Kime Marwa
 * @since November 2, 2025
 * @version 1.0
 */
require_once dirname(__FILE__) . '/../../class/matiere.class.php';

/**
 * Retrieval de l'identifiant de la matière à supprimer
 * 
 * @var int|null Identifiant unique de la matière
 */
$id = $_GET['id'] ?? null;
if ($id) {
    $matiere = Matiere::fetch((int)$id);
    if ($matiere) $matiere->delete();
}
header('Location: index.php?element=matieres&action=list');
exit;
