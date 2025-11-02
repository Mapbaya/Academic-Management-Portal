<?php
require_once dirname(__FILE__) . '/../../lib/myproject.lib.php';
?>
<h2>Ajouter un cours</h2>

<form method="post" class="w3-container w3-card w3-padding w3-margin-top">

    <!-- Date du cours -->
    <div class="w3-section">
        <label>Date du cours :</label>
        <input type="date" name="date_cours" class="w3-input w3-border" value="<?= htmlspecialchars($cours->date_cours ?? '') ?>" required>
    </div>

    <!-- Matière -->
    <div class="w3-section">
        <label>Matière :</label>
        <select name="fk_matiere" class="w3-select w3-border">
            <option value="">-- Sélectionner une matière existante --</option>
            <?php foreach ($matieres as $m): ?>
                <option value="<?= $m->rowid ?>" <?= isset($cours->fk_matiere) && $cours->fk_matiere==$m->rowid ? 'selected' : '' ?>>
                    <?= htmlspecialchars($m->name) ?> (Module: <?= htmlspecialchars($m->module_name) ?>)
                </option>
            <?php endforeach; ?>
        </select>

        <p style="margin:0.5em 0;">Ou créer une nouvelle matière :</p>
        <input type="text" name="new_matiere_name" class="w3-input w3-border" placeholder="Nom de la matière">
        <input type="text" name="new_matiere_num" class="w3-input w3-border" placeholder="Numéro de matière">
        <input type="number" step="0.1" name="new_matiere_coef" class="w3-input w3-border" placeholder="Coefficient">

        <label>Module :</label>
        <select name="new_matiere_module" class="w3-select w3-border">
            <option value="">-- Sélectionner un module existant --</option>
            <?php foreach ($modules as $mod): ?>
                <option value="<?= $mod->rowid ?>"><?= htmlspecialchars($mod->name) ?></option>
            <?php endforeach; ?>
        </select>

        <input type="text" name="new_module_name" class="w3-input w3-border" placeholder="Ou créer un nouveau module">
        <small>Si vous remplissez ce champ, un nouveau module sera créé automatiquement.</small>
    </div>

    <!-- Enseignant -->
    <div class="w3-section">
        <label>Enseignant :</label>
        <select name="fk_enseignant" class="w3-select w3-border" required>
            <option value="">-- Sélectionner --</option>
            <?php foreach ($enseignants as $e): ?>
                <option value="<?= $e->rowid ?>" <?= isset($cours->fk_enseignant) && $cours->fk_enseignant==$e->rowid ? 'selected' : '' ?>>
                    <?php echo htmlspecialchars(capitalizeName($e->firstname) . ' ' . capitalizeName($e->lastname)); ?>
                </option>
            <?php endforeach; ?>
        </select>
    </div>

    <!-- Groupes et salle -->
    <div class="w3-section">
        <label>Groupe TD :</label>
        <input type="text" name="groupe_td" class="w3-input w3-border" value="<?= htmlspecialchars($cours->groupe_td ?? '') ?>">
    </div>
    <div class="w3-section">
        <label>Groupe TP :</label>
        <input type="text" name="groupe_tp" class="w3-input w3-border" value="<?= htmlspecialchars($cours->groupe_tp ?? '') ?>">
    </div>
    <div class="w3-section">
        <label>Salle :</label>
        <input type="text" name="salle" class="w3-input w3-border" value="<?= htmlspecialchars($cours->salle ?? '') ?>">
    </div>

    <button type="submit" class="w3-button w3-green">Enregistrer</button>
</form>
