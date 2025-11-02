<h2><?= isset($_GET['id']) ? 'Modifier' : 'Ajouter' ?> une matière</h2>

<form method="POST" class="w3-container w3-card w3-padding">
    <label>Numéro de matière</label>
    <input type="text" name="num_matiere" class="w3-input" value="<?= htmlspecialchars($matiere->num_matiere ?? '') ?>" required>

    <label>Nom</label>
    <input type="text" name="name" class="w3-input" value="<?= htmlspecialchars($matiere->name ?? '') ?>" required>

    <label>Coefficient</label>
    <input type="number" name="coef" step="0.1" class="w3-input" value="<?= htmlspecialchars($matiere->coef ?? 1) ?>" required>

    <label>Module associé (ID)</label>
    <input type="number" name="fk_module" class="w3-input" value="<?= htmlspecialchars($matiere->fk_module ?? 0) ?>" required>

    <br>
    <button type="submit" class="w3-button w3-blue">💾 Enregistrer</button>
    <a href="index.php?element=matieres&action=list" class="w3-button w3-gray">↩️ Annuler</a>
</form>
