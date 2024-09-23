<?php 
require_once 'include/database.php';
$id = $_GET['id'];
$stmtsql = $pdo->prepare("DELETE FROM categorie WHERE id = ?");
$stmtsql->execute([$id]);
header('location: liste_categorie.php');
