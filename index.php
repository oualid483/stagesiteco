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
    <h4>Ajouter un Utilisateur</h4>
    <?php 
    if (isset($_POST['ajouter'])) {
        $login = $_POST['login'];
        $pwd = $_POST['password'];
        
        if (!empty($login) && !empty($pwd)) {
            require_once 'include/database.php';
            
            // Vérifier si l'utilisateur existe déjà
            $stmtCheck = $pdo->prepare('SELECT COUNT(*) FROM utilisateur WHERE login = ? AND password = ?');
            $stmtCheck->execute([$login,$pwd]);
            $utilisateur= $stmtCheck->fetchColumn();
            
            if ( $utilisateur) {
                echo '<div class="alert alert-warning" role="alert">
                    Ce compte existe déjà
                </div>';
            } else {
                // Insérer le nouvel utilisateur
                $date = date('Y-m-d');
                $stmtInsert = $pdo->prepare('INSERT INTO utilisateur VALUES (null, ?, ?, ?)');
                $stmtInsert->execute([$login, $pwd, $date]);
                echo '<div class="alert alert-success" role="alert">
                    Utilisateur ajouter avec succes
                </div>';
            }
        } else {
            echo '<div class="alert alert-danger" role="alert">
                Veuillez remplir tous les champs
            </div>';
        }
    }
    ?>
    <form action="" method="POST">
        <label class="form-label">Nom d'utilisateur</label>
        <input type="text" class="form-control" name="login">

        <label class="form-label">Mot de passe</label>
        <input type="password" class="form-control" name="password">
      
        <button type="submit" class="btn btn-primary my-2" name="ajouter" value="ajouter">Ajouter</button>
    </form>
</div>

</body>
</html>
