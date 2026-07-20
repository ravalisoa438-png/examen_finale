<?php
include("../inc/function.php");

$message = '';

if (!empty($_POST['id_produit_membre']) && !empty($_POST['quantite'])) {
    $id_produit_membre = $_POST['id_produit_membre'];
    $quantite = $_POST['quantite'];

    $ok = acheter_produit($id_produit_membre, $quantite);

    $message = $ok ? "Achat effectue avec succes." : "Erreur : quantite non disponible.";
}

$id_categorie = isset($_GET['id_categorie']) ? (int)$_GET['id_categorie'] : 0;
$id_produit = isset($_GET['id_produit']) ? (int)$_GET['id_produit'] : 0;

$categories = get_categories();
$tous_produits = get_all_product();
$produits = get_produits_filtre($id_categorie, $id_produit);
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
                <polygon points="50,10 50,55 20,72 20,35" fill="#B4CD3E" />
                <polygon points="50,10 50,55 80,72 80,35" fill="#78B72A" />
                <polygon points="0,72 30,55 50,72 20,90" fill="#B4CD3E" />
                <polygon points="100,72 70,55 50,72 80,90" fill="#78B72A" />
            </svg>
            IT-food
        </a>
        <nav class="nav">
            <a href="produit.php">Produits</a>
            <a href="vendre.php">Vendre</a>
            <a href="mesVente.php">Mes ventes</a>
            <a href="statistiques.php">Statistiques</a>
            <a href="deconnexion.php">Déconnexion</a>
        </nav>
    </header>

    <div class="container">
        <h1>Tous les produits</h1>

        <?php if ($message) { ?>
            <div class="message"><?= $message ?></div>
        <?php } ?>

        <form class="form-filtre" method="get" action="">
            <select name="id_categorie">
                <option value="0">Toutes les categories</option>
                <?php foreach ($categories as $categorie) { ?>
                    <option value="<?= $categorie['id_categorie'] ?>"
                        <?= ($id_categorie == $categorie['id_categorie']) ? 'selected' : '' ?>>
                        <?= $categorie['nom_categorie'] ?>
                    </option>
                <?php } ?>
            </select>

            <select name="id_produit">
                <option value="0">Tous les produits</option>
                <?php foreach ($tous_produits as $p) { ?>
                    <option value="<?= $p['id_produit'] ?>"
                        <?= ($id_produit == $p['id_produit']) ? 'selected' : '' ?>>
                        <?= $p['nom'] ?>
                    </option>
                <?php } ?>
            </select>

            <button class="btn btn-filtre" type="submit">Filtrer</button>
        </form>

        <div class="grid-produits">
            <?php foreach ($produits as $produit) { ?>
                <div class="card">
                    <?php if (!empty($produit['photo'])) { ?>
                        <img src="uploads/<?= $produit['photo'] ?>" alt="<?= $produit['nom'] ?>" style="width:100%; height:140px; object-fit:cover; border-radius:var(--radius); margin-bottom:10px;">
                    <?php } elseif (!empty($produit['photo_defaut'])) { ?>
                        <img src="img/produits/<?= $produit['photo_defaut'] ?>" alt="<?= $produit['nom'] ?>" style="width:100%; height:140px; object-fit:cover; border-radius:var(--radius); margin-bottom:10px;">
                    <?php } ?>
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

            <?php if (empty($produits)) { ?>
                <p>Aucun produit ne correspond a ce filtre.</p>
            <?php } ?>
        </div>
    </div>
</body>
</html>