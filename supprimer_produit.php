<?php 
require_once 'include/database.php';
$id = $_GET['id'];
$stmtsql = $pdo->prepare("DELETE FROM produit WHERE id = ?");
$stmtsql->execute([$id]);
header('location: liste_produits.php');