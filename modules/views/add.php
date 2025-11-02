<h2>Ajouter un module</h2>

<?php if(!empty($error)): ?>
<div class="w3-panel w3-red"><?= htmlspecialchars($error) ?></div>
<?php endif; ?>

<form method="post" class="w3-container w3-card w3-padding w3-margin-top">
    <div class="w3-section">
        <label>Numéro du module :</label>
        <input type="text" name="num_module" class="w3-input w3-border" required>
    </div>
    <div class="w3-section">
        <label>Nom du module :</label>
        <input type="text" name="name" class="w3-input w3-border" required>
    </div>
    <div class="w3-section">
        <label>Coefficient :</label>
        <input type="number" name="coef" class="w3-input w3-border" required>
    </div>
    <button type="submit" class="w3-button w3-green">Créer</button>
</form>
