<?php
/**
 * Main site header (CSS, JS imports and global structure)
 * 
 * This file generates the HTML <head> with all necessary imports (CSS, JS),
 * dynamically calculates resource paths, and includes the navigation menu.
 * 
 * @package TD3
 * @subpackage Inc
 * @author Kime Marwa
 * @since November 2, 2025
 * @version 1.0
 */
declare(strict_types=1);

/**
 * Calculates the base path of the project for CSS/JS resources
 * 
 * Automatically determines the base path of the project by analyzing multiple
 * PHP environment variables (_SERVER). Uses multiple detection methods
 * to ensure compatibility with different server configurations.
 * 
 * @return string Base path (e.g. /r301devweb/TD3 or /TD3)
 * @author Kime Marwa
 * @since November 2, 2025
 */
function calculateBaseUrl(): string {
    // Method 1: From SCRIPT_NAME (most reliable)
    // Example: /r301devweb/TD3/index.php => /r301devweb/TD3
    if (!empty($_SERVER['SCRIPT_NAME'])) {
        $baseUrl = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/\\');
        if ($baseUrl !== '/' && $baseUrl !== '.' && !empty($baseUrl)) {
            return $baseUrl;
        }
    }
    
    // Method 2: From current file and DOCUMENT_ROOT
    // If DOCUMENT_ROOT is /srv/http, and the project is in /srv/http/r301devweb/TD3
    // Then the web path should be /r301devweb/TD3
    if (!empty($_SERVER['DOCUMENT_ROOT'])) {
        $currentDir = dirname(__FILE__); // /srv/http/r301devweb/TD3/inc/
        $projectRoot = dirname($currentDir); // /srv/http/r301devweb/TD3/
        $docRoot = rtrim(str_replace('\\', '/', $_SERVER['DOCUMENT_ROOT']), '/');
        $projectPath = str_replace('\\', '/', $projectRoot);
        
        if (strpos($projectPath, $docRoot) === 0) {
            $relativePath = substr($projectPath, strlen($docRoot));
            if (!empty($relativePath)) {
                return rtrim($relativePath, '/');
            }
        }
    }
    
    // Method 3: Search for path in REQUEST_URI
    if (!empty($_SERVER['REQUEST_URI'])) {
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        if ($uri) {
            // Search for /r301devweb/TD3 or /TD3 in URI
            if (preg_match('#(/r301devweb/TD3|/TD3|/td3)#i', $uri, $matches)) {
                return rtrim($matches[1], '/');
            }
            // Otherwise, take the dirname of the URI
            $uriDir = dirname($uri);
            if ($uriDir !== '/' && $uriDir !== '.') {
                return rtrim($uriDir, '/');
            }
        }
    }
    
    // By default, try to detect from script path
    if (!empty($_SERVER['PHP_SELF'])) {
        $phpSelf = $_SERVER['PHP_SELF'];
        $phpSelfDir = dirname($phpSelf);
        if ($phpSelfDir !== '/' && $phpSelfDir !== '.') {
            return rtrim($phpSelfDir, '/');
        }
    }
    
    return '';
}

$baseUrl = calculateBaseUrl();
$cssPath = ($baseUrl ? rtrim($baseUrl, '/') : '') . '/css/styles.css';
$jsPath = ($baseUrl ? rtrim($baseUrl, '/') : '') . '/js/scripts.js';

// Temporary debug to verify path (uncomment if needed)
// echo "<!-- DEBUG - Base URL: " . htmlspecialchars($baseUrl) . " -->\n";
// echo "<!-- DEBUG - CSS Path: " . htmlspecialchars($cssPath) . " -->\n";
// echo "<!-- DEBUG - JS Path: " . htmlspecialchars($jsPath) . " -->\n";
// echo "<!-- DEBUG - SCRIPT_NAME: " . htmlspecialchars($_SERVER['SCRIPT_NAME'] ?? '') . " -->\n";
// echo "<!-- DEBUG - REQUEST_URI: " . htmlspecialchars($_SERVER['REQUEST_URI'] ?? '') . " -->\n";
// echo "<!-- DEBUG - DOCUMENT_ROOT: " . htmlspecialchars($_SERVER['DOCUMENT_ROOT'] ?? '') . " -->\n";

?>
<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <title>TD3 <?= htmlspecialchars($title_page ?? 'Accueil'); ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Librairies externes -->
    <!-- W3.CSS retiré - utilisation de notre propre CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@400;600;700&display=swap" rel="stylesheet">

    <!-- Your style (calculated public URL) -->
    <link rel="stylesheet" href="<?php echo htmlspecialchars($cssPath); ?>?v=<?php echo time(); ?>" type="text/css" media="all">
    <style>
        /* Immediate fallback to ensure application */
        * { box-sizing: border-box; }
        body { 
            font-family: 'Quicksand', sans-serif !important;
            background: linear-gradient(135deg, #f5f7fa 0%, #e9ecef 100%) !important;
            margin: 0;
            padding: 0;
        }
        a { text-decoration: none !important; }
        table { border-collapse: collapse; width: 100%; }
    </style>

    <!-- Your JS (calculated public URL) -->
    <script src="<?php echo htmlspecialchars($jsPath); ?>?v=<?php echo time(); ?>" defer></script>
</head>
<body>

    <!-- Main menu (top) -->
    <div class="menu-haut w3-top">
        <?php
        if ($authorized == true)
            include dirname(__FILE__) . '/top.php';
        ?>
    </div>

    <!-- Side menu (optional, hidden if empty) -->
    <div class="menu-gauche">
        <?php
        if ($authorized == true)
            include dirname(__FILE__) . '/left.php';
        ?>
    </div>

    <!-- Main content -->
    <div class="contenu-principal w3-container w3-center w3-padding-64">
