<?php
include('../inc/function.php');
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@600;700&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/css/style.css" />
    <title>Connexion</title>
</head>
<body>
    <header class="site-header">
        <a href="index.php" class="brand">
            <svg viewBox="0 0 100 100">
                <polygon points="50,10 50,55 20,72 20,35" fill="#B4CD3E"/>
                <polygon points="50,10 50,55 80,72 80,35" fill="#78B72A"/>
                <polygon points="0,72 30,55 50,72 20,90" fill="#B4CD3E"/>
                <polygon points="100,72 70,55 50,72 80,90" fill="#78B72A"/>
            </svg>
            IT-food
        </a>
    </header>

    <div class="form-page">
        <h1>Connectez-vous</h1>
        <form class="auth-form" action="traitementLogin.php" method="post">
            <div class="form-group">
                <label for="etu">ETU</label>
                <input type="text" id="etu" name="etu" value="ETU004958" placeholder="ETU0123" required />
            </div>
            <button type="submit" class="btn btn-primary">Se connecter</button>
        </form>
    </div>
</body>
</html>