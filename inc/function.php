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
function get_all_product() {
    $sql = "select * from produit";
    return get_all_lines($sql);
}
function add_produit_membre($id_produit, $id_membre, $prix_vente, $quantite_dispo, $date_dispo) {
    $sql = "insert into produit_membre (id_produit, id_membre, prix_vente, quantite_dispo, date_dispo)
            values ($id_produit, $id_membre, $prix_vente, $quantite_dispo, '$date_dispo')";
    $req = mysqli_query(dbconnect(), $sql);
    if (!$req) {
        die('Erreur SQL : ' . mysqli_error(dbconnect()));
    }
    return $req;
} 