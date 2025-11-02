<?php
/**
 * Vue de modification d'un module
 * 
 * Affiche le formulaire de modification d'un module avec tous ses champs.
 * Permet de modifier le numéro, le nom et le coefficient du module.
 * 
 * @package TD3
 * @subpackage Views
 * @author Kime Marwa
 * @since 2 novembre 2025
 * @version 1.0
 */
?>

<div class="w3-container">
    <h2 class="dtitle">Modifier un module</h2>

    <?php if (isset($error) && !empty($error)): ?>
        <div class="w3-panel w3-red w3-display-container">
            <span onclick="this.parentElement.style.display='none'" class="w3-button w3-red w3-large w3-display-topright">&times;</span>
            <p><?= htmlspecialchars($error) ?></p>
        </div>
    <?php endif; ?>

    <form method="post" class="w3-container w3-card-4 w3-padding">
        <div class="form-group">
            <label for="num_module"><strong>Numéro du module :</strong></label>
            <input 
                class="w3-input w3-border" 
                type="text" 
                name="num_module" 
                id="num_module"
                value="<?= htmlspecialchars($mod->num_module ?? '') ?>" 
                required>
        </div>

        <div class="form-group">
            <label for="name"><strong>Nom du module :</strong></label>
            <input 
                class="w3-input w3-border" 
                type="text" 
                name="name" 
                id="name"
                value="<?= htmlspecialchars($mod->name ?? '') ?>" 
                required>
        </div>

        <div class="form-group">
            <label for="coef"><strong>Coefficient :</strong></label>
            <input 
                class="w3-input w3-border" 
                type="number" 
                step="0.1" 
                min="0" 
                name="coef" 
                id="coef"
                value="<?= htmlspecialchars((string)($mod->coef ?? 1.0)) ?>" 
                required>
        </div>

        <div class="form-actions" style="margin-top: 20px;">
            <button class="w3-button w3-blue w3-round" type="submit">
                <i class="fas fa-save"></i> Mettre à jour
            </button>
            <a href="index.php?element=modules&action=list" class="w3-button w3-gray w3-round">
                <i class="fas fa-undo"></i> Annuler
            </a>
        </div>
    </form>
</div>
