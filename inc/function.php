<?php

function dbconnect()
{
    static $connect = null;

    if ($connect === null) {
        $connect = mysqli_connect('localhost', 'root', '', 'itfood');

        if (!$connect) {
            die('Erreur de connexion à la base de données : ' . mysqli_connect_error());
        }

        mysqli_set_charset($connect, 'utf8mb4');
    }

    return $connect;
}


// ---------------------------
// LOGIN / MEMBRE
// ---------------------------

function checkLogin($etu) {
    $connect = dbconnect();

    $sql = "SELECT * FROM membre WHERE numero_etu = '$etu'";
    $resultat = mysqli_query($connect, $sql);
    $ligne = mysqli_fetch_assoc($resultat);

    return $ligne ? $ligne : null;
}

function add_user($etu, $nom) {
    $connect = dbconnect();

    $sql = "INSERT INTO membre (nom, numero_etu) VALUES ('$nom', '$etu')";
    mysqli_query($connect, $sql);

    $nouvel_id = mysqli_insert_id($connect);

    $sql2 = "SELECT * FROM membre WHERE id_membre = $nouvel_id";
    $resultat = mysqli_query($connect, $sql2);
    $ligne = mysqli_fetch_assoc($resultat);

    return $ligne;
}


// ---------------------------
// PRODUITS (catalogue de base)
// ---------------------------

function get_all_product() {
    $connect = dbconnect();

    $sql = "SELECT * FROM produit";
    $resultat = mysqli_query($connect, $sql);

    $produits = [];
    while ($ligne = mysqli_fetch_assoc($resultat)) {
        $produits[] = $ligne;
    }

    return $produits;
}

function get_produit_par_id($id_produit) {
    $connect = dbconnect();

    $sql = "SELECT * FROM produit WHERE id_produit = $id_produit";
    $resultat = mysqli_query($connect, $sql);
    $ligne = mysqli_fetch_assoc($resultat);

    return $ligne;
}

function get_photo_defaut_produit($id_produit) {
    $connect = dbconnect();

    $sql = "SELECT photo FROM produit WHERE id_produit = '$id_produit'";
    $resultat = mysqli_query($connect, $sql);
    $ligne = mysqli_fetch_assoc($resultat);

    if ($ligne) {
        $photo = $ligne['photo'];
    } else {
        $photo = null;
    }

    return $photo;
}

function get_categories() {
    $connect = dbconnect();

    $sql = "SELECT * FROM categorie";
    $resultat = mysqli_query($connect, $sql);

    $categories = [];
    while ($ligne = mysqli_fetch_assoc($resultat)) {
        $categories[] = $ligne;
    }

    return $categories;
}

function get_nom_categorie($id_categorie) {
    $connect = dbconnect();

    $sql = "SELECT nom_categorie FROM categorie WHERE id_categorie = $id_categorie";
    $resultat = mysqli_query($connect, $sql);
    $ligne = mysqli_fetch_assoc($resultat);

    return $ligne ? $ligne['nom_categorie'] : '';
}


// ---------------------------
// PRODUIT_MEMBRE (produits mis en vente)
// ---------------------------

// Utilisee sur accueil.php (avec filtres categorie / produit)
function get_produits_filtre($id_categorie, $id_produit) {
    $connect = dbconnect();

    $sql = "SELECT
                pm.id_produit_membre,
                pm.prix_vente,
                pm.quantite_dispo,
                pm.photo,
                pm.perime,
                p.id_produit,
                p.nom,
                p.photo AS photo_defaut,
                c.id_categorie,
                c.nom_categorie,
                m.nom AS nom_membre
            FROM produit_membre pm
            INNER JOIN produit p ON pm.id_produit = p.id_produit
            INNER JOIN categorie c ON p.id_categorie = c.id_categorie
            INNER JOIN membre m ON pm.id_membre = m.id_membre
            WHERE pm.quantite_dispo > 0
              AND pm.perime = 0";

    if ($id_categorie > 0) {
        $sql .= " AND c.id_categorie = $id_categorie";
    }

    if ($id_produit > 0) {
        $sql .= " AND p.id_produit = $id_produit";
    }

    $resultat = mysqli_query($connect, $sql);

    $produits = [];
    while ($ligne = mysqli_fetch_assoc($resultat)) {
        $produits[] = $ligne;
    }

    return $produits;
}

// Utilisee sur produit.php : tous les produits mis en vente par TOUS les membres
// (pour l'instant sans filtre par membre connecte, adapte si besoin)
function get_tous_produits_membre() {
    $connect = dbconnect();

    $sql = "SELECT
                pm.id_produit_membre,
                pm.prix_vente,
                pm.quantite_dispo,
                pm.perime,
                p.nom,
                c.nom_categorie,
                m.nom AS nom_membre
            FROM produit_membre pm
            INNER JOIN produit p ON pm.id_produit = p.id_produit
            INNER JOIN categorie c ON p.id_categorie = c.id_categorie
            INNER JOIN membre m ON pm.id_membre = m.id_membre";

    $resultat = mysqli_query($connect, $sql);

    $produits = [];
    while ($ligne = mysqli_fetch_assoc($resultat)) {
        $produits[] = $ligne;
    }

    return $produits;
}

// Utilisee sur modifier_product.php pour pre-remplir le formulaire
function get_produit_membre($id_produit_membre) {
    $connect = dbconnect();

    $sql = "SELECT * FROM produit_membre WHERE id_produit_membre = $id_produit_membre";
    $resultat = mysqli_query($connect, $sql);
    $ligne = mysqli_fetch_assoc($resultat);

    return $ligne;
}

