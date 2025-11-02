<?php
/**
 * En-tête principal du site (import CSS, JS et structure globale)
 * 
 * Ce fichier génère le <head> HTML avec tous les imports nécessaires (CSS, JS),
 * calcule dynamiquement les chemins des ressources, et inclut le menu de navigation.
 * 
 * @package TD3
 * @subpackage Inc
 * @author Kime Marwa
 * @since 2 novembre 2025
 * @version 1.0
 */
declare(strict_types=1);

/**
 * Calcule le chemin de base du projet pour les ressources CSS/JS
 * 
 * Détermine automatiquement le chemin de base du projet en analysant plusieurs
 * variables d'environnement PHP (_SERVER). Utilise plusieurs méthodes de détection
 * pour garantir la compatibilité avec différentes configurations serveur.
 * 
 * @return string Chemin de base (ex: /r301devweb/TD3 ou /TD3)
 * @author Kime Marwa
 * @since 2 novembre 2025
 */
function calculateBaseUrl(): string {
    // Méthode 1 : Depuis SCRIPT_NAME (le plus fiable)
    // Exemple: /r301devweb/TD3/index.php => /r301devweb/TD3
    if (!empty($_SERVER['SCRIPT_NAME'])) {
        $baseUrl = rtrim(dirname($_SERVER['SCRIPT_NAME']), '/\\');
        if ($baseUrl !== '/' && $baseUrl !== '.' && !empty($baseUrl)) {
            return $baseUrl;
        }
    }
    
    // Méthode 2 : Depuis le fichier actuel et DOCUMENT_ROOT
    // Si DOCUMENT_ROOT est /srv/http, et le projet est dans /srv/http/r301devweb/TD3
    // Alors le chemin web devrait être /r301devweb/TD3
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
    
    // Méthode 3 : Chercher le chemin dans REQUEST_URI
    if (!empty($_SERVER['REQUEST_URI'])) {
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        if ($uri) {
            // Chercher /r301devweb/TD3 ou /TD3 dans l'URI
            if (preg_match('#(/r301devweb/TD3|/TD3|/td3)#i', $uri, $matches)) {
                return rtrim($matches[1], '/');
            }
            // Sinon, prendre le dirname de l'URI
            $uriDir = dirname($uri);
            if ($uriDir !== '/' && $uriDir !== '.') {
                return rtrim($uriDir, '/');
            }
        }
    }
    
    // Par défaut, essayer de détecter depuis le chemin du script
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

// Debug temporaire pour vérifier le chemin (décommenter si besoin)
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

    <!-- Ton style (URL publique calculée) -->
    <link rel="stylesheet" href="<?php echo htmlspecialchars($cssPath); ?>?v=<?php echo time(); ?>" type="text/css" media="all">
    <style>
        /* Fallback immédiat pour garantir l'application */
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

    <!-- Ton JS (URL publique calculée) -->
    <script src="<?php echo htmlspecialchars($jsPath); ?>?v=<?php echo time(); ?>" defer></script>
</head>
<body>

    <!-- Menu principal (haut) -->
    <div class="menu-haut w3-top">
        <?php
        if ($authorized == true)
            include dirname(__FILE__) . '/top.php';
        ?>
    </div>

    <!-- Menu latéral (optionnel, masqué si vide) -->
    <div class="menu-gauche">
        <?php
        if ($authorized == true)
            include dirname(__FILE__) . '/left.php';
        ?>
    </div>

    <!-- Contenu principal -->
    <div class="contenu-principal w3-container w3-center w3-padding-64">
