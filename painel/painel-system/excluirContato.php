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
    $contatoID = $_POST['id'];
else
    header('Location: ../contatos');

$query = "DELETE FROM `nc_contatos` where contato_id=?";
$stmt = $mysqli->prepare($query);
$stmt->bind_param('i', $contatoID);
$stmt->execute();

if ($stmt->affected_rows==1){
    echo "<script> location.href='../contatos';</script>";
}else{
    echo "<script> location.href='../contatos;</script>";
}

$stmt->close();

?>