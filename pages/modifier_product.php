<?php
session_start();
include('../inc/function.php');

if (!isset($_SESSION['user_id'])) {
    die("Vous devez etre connecte pour modifier un produit.");
}

$id_produit_membre = isset($_GET['id_produit_membre']) ? (int)$_GET['id_produit_membre'] : 0;
$produit_membre = get_produit_membre($id_produit_membre);

$result = get_all_product();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/css/style.css" />
    <title>Modifier un produit</title>
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
    <main>
        <h1>Modifier un produit</h1>
        <form action="traitementVente.php" method="post">
            <input type="hidden" name="id_produit_membre" value="<?= $produit_membre['id_produit_membre'] ?>">

            <select name="id_produit" id="">
            <option value="">--Choisir un produit--</option>
                <?php foreach ($result as $key) { ?>
                    <option value="<?= $key['id_produit']; ?>"
                        <?= ($produit_membre['id_produit'] == $key['id_produit']) ? 'selected' : '' ?>>
                        <?= $key['nom']; ?>
                    </option>
                <?php } ?>
            </select>
            <input type="number" name="dispo" id="" placeholder="Quantite disponible"
                value="<?= $produit_membre['quantite_dispo'] ?>">
            <input type="number" name="prix" id="" placeholder="Prix en MGA"
                value="<?= $produit_membre['prix_vente'] ?>">
            <label>
                <input type="checkbox" name="perime" value="1"
                    <?= $produit_membre['perime'] ? 'checked' : '' ?>>
                Perime
            </label>
            <button type="submit">Modifier</button>
        </form>
    </main>
    <footer></footer>
</body>
</html>