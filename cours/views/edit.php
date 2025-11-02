<h2>Modifier un cours</h2>

<form method="post">
    <label>Date of the course :</label>
    <input type="date" name="date_cours" value="<?= htmlspecialchars($cours->date_cours) ?>" required><br>

    <label>ID Matière :</label>
    <input type="number" name="fk_matiere" value="<?= $cours->fk_matiere ?>" required><br>

    <label>ID Enseignant :</label>
    <input type="number" name="fk_enseignant" value="<?= $cours->fk_enseignant ?>" required><br>

    <label>Groupe TD :</label>
    <input type="text" name="groupe_td" value="<?= htmlspecialchars($cours->groupe_td) ?>"><br>

    <label>Groupe TP :</label>
    <input type="text" name="groupe_tp" value="<?= htmlspecialchars($cours->groupe_tp) ?>"><br>

    <label>Salle :</label>
    <input type="text" name="salle" value="<?= htmlspecialchars($cours->salle) ?>"><br><br>

    <button type="submit" class="w3-button w3-blue">Mettre à jour</button>
</form>
