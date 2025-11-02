<?php
/**
 * Main file of the TD3 application
 * 
 * This file structures the application by including the different components:
 * - The header (head.php): contains HTML header tags, CSS and JS
 * - Main content (content.php): manages MVC routing
 * - Footer (footer.php): contains footer and HTML closing tags
 * 
 * @package TD3
 * @author Kime Marwa
 * @since November 2, 2025
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
