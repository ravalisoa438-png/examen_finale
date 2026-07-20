<?php
ini_set('display_errors', 1);
ini_set('display_error_reporting', E_ALL);
error_reporting(E_ALL);
include('../inc/function.php');
$result = get_all_product();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/css/style.css" />
    <title>Ajouter un produit</title>
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
        <h1>Ajouter un produit</h1>
        <form action="traitementVente.php" method="post">
            <select name="id_produit" id="">
            <option value="">--Choisir un produit--</option>
                <?php foreach ($result as $key) { ?>
                    <option value="<?= $key['id_produit']; ?>"><?= $key['nom']; ?></option>
                <?php } ?>
            </select>
            <input type="number" name="dispo" id="" placeholder="Quantite disponible">
            <input type="number" name="prix" id="" placeholder="Prix en MGA">
            <label>
                <input type="checkbox" name="perime" value="1">
                Perime
            </label>
            <button type="submit">Vendre</button>
        </form>
    </main>
    <footer></footer>
</body>
</html>