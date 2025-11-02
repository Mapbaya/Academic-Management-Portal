<?php
/**
 * Delete controller d'un cours
 * 
 * Manages la suppression d'un cours par son ID. Checks l'existence du cours,
 * le supprime puis redirige vers la liste des cours.
 * 
 * @package TD3
 * @subpackage Controllers
 * @author Kime Marwa
 * @since November 2, 2025
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