// Ajout d'un nouveau produit mis en vente (avec photo et perime)
function add_produit_membre($id_produit, $id_membre, $prix_vente, $quantite_dispo, $date_dispo, $photo, $perime) {
    $connect = dbconnect();

    // Si la photo est vide, on met NULL dans la requete
    if ($photo === null) {
        $photo_sql = "NULL";
    } else {
        $photo_sql = "'$photo'";
    }

    $sql = "INSERT INTO produit_membre
                (id_produit, id_membre, prix_vente, quantite_dispo, date_dispo, photo, perime)
            VALUES
                ($id_produit, $id_membre, $prix_vente, $quantite_dispo, '$date_dispo', $photo_sql, $perime)";

    mysqli_query($connect, $sql);
}

// Modification d'un produit mis en vente deja existant
function modifier_produit_membre($id_produit_membre, $prix_vente, $quantite_dispo, $date_dispo, $perime) {
    $connect = dbconnect();

    $sql = "UPDATE produit_membre
            SET prix_vente = $prix_vente,
                quantite_dispo = $quantite_dispo,
                date_dispo = '$date_dispo',
                perime = $perime
            WHERE id_produit_membre = $id_produit_membre";

    mysqli_query($connect, $sql);
}


// ---------------------------
// ACHAT / VENTE
// ---------------------------

function acheter_produit($id_produit_membre, $quantite) {
    $connect = dbconnect();

    // On verifie la quantite disponible
    $sql = "SELECT quantite_dispo FROM produit_membre WHERE id_produit_membre = $id_produit_membre";
    $resultat = mysqli_query($connect, $sql);
    $ligne = mysqli_fetch_assoc($resultat);

    if (!$ligne || $ligne['quantite_dispo'] < $quantite) {
        return false;
    }

    // On enregistre la vente
    $date = date('Y-m-d');
    $heure = date('H:i:s');

    $sql2 = "INSERT INTO vente (`date`, `heure`, id_produit_membre, quantite)
              VALUES ('$date', '$heure', $id_produit_membre, $quantite)";
    mysqli_query($connect, $sql2);

    // On diminue la quantite disponible
    $sql3 = "UPDATE produit_membre
             SET quantite_dispo = quantite_dispo - $quantite
             WHERE id_produit_membre = $id_produit_membre";
    mysqli_query($connect, $sql3);

    return true;
}

function get_total_ventes($id_membre) {
    $connect = dbconnect();

    $sql = "SELECT SUM(v.quantite * pm.prix_vente) AS total
            FROM vente v
            INNER JOIN produit_membre pm ON v.id_produit_membre = pm.id_produit_membre
            WHERE pm.id_membre = $id_membre";

    $resultat = mysqli_query($connect, $sql);
    $ligne = mysqli_fetch_assoc($resultat);

    return $ligne['total'];
}


// ---------------------------
// STATISTIQUES
// ---------------------------

// Ventes regroupees par categorie
function get_ventes_categories() {
    $connect = dbconnect();

    $sql = "SELECT
                c.id_categorie,
                c.nom_categorie,
                SUM(v.quantite) AS qte_vendue,
                SUM(v.quantite * pm.prix_vente) AS total_vente
            FROM vente v
            INNER JOIN produit_membre pm ON v.id_produit_membre = pm.id_produit_membre
            INNER JOIN produit p ON pm.id_produit = p.id_produit
            INNER JOIN categorie c ON p.id_categorie = c.id_categorie
            GROUP BY c.id_categorie, c.nom_categorie";

    $resultat = mysqli_query($connect, $sql);

    $lignes = [];
    while ($ligne = mysqli_fetch_assoc($resultat)) {
        $lignes[] = $ligne;
    }

    return $lignes;
}

// Ventes regroupees par produit, pour une categorie donnee
function get_ventes_produits($id_categorie) {
    $connect = dbconnect();

    $sql = "SELECT
                p.id_produit,
                p.nom,
                SUM(v.quantite) AS qte_vendue,
                SUM(v.quantite * pm.prix_vente) AS total_vente
            FROM vente v
            INNER JOIN produit_membre pm ON v.id_produit_membre = pm.id_produit_membre
            INNER JOIN produit p ON pm.id_produit = p.id_produit
            WHERE p.id_categorie = $id_categorie
            GROUP BY p.id_produit, p.nom";

    $resultat = mysqli_query($connect, $sql);

    $lignes = [];
    while ($ligne = mysqli_fetch_assoc($resultat)) {
        $lignes[] = $ligne;
    }

    return $lignes;
}

// Ventes regroupees par membre, pour un produit donne
function get_ventes_membres($id_produit) {
    $connect = dbconnect();

    $sql = "SELECT
                m.id_membre,
                m.nom,
                SUM(v.quantite) AS qte_vendue,
                SUM(v.quantite * pm.prix_vente) AS total_vente
            FROM vente v
            INNER JOIN produit_membre pm ON v.id_produit_membre = pm.id_produit_membre
            INNER JOIN membre m ON pm.id_membre = m.id_membre
            WHERE pm.id_produit = $id_produit
            GROUP BY m.id_membre, m.nom";

    $resultat = mysqli_query($connect, $sql);

    $lignes = [];
    while ($ligne = mysqli_fetch_assoc($resultat)) {
        $lignes[] = $ligne;
    }

    return $lignes;
}