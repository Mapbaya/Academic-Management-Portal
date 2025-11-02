<?php
/**
 * Vue de la liste des étudiants
 * Affiche la liste des étudiants avec filtres et actions
 * 
 * @package TD3
 * @author Votre nom
 * @since 2024
 */
declare(strict_types=1);
require_once dirname(__FILE__) . '/../../lib/myproject.lib.php';
?>

<div class="w3-container">
    <h2 class="w3-center">Liste des étudiants</h2>

    <!-- Filtrage -->
    <form method="get" action="index.php" class="w3-bar w3-margin-bottom">
        <input type="hidden" name="element" value="etudiants">
        <input type="hidden" name="action" value="list">

        <input type="text" name="lastname" placeholder="Nom" value="<?= $_GET['lastname'] ?? '' ?>" class="w3-input w3-bar-item w3-border" style="width:15%">
        <input type="text" name="firstname" placeholder="Prénom" value="<?= $_GET['firstname'] ?? '' ?>" class="w3-input w3-bar-item w3-border" style="width:15%">
        <select name="diploma" class="w3-select w3-bar-item w3-border" style="width:15%">
            <option value="">-- Diplôme --</option>
            <?php foreach (Etudiant::DIPLOMAS as $d): ?>
                <option value="<?= $d ?>" <?= (($_GET['diploma'] ?? '') === $d) ? 'selected' : '' ?>><?= htmlspecialchars($d) ?></option>
            <?php endforeach; ?>
        </select>
        <input type="number" name="year" placeholder="Année" value="<?= $_GET['year'] ?? '' ?>" class="w3-input w3-bar-item w3-border" style="width:10%">
        <button type="submit" class="w3-button w3-green w3-bar-item">
            <i class="fas fa-filter"></i> Filtrer
        </button>
        <a href="index.php?element=etudiants&action=list" class="w3-button w3-gray w3-bar-item">
            <i class="fas fa-redo"></i> Réinitialiser
        </a>
    </form>

    <!-- Ajouter un étudiant -->
    <div class="w3-right w3-margin-bottom">
        <a href="index.php?element=etudiants&action=add" class="w3-button w3-blue w3-round">
            <i class="fas fa-plus"></i> Ajouter un étudiant
        </a>
    </div>

    <!-- Tableau -->
    <table class="w3-table-all w3-hoverable">
        <thead>
            <tr class="w3-light-grey">
                <th>ID</th>
                <th>Numétu</th>
                <th>Nom</th>
                <th>Prénom</th>
                <th>Diplôme</th>
                <th>Année</th>
                <th>TD</th>
                <th>TP</th>
                <th>Ville</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($etudiants)): ?>
                <?php foreach ($etudiants as $etu): ?>
                    <tr>
                        <td><?= htmlspecialchars((string)$etu->rowid) ?></td>
                        <td><?= htmlspecialchars($etu->numetu) ?></td>
                        <td><?= htmlspecialchars(capitalizeName($etu->lastname)) ?></td>
                        <td><?= htmlspecialchars(capitalizeName($etu->firstname)) ?></td>
                        <td><?= htmlspecialchars($etu->diploma) ?></td>
                        <td><?= htmlspecialchars((string)($etu->year ?? '')) ?></td>
                        <td><?= htmlspecialchars((string)($etu->td ?? '')) ?></td>
                        <td><?= htmlspecialchars((string)($etu->tp ?? '')) ?></td>
                        <td><?= htmlspecialchars($etu->town) ?></td>
                        <td>
                            <div class="action-buttons">
                                <a href="index.php?element=etudiants&action=edit&id=<?= $etu->rowid ?>" 
                                   class="action-btn action-btn-edit" 
                                   title="Modifier cet étudiant">
                                    <i class="fas fa-edit"></i>
                                    <span class="tooltip">Modifier</span>
                                </a>
                                <a href="index.php?element=etudiants&action=delete&id=<?= $etu->rowid ?>" 
                                   class="action-btn action-btn-delete" 
                                   title="Supprimer cet étudiant">
                                    <i class="fas fa-trash-alt"></i>
                                    <span class="tooltip">Supprimer</span>
                                </a>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="10" class="w3-center">Aucun étudiant trouvé.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
