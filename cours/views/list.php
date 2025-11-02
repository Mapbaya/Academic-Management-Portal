<?php
/**
 * Vue de la liste des cours
 * Affiche la liste des cours avec filtres et actions
 * 
 * @package TD3
 * @author Votre nom
 * @since 2024
 */
declare(strict_types=1);
require_once dirname(__FILE__) . '/../../lib/myproject.lib.php';
?>

<div class="w3-container">
    <h2 class="w3-center">Liste des cours</h2>

<!-- Formulaire de filtres -->
<form method="get" action="index.php" class="w3-bar w3-margin-bottom">
    <input type="hidden" name="element" value="cours">
    <input type="hidden" name="action" value="list">

    <input type="date" name="date_cours" value="<?= $_GET['date_cours'] ?? '' ?>" class="w3-input w3-bar-item w3-border" style="width:15%">

    <select name="fk_matiere" class="w3-input w3-bar-item w3-border" style="width:20%">
        <option value="">-- Matière --</option>
        <?php foreach ($matieres as $m): ?>
            <option value="<?= $m->rowid ?>" <?= (!empty($_GET['fk_matiere']) && $_GET['fk_matiere'] == $m->rowid) ? 'selected' : '' ?>>
                <?= htmlspecialchars($m->name) ?>
            </option>
        <?php endforeach; ?>
    </select>

    <select name="fk_enseignant" class="w3-input w3-bar-item w3-border" style="width:20%">
        <option value="">-- Enseignant --</option>
        <?php foreach ($enseignants as $e): ?>
            <option value="<?= $e->rowid ?>" <?= (!empty($_GET['fk_enseignant']) && $_GET['fk_enseignant'] == $e->rowid) ? 'selected' : '' ?>>
                    <?php echo htmlspecialchars(capitalizeName($e->firstname) . ' ' . capitalizeName($e->lastname)); ?>
            </option>
        <?php endforeach; ?>
    </select>

    <input type="text" name="salle" placeholder="Salle" value="<?= $_GET['salle'] ?? '' ?>" class="w3-input w3-bar-item w3-border" style="width:15%">

        <button type="submit" class="w3-button w3-green w3-bar-item">
            <i class="fas fa-filter"></i> Filtrer
        </button>
        <a href="index.php?element=cours&action=list" class="w3-button w3-gray w3-bar-item">
            <i class="fas fa-redo"></i> Réinitialiser
        </a>
</form>

    <!-- Bouton d'ajout -->
    <div class="w3-right w3-margin-bottom">
        <a href="index.php?element=cours&action=add" class="w3-button w3-blue w3-round">
            <i class="fas fa-plus"></i> Nouveau cours
        </a>
    </div>

    <!-- Tableau des cours -->
    <table class="w3-table-all w3-hoverable">
        <thead>
            <tr class="w3-light-grey">
        <th>ID</th>
        <th>Date</th>
        <th>Matière</th>
        <th>Enseignant</th>
        <th>TD</th>
        <th>TP</th>
        <th>Salle</th>
        <th>Actions</th>
    </tr>
        </thead>
        <tbody>
    <?php if (!empty($cours)): ?>
        <?php foreach ($cours as $c): ?>
            <tr>
                        <td><?= htmlspecialchars((string)$c->rowid) ?></td>
                        <td><?= htmlspecialchars((string)$c->date_cours) ?></td>
                        <td><?= htmlspecialchars((string)($c->matiere_name ?? '')) ?></td>
                        <td><?= htmlspecialchars((string)($c->enseignant_name ?? '')) ?></td>
                        <td><?= htmlspecialchars((string)($c->groupe_td ?? '')) ?></td>
                        <td><?= htmlspecialchars((string)($c->groupe_tp ?? '')) ?></td>
                        <td><?= htmlspecialchars((string)($c->salle ?? '')) ?></td>
                <td>
                            <div class="action-buttons">
                                <a href="index.php?element=cours&action=edit&id=<?= $c->rowid ?>" 
                                   class="action-btn action-btn-edit" 
                                   title="Modifier ce cours">
                                    <i class="fas fa-edit"></i>
                                    <span class="tooltip">Modifier</span>
                                </a>
                                <a href="index.php?element=cours&action=delete&id=<?= $c->rowid ?>" 
                                   class="action-btn action-btn-delete" 
                                   title="Supprimer ce cours">
                                    <i class="fas fa-trash-alt"></i>
                                    <span class="tooltip">Supprimer</span>
                                </a>
                            </div>
                </td>
            </tr>
        <?php endforeach; ?>
    <?php else: ?>
                <tr>
                    <td colspan="8" class="w3-center">Aucun cours trouvé.</td>
            </tr>
    <?php endif; ?>
        </tbody>
</table>
</div>
