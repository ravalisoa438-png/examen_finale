<?php
include("../inc/function.php");

$message = '';

if (!empty($_POST['id_produit_membre']) && !empty($_POST['quantite'])) {
    $id_produit_membre = $_POST['id_produit_membre'];
    $quantite = $_POST['quantite'];

    $ok = acheter_produit($id_produit_membre, $quantite);

    if ($ok) {
        $message = "Achat effectue avec succes.";
    } else {
        $message = "Erreur : quantite non disponible.";
    }
}

$produits = get_produits_dispo();
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/css/style.css" />
    <title>Accueil</title>
</head>

<body>
    <header class="site-header">
        <a href="accueil.php" class="brand">
            <svg viewBox="0 0 100 100">
                <polygon points="50,10 50,55 20,72 20,35" fill="#B4CD3E"/>
                <polygon points="50,10 50,55 80,72 80,35" fill="#78B72A"/>
                <polygon points="0,72 30,55 50,72 20,90" fill="#B4CD3E"/>
                <polygon points="100,72 70,55 50,72 80,90" fill="#78B72A"/>
            </svg>
            IT-food
        </a>
        <nav class="nav">
            <a href="accueil.php">Produits</a>
            <a href="vendre.php">Vendre</a>
            <a href="mesVente.php">Mes ventes</a>
        </nav>
    </header>

    <div class="container">
        <h1>Tous les produits</h1>

        <?php if ($message) { ?>
            <div class="message"><?= $message ?></div>
        <?php } ?>

        <div class="grid-produits">
            <?php foreach ($produits as $produit) { ?>
                <div class="card">
                    <span class="badge"><?= $produit['nom_categorie'] ?></span>
                    <h3><?= $produit['nom'] ?></h3>
                    <p class="vendeur">vendu par <?= $produit['nom_membre'] ?></p>

                    <div class="price-tag"><span><?= $produit['prix_vente'] ?><br>Ar</span></div>

                    <p class="dispo">Quantite disponible : <?= $produit['quantite_dispo'] ?></p>

                    <form class="form-achat" method="post" action="">
                        <input type="hidden" name="id_produit_membre" value="<?= $produit['id_produit_membre'] ?>">
                        <input type="number" name="quantite" min="1" max="<?= $produit['quantite_dispo'] ?>" value="1">
                        <button class="btn btn-buy" type="submit">Acheter</button>
                    </form>
                </div>
            <?php } ?>
        </div>
    </div>
</body>
</html>