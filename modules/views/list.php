<?php
/**
 * Vue of the list des modules
 * 
 * Affiche la liste de tous les modules avec possibilité d'ajout, modification et suppression.
 * Les actions utilisent des icônes Font Awesome et des tooltips pour une meilleure UX.
 * 
 * @package TD3
 * @subpackage Views
 * @author Kime Marwa
 * @since 2 novembre 2025
 * @version 1.0
 */
declare(strict_types=1);
?>

<div class="w3-container">
    <h2 class="w3-center">Liste des modules</h2>

    <!-- Bouton d'ajout -->
    <div class="w3-right w3-margin-bottom">
        <a href="index.php?element=modules&action=add" class="w3-button w3-green w3-round">
            <i class="fas fa-plus"></i> Nouveau module
        </a>
    </div>

    <!-- Tableau des modules -->
    <table class="w3-table-all w3-hoverable">
        <thead>
            <tr class="w3-light-grey">
        <th>ID</th>
        <th>Numéro</th>
        <th>Nom</th>
        <th>Coefficient</th>
        <th>Actions</th>
    </tr>
        </thead>
        <tbody>
            <?php if (!empty($modules)): ?>
    <?php foreach ($modules as $m): ?>
        <tr>
                        <td><?= htmlspecialchars((string)$m->rowid) ?></td>
                        <td><?= htmlspecialchars((string)($m->num_module ?? '')) ?></td>
            <td><?= htmlspecialchars($m->name) ?></td>
                        <td><?= htmlspecialchars((string)($m->coef ?? '')) ?></td>
            <td>
                            <div class="action-buttons">
                                <a href="index.php?element=modules&action=edit&id=<?= $m->rowid ?>" 
                                   class="action-btn action-btn-edit" 
                                   title="Modifier ce module">
                                    <i class="fas fa-edit"></i>
                                    <span class="tooltip">Modifier</span>
                                </a>
                                <a href="index.php?element=modules&action=delete&id=<?= $m->rowid ?>" 
                                   class="action-btn action-btn-delete" 
                                   title="Supprimer ce module">
                                    <i class="fas fa-trash-alt"></i>
                                    <span class="tooltip">Supprimer</span>
                                </a>
                            </div>
            </td>
        </tr>
    <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5" class="w3-center">Aucun module trouvé.</td>
                </tr>
            <?php endif; ?>
        </tbody>
</table>
</div>
