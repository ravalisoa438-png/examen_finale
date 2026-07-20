<?php
session_start();
include('../inc/function.php');

if (!isset($_SESSION['user_id'])) {
    die("Vous devez etre connecte pour voir vos ventes.");
}

$total = get_total_ventes($_SESSION['user_id']);
if (!$total) {
    $total = 0;
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mes ventes</title>
</head>
<body>
    <header>
        <h1>Mes ventes</h1>
    </header>
    <main>
        <p>Bonjour <?= $_SESSION['user_name'] ?>, voici le montant total de vos ventes :</p>
        <p><strong><?= $total ?> MGA</strong></p>
    </main>
    <footer></footer>
</body>
</html>