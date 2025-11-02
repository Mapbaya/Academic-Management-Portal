<?php
/**
 * Add controller for a student
 * 
 * Manages the creation of a new student. Validates form data,
 * creates the student as well as the associated user, and redirects to the list
 * with a confirmation or error message.
 * 
 * @package TD3
 * @subpackage Controllers
 * @author Kime Marwa
 * @since November 2, 2025
 * @version 1.0
 */
if (session_status() !== PHP_SESSION_ACTIVE) session_start();

require_once dirname(__FILE__) . '/../../class/etudiant.class.php';
require_once dirname(__FILE__) . '/../../lib/myproject.lib.php';

$error = '';
$old = []; // values to pre-fill the form on error

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieval and cleaning minimal
    $old = array_map(fn($v) => trim((string)$v), $_POST);

    // Basic validation (add what you want)
    $required = ['numetu','firstname','lastname','diploma','year','username','password'];
    $missing = [];
    foreach ($required as $r) {
        if (empty($old[$r])) $missing[] = $r;
    }
    if ($missing) {
        $error = 'Missing required fields: ' . implode(', ', $missing);
    } else {
        try {
            $etu = new Etudiant([
                'numetu'   => $old['numetu'],
                'firstname'=> capitalizeName($old['firstname']),
                'lastname' => capitalizeName($old['lastname']),
                'birthday' => $old['birthday'] ?? null,
                'diploma'  => $old['diploma'],
                'year'     => (int)$old['year'],
                'td'       => $old['td'] ?? null,
                'tp'       => $old['tp'] ?? null,
                'adress'   => $old['adress'] ?? null,
                'zipcode'  => $old['zipcode'] ?? null,
                'town'     => capitalizeName($old['town'] ?? null)
            ]);

            // create => also creates the user (transaction in the class)
            $etu->create($old['username'], $old['password']);

            // Confirmation message in session then redirect
            // Using the standardized structure for messages
            $_SESSION['mesgs']['confirm'][] = "Student created successfully (numetu={$old['numetu']}).";
            header('Location: index.php?element=etudiants&action=list');
            exit;
        } catch (Exception $e) {
            // Propagate error to view
            $error = 'Error during creation: ' . $e->getMessage();
            $_SESSION['mesgs']['errors'][] = $error;
        }
    }
}
