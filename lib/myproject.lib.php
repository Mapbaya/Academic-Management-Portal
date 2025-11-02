<?php
/**
 * Bibliothèque de fonctions utilitaires du projet TD3
 * 
 * Ce fichier contient des fonctions utilitaires utilisées dans tout le projet,
 * notamment pour la gestion des paramètres GET/POST et la manipulation de chaînes.
 * 
 * @package TD3
 * @subpackage Lib
 * @author Kime Marwa
 * @since 2 novembre 2025
 * @version 1.0
 */

require_once(dirname(__FILE__) . '/../vendor/autoload.php');

/**
 * Récupère un paramètre depuis $_POST ou $_GET
 * 
 * Cherche d'abord dans $_POST, puis dans $_GET si le paramètre n'est pas trouvé.
 * Retourne null si le paramètre est vide ou inexistant.
 * 
 * @param string $paramname Nom du paramètre à récupérer
 * @return mixed|null Valeur du paramètre ou null si non trouvé ou vide
 * @author Kime Marwa
 * @since 2 novembre 2025
 */
function GETPOST($paramname)
{
    if (isset($_POST[$paramname]) && !empty($_POST[$paramname]))
        return $_POST[$paramname];
    if (isset($_GET[$paramname]) && !empty($_GET[$paramname]))
        return $_GET[$paramname];
    return null;
}

/**
 * Vérifie si un paramètre existe dans $_POST ou $_GET
 * 
 * Vérifie la présence d'un paramètre dans $_POST ou $_GET,
 * sans tenir compte de sa valeur (même si elle est vide).
 * 
 * @param string $paramname Nom du paramètre à vérifier
 * @return bool true si le paramètre existe dans $_POST ou $_GET, false sinon
 * @author Kime Marwa
 * @since 2 novembre 2025
 */
function GETPOSTISSET($paramname)
{
    return (isset($_POST[$paramname]) || isset($_GET[$paramname]));
}

/**
 * Capitalise la première lettre d'un nom/prénom
 * 
 * Met en forme un nom ou prénom en mettant la première lettre en majuscule
 * et le reste en minuscule. Utilise mb_convert_case pour gérer correctement
 * les caractères UTF-8 (accents, caractères spéciaux).
 * 
 * @param string|null $name Le nom/prénom à capitaliser
 * @return string Le nom avec la première lettre en majuscule, chaîne vide si null ou vide
 * @author Kime Marwa
 * @since 2 novembre 2025
 */
function capitalizeName(?string $name): string {
    if (empty($name)) {
        return '';
    }
    return mb_convert_case(trim($name), MB_CASE_TITLE, 'UTF-8');
}