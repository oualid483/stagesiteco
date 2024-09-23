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
            <h4>Modifier La Categorie</h4>
    <?php 
            include 'include/database.php';
            $id = $_GET['id'];
            $stmtsql = $pdo->prepare('SELECT * FROM  categorie WHERE id=?');
            $stmtsql->execute([$id]);
            $categoriee = $stmtsql->fetch(PDO::FETCH_ASSOC);
        if(isset($_POST['modifier'])){

            $libelle = $_POST['libelle'];
            $desc = $_POST['description'];
            $icone = $_POST['icone'];

            if(!empty($libelle) && !empty($desc) && !empty($icone)){
                $stmtsql = $pdo->prepare('UPDATE categorie SET libelle  = ?, descriptione = ? , icone = ? WHERE   id = ?');
                $stmtsql->execute([$libelle,$desc,$icone,$id]);
                header('Location: liste_categorie.php');
                exit();
                                                  }
        else{
    ?> 
            <div class="alert alert-danger" role="alert">
            Veuillez remplir tous les champs
            </div>
   <?php
            }
                                         }
    ?>
    <form action="" method="POST">
         <input type="hidden" class="form-control" name="id" value="<?php echo $categoriee['id']?>">

        <label class="form-label">Libelle</label>
        <input type="text" class="form-control" name="libelle" value="<?php echo $categoriee['libelle']?>">

        <label class="form-label">Description</label>
        <textarea class="form-control" name="description"><?php echo $categoriee['descriptione']?></textarea>

        <label class="form-label">Icone</label>
        <input type="text" class="form-control" name="icone" value="<?php echo $categoriee['icone']?>">
      
        <button type="submit" class="btn btn-primary my-2" name="modifier" value="modifier categorie" >Modifier</button>
    </form>
</div>

</body>
</html>
