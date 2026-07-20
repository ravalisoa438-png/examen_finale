<?php
ini_set('display_errors', 1);
ini_set('display_error_reporting', E_ALL);
error_reporting(E_ALL);
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

// Gestion de la photo (seulement utile lors d'un ajout)
$newName = null;

if (isset($_FILES['fichier']) && $_FILES['fichier']['error'] === UPLOAD_ERR_OK) {
    $file = $_FILES['fichier'];
    $uploadDir = __DIR__ . '/uploads/';
    $maxSize = 2 * 1024 * 1024; // 2 Mo
    $allowedMimeTypes = ['image/jpeg', 'image/jpg', 'image/png'];

    if ($file['size'] > $maxSize) {
        die('Le fichier est trop volumineux.');
    }

    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $mime = finfo_file($finfo, $file['tmp_name']);
    finfo_close($finfo);

    if (!in_array($mime, $allowedMimeTypes)) {
        die('Type de fichier non autorisé : ' . $mime);
    }

    $originalName = pathinfo($file['name'], PATHINFO_FILENAME);
    $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
    $newName = $originalName . '_' . uniqid() . '.' . $extension;

    if (!move_uploaded_file($file['tmp_name'], $uploadDir . $newName)) {
        die('Échec du déplacement du fichier.');
    }
}

if (!empty($_POST['id_produit_membre'])) {
    // Modification d'une vente existante
    modifier_produit_membre($_POST['id_produit_membre'], $prix_vente, $quantite_dispo, $date_dispo, $perime);
} else {
    // Ajout d'un nouveau produit a vendre
    if ($newName === null) {
        $newName = get_photo_defaut_produit($id_produit);
    }
    add_produit_membre($id_produit, $_SESSION['user_id'], $prix_vente, $quantite_dispo, $date_dispo, $newName, $perime);
}

header('Location: accueil.php');
exit();