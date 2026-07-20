<?php 
include('../inc/function.php');

?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css" />
    <title>Document</title>
</head>
<body>
    <h1">Connectez-vous</h1>
    <form class="auth-form" action="traitementLogin.php" method="post">
    <div class="form-group">
        <label for="ETU">ETU</label>
        <input type="text" name="etu" value="ETU004958" placeholder="ETU0123" required />
      </div>
      <button type="submit" class="btn-primary">Se connecter</button>   
    </form>
</body>
</html>