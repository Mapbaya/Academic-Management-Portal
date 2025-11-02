<?php
/**
 * Contrôleur de suppression d'un cours
 * 
 * Gère la suppression d'un cours par son ID. Vérifie l'existence du cours,
 * le supprime puis redirige vers la liste des cours.
 * 
 * @package TD3
 * @subpackage Controllers
 * @author Kime Marwa
 * @since 2 novembre 2025
 * @version 1.0
 */
require_once dirname(__FILE__) . '/../../class/cours.class.php';

$id = $_GET['id'] ?? null;
if ($id) {
    $cours = Cours::fetch((int)$id);
    if ($cours) $cours->delete();
}
header("Location: index.php?element=cours&action=list");
exit;
