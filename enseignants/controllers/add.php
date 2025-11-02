<?php
/**
 * Contrôleur d'ajout d'un enseignant
 * 
 * Gère la création d'un nouvel enseignant. Valide les données du formulaire,
 * crée l'enseignant ainsi que l'utilisateur associé, et redirige vers la liste
 * avec un message de confirmation ou d'erreur.
 * 
 * @package TD3
 * @subpackage Controllers
 * @author Kime Marwa
 * @since 2 novembre 2025
 * @version 1.0
 */
require_once dirname(__FILE__).'/../../class/enseignant.class.php';
require_once dirname(__FILE__).'/../../lib/myproject.lib.php';

/**
 * Variable pour stocker les messages d'erreur
 * 
 * @var string Message d'erreur éventuel
 */
$error='';

/**
 * Traitement de la soumission du formulaire
 */
if ($_SERVER['REQUEST_METHOD']==='POST') {
    try {
        /**
         * Crée un nouvel enseignant avec les données du formulaire
         * Les noms, prénoms et villes sont automatiquement capitalisés
         * 
         * @var Enseignant
         */
        $ens = new Enseignant([
            'firstname'=>capitalizeName($_POST['firstname']??null),
            'lastname'=>capitalizeName($_POST['lastname']??null),
            'birthday'=>$_POST['birthday']??null,
            'adress'=>$_POST['adress']??null,
            'zipcode'=>$_POST['zipcode']??null,
            'town'=>capitalizeName($_POST['town']??null)
        ]);
        
        /**
         * Crée l'enseignant et l'utilisateur associé
         * 
         * @param string $username Nom d'utilisateur
         * @param string $password Mot de passe (sera hashé en MD5)
         */
        $ens->create($_POST['username'], $_POST['password']);
        
        /**
         * Redirige vers la liste des enseignants après création réussie
         */
        header("Location: index.php?element=enseignants&action=list");
        exit;
    } catch(Exception $e) {
        $error = $e->getMessage();
    }
}
