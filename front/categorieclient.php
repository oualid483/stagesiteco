<?php 
require_once '../include/database.php';

session_start();

$id = $_GET['id'];

$stmtsql = $pdo->prepare("SELECT * FROM categorie WHERE id=?");
$stmtsql->execute([$id]);
$categorie = $stmtsql->fetch(PDO::FETCH_OBJ);


$stmtsql = $pdo->prepare("SELECT * FROM produit WHERE id_categorie=?");
$stmtsql->execute([$id]);
$produits = $stmtsql->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Categorie | <?php echo $categorie->libelle; ?></title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href=" https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">
    <link href="../assets/css/produit.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>


</head>
<body>
<?php  include '../include/nav_front.php' ?>


<div class="container py-2">
    <h4><?php echo $categorie->libelle; ?>  <i class="<?= htmlspecialchars($categorie->icone) ?>"></i></h4>
        <div class="container">

            <div class="row">
                <?php 
                foreach ($produits as $produit){
                    $idProduit=$produit['id'];
                ?>
                 <div class="card mb-3 col-md-4 m-1">
                        <img src="../uplode/produit/<?= $produit['image'] ?>" width="200%" height="300" class="card-img-top w-50 mx-auto" alt="...">
                                 <div class="card-body">
                                     <h5 class="card-title"><?= $produit['libelle'] ?></h5>
                                     <p class="card-text"><?= $produit['descriptione'] ?></p>
                                     <p class="card-text"><?= $produit['prix'] ?> DH</p>
                                    <p class="card-text"><small class="text-body-secondary"> Ajouter Le <?= date_format(date_create($produit['date_creation']),'Y/m/d') ?></small></p>
                                    <a href="produitclient.php?id=<?= $idProduit ?>" class="btn stretched-link">Afficher plus de details</a>

                                 </div>
                    <div class="card-footer" style="z-index: 10">
                        
                        <?php include '../include/front/counter.php' ?>
                   
                    </div>
                </div>
               
   
                <?php

                }
                if(empty($produits)){
                    echo '<div class="alert alert-warning" role="alert">Aucun produit trouve dans cette categorie pour l\'instant</div>';
                }
                ?>

               
        </div>
</div>

<script src="../assets/js/produit/counter.js"></script>


</body>
</html>
