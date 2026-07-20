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
    <title>Accueil</title>
</head>
<body>
    <h1>Tous les produits</h1>

    <?php if ($message) { ?>
        <p><?= $message ?></p>
    <?php } ?>

    <?php foreach ($produits as $produit) { ?>
        <div>
            <p>
                <strong><?= $produit['nom'] ?></strong>
                (<?= $produit['nom_categorie'] ?>) - vendu par <?= $produit['nom_membre'] ?>
            </p>
            <p>Prix : <?= $produit['prix_vente'] ?> Ar</p>
            <p>Quantite disponible : <?= $produit['quantite_dispo'] ?></p>

            <form method="post" action="">
                <input type="hidden" name="id_produit_membre" value="<?= $produit['id_produit_membre'] ?>">
                <input type="number" name="quantite" min="1" max="<?= $produit['quantite_dispo'] ?>" value="1">
                <button type="submit">Acheter</button>
            </form>
        </div>
        <hr>
    <?php } ?>
</body>
</html>