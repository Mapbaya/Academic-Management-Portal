<?php
/**
 * Navigation principale du site (barre de menu en haut)
 * 
 * Affiche la barre de navigation avec les menus déroulants pour accéder
 * aux différentes sections de l'application (étudiants, enseignants, cours).
 * Inclut également le menu utilisateur avec déconnexion.
 * 
 * @package TD3
 * @subpackage Inc
 * @author Kime Marwa
 * @since 2 novembre 2025
 * @version 1.0
 */
?>

<!-- Navbar -->
<div class="w3-top">
  <div class="w3-bar w3-card">
    <div class="w3-dropdown-hover">
      <button class="w3-bar-item w3-button logo">Bienvenue <?= htmlspecialchars($_SESSION['login']); ?></button>
      <div class="w3-dropdown-content w3-bar-block w3-card-4">
        <a href="index.php" class="w3-bar-item w3-button">Accueil</a>
        <a href="#" class="w3-bar-item w3-button"><i><?php 
            require_once dirname(__FILE__) . '/../lib/myproject.lib.php';
            echo htmlspecialchars(capitalizeName($_SESSION['user']['firstname']) . ' ' . capitalizeName($_SESSION['user']['lastname'])); 
        ?></i></a>
        <a href="delog.php" class="w3-bar-item w3-button"><i class="fa-solid fa-person-walking-arrow-right"></i> Se déconnecter</a>
      </div>
    </div>

    <?php
    $list_menus = array(
      'etudiants' => 'Les étudiants',
      'enseignants' => 'Les enseignants',
      'cours' => 'Les cours',
    );

    foreach ($list_menus as $key => $menu) {
    ?>
      <div class="w3-dropdown-hover">
        <a href="index.php?element=<?= htmlspecialchars($key); ?>" class="w3-bar-item w3-button"><?= htmlspecialchars($menu); ?></a>
        <div class="w3-dropdown-content w3-bar-block w3-card-4">
          <a href="index.php?element=<?= htmlspecialchars($key); ?>&action=list" class="w3-bar-item w3-button">Liste</a>
          <a href="index.php?element=<?= htmlspecialchars($key); ?>&action=add" class="w3-bar-item w3-button">Nouveau</a>
        </div>
      </div>
    <?php
    }
    ?>
  </div>
</div>
