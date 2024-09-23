<?php 
include_once 'include/database.php';
$id=$_GET['id'];
$etat=$_GET['etat'];

$stmt = $pdo->prepare("UPDATE commande SET valide = ? WHERE id = ?");
$stmt->execute([$etat, $id]);
header('location:commande.php?id='.$id);
?>