<?php
include_once '../inc/function.php';
session_start();

if (!empty($_POST['etu'])) {
    $etu = $_POST['etu'];
    $user = checkLogin($etu);

    if ($user) {

        $_SESSION['user_id'] = $user['id_membre'];
        $_SESSION['user_name'] = $user['nom'];

        header('Location: accueil.php');
        exit();

    } elseif (!empty($_POST['nom'])) {
        $nom = $_POST['nom'];
        $user = add_user($etu, $nom);

        $_SESSION['user_id'] = $user['id_membre'];
        $_SESSION['user_name'] = $user['nom'];

        header('Location: accueil.php');
        exit();

    } else {
        echo '<form method="post" action="">';
        echo '<p>Numero etudiant inconnu, merci de saisir votre nom :</p>';
        echo '<input type="hidden" name="etu" value="'.$etu.'">';
        echo '<input type="text" name="nom" placeholder="Votre nom">';
        echo '<button type="submit">Valider</button>';
        echo '</form>';
        exit();
    }

} else {
   header('Location: index.php?error=2');
   exit();
}