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

$nome = $_POST['nomeProduto'];
$estoque = $_POST['estoqueProduto'];



if (isset($_POST['id']))
    $idProduto = $_POST['id'];
else
    echo "<script> location.href='../estoque';</script>";


$query = "UPDATE `nc_produtos` SET `pro_nome`=?,`pro_estoque`=? WHERE pro_id=?;";  
$stmt = $mysqli->prepare($query);
$stmt->bind_param('sii', $nome, $estoque, $idProduto);
$stmt->execute();

if ($stmt->affected_rows==1){
    echo "<script> location.href='../estoque';</script>";
}else{
    echo "<script> location.href='../estoque';</script>";
}

$stmt->close();

exit;


?>