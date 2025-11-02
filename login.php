<?php
/**
 * Page de connexion à l'application
 * 
 * Affiche le formulaire de connexion et gère l'authentification des utilisateurs.
 * Utilise head.php et footer.php pour inclure les styles et scripts globaux.
 * 
 * @package TD3
 * @author Kime Marwa
 * @since 2 novembre 2025
 * @version 1.1
 */
session_start();
error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING);

// Connexion à la base
$db = require(dirname(__FILE__) . '/lib/mypdo.php');

// Variables pour head.php
$authorized = false;      // pas encore connecté
$title_page = "Connexion";

// Inclusion de l'en-tête
include dirname(__FILE__) . '/inc/head.php';
?>

<!-- Contenu spécifique à la page de login -->
<div class="login-container">
    <div class="login-card">
        <div class="login-header">
            <h1><i class="fas fa-graduation-cap"></i> Bienvenue sur le portail de votre projet !</h1>
        </div>

        <form action="check_login.php" method="post" class="login-form">
            <div class="form-group">
                <label for="uname">
                    <i class="fas fa-user"></i> Identifiant
                </label>
                <input type="text" placeholder="Entrez votre identifiant" name="uname" id="uname" required>
            </div>

            <div class="form-group">
                <label for="psw">
                    <i class="fas fa-lock"></i> Mot de passe
                </label>
                <input type="password" placeholder="Entrez votre mot de passe" name="psw" id="psw" required>
            </div>

            <div class="form-group">
                <?php if (is_null($db)) { ?>
                    <button type="submit" name="connect" disabled class="btn-submit btn-disabled">
                        <i class="fas fa-exclamation-triangle"></i> Impossible de se connecter
                    </button>
                <?php } else { ?>
                    <button type="submit" name="connect" class="btn-submit">
                        <i class="fas fa-sign-in-alt"></i> Se connecter
                    </button>
                <?php } ?>
            </div>
        </form>
    </div>
</div>

<?php
// Inclure le footer (fermeture de contenu-principal, body, html)
include dirname(__FILE__) . '/inc/footer.php';
