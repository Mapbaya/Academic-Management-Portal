<?php
/**
 * Controller forajout d'un enseignant
 * 
 * Manages the creation of a new enseignant. Validates form data,
 * creates l'enseignant ainsi que associated user, and redirects to the list
 * with a confirmation or error message.
 * 
 * @package TD3
 * @subpackage Controllers
 * @author Kime Marwa
 * @since November 2, 2025
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
 * Processing of submission du formulaire
 */
if ($_SERVER['REQUEST_METHOD']==='POST') {
    try {
        /**
         * Creates un nouvel enseignant avec les données du formulaire
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
         * Creates l'enseignant et associated user
         * 
         * @param string $username Username
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
