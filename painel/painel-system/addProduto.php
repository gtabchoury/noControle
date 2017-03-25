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

$userConta=$_SESSION['usuario_id'];

$nomeProduto = $_POST['nomeProduto'];
$estoqueProduto = $_POST['estoqueProduto'];

$query = "INSERT INTO `nc_produtos`(`pro_nome`, `pro_userID`, `pro_estoque`) VALUES (?,?,?)";  
$stmt = $mysqli->prepare($query);
$stmt->bind_param('sii',$nomeProduto,$userConta, $estoqueProduto);
$stmt->execute();

if ($stmt->affected_rows!=1){
    echo "<script> location.href='../estoque?success=0#addProduto';</script>";
}else{
    echo "<script> location.href='../estoque?success=1#addProduto';</script>";
}

$stmt->close();
exit;