<?php
/**
 * Vue de la liste des enseignants
 * Affiche la liste des enseignants avec filtres et actions
 * 
 * @package TD3
 * @author Votre nom
 * @since 2024
 */
declare(strict_types=1);
require_once dirname(__FILE__) . '/../../lib/myproject.lib.php';
?>

<div class="w3-container">
    <h2 class="w3-center">Liste des enseignants</h2>

    <!-- Barre de recherche / filtres -->
    <form method="get" action="index.php" class="w3-bar w3-margin-bottom">
        <input type="hidden" name="element" value="enseignants">
        <input type="hidden" name="action" value="list">

        <input type="text" name="lastname" placeholder="Nom" value="<?= $_GET['lastname'] ?? '' ?>" class="w3-input w3-bar-item w3-border" style="width:20%">
        <input type="text" name="firstname" placeholder="Prénom" value="<?= $_GET['firstname'] ?? '' ?>" class="w3-input w3-bar-item w3-border" style="width:20%">
        <input type="text" name="town" placeholder="Ville" value="<?= $_GET['town'] ?? '' ?>" class="w3-input w3-bar-item w3-border" style="width:20%">

        <button type="submit" class="w3-button w3-green w3-bar-item">
            <i class="fas fa-filter"></i> Filtrer
        </button>
        <a href="index.php?element=enseignants&action=list" class="w3-button w3-gray w3-bar-item">
            <i class="fas fa-redo"></i> Réinitialiser
        </a>
    </form>

    <!-- Bouton d'ajout -->
    <div class="w3-right w3-margin-bottom">
        <a href="index.php?element=enseignants&action=add" class="w3-button w3-blue w3-round">
            <i class="fas fa-plus"></i> Ajouter un enseignant
        </a>
    </div>

    <!-- Tableau des enseignants -->
    <table class="w3-table-all w3-hoverable">
        <thead>
            <tr class="w3-light-grey">
                <th>ID</th>
                <th>Nom</th>
                <th>Prénom</th>
                <th>Date de naissance</th>
                <th>Adresse</th>
                <th>Code postal</th>
                <th>Ville</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($enseignants)): ?>
                <?php foreach ($enseignants as $ens): ?>
                    <tr>
                        <td><?= htmlspecialchars((string)$ens->rowid) ?></td>
                        <td><?= htmlspecialchars(capitalizeName($ens->lastname)) ?></td>
                        <td><?= htmlspecialchars(capitalizeName($ens->firstname)) ?></td>
                        <td><?= htmlspecialchars($ens->birthday) ?></td>
                        <td><?= htmlspecialchars($ens->adress) ?></td>
                        <td><?= htmlspecialchars($ens->zipcode) ?></td>
                        <td><?= htmlspecialchars($ens->town) ?></td>
                        <td>
                            <div class="action-buttons">
                                <a href="index.php?element=enseignants&action=edit&id=<?= $ens->rowid ?>" 
                                   class="action-btn action-btn-edit" 
                                   title="Modifier cet enseignant">
                                    <i class="fas fa-edit"></i>
                                    <span class="tooltip">Modifier</span>
                                </a>
                                <a href="index.php?element=enseignants&action=delete&id=<?= $ens->rowid ?>" 
                                   class="action-btn action-btn-delete" 
                                   title="Supprimer cet enseignant">
                                    <i class="fas fa-trash-alt"></i>
                                    <span class="tooltip">Supprimer</span>
                                </a>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="8" class="w3-center">Aucun enseignant trouvé.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
