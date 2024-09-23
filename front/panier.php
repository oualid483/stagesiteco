<?php 
require_once '../include/database.php';
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panier</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href=" https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">
    <link href="../assets/css/produit.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
</head>
<body>
<?php include '../include/nav_front.php'; ?>

<div class="container py-2">
    <?php
    // Fetch the user's ID from the session
    $idUtilisateur = $_SESSION['client']['id'] ?? null;

    if (!$idUtilisateur) {
        echo '<div class="alert alert-danger" role="alert">Utilisateur non identifié.</div>';
        exit();
    }

    if (isset($_POST['vider'])) {
        // Clear the cart for the logged-in user
        $_SESSION['panier'][$idUtilisateur] = [];
        header('Location: panier.php');
        exit(); // Exit to stop further execution
    }

    $panier = $_SESSION['panier'][$idUtilisateur] ?? [];

    if (!empty($panier)) {
        $idProduits = array_keys($panier);
        $idProduits = implode(',', $idProduits);

        if (!empty($idProduits)) {
            $produits = $pdo->query("SELECT * FROM produit WHERE id IN ($idProduits)")->fetchAll(PDO::FETCH_ASSOC);
        } else {
            $produits = [];  // Initialize as an empty array if there are no products
        }
    } else {
        $produits = [];  // Initialize as an empty array if the cart is empty
    }

    if (isset($_POST['valider']) && !empty($produits)) {
        $sql = 'INSERT INTO ligne_commande (id_produit, id_commande, prix, quantite, total) VALUES';
        $total = 0;
        $prixProduits = [];

        foreach ($produits as $produit) {
            $idProduit = $produit['id'];
            $qty = $panier[$idProduit];
            $prix = $produit['prix'];
            $total += $qty * $prix;
            $prixProduits[$idProduit] = [
                'id' => $idProduit,
                'prix' => $prix,
                'qty' => $qty,
                'total' => $qty * $prix
            ];
        }

        $stmtCommande = $pdo->prepare('INSERT INTO commande (id_client, total) VALUES (?, ?)');
        $stmtCommande->execute([$idUtilisateur, $total]);
        $idCommande = $pdo->lastInsertId();

        foreach ($prixProduits as $produit) {
            $id = $produit['id'];
            $sql .= "(:id$id, $idCommande, :prix$id, :qty$id, :total$id),";
        }

        $sql = rtrim($sql, ',');  // Remove the trailing comma
        $stmt = $pdo->prepare($sql);

        foreach ($prixProduits as $produit) {
            $id = $produit['id'];
            $stmt->bindParam(':id' . $id, $produit['id']);
            $stmt->bindParam(':prix' . $id, $produit['prix']);
            $stmt->bindParam(':qty' . $id, $produit['qty']);
            $stmt->bindParam(':total' . $id, $produit['total']);
        }

        $inserted = $stmt->execute();

        if ($inserted) {
            // Clear the cart after successful order
            $_SESSION['panier'][$idUtilisateur] = [];
            ?>
            <div class="alert alert-success" role="alert">
                Votre commande est valide avec succes, (<?= $total . ' MAD'; ?>)
            </div>
            <?php
            header("refresh:2;url=panier.php");
            exit();
        }
    }
    ?>

    <h4>Panier (<?= count($panier); ?>)</h4>
    <div class="container">
        <div class="row">
            <?php
            if (empty($panier)) {
                ?>
                <div class="alert alert-warning" role="alert">
                    Votre panier est vide pour l'instant.
                </div>
                <?php
            } else {
                ?>
                <table class="table">
                    <thead>
                        <tr>
                            <th>IMAGE</th>
                            <th>LIBELLE</th>
                            <th>QUANTITE</th>
                            <th>PRIX</th>
                            <th>TOTAL</th>
                        </tr>
                    </thead>
                    <?php
                    $total = 0;
                    foreach ($produits as $produit) {
                        $idProduit = $produit['id'];
                        $totalProduit = $produit['prix'] * $panier[$idProduit];
                        $total += $totalProduit;
                        ?>
                        <tr>
                            <td><img src="../uplode/produit/<?= htmlspecialchars($produit['image']); ?>" alt="image produit" width="60px"></td>
                            <td><?= htmlspecialchars($produit['libelle']); ?></td>
                            <td><?php include '../include/front/counter.php'; ?></td>
                            <td><?= htmlspecialchars($produit['prix']); ?> DH</td>
                            <td><?= htmlspecialchars($totalProduit); ?> DH</td>
                        </tr>
                        <?php
                    }
                    ?>
                    <tfoot>
                        <tr>
                            <td colspan="4" align="right"><strong>TOTAL</strong></td>
                            <td><?= htmlspecialchars($total); ?> DH</td>
                        </tr>
                        <tr>
                            <td colspan="5" align="right">
                                <form method="post">
                                    <input type="submit" class="btn btn-success" value="Valider la commande" name="valider">
                                    <input onclick="return confirm('Voulez-vous vider le panier ?')" type="submit" class="btn btn-danger" value="Vider le panier" name="vider">
                                </form>
                            </td>
                        </tr>
                    </tfoot>
                </table>
                <?php
            }
            ?>
        </div>
    </div>
</div>

<script src="../assets/js/produit/counter.js"></script>

</body>
</html>
