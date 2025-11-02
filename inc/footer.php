<?php
/**
 * Pied de page du site
 * 
 * Affiche le footer avec les liens réseaux sociaux et gère l'affichage
 * des messages de confirmation et d'erreur stockés en session.
 * 
 * @package TD3
 * @subpackage Inc
 * @author Kime Marwa
 * @since 2 novembre 2025
 * @version 1.0
 */
?>

</div>
<div style="clear:both;"></div>

<?php
// Fermer la connexion si elle existe
if (isset($db) && $db) {
    $db = null;
}

// Messages de confirmation
if (!empty($_SESSION['mesgs']['confirm']) && is_array($_SESSION['mesgs']['confirm'])) {
    foreach ($_SESSION['mesgs']['confirm'] as $mesg) {
?>
    <div class="alertbox messagebox">
        <span class="closebtn">&times;</span>
        <?= htmlspecialchars($mesg) ?>
    </div>
<?php
    }
    unset($_SESSION['mesgs']['confirm']);
}

// Messages d'erreur
if (!empty($_SESSION['mesgs']['errors']) && is_array($_SESSION['mesgs']['errors'])) {
    foreach ($_SESSION['mesgs']['errors'] as $err) {
?>
    <div class="alertbox errorbox">
        <span class="closebtn">&times;</span>
        <?= htmlspecialchars($err) ?>
    </div>
<?php
    }
    unset($_SESSION['mesgs']['errors']);
}
?>

<script>
    // Fermeture des messages d'alerte au clic sur le bouton X
    var close = document.getElementsByClassName("closebtn");
    for (var i = 0; i < close.length; i++) {
        close[i].onclick = function() {
            var div = this.parentElement;
            div.style.opacity = "0";
            setTimeout(function() { div.style.display = "none"; }, 600);
        }
    }
</script>

<footer class="footer-container">
  <div class="footer-social">
    <a href="#" class="social-icon" title="Facebook" aria-label="Facebook">
      <i class="fab fa-facebook"></i>
    </a>
    <a href="#" class="social-icon" title="Instagram" aria-label="Instagram">
      <i class="fab fa-instagram"></i>
    </a>
    <a href="#" class="social-icon" title="Snapchat" aria-label="Snapchat">
      <i class="fab fa-snapchat"></i>
    </a>
    <a href="#" class="social-icon" title="Pinterest" aria-label="Pinterest">
      <i class="fab fa-pinterest-p"></i>
    </a>
    <a href="#" class="social-icon" title="Twitter" aria-label="Twitter">
      <i class="fab fa-twitter"></i>
    </a>
    <a href="#" class="social-icon" title="LinkedIn" aria-label="LinkedIn">
      <i class="fab fa-linkedin"></i>
    </a>
  </div>
  <p class="footer-text">TD3 - Gestion académique © 2025</p>
  <p class="footer-legal">
    <a href="#" onclick="alert('Mentions légales\n\nPropriétaire : TD3 - Gestion académique\n\nTous droits réservés.'); return false;">
      Mentions légales
    </a>
  </p>
</footer>

</body>
</html>
