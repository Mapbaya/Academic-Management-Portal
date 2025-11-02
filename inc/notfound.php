<?php
/**
 * 404 error page - Resource not found
 * 
 * Displays an error message when the requested controller or view
 * was not found in the MVC structure.
 * 
 * @package TD3
 * @subpackage Inc
 * @author Kime Marwa
 * @since November 2, 2025
 * @version 1.0
 */
?>
<div class="dtitle">The requested page (concerning <?= htmlspecialchars($target_c ?? '') . " / " . htmlspecialchars($target_v ?? ''); ?>) was not found.</div>