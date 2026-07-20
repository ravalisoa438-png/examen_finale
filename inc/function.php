<?php
include_once 'connection.php';

function get_one_line($sql)
{
    $req = mysqli_query(dbconnect(), $sql);
    $result = mysqli_fetch_assoc($req);
    mysqli_free_result($req);
    return $result;
}
function get_all_lines($sql)
{
    $req = mysqli_query(dbconnect(), $sql);
    $result = array();
    while ($line = mysqli_fetch_assoc($req)) {
        $result[] = $line;
    }
    mysqli_free_result($req);
    return $result;
}

function checkLogin($etu)
{
    $sql = "SELECT * FROM membre WHERE numero_etu = '%s' ";
    $sql = sprintf($sql, $etu);
    return get_one_line($sql);
}
function add_user($etu, $nom)
{
    $sql = "INSERT INTO membre (nom,numero_etu) VALUES('%s','%s')";
    $sql = sprintf($sql, $nom, $etu);
    mysqli_query(dbconnect(), $sql);
    return checkLogin($etu);
}
function get_produits_dispo()
{
    $sql = "SELECT pm.id_produit_membre, p.nom, p.prix_reference, pm.prix_vente,
                   pm.quantite_dispo, m.nom AS nom_membre, c.nom_categorie
            FROM produit_membre pm
            JOIN produit p ON pm.id_produit = p.id_produit
            JOIN membre m ON pm.id_membre = m.id_membre
            JOIN categorie c ON p.id_categorie = c.id_categorie
            WHERE pm.quantite_dispo > 0
            ORDER BY p.nom";
    return get_all_lines($sql);
}
 
function get_produit_membre($id_produit_membre)
{
    $sql = "SELECT * FROM produit_membre WHERE id_produit_membre = %d";
    $sql = sprintf($sql, $id_produit_membre);
    return get_one_line($sql);
}
 
function quantite_suffisante($produit_membre, $quantite)
{
    if (!$produit_membre) {
        return false;
    }
    return $produit_membre['quantite_dispo'] >= $quantite;
}
 
function enregistrer_vente($id_produit_membre, $quantite)
{
    $date = date('Y-m-d');
    $heure = date('H:i:s');
 
    $sql = "INSERT INTO vente(`date`,`heure`,id_produit_membre,quantite) VALUES ('%s','%s',%d,%d)";
    $sql = sprintf($sql, $date, $heure, $id_produit_membre, $quantite);
    mysqli_query(dbconnect(), $sql);
}
 
function maj_quantite_dispo($id_produit_membre, $nouvelle_quantite)
{
    $sql = "UPDATE produit_membre SET quantite_dispo = %d WHERE id_produit_membre = %d";
    $sql = sprintf($sql, $nouvelle_quantite, $id_produit_membre);
    mysqli_query(dbconnect(), $sql);
}
 
function acheter_produit($id_produit_membre, $quantite)
{
    $produit_membre = get_produit_membre($id_produit_membre);
 
    if (!quantite_suffisante($produit_membre, $quantite)) {
        return false;
    }
 
    enregistrer_vente($id_produit_membre, $quantite);
 
    $nouvelle_quantite = $produit_membre['quantite_dispo'] - $quantite;
    maj_quantite_dispo($id_produit_membre, $nouvelle_quantite);
 
    return true;
   
}
function get_all_product()
{
    $sql = "SELECT * FROM produit ORDER BY nom";
    return get_all_lines($sql);
}
 
function add_produit_membre($id_produit, $id_membre, $prix_vente, $quantite_dispo, $date_dispo, $perime = 0)
{
    $sql = "INSERT INTO produit_membre(id_produit, id_membre, prix_vente, quantite_dispo, date_dispo, perime)
            VALUES (%d, %d, %d, %d, '%s', %d)";
    $sql = sprintf($sql, $id_produit, $id_membre, $prix_vente, $quantite_dispo, $date_dispo, $perime);
    mysqli_query(dbconnect(), $sql);
}
function get_total_ventes($id_membre)
{
    $sql = "SELECT SUM(v.quantite * pm.prix_vente) AS total
            FROM vente v
            JOIN produit_membre pm ON v.id_produit_membre = pm.id_produit_membre
            WHERE pm.id_membre = %d";
    $sql = sprintf($sql, $id_membre);
    $result = get_one_line($sql);
    return $result['total'];
}
function get_ventes_categories()
{
    $sql = "SELECT c.id_categorie, c.nom_categorie,
                   SUM(v.quantite) AS qte_vendue,
                   SUM(v.quantite * pm.prix_vente) AS total_vente
            FROM vente v
            JOIN produit_membre pm ON v.id_produit_membre = pm.id_produit_membre
            JOIN produit p ON pm.id_produit = p.id_produit
            JOIN categorie c ON p.id_categorie = c.id_categorie
            GROUP BY c.id_categorie, c.nom_categorie
            ORDER BY total_vente DESC";
    return get_all_lines($sql);
}
 
