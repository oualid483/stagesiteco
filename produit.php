<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter Produit</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href=" https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">

</head>
<body>

<?php  
require_once 'include/database.php' ;
include 'include/nav.php' ?>

<div class="container py-2">
    <h4>Ajouter un Produit</h4>
    <?php 
    if(isset($_POST['ajouter'])){
        $libelle=$_POST['libelle'] ;
        $prix=$_POST['prix'] ;
        $remise=$_POST['remise'] ;
        $categorie=$_POST['categorie'] ;
        $desc = $_POST['description'] ;
        $date = date('Y-m-d H:i:s');

        $filename ='logoo.png';
        if(!empty($_FILES['image']['name'])){
            $image = $_FILES['image']['name'];
            $filename = uniqid().$image;
           move_uploaded_file($_FILES['image']['tmp_name'],'uplode/produit/'.$filename);
        }
        









        if(!empty($libelle) && !empty($prix) && !empty($categorie)){
          $stmtsql = $pdo->prepare('INSERT INTO produit VALUES (null,?,?,?,?,?,?,?)');
          $stmtsql->execute([$libelle, $prix, $remise, $categorie, $date,$desc,$filename]);
          header('location: liste_produits.php');

        }else{
            ?>

             <div class="alert alert-danger" role="alert">
                Veuillez remplir tous les champs
            </div>

            <?php

        }

    }

    ?>
    <form  method="POST" enctype="multipart/form-data">
        <label class="form-label">Libelle</label>
        <input type="text" class="form-control" name="libelle">

        <label class="form-label">Description</label>
        <textarea type="text" class="form-control" name="description"></textarea>

        <label class="form-label">Prix</label>
        <input type="number" class="form-control" step="0.1" name="prix" min="0">

        <label class="form-label">Remise</label>
        <input type="range" class="form-control" step="0.1" name="remise" min="0" max="90" value="0">

        <label class="form-label">Image</label>
        <input type="file" class="form-control" name="image">
     
            <?php
            $categories=$pdo->query('SELECT * FROM categorie')->fetchAll(PDO::FETCH_ASSOC);
            ?>
        <label class="form-label">Categorie</label>

        <select class="form-control" name="categorie">
            <option value="">choisir une categorie</option>
        <?php

        foreach ($categories as $categorie){
            echo '<option value="'.$categorie['id'].'">'.$categorie['libelle'].'</option>'; 
        }
        ?>
        </select>
      
        <button type="submit" class="btn btn-primary my-2" name="ajouter" value="ajouter produit">Ajouter</button>
    </form>
</div>

</body>
</html>
