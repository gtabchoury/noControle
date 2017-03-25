<?php
include("../../system/sy-conexao.php");
ini_set('default_charset','UTF-8');

if (!isset($_SESSION)){
    session_start();
}

if(!isset($_SESSION['usuario_id'])){
    header('Location: ../../login');
    exit;
}


if (isset($_POST['id']))
    $idProd = $_POST['id'];
else
    header('Location: ../estoque');

$query = "DELETE FROM `nc_produtos` where pro_id=?";
$stmt = $mysqli->prepare($query);
$stmt->bind_param('i', $idProd);
$stmt->execute();

if ($stmt->affected_rows==1){
    echo "<script> location.href='../estoque';</script>";
}else{
    echo "<script> location.href='../estoque;</script>";
}

$stmt->close();

?>