<?php
// Vérifier si la session est déjà démarrée
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Vérifier si le client est connecté
$clientLoggedIn = isset($_SESSION['client']);
$clientId = $clientLoggedIn ? $_SESSION['client']['id'] : null;

// Vérifier si 'panier' est défini et initialisé pour le client
$productsCount = 0;
if ($clientId && isset($_SESSION['panier'][$clientId]) && is_array($_SESSION['panier'][$clientId])) {
    $productsCount = count($_SESSION['panier'][$clientId]);
}

// Définir la constante PRODUCTS_COUNT pour un accès facile
define('PRODUCTS_COUNT', $productsCount);
?>

<nav class="navbar navbar-expand-lg bg-body-tertiary">
  <div class="container-fluid">
    <img src="../img/to.png" alt="logo" width="100">
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" aria-current="page" href="index.php"><i class="fa-solid fa-network-wired"></i> Liste des Categories</a>
        </li>
      </ul>

      <!-- Aligner les éléments de droite avec ms-auto -->
      <ul class="navbar-nav ms-auto">
        <?php if ($clientLoggedIn): ?>
          <li class="nav-item">
            <a class="btn float-end" href="panier.php"><i class="fa-solid fa-cart-shopping"></i> Panier (<?= PRODUCTS_COUNT; ?>)</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" aria-current="page" href="deconnexion_client.php">
              <i class="fa-solid fa-right-from-bracket"></i> Déconnexion
            </a>
          </li>
        <?php else: ?>
          <li class="nav-item">
            <a class="nav-link" href="connexion_client.php"><i class="fa-solid fa-user"></i> Connexion</a>
          </li>
        <?php endif; ?>
      </ul>
    </div>
  </div>
</nav>
<script>
window.embeddedChatbotConfig = {
chatbotId: "Fb7HhMBkoO1Yq0Y-AZ2N2",
domain: "www.chatbase.co"
}
</script>
<script
src="https://www.chatbase.co/embed.min.js"
chatbotId="Fb7HhMBkoO1Yq0Y-AZ2N2"
domain="www.chatbase.co"
defer>
</script>
