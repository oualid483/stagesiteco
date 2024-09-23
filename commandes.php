<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des Commandes</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <link href=" https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">

</head>
<body>

<?php include 'include/nav.php'; ?>

<div class="container py-2">
    <h4>Liste des Commandes</h4>
    <table class="table table-dark table-hover">
        <thead>
            <tr>
                <th>#ID</th>
                <th>CLIENT</th>
                <th>TOTAL</th>
                <th>DATE</th>
                <th>OPERATIONS</th>
            </tr>
        </thead>
        <tbody>
            <?php 
                require_once 'include/database.php';
                $stmtsql = $pdo->query('SELECT commande.*, client.login 
                        FROM commande 
                        INNER JOIN client 
                        ON commande.id_client = client.id 
                        ORDER BY date_commande DESC')->fetchAll(PDO::FETCH_ASSOC);
                foreach($stmtsql as $commande){
                    echo '<tr>';
                    echo '<td>'. $commande['id'] .'</td>';
                    echo '<td>'. $commande['login'] .'</td>';
                    echo '<td>'. $commande['total'] .' DH'.'</td>';
                    echo '<td>'. $commande['date_commande'] .'</td>';
                    echo '<td>
                             <a href="commande.php?id='. $commande['id'] . '" class="btn btn-info btn-sm">Details</a>
                          </td>';
                    echo '</tr>';  
                }
            ?>
        </tbody>
    </table>
</div>
</body>
</html>
