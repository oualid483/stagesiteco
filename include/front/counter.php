<div>
    <?php 
    // Check if the session variable 'client' exists
    if (isset($_SESSION['client']) && isset($_SESSION['client']['id'])) {
        $idUtilisateur = $_SESSION['client']['id'];
    } else {
        $idUtilisateur = null; // Handle this scenario appropriately
    }

    // Check if 'idProduit' is set before using it
    $qty = isset($idUtilisateur) && isset($idProduit) && isset($_SESSION['panier'][$idUtilisateur][$idProduit]) 
            ? $_SESSION['panier'][$idUtilisateur][$idProduit] 
            : 0;

    // Determine the button to display
    $btn = $qty == 0 ? '<i class="fa-solid fa-cart-shopping"></i>' : '<i class="fa-solid fa-pen"></i>';

    if ($idUtilisateur) { // Show cart management buttons only if the user is logged in
    ?>
        <form method="post" class="counter d-flex" action="ajouter_panier.php">
            <button onclick="return false;" class="btn btn-primary mx-2 counter-moins">-</button>
            <input type="hidden" name="id" value="<?= htmlspecialchars($idProduit) ?>">
            <input class="form-control" type="number" name="qty" id="qty" max="99" value="<?= htmlspecialchars($qty) ?>">
            <button onclick="return false;" class="btn btn-primary mx-2 counter-plus">+</button> 

            <button class="btn btn-success" type="submit" name="ajouter"><?= $btn; ?></button>

            <?php if ($qty !== 0) { ?>
                <button formaction="supprimer_panier.php" class="btn btn-danger" type="submit" name="supprimer">
                    <i class="fa-solid fa-trash"></i>
                </button>
            <?php } ?>
        </form>
    <?php
    } else {
        // Prompt to login or show an alert if not logged in
        echo '<div class="alert alert-warning" role="alert">Veuillez vous connecter pour gérer le panier.</div>';
    }
    ?>
</div>
