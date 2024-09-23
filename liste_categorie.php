<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Categories</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <link href=" https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">

</head>
<body>

<?php include 'include/nav.php'; ?>

<div class="container py-2">
    <h4>Liste des Categories</h4>
    <table class="table table-dark table-hover">
        <thead>
            <tr>
                <th>#ID</th>
                <th>LIBELLE</th>
                <th>DESCRIPTION</th>
                <th>ICONE</th>
                <th>DATE</th>
                <th>OPERATIONS</th>
            </tr>
        </thead>
        <tbody>
            <?php 
                require_once 'include/database.php';
                $stmtsql = $pdo->query('SELECT * FROM categorie')->fetchAll(PDO::FETCH_ASSOC);
                foreach($stmtsql as $categorie){
                    echo '<tr>';
                    echo '<td>'. $categorie['id'] .'</td>';
                    echo '<td>'. $categorie['libelle'] .'</td>';
                    echo '<td>'. $categorie['descriptione'] .'</td>';
                    echo '<td>'.'<i class="'.$categorie['icone'].'"></i>'.'</td>'; 
                    echo '<td>'. $categorie['date_creation'] .'</td>';
                    echo '<td>
                            <a href="modifier_categorie.php?id=' . $categorie['id'] . '" class="btn btn-primary btn-sm">Modifier</a>
                            <a href="supprimer_categorie.php?id=' . $categorie['id'] . '" class="btn btn-danger btn-sm" onclick="return confirm(\'Etes-vous sûr de vouloir supprimer cette catégorie : ' . $categorie['libelle'] . ' ?\');">Supprimer</a>
                          </td>';
                    echo '</tr>';  
                }
            ?>
        </tbody>
    </table>
    <a href="categorie.php" class="btn btn-success">Ajouter une Categorie</a>
</div>
</body>
</html>
