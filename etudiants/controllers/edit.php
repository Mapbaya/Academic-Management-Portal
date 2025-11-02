<?php
/**
 * Contrôleur de modification d'un étudiant
 * 
 * Gère la modification d'un étudiant existant. Récupère l'étudiant par son ID,
 * valide et met à jour les données du formulaire, puis redirige vers la liste
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
$etu = null;

// ID en GET obligatoire pour identifier l'étudiant à modifier
$id = isset($_REQUEST['id']) ? (int)$_REQUEST['id'] : 0;
if ($id <= 0) {
    $_SESSION['mesgs']['errors'][] = 'Identifiant invalide.';
    header('Location: index.php?element=etudiants&action=list');
    exit;
}

// Récupération de l'étudiant à modifier
$etu = Etudiant::fetch($id);
if (!$etu) {
    $_SESSION['mesgs']['errors'][] = 'Étudiant introuvable.';
    header('Location: index.php?element=etudiants&action=list');
    exit;
}

// Traitement de la soumission du formulaire (mise à jour)
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // Mise à jour des propriétés de l'étudiant
        $etu->numetu = $_POST['numetu'] ?? $etu->numetu;
        $etu->firstname = !empty($_POST['firstname']) ? capitalizeName($_POST['firstname']) : $etu->firstname;
        $etu->lastname = !empty($_POST['lastname']) ? capitalizeName($_POST['lastname']) : $etu->lastname;
        $etu->birthday = $_POST['birthday'] ?? $etu->birthday;
        $etu->diploma = $_POST['diploma'] ?? $etu->diploma;
        $etu->year = !empty($_POST['year']) ? (int)$_POST['year'] : $etu->year;
        $etu->td = $_POST['td'] ?? $etu->td;
        $etu->tp = $_POST['tp'] ?? $etu->tp;
        $etu->adress = $_POST['adress'] ?? $etu->adress;
        $etu->zipcode = $_POST['zipcode'] ?? $etu->zipcode;
        $etu->town = !empty($_POST['town']) ? capitalizeName($_POST['town']) : $etu->town;

        $etu->update();

        // Message de confirmation standardisé
        $_SESSION['mesgs']['confirm'][] = 'Étudiant mis à jour avec succès.';
        header('Location: index.php?element=etudiants&action=list');
        exit;
    } catch (Exception $e) {
        $error = 'Erreur lors de la mise à jour : ' . $e->getMessage();
        $_SESSION['mesgs']['errors'][] = $error;
    }
}
