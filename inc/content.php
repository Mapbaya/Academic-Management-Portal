<?php
/**
 * Main project routing management (MVC structure)
 * 
 * This file identifies which controller and view to load based on parameters
 * passed in the URL:
 *   - element = directory (e.g., etudiants, enseignants, cours)
 *   - action  = controller file (e.g., list, add, edit)
 * 
 * @package TD3
 * @subpackage Inc
 * @author Kime Marwa
 * @since November 2, 2025
 * @version 1.0
 */

// Retrieve GET or POST parameters
$action  = GETPOST('action') ?? 'index';
$element = GETPOST('element') ?? 'accueil'; // home by default

// Special case: main home page
if ($element === 'accueil') {
    $home = dirname(__FILE__) . '/../views/index.php';
    if (is_file($home)) {
        include $home;
        return;
    } else {
        echo "<div class='w3-container w3-red w3-padding'>Error: home page not found.</div>";
        return;
    }
}

// Build paths to controller and view
$target_c = dirname(__FILE__) . "/../$element/controllers/$action.php";
$target_v = dirname(__FILE__) . "/../$element/views/$action.php";

// If controller exists
if (is_file($target_c)) {
    include $target_c;

    // Display associated view if it exists
    if (is_file($target_v)) {
        include $target_v;
    }
} else {
    // Page not found
    include dirname(__FILE__) . '/notfound.php';
}
