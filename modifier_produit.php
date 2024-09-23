<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modifier Produit</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href=" https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">

</head>
<body>

<?php  
require_once 'include/database.php';
include 'include/nav.php'; 
?>

<div class="container py-2">
    <h4>Modifier Le Produit</h4>
    <?php 
    
        $id = $_GET['id'];
        $stmtsql = $pdo->prepare('SELECT * FROM produit WHERE id=?');
        $stmtsql->execute([$id]);
        $produit = $stmtsql->fetch(PDO::FETCH_ASSOC);

    if (isset($_POST['modifier'])) {
        $libelle = $_POST['libelle'];
        $prix = $_POST['prix'];
        $remise = $_POST['remise'];
        $categorie = $_POST['categorie'];
        $desc = $_POST['description'];
        $date = date('Y-m-d H:i:s');

        $filename ='';
        if(!empty($_FILES['image']['name'])){
            $image = $_FILES['image']['name'];
            $filename = uniqid().$image;
           move_uploaded_file($_FILES['image']['tmp_name'],'uplode/produit/'.$filename);
        }
        
        if (!empty($libelle) && !empty($prix) && !empty($categorie)) {
            $query ="UPDATE produit SET libelle=?, prix=?, discount=?, id_categorie=?, date_creation=? ,descriptione = ? WHERE id=?";
            if(!empty($filename)){
                        $query ="UPDATE produit SET libelle=?, prix=?, discount=?, id_categorie=?, date_creation=? ,descriptione = ? , image=? WHERE id=?";

                        $stmtsql = $pdo->prepare($query);
                        $updated=$stmtsql->execute([$libelle, $prix, $remise, $categorie, $date, $desc,$filename,$id]);
                        }

            else{
                $query ="UPDATE produit SET libelle=?, prix=?, discount=?, id_categorie=?, date_creation=? ,descriptione = ? WHERE id=?";
                $stmtsql = $pdo->prepare($query);
                $updated=$stmtsql->execute([$libelle, $prix, $remise, $categorie, $date, $desc,$id]);
            }
            if($updated){
            header('Location: liste_produits.php');
            }
         
        } else {
            echo '<div class="alert alert-danger" role="alert">Veuillez remplir tous les champs</div>';
        }
    }
    ?>
    <form method="POST" enctype="multipart/form-data">
        <input type="hidden" class="form-control" name="id" value="<?= $produit['id']; ?>">

        <label class="form-label">Libelle</label>
        <input type="text" class="form-control" name="libelle" value="<?php echo $produit['libelle']; ?>">

        <label class="form-label">Description</label>
        <textarea type="text" class="form-control" name="description"><?php echo $produit['descriptione']; ?></textarea>


        <label class="form-label">Prix</label>
        <input type="number" class="form-control" step="0.1" name="prix" min="0" value="<?php echo $produit['prix']; ?>">

        <label class="form-label">Remise</label>
        <input type="range" class="form-control" step="0.1" name="remise" min="0" max="90" value="<?php echo $produit['discount']; ?>">
         
        <label class="form-label">Image</label>
        <input type="file" class="form-control" name="image">
        <img class="img img-fluid" src="uplode/produit/<?= $produit['image'] ?>" alt="" width="170"><br>
        <?php

        ?>


        <?php
        $categories = $pdo->query('SELECT * FROM categorie')->fetchAll(PDO::FETCH_ASSOC);
        ?>
        <label class="form-label">Categorie</label>
        <select class="form-control" name="categorie">
            <option value="">choisir une categorie</option>
            <?php
            foreach ($categories as $categorie) {
                echo '<option value="'.$categorie['id'].'" '.($produit['id_categorie'] == $categorie['id'] ? 'selected' : '').'>'.$categorie['libelle'].'</option>'; 
            }
            ?>
        </select>
      
        <button type="submit" class="btn btn-primary my-2" name="modifier">Modifier</button>
    </form>
</div>

</body>
</html>
