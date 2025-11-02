<div class="w3-container">
    <h2 class="w3-center">Modifier un enseignant</h2>

    <?php if (!empty($error)): ?>
        <div class="w3-panel w3-red"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form method="post" class="w3-container w3-card-4 w3-light-grey w3-padding">
        <p>
            <label>Nom</label>
            <input type="text" name="lastname" value="<?= htmlspecialchars($ens->lastname) ?>" class="w3-input">
        </p>
        <p>
            <label>Prénom</label>
            <input type="text" name="firstname" value="<?= htmlspecialchars($ens->firstname) ?>" class="w3-input">
        </p>
        <p>
            <label>Date de naissance</label>
            <input type="date" name="birthday" value="<?= htmlspecialchars($ens->birthday) ?>" class="w3-input">
        </p>
        <p>
        <label>Adresse <small style="color: #666; font-weight: normal;">(recherche automatique)</small></label>
        <div style="position: relative;">
            <input type="text" name="adress" id="address-input-edit-ens" value="<?= htmlspecialchars($ens->adress) ?>" class="w3-input address-autocomplete" placeholder="Tapez une adresse (ex: 10 rue de Paris, 59000 Lille)">
        </div>
        </p>
        <p>
            <label>Code postal</label>
            <input type="text" name="zipcode" value="<?= htmlspecialchars($ens->zipcode) ?>" class="w3-input">
        </p>
        <p>
            <label>Ville</label>
            <input type="text" name="town" value="<?= htmlspecialchars($ens->town) ?>" class="w3-input">
        </p>

        <button type="submit" class="w3-button w3-blue">
            <i class="fas fa-save"></i> Enregistrer
        </button>
        <a href="index.php?element=enseignants&action=list" class="w3-button w3-gray">
            <i class="fas fa-undo"></i> Annuler
        </a>
    </form>
</div>
