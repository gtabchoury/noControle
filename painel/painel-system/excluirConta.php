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

if (isset($_GET['tipo'])){
    $tipoConta=$_GET['tipo'];
}else{
    echo "<script> javascript:history.back();</script>";
}

if ($tipoConta=="R"){
    $arquivo="contasReceber.php";
}

if ($tipoConta=="P"){
    $arquivo="contasPagar.php";
}

if (isset($_POST['id']))
    $contaID = $_POST['id'];
else
    header('Location: ../contasReceber.php');

$query = "DELETE FROM `nc_contas` where conta_id=?";
$stmt = $mysqli->prepare($query);
$stmt->bind_param('i', $contaID);
$stmt->execute();

if ($stmt->affected_rows==1){
    echo "<script> location.href='../$arquivo';</script>";
}else{
    echo "<script> location.href='../$arquivo';</script>";
}

$stmt->close();

?>