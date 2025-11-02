<?php
/**
 * Delete controller for a cours
 * 
 * Manages the deletion for a cours by its ID. Checks l'existence du cours,
 * le deletes then redirects vers the list des cours.
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
