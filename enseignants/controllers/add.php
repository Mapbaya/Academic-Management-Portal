<?php
/**
 * Add controller for a teacher
 * 
 * Manages the creation of a new teacher. Validates form data,
 * creates the teacher as well as the associated user, and redirects to the list
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
 * Variable to store error messages
 * 
 * @var string Possible error message
 */
$error='';

/**
 * Processing of form submission
 */
if ($_SERVER['REQUEST_METHOD']==='POST') {
    try {
        /**
         * Creates a new teacher with form data
         * Names, first names and cities are automatically capitalized
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
         * Creates the teacher and the associated user
         * 
         * @param string $username Username
         * @param string $password Password (will be hashed in MD5)
         */
        $ens->create($_POST['username'], $_POST['password']);
        
        /**
         * Redirects to the list of teachers after successful creation
         */
        header("Location: index.php?element=enseignants&action=list");
        exit;
    } catch(Exception $e) {
        $error = $e->getMessage();
    }
}
