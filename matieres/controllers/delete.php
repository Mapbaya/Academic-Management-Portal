<?php
/**
 * Delete controller for a subject
 * 
 * Manages the deletion of a subject by its ID. Checks the existence of the subject,
 * deletes it then redirects to the list of subjects.
 * 
 * @package TD3
 * @subpackage Controllers
 * @author Kime Marwa
 * @since November 2, 2025
 * @version 1.0
 */
require_once dirname(__FILE__) . '/../../class/matiere.class.php';

/**
 * Retrieval of the subject identifier to delete
 * 
 * @var int|null Unique identifier of the subject
 */
$id = $_GET['id'] ?? null;
if ($id) {
    $matiere = Matiere::fetch((int)$id);
    if ($matiere) $matiere->delete();
}
header('Location: index.php?element=matieres&action=list');
exit;
