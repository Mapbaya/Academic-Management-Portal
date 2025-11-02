<?php
/**
 * Gestion du routage principal du projet (structure MVC)
 * 
 * Ce fichier identifie quel contrôleur et quelle vue charger en fonction des paramètres
 * passés dans l'URL : 
 *   - element = dossier (ex: etudiants, enseignants, cours)
 *   - action  = fichier du contrôleur (ex: list, add, edit)
 * 
 * @package TD3
 * @subpackage Inc
 * @author Kime Marwa
 * @since 2 novembre 2025
 * @version 1.0
 */

// Récupération des paramètres GET ou POST
$action  = GETPOST('action') ?? 'index';
$element = GETPOST('element') ?? 'accueil'; // accueil par défaut

// ✅ Cas particulier : page d'accueil principale
if ($element === 'accueil') {
    $home = dirname(__FILE__) . '/../views/index.php';
    if (is_file($home)) {
        include $home;
        return;
    } else {
        echo "<div class='w3-container w3-red w3-padding'>Erreur : page d'accueil introuvable.</div>";
        return;
    }
}

// Construction des chemins vers contrôleur et vue
$target_c = dirname(__FILE__) . "/../$element/controllers/$action.php";
$target_v = dirname(__FILE__) . "/../$element/views/$action.php";

// ✅ Si le contrôleur existe
if (is_file($target_c)) {
    include $target_c;

    // ✅ Affiche la vue associée si elle existe
    if (is_file($target_v)) {
        include $target_v;
    }
} else {
    // 🔻 Page non trouvée
    include dirname(__FILE__) . '/notfound.php';
}
