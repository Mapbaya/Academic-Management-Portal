<?php
/**
 * Application login page
 * 
 * Displays the login form and handles user authentication.
 * Uses head.php and footer.php to include global styles and scripts.
 * 
 * @package TD3
 * @author Kime Marwa
 * @since November 2, 2025
 * @version 1.1
 */
session_start();
error_reporting(E_ALL & ~E_NOTICE & ~E_WARNING);

// Database connection
$db = require(dirname(__FILE__) . '/lib/mypdo.php');

// Variables for head.php
$authorized = false;      // not logged in yet
$title_page = "Login";

// Include header
include dirname(__FILE__) . '/inc/head.php';
?>

<!-- Login page specific content -->
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
// Include footer (closes main-content, body, html)
include dirname(__FILE__) . '/inc/footer.php';
