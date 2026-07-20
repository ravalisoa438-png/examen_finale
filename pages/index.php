<?php
if (!isset($_SESSION['etu'])) {
    header("Location: login.php");
    exit();
} else {
    header("Location: accueil.php");
}

