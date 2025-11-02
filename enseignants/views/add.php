<div class="w3-container">
    <h2 class="w3-center">Ajouter un enseignant</h2>
    <?php if(!empty($error)) echo "<p class='w3-red'>$error</p>"; ?>
    <form method="post" class="w3-container w3-card-4 w3-padding">
        <label>Prénom</label><input class="w3-input" type="text" name="firstname" required>
        <label>Nom</label><input class="w3-input" type="text" name="lastname" required>
        <label>Date de naissance</label><input class="w3-input" type="date" name="birthday">
        <label>Adresse <small style="color: #666; font-weight: normal;">(recherche automatique)</small></label>
        <div style="position: relative;">
            <input class="w3-input address-autocomplete" type="text" name="adress" placeholder="Tapez une adresse (ex: 10 rue de Paris, 59000 Lille)">
        </div>
        <label>Code postal</label><input class="w3-input" type="text" name="zipcode">
        <label>Ville</label><input class="w3-input" type="text" name="town">
        <label>Username</label><input class="w3-input" type="text" name="username" required>
        <label>Mot de passe</label><input class="w3-input" type="password" name="password" required>
        <div class="w3-margin-top">
            <button type="submit" class="w3-button w3-green">Créer</button>
            <a href="index.php?element=enseignants&action=list" class="w3-button w3-gray">Annuler</a>
        </div>
    </form>
</div>
