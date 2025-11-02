<?php
/**
 * Controller forajout d'un étudiant
 * 
 * Manages the creation of a new étudiant. Validates form data,
 * creates l'étudiant ainsi que associated user, and redirects to the list
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
$old = []; // valeurs pour pré-remplir le formulaire si erreur

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieval et nettoyage minimal
    $old = array_map(fn($v) => trim((string)$v), $_POST);

    // Validation basique (ajoute ce que tu veux)
    $required = ['numetu','firstname','lastname','diploma','year','username','password'];
    $missing = [];
    foreach ($required as $r) {
        if (empty($old[$r])) $missing[] = $r;
    }
    if ($missing) {
        $error = 'Champs obligatoires manquants : ' . implode(', ', $missing);
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

            // create => creates aussi l'utilisateur (transaction dans la classe)
            $etu->create($old['username'], $old['password']);

            // Confirmation message in session then redirect
            // Utilisation de la structure standardizede pour les messages
            $_SESSION['mesgs']['confirm'][] = "Étudiant créé avec succès (numetu={$old['numetu']}).";
            header('Location: index.php?element=etudiants&action=list');
            exit;
        } catch (Exception $e) {
            // Propagate error to view
            $error = 'Erreur lors de la création : ' . $e->getMessage();
            $_SESSION['mesgs']['errors'][] = $error;
        }
    }
}
