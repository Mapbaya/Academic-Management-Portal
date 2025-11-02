<h2 class="w3-center">Gestion des Étudiants</h2>

<div class="w3-container w3-center w3-margin-bottom">
    <a href="index.php?element=etudiants&action=list" class="w3-button w3-blue w3-margin-right">
        <i class="fas fa-list"></i> Liste des étudiants
    </a>
    <a href="index.php?element=etudiants&action=add" class="w3-button w3-green">
        <i class="fas fa-plus"></i> Ajouter un étudiant
    </a>
</div>

<p>On this page, you can view all étudiants existants, add a new étudiant or manage étudiants already registered.</p>

<p>Total étudiants enregistrés : <?= $totalEtudiants ?></p>
