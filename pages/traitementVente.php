<?php
session_start();
include('../inc/fonctions.php');

if (!isset($_SESSION['id_membre'])) {
    die("Vous devez être connecté pour vendre un produit.");
}

$id_produit = $_GET['id_produit'];
$quantite_dispo = $_GET['dispo'];
$prix_vente = $_GET['avendre'];
$date_dispo = date('Y-m-d');

add_produit_membre($id_produit, $_SESSION['id_membre'], $prix_vente, $quantite_dispo, $date_dispo);
?>