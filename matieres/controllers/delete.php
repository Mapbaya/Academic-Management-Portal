<?php
/**
 * Contrôleur de suppression d'une matière
 * 
 * Gère la suppression d'une matière par son ID. Vérifie l'existence de la matière,
 * la supprime puis redirige vers la liste des matières.
 * 
 * @package TD3
 * @subpackage Controllers
 * @author Kime Marwa
 * @since 2 novembre 2025
 * @version 1.0
 */
require_once dirname(__FILE__) . '/../../class/matiere.class.php';

/**
 * Récupération de l'identifiant de la matière à supprimer
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
