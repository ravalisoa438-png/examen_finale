<?php
session_start();
include('../inc/function.php');

if (!isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit();
}

if (!empty($_GET['produit'])) {
    $produit = get_produit_par_id($_GET['produit']);

    $niveau = 'membre';
    $titre = 'Ventes de "' . $produit['nom'] . '" par membre';
    $lignes = get_ventes_membres($_GET['produit']);
    $retour = '<a href="statistiques.php?categorie=' . $produit['id_categorie'] . '">Retour aux produits</a>';
} elseif (!empty($_GET['categorie'])) {
    $nom_categorie = get_nom_categorie($_GET['categorie']);

    $niveau = 'produit';
    $titre = 'Ventes de la categorie "' . $nom_categorie . '"';
    $lignes = get_ventes_produits($_GET['categorie']);
    $retour = '<a href="statistiques.php">Retour aux categories</a>';
} else {
    $niveau = 'categorie';
    $titre = 'Ventes par categorie';
    $lignes = get_ventes_categories();
    $retour = '';
}
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Statistiques</title>
</head>

<body>
    <nav>
        <a href="accueil.php">Produits</a>
        <a href="vendre.php">Vendre</a>
        <a href="mesVente.php">Mes ventes</a>
        <a href="statistiques.php">Statistiques</a>
    </nav>

    <h1><?= $titre ?></h1>

    <?php if ($retour) { ?>
        <p><?= $retour ?></p>
    <?php } ?>

    <table border="1" cellpadding="8">
        <tr>
            <th><?= $niveau == 'categorie' ? 'Categorie' : ($niveau == 'produit' ? 'Produit' : 'Membre') ?></th>
            <th>Quantite vendue</th>
            <th>Total (Ar)</th>
        </tr>
        <?php foreach ($lignes as $ligne) { ?>
            <tr>
                <td>
                    <?php if ($niveau == 'categorie') { ?>
                        <a href="statistiques.php?categorie=<?= $ligne['id_categorie'] ?>"><?= $ligne['nom_categorie'] ?></a>
                    <?php } elseif ($niveau == 'produit') { ?>
                        <a href="statistiques.php?produit=<?= $ligne['id_produit'] ?>"><?= $ligne['nom'] ?></a>
                    <?php } else { ?>
                        <?= $ligne['nom'] ?>
                    <?php } ?>
                </td>
                <td><?= $ligne['qte_vendue'] ?></td>
                <td><?= $ligne['total_vente'] ?></td>
            </tr>
        <?php } ?>
    </table>
</body>

</html>