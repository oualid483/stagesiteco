<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href=" https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">

    <style>
        /* Make the category list sticky */
        .sticky-sidebar {
            position: -webkit-sticky; /* For Safari */
            position: sticky;
            top: 20px;
        }
    </style>
</head>
<body>
<?php include '../include/nav_front.php'; ?>

<div class="container py-4">
    <div class="row">
        <!-- Categories on the left -->
        <div class="col-md-3">
            <div class="sticky-sidebar">
                <h4><i class="fa-solid fa-list"></i> Liste des Categories</h4>
                <?php 
                require_once '../include/database.php';
                $categories = $pdo->query("SELECT * FROM categorie")->fetchAll(PDO::FETCH_OBJ);
                ?>

                <ul class="list-group list-group-flush">
                    <?php foreach ($categories as $categorie): ?>
                        <li class="list-group-item">
                            <a href="categorieclient.php?id=<?php echo $categorie->id ?>" class="list-group-item list-group-item-primary">
                                <i class="<?= htmlspecialchars($categorie->icone) ?>"></i> <?= htmlspecialchars($categorie->libelle) ?>
                            </a>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>

        <!-- Products on the right -->
        <div class="col-md-9">
            <div class="row row-cols-1 row-cols-md-2 g-4">
                <?php
                $produits = $pdo->query("SELECT * FROM produit")->fetchAll(PDO::FETCH_OBJ);
                foreach ($produits as $produit):
                ?>
                    <div class="col">
                        <div class="card h-100">
                            <img src="../uplode/produit/<?= $produit->image ?>" class="card-img-top" alt="<?= htmlspecialchars($produit->libelle) ?>">
                            <div class="card-body">
                                <h5 class="card-title"><?= htmlspecialchars($produit->libelle) ?></h5>
                                <p class="card-text"><?= htmlspecialchars($produit->descriptione) ?></p>
                                <p class="card-text"><strong>Prix: <?= htmlspecialchars($produit->prix) ?> DH</strong></p>
                                <a href="produitclient.php?id=<?= $produit->id ?>" class="btn btn-primary">Voir Détails</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>

</body>
</html>
