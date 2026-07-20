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
    <title>Vendre</title>
</head>
<body>
    <header>
        <h1>Vendre un produit</h1>
    </header>
    <main>
        <form action="traitementVente.php" method="post">
            <select name="id_produit" id="">
            <option value="">--Choisir un produit--</option>
                <?php foreach ($result as $key) { ?>
                    <option value="<?= $key['id_produit']; ?>"><?= $key['nom']; ?></option>
                <?php } ?>
            </select>
            <input type="number" name="dispo" id="" placeholder="Quantite disponible">
            <input type="number" name="prix" id="" placeholder="Prix en MGA">
            <button type="submit">Vendre</button>
        </form>
    </main>
    <footer></footer>
</body>
</html>