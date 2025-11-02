<h2 class="w3-center">Gestion des Étudiants</h2>

<div class="w3-container w3-center w3-margin-bottom">
    <a href="index.php?element=etudiants&action=list" class="w3-button w3-blue w3-margin-right">
        <i class="fas fa-list"></i> Liste des étudiants
    </a>
    <a href="index.php?element=etudiants&action=add" class="w3-button w3-green">
        <i class="fas fa-plus"></i> Ajouter un étudiant
    </a>
</div>

<p>Sur cette page, vous pouvez consulter tous les étudiants existants, ajouter un nouvel étudiant ou gérer les étudiants déjà enregistrés.</p>

<p>Total étudiants enregistrés : <?= $totalEtudiants ?></p>
