<?php
/**
 * Page d'accueil du site
 * 
 * Displays la page d'accueil avec les cartes interactives permettant d'accéder
 * aux différentes sections de l'application (étudiants, enseignants, cours).
 * 
 * Note: This file est inclus dans main.inc.php qui charge déjà head.php et footer.php,
 * donc on génère uniquement le contenu, pas un document HTML complet.
 * 
 * @package TD3
 * @author Kime Marwa
 * @since November 2, 2025
 * @version 1.0
 */
declare(strict_types=1);
?>

<div class="accueil">
    <h1 class="titre-accueil">Bienvenue sur votre portail de gestion</h1>
    <p class="sous-titre-accueil">Gérez facilement vos étudiants, enseignants et cours</p>

    <div class="grille-cartes">
        <!-- Étudiants -->
        <div class="carte etudiants">
            <div class="carte-interieure">
                <div class="carte-face carte-avant">
                    <i class="fas fa-user-graduate icone-carte"></i>
                    <h3>Étudiants</h3>
                </div>
                <div class="carte-face carte-arriere">
                    <p>Voir, ajouter et modifier les étudiants.</p>
                    <a href="index.php?element=etudiants&action=index" class="bouton-acces">Accéder</a>
                </div>
            </div>
        </div>

        <!-- Enseignants -->
        <div class="carte enseignants">
            <div class="carte-interieure">
                <div class="carte-face carte-avant">
                    <i class="fas fa-chalkboard-teacher icone-carte"></i>
                    <h3>Enseignants</h3>
                </div>
                <div class="carte-face carte-arriere">
                    <p>Voir, ajouter et modifier les enseignants.</p>
                    <a href="index.php?element=enseignants&action=index" class="bouton-acces">Accéder</a>
                </div>
            </div>
        </div>

        <!-- Cours -->
        <div class="carte cours">
            <div class="carte-interieure">
                <div class="carte-face carte-avant">
                    <i class="fas fa-book icone-carte"></i>
                    <h3>Cours</h3>
                </div>
                <div class="carte-face carte-arriere">
                    <p>Voir, ajouter et modifier les cours.</p>
                    <a href="index.php?element=cours&action=index" class="bouton-acces">Accéder</a>
                </div>
            </div>
        </div>
    </div>
</div>
