<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter Categorie</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href=" https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">

</head>
<body>

<?php  include 'include/nav.php' ?>

<div class="container py-2">
    <h4>Ajouter un Categorie</h4>
    <?php 
    if(isset($_POST['ajouter'])){
        $libelle = $_POST['libelle'];
        $desc = $_POST['description'];
        $icone = $_POST['icone'];

        if(!empty($libelle) && !empty($desc)){
            require_once 'include/database.php';
            $stmtsql = $pdo->prepare('INSERT INTO categorie(libelle,descriptione,icone) VALUES(?,?,?)');
            $stmtsql->execute([$libelle, $desc,$icone]);
            header('location: liste_categorie.php');

    }else{
?> 
<div class="alert alert-danger" role="alert">
     Veuillez remplir tous les champs
 </div>
<?php
    }
}
    ?>
    <form action="" method="POST">
        <label class="form-label">Libelle</label>
        <input type="text" class="form-control" name="libelle">

        <label class="form-label">Description</label>
        <textarea class="form-control" name="description" ></textarea>

        <label class="form-label">Icone</label>
        <input type="text" class="form-control" name="icone">
      
        <button type="submit" class="btn btn-primary my-2" name="ajouter" value="ajouter categorie">Ajouter</button>
    </form>
</div>

</body>
</html>
