<?php  
require_once 'include/database.php';

$idCommande = $_GET['id'];
$stmtsql = $pdo->prepare('SELECT commande.*, client.login 
                    FROM commande 
                    INNER JOIN client 
                    ON commande.id_client = client.id 
                    WHERE commande.id = ?
                    ORDER BY date_commande DESC');
$stmtsql->execute([$idCommande]);
$commande = $stmtsql->fetch(PDO::FETCH_ASSOC);

// Check if the query returned a result
if (!$commande) {
    // Display an error message or redirect the user
    echo '<div class="alert alert-danger" role="alert">Commande non trouvée.</div>';
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Commande | <?= htmlspecialchars($commande['id']) ?></title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">
</head>
<body>

<?php include 'include/nav.php'; ?>

<div class="container py-2">
    <h4>Details Commande</h4>
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
                    $stmtsqlLigneCommandes = $pdo->prepare('SELECT ligne_commande.*, produit.libelle, produit.image 
                    FROM ligne_commande 
                    INNER JOIN produit 
                    ON ligne_commande.id_produit = produit.id 
                    WHERE id_commande = ?');
                    $stmtsqlLigneCommandes->execute([$idCommande]);
                    $lignesCommandes = $stmtsqlLigneCommandes->fetchAll(PDO::FETCH_ASSOC);
            ?>
            <tr>
               <td><?= htmlspecialchars($commande['id']) ?></td>
               <td><?= htmlspecialchars($commande['login']) ?></td>
                <td><?= htmlspecialchars($commande['total']) ?> DH</td>
               <td><?= htmlspecialchars($commande['date_commande']) ?></td>
               <td>
                <?php if($commande['valide'] == 0): ?>
                    <a href="valider_commandes.php?id=<?= $commande['id']?>&etat=1" class="btn btn-success btn-sm">Valider La Commande</a>
                <?php else: ?>
                    <a href="valider_commandes.php?id=<?= $commande['id']?>&etat=0" class="btn btn-danger btn-sm">Annuler La Commande</a>
                <?php endif; ?>
               </td>
            </tr>  
        </tbody>
    </table>
    <hr>
    
    
    <h4>Les Produits Commandees</h4>
    <table class="table table-dark table-hover">
        <thead>
            <tr>
                <th>#ID</th>
                <th>PRODUIT</th>
                <th>IMAGE</th>
                <th>PRIX UNITAIRE</th>
                <th>QUANTITE</th>
                <th>TOTAL</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            foreach($lignesCommandes as $ligneCommande):
            ?>
                <tr>
                    <td><?= htmlspecialchars($ligneCommande['id']) ?></td>
                    <td><?= htmlspecialchars($ligneCommande['libelle']) ?></td>
                    <td><img src="uplode/produit/<?= htmlspecialchars($ligneCommande['image'])?>" alt="Image Produit" width="50" class="img-thumbnail"></td>
                    <td><?= htmlspecialchars($ligneCommande['prix']) ?> DH</td>
                    <td>x <?= htmlspecialchars($ligneCommande['quantite']) ?></td>
                    <td><?= htmlspecialchars($ligneCommande['total']) ?> DH</td>

                </tr>
            <?php endforeach; ?>     
        </tbody>
    </table>
</div>
</body>
</html>
