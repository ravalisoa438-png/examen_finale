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
function 