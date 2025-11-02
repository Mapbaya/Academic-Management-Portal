<!-- etudiants/views/edit.php -->
<div class="w3-container">
    <h2 class="w3-center">Modifier l'étudiant</h2>

    <?php if (!empty($error)) : ?>
        <div class="w3-panel w3-red"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form method="post" class="w3-container w3-card w3-padding w3-margin-top">
        <label>Numéro étudiant</label>
        <input type="text" name="numetu" class="w3-input" required value="<?= htmlspecialchars($etu->numetu) ?>">

        <label>Prénom</label>
        <input type="text" name="firstname" class="w3-input" required value="<?= htmlspecialchars($etu->firstname) ?>">

        <label>Nom</label>
        <input type="text" name="lastname" class="w3-input" required value="<?= htmlspecialchars($etu->lastname) ?>">

        <label>Date de naissance</label>
        <input type="date" name="birthday" class="w3-input" value="<?= htmlspecialchars($etu->birthday) ?>">

        <label>Diplôme</label>
        <select name="diploma" class="w3-select">
            <?php foreach (Etudiant::DIPLOMAS as $d): ?>
                <option value="<?= $d ?>" <?= ($etu->diploma === $d) ? 'selected' : '' ?>><?= $d ?></option>
            <?php endforeach; ?>
        </select>

        <label>Année</label>
        <input type="number" name="year" class="w3-input" value="<?= htmlspecialchars($etu->year) ?>">

        <label>TD</label>
        <input type="text" name="td" class="w3-input" value="<?= htmlspecialchars($etu->td) ?>">

        <label>TP</label>
        <input type="text" name="tp" class="w3-input" value="<?= htmlspecialchars($etu->tp) ?>">

        <label>Adresse <small style="color: #666; font-weight: normal;">(recherche automatique)</small></label>
        <div style="position: relative;">
            <input type="text" name="adress" id="address-input-edit" class="w3-input address-autocomplete" value="<?= htmlspecialchars($etu->adress) ?>" placeholder="Tapez une adresse (ex: 10 rue de Paris, 59000 Lille)">
        </div>

        <label>Code postal</label>
        <input type="text" name="zipcode" class="w3-input" value="<?= htmlspecialchars($etu->zipcode) ?>">

        <label>Ville</label>
        <input type="text" name="town" class="w3-input" value="<?= htmlspecialchars($etu->town) ?>">

        <div class="w3-margin-top">
            <button type="submit" class="w3-button w3-green">Enregistrer</button>
            <a href="index.php?element=etudiants&action=list" class="w3-button w3-gray">Annuler</a>
        </div>
    </form>
</div>

