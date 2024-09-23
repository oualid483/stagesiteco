<?php 
require_once '../include/database.php';
session_start();

// Get product ID from URL
$id = $_GET['id'];

// Fetch the product details from the database
$stmtsql = $pdo->prepare("SELECT * FROM produit WHERE id=?");
$stmtsql->execute([$id]);
$produit = $stmtsql->fetch(PDO::FETCH_ASSOC);

if (!$produit) {
    echo '<div class="alert alert-danger" role="alert">Produit non trouvé.</div>';
    exit();
}

$discount = $produit['discount'];
$prix = $produit['prix'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Produit | <?php echo htmlspecialchars($produit['libelle']); ?></title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">
    <link href="../assets/css/produit.css" rel="stylesheet">
</head>
<body>
<?php include '../include/nav_front.php'; ?>

<div class="container py-2">
    <h4><?php echo htmlspecialchars($produit['libelle']); ?></h4>
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <img class="img img-fluid w-75" src="../uplode/produit/<?= htmlspecialchars($produit['image']) ?>" alt="<?= htmlspecialchars($produit['libelle']) ?>">
            </div>
            <div class="col-md-6">
                <div class="d-flex align-items-center">
                    <h1 class="w-100"><?= htmlspecialchars($produit['libelle']) ?></h1>
                    <?php if (!empty($discount)) { ?>
                        <span class="badge text-bg-danger">- <?= htmlspecialchars($discount) ?>%</span>
                    <?php } ?>
                </div>
                <hr>
                <?php
                if (!empty($discount)) {
                    $total = $prix - (($prix * $discount) / 100);
                ?>
                    <h5>
                        <span class="badge text-bg-secondary"><strike><?= htmlspecialchars($prix) ?> DH</strike></span>
                    </h5>
                    <h5>
                        <span class="badge text-bg-success"><?= htmlspecialchars($total) ?> DH</span>
                    </h5>
                <?php
                } else {
                    $total = $prix;
                ?>
                    <h5><span class="badge text-bg-success"><?= htmlspecialchars($total) ?> DH</span></h5>
                <?php
                }
                ?>
                <p>
                    <?= htmlspecialchars($produit['descriptione']) ?>
                </p>
                <hr>
                <?php
                $idProduit = $produit['id'];
                include '../include/front/counter.php';
                ?>
            </div>
        </div>
    </div>
</div>

<script src="../assets/js/produit/counter.js"></script>
</body>
</html>
