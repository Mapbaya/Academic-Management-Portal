<?php
/**
 * Contrôleur d'ajout d'un étudiant
 * 
 * Gère la création d'un nouvel étudiant. Valide les données du formulaire,
 * crée l'étudiant ainsi que l'utilisateur associé, et redirige vers la liste
 * avec un message de confirmation ou d'erreur.
 * 
 * @package TD3
 * @subpackage Controllers
 * @author Kime Marwa
 * @since 2 novembre 2025
 * @version 1.0
 */
if (session_status() !== PHP_SESSION_ACTIVE) session_start();

require_once dirname(__FILE__) . '/../../class/etudiant.class.php';
require_once dirname(__FILE__) . '/../../lib/myproject.lib.php';

$error = '';
$old = []; // valeurs pour pré-remplir le formulaire si erreur

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupération et nettoyage minimal
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

            // create => crée aussi l'utilisateur (transaction dans la classe)
            $etu->create($old['username'], $old['password']);

            // Message de confirmation en session puis redirection
            // Utilisation de la structure standardisée pour les messages
            $_SESSION['mesgs']['confirm'][] = "Étudiant créé avec succès (numetu={$old['numetu']}).";
            header('Location: index.php?element=etudiants&action=list');
            exit;
        } catch (Exception $e) {
            // Remonter l'erreur sur la vue
            $error = 'Erreur lors de la création : ' . $e->getMessage();
            $_SESSION['mesgs']['errors'][] = $error;
        }
    }
}