function get_nom_categorie($id_categorie)
{
    $sql = "SELECT nom_categorie FROM categorie WHERE id_categorie = %d";
    $sql = sprintf($sql, $id_categorie);
    $categorie = get_one_line($sql);
    return $categorie['nom_categorie'];
}
 
function get_ventes_produits($id_categorie)
{
    $sql = "SELECT p.id_produit, p.nom,
                   SUM(v.quantite) AS qte_vendue,
                   SUM(v.quantite * pm.prix_vente) AS total_vente
            FROM vente v
            JOIN produit_membre pm ON v.id_produit_membre = pm.id_produit_membre
            JOIN produit p ON pm.id_produit = p.id_produit
            WHERE p.id_categorie = %d
            GROUP BY p.id_produit, p.nom
            ORDER BY total_vente DESC";
    $sql = sprintf($sql, $id_categorie);
    return get_all_lines($sql);
}
 
function get_produit_par_id($id_produit)
{
    $sql = "SELECT nom, id_categorie FROM produit WHERE id_produit = %d";
    $sql = sprintf($sql, $id_produit);
    return get_one_line($sql);
}
 
function get_ventes_membres($id_produit)
{
    $sql = "SELECT m.id_membre, m.nom,
                   SUM(v.quantite) AS qte_vendue,
                   SUM(v.quantite * pm.prix_vente) AS total_vente
            FROM vente v
            JOIN produit_membre pm ON v.id_produit_membre = pm.id_produit_membre
            JOIN membre m ON pm.id_membre = m.id_membre
            WHERE pm.id_produit = %d
            GROUP BY m.id_membre, m.nom
            ORDER BY total_vente DESC";
    $sql = sprintf($sql, $id_produit);
    return get_all_lines($sql);
}
function get_categories()
{
    $sql = "SELECT * FROM categorie ORDER BY nom_categorie";
    return get_all_lines($sql);
}

function get_produits_filtre($id_categorie, $id_produit)
{
    $sql = "SELECT pm.id_produit_membre, p.nom, p.prix_reference, pm.prix_vente,
                   pm.quantite_dispo, m.nom AS nom_membre, c.nom_categorie
            FROM produit_membre pm
            JOIN produit p ON pm.id_produit = p.id_produit
            JOIN membre m ON pm.id_membre = m.id_membre
            JOIN categorie c ON p.id_categorie = c.id_categorie
            WHERE pm.quantite_dispo > 0";

    if ($id_categorie > 0) {
        $sql =$sql . sprintf(" AND p.id_categorie = %d", $id_categorie);
    }

    if ($id_produit > 0) {
        $sql = $sql . sprintf(" AND p.id_produit = %d", $id_produit);
    }

    $sql =$sql . " ORDER BY p.nom";

    return get_all_lines($sql);
}
function modifier_produit_membre($id_produit_membre, $prix_vente, $quantite_dispo, $date_dispo, $perime)
{
    $sql = "UPDATE produit_membre
            SET prix_vente = %d, quantite_dispo = %d, date_dispo = '%s', perime = %d
            WHERE id_produit_membre = %d";
    $sql = sprintf($sql, $prix_vente, $quantite_dispo, $date_dispo, $perime, $id_produit_membre);
    mysqli_query(dbconnect(), $sql);
}
function get_produits_par_membre($id_membre)
{
    $sql = "SELECT pm.id_produit_membre, p.nom, pm.prix_vente, pm.quantite_dispo, pm.date_dispo, pm.perime
            FROM produit_membre pm
            JOIN produit p ON pm.id_produit = p.id_produit
            WHERE pm.id_membre = %d
            ORDER BY p.nom";
    $sql = sprintf($sql, $id_membre);
    return get_all_lines($sql);
}

function get_tous_produits_membre()
{
    $sql = "SELECT pm.id_produit_membre, p.nom, pm.prix_vente, pm.quantite_dispo,
                   pm.date_dispo, pm.perime, m.nom AS nom_membre, c.nom_categorie
            FROM produit_membre pm
            JOIN produit p ON pm.id_produit = p.id_produit
            JOIN membre m ON pm.id_membre = m.id_membre
            JOIN categorie c ON p.id_categorie = c.id_categorie
            ORDER BY p.nom";
    return get_all_lines($sql);
}