<?php
/**
 * Fichier principal de l'application TD3
 * 
 * Ce fichier structure l'application en incluant les différents composants :
 * - L'en-tête (head.php) : contient les balises HTML d'en-tête, CSS et JS
 * - Le contenu principal (content.php) : gère le routage MVC
 * - Le pied de page (footer.php) : contient le footer et la fermeture HTML
 * 
 * @package TD3
 * @author Kime Marwa
 * @since 2 novembre 2025
 * @version 1.0
 */
include dirname(__FILE__) . "/inc/head.php";
?>
<div class="maincontent  w3-display-container w3-center">
    <?php
        include dirname(__FILE__) . "/inc/content.php";
    ?>
</div>
<?php
include dirname(__FILE__) . "/inc/footer.php";
