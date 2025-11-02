<?php
/**
 * Point d'entrée principal de l'application TD3
 * 
 * Ce fichier initialise l'application en chargeant les bibliothèques nécessaires
 * et en activant l'affichage des erreurs en mode développement. Il charge ensuite
 * le fichier principal qui gère la structure MVC du projet.
 * 
 * @package TD3
 * @author Kime Marwa
 * @since 2 novembre 2025
 * @version 1.0
 */

// Chargement des bibliothèques du projet
require_once(dirname(__FILE__) . '/lib/security.lib.php');
require_once(dirname(__FILE__) . '/lib/myproject.lib.php');

// Activation de l'affichage des erreurs PHP (en dev uniquement)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Chargement du cœur principal du projet (structure MVC)
include dirname(__FILE__) . '/main.inc.php';
