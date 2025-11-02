<?php
/**
 * Vue of the list des matières
 * Displays la liste des matières avec actions
 * 
 * @package TD3
 * @author Votre nom
 * @since 2024
 */
declare(strict_types=1);
?>

<div class="w3-container">
    <h2 class="w3-center">Liste des matières</h2>

    <!-- Bouton d'ajout -->
    <div class="w3-right w3-margin-bottom">
        <a href="index.php?element=matieres&action=edit" class="w3-button w3-green w3-round">
            <i class="fas fa-plus"></i> Ajouter une matière
        </a>
    </div>

    <!-- Tableau des matières -->
    <table class="w3-table-all w3-hoverable">
        <thead>
            <tr class="w3-light-grey">
        <th>ID</th>
        <th>Numéro</th>
        <th>Nom</th>
        <th>Coefficient</th>
        <th>Module</th>
        <th>Actions</th>
    </tr>
        </thead>
        <tbody>
            <?php if (!empty($matieres)): ?>
    <?php foreach ($matieres as $m): ?>
        <tr>
                        <td><?= htmlspecialchars((string)$m->rowid) ?></td>
                        <td><?= htmlspecialchars((string)($m->num_matiere ?? '')) ?></td>
            <td><?= htmlspecialchars($m->name) ?></td>
                        <td><?= htmlspecialchars((string)($m->coef ?? '')) ?></td>
            <td><?= htmlspecialchars($m->module_name) ?></td>
            <td>
                            <div class="action-buttons">
                                <a href="index.php?element=matieres&action=edit&id=<?= $m->rowid ?>" 
                                   class="action-btn action-btn-edit" 
                                   title="Modifier cette matière">
                                    <i class="fas fa-edit"></i>
                                    <span class="tooltip">Modifier</span>
                                </a>
                                <a href="index.php?element=matieres&action=delete&id=<?= $m->rowid ?>" 
                                   class="action-btn action-btn-delete" 
                                   title="Supprimer cette matière">
                                    <i class="fas fa-trash-alt"></i>
                                    <span class="tooltip">Supprimer</span>
                                </a>
                            </div>
            </td>
        </tr>
    <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="6" class="w3-center">Aucune matière trouvée.</td>
                </tr>
            <?php endif; ?>
        </tbody>
</table>
</div>
