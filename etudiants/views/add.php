<!-- etudiants/views/add.php -->
<div class="w3-container">
    <h2 class="w3-center">Ajouter un étudiant</h2>

    <?php if (!empty($error)): ?>
        <div class="w3-panel w3-red w3-round"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form method="post" class="w3-container w3-card w3-padding w3-margin-top">
        <label>Numéro étudiant *</label>
        <input type="text" name="numetu" class="w3-input" required value="<?= htmlspecialchars($old['numetu'] ?? '') ?>">

        <label>Prénom *</label>
        <input type="text" name="firstname" class="w3-input" required value="<?= htmlspecialchars($old['firstname'] ?? '') ?>">

        <label>Nom *</label>
        <input type="text" name="lastname" class="w3-input" required value="<?= htmlspecialchars($old['lastname'] ?? '') ?>">

        <label>Date de naissance</label>
        <input type="date" name="birthday" class="w3-input" value="<?= htmlspecialchars($old['birthday'] ?? '') ?>">

        <label>Diplôme *</label>
        <select name="diploma" class="w3-select" required>
            <option value="">-- Sélectionner --</option>
            <?php foreach (Etudiant::DIPLOMAS as $d): ?>
                <option value="<?= $d ?>" <?= (isset($old['diploma']) && $old['diploma'] === $d) ? 'selected' : '' ?>><?= $d ?></option>
            <?php endforeach; ?>
        </select>

        <label>Année *</label>
        <input type="number" name="year" class="w3-input" required value="<?= htmlspecialchars($old['year'] ?? '') ?>">

        <label>TD</label>
        <input type="text" name="td" class="w3-input" value="<?= htmlspecialchars($old['td'] ?? '') ?>">

        <label>TP</label>
        <input type="text" name="tp" class="w3-input" value="<?= htmlspecialchars($old['tp'] ?? '') ?>">

        <label>Adresse <small style="color: #666; font-weight: normal;">(recherche automatique)</small></label>
        <div style="position: relative;">
            <input type="text" name="adress" class="w3-input address-autocomplete" id="address-input" value="<?= htmlspecialchars($old['adress'] ?? '') ?>" placeholder="Tapez une adresse (ex: 10 rue de Paris, 59000 Lille)">
        </div>

        <label>Code postal</label>
        <input type="text" name="zipcode" class="w3-input" value="<?= htmlspecialchars($old['zipcode'] ?? '') ?>">

        <label>Ville</label>
        <input type="text" name="town" class="w3-input" value="<?= htmlspecialchars($old['town'] ?? '') ?>">

        <hr>

        <h4>Compte utilisateur lié</h4>
        <label>Nom d’utilisateur *</label>
        <input type="text" name="username" class="w3-input" required value="<?= htmlspecialchars($old['username'] ?? '') ?>">

        <label>Mot de passe *</label>
        <input type="password" name="password" class="w3-input" required>

        <div class="w3-margin-top">
            <button type="submit" class="w3-button w3-green">Créer l’étudiant</button>
            <a href="index.php?element=etudiants&action=list" class="w3-button w3-gray">Annuler</a>
        </div>
    </form>
</div>
