<?php
/**
 * Page d'erreur 404 - Ressource non trouvée
 * 
 * Affiche un message d'erreur lorsque le contrôleur ou la vue demandée
 * n'a pas été trouvé dans la structure MVC.
 * 
 * @package TD3
 * @subpackage Inc
 * @author Kime Marwa
 * @since 2 novembre 2025
 * @version 1.0
 */
?>
<div class="dtitle">La page demandée (concernant <?= htmlspecialchars($target_c ?? '') . " / " . htmlspecialchars($target_v ?? ''); ?>) n'a pas été trouvée.</div>