<?php
include("../../system/sy-conexao.php");
ini_set('default_charset','UTF-8');

if (!isset($_SESSION)){
    session_start();
}

if(!isset($_SESSION['usuario_id'])){
    header('Location: ../../login.php');
    exit;
}


if (isset($_POST['id']))
    $funcID = $_POST['id'];
else
    header('Location: ../contatos.php');

$query = "DELETE FROM `nc_funcionarios` where func_id=?";
$stmt = $mysqli->prepare($query);
$stmt->bind_param('i', $funcID);
$stmt->execute();

if ($stmt->affected_rows==1){
    echo "<script> location.href='../funcionarios.php';</script>";
}else{
    echo "<script> location.href='../funcionarios.php;</script>";
}

$stmt->close();

?>