<?php 
session_start();
$conn = false;
if(isset($_SESSION['utilisateur'])){
    $conn = true;
}
?>
<nav class="navbar navbar-expand-lg bg-body-tertiary">
<div class="container-fluid">
  <img src="./img/to.png" alt="logo" width="100">
  <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <?php
        $currentpage=$_SERVER['PHP_SELF'];

  ?>
  <div class="collapse navbar-collapse" id="navbarNav">
    <ul class="navbar-nav">

     
      <?php
        if($conn){
            ?>
     <li class="nav-item">
        <a class="nav-link <?php if($currentpage == '/projetfatima/liste_categorie.php') echo 'active'?>" aria-current="page" href="liste_categorie.php"><i class="fa-solid fa-network-wired"></i>Liste des Categories</a>
      </li>

      <li class="nav-item">
        <a class="nav-link  <?php if($currentpage == '/projetfatima/liste_produits.php') echo 'active'?>" aria-current="page" href="liste_produits.php"><i class="fa-solid fa-tag"></i>Liste des Produit</a>
      </li>

      <li class="nav-item">
        <a class="nav-link <?php if($currentpage == '/projetfatima/commandes.php') echo 'active'?>" aria-current="page" href="commandes.php"
        ><i class="fa-solid fa-envelope"></i>Commandes</a>
      </li>

      <li class="nav-item">
        <a class="nav-link" aria-current="page" href="deconnexion.php">
            <i class="fa-solid fa-right-from-bracket"></i> Deconnexion
        </a>
      </li>


      <?php
        }else{ 
            ?>
         <li class="nav-item">
             <a class="nav-link  <?php if($currentpage == '/projetfatima/index.php') echo 'active'?>" aria-current="page" href="index.php"><i class="fa-solid fa-user-plus"></i>Ajouter Un Utilisateur</a>
        </li>

        <li class="nav-item">
        <a class="nav-link  <?php if($currentpage == '/projetfatima/connexion.php') echo 'active'?>" href="connexion.php"><i class="fa-solid fa-user"></i>Connexion</a>
        </li>
        <?php
     
         }
      ?>

    </ul>
  </div>
</div>
</nav>
