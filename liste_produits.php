<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href=" https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">

</head>
<body>

<?php include 'include/nav.php'; ?>

<div class="container py-2">
    <h4>Liste des Produits</h4>
    <table class="table table-dark table-hover">
        <thead>
            <tr>
                <th>#ID</th>
                <th>LIBELLE</th>
                <th>PRIX</th>
                <th>REMISE</th>
                <th>PRIX AVEC REMISE</th>
                <th>CATEGORIE</th>
                <th>IMAGE</th>
                <th>DATE</th>
                <th>OPERATIONS</th>
            </tr>
        </thead>
        <tbody>
            <?php 
              require_once 'include/database.php';
              $stmtsql = $pdo->query('SELECT p.*,c.libelle as"categorie_libelle" FROM produit p INNER JOIN categorie c ON p.id_categorie=c.id')->fetchAll(PDO::FETCH_ASSOC);
              foreach ($stmtsql as $produit) {
                $prix=$produit['prix'];
                $remise=$produit['discount'];
                $nouvprix = $prix - (($prix*$remise)/100);

                echo '<tr>';
                echo '<td>'.$produit['id'].'</td>';
                echo '<td>'.$produit['libelle'].'</td>';
                echo '<td>'.$produit['prix'].' DH'.'</td>';
                echo '<td>'.$remise.' %<'.'/td>';
                echo '<td>'.$nouvprix .' DH'.'</td>';
                echo '<td>'.$produit['categorie_libelle'].'</td>';
                echo '<td><img  class="img-fluid"src="uplode/produit/'.$produit['image'].'" alt="'.$produit['libelle'].'" width="70"></td>'; 
                echo '<td>'.$produit['date_creation'].'</td>';
                echo '<td>
                            <a href="modifier_produit.php?id='.$produit['id'].' " type="submit" class="btn btn-primary btn-sm" value"modifier">Modifier</a>
                            <a href="supprimer_produit.php?id='.$produit['id'].' " class="btn btn-danger btn-sm" value"supprimer">Supprimer</a>
                    </td>';
                echo '</tr>';
              }
            ?>
        </tbody>
    </table>
    <a href="produit.php" class="btn btn-success">Ajouter un Produit</a>


    
</div>

</body>
</html>
