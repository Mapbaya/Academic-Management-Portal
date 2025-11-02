<?php
/**
 * Delete controller for ae matière
 * 
 * Manages the deletion for ae matière by its ID. Checks l'existence de la matière,
 * la deletes then redirects vers the list des matières.
 * 
 * @package TD3
 * @subpackage Controllers
 * @author Kime Marwa
 * @since November 2, 2025
 * @version 1.0
 */
require_once dirname(__FILE__) . '/../../class/matiere.class.php';

/**
 * Retrieval of identifier de la matière à deletesr
 * 
 * @var int|null Unique identifier de la matière
 */
$id = $_GET['id'] ?? null;
if ($id) {
    $matiere = Matiere::fetch((int)$id);
    if ($matiere) $matiere->delete();
}
header('Location: index.php?element=matieres&action=list');
exit;
