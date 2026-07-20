<?php
session_start();
include('../inc/function.php');

if (!isset($_SESSION['user_id'])) {
    die("Vous devez etre connecte pour voir les produits.");
}

$produits = get_tous_produits_membre();
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/css/style.css" />
    <title>Produit</title>
</head>

<body>
    <header class="site-header">
        <a href="accueil.php" class="brand">
            <svg viewBox="0 0 100 100">
                <polygon points="50,10 50,55 20,72 20,35" fill="#B4CD3E" />
                <polygon points="50,10 50,55 80,72 80,35" fill="#78B72A" />
                <polygon points="0,72 30,55 50,72 20,90" fill="#B4CD3E" />
                <polygon points="100,72 70,55 50,72 80,90" fill="#78B72A" />
            </svg>
            IT-food
        </a>
        <nav class="nav">
            <a href="accueil.php">Produits</a>
            <a href="produit.php">Produit</a>
            <a href="vendre.php">Vendre</a>
            <a href="mesVente.php">Mes ventes</a>
            <a href="statistiques.php">Statistiques</a>
            <a href="deconnexion.php">Déconnexion</a>
        </nav>
    </header>

    <div class="container">
        <div class="page-title-row">
            <h1>Tous les produits</h1>
            <a class="btn btn-buy" href="ajouter_product.php">+ Ajouter un produit</a>
        </div>

        <div class="grid-produits">
            <?php foreach ($produits as $produit) { ?>
                <div class="card">
                    <span class="badge"><?= $produit['nom_categorie'] ?></span>
                    <h3><?= $produit['nom'] ?></h3>
                    <p class="vendeur">vendu par <?= $produit['nom_membre'] ?></p>

                    <div class="price-tag"><span><?= $produit['prix_vente'] ?><br>Ar</span></div>

                    <p class="dispo">Quantite disponible : <?= $produit['quantite_dispo'] ?></p>

                    <?php if ($produit['perime']) { ?>
                        <span class="badge">Perime</span>
                    <?php } ?>

                    <a class="btn btn-filtre"
                       href="modifier_product.php?id_produit_membre=<?= $produit['id_produit_membre'] ?>">
                        Modifier
                    </a>
                </div>
            <?php } ?>

            <?php if (empty($produits)) { ?>
                <p>Aucun produit pour le moment.</p>
            <?php } ?>
        </div>
    </div>
</body>

</html>