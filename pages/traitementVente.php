<?php
session_start();
include('../inc/function.php');

if (!isset($_SESSION['user_id'])) {
    die("Vous devez etre connecte pour vendre un produit.");
}

$id_produit = $_POST['id_produit'];
$quantite_dispo = $_POST['dispo'];
$prix_vente = $_POST['prix'];
$date_dispo = date('Y-m-d');
$perime = isset($_POST['perime']) ? 1 : 0;

if (!empty($_POST['id_produit_membre'])) {
    modifier_produit_membre($_POST['id_produit_membre'], $prix_vente, $quantite_dispo, $date_dispo, $perime);
} else {
    add_produit_membre($id_produit, $_SESSION['user_id'], $prix_vente, $quantite_dispo, $date_dispo, $perime);
}

header('Location: accueil.php');
exit();