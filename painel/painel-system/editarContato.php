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

$nomeContato = $_POST['nomeContato'];
$emailContato = $_POST['emailContato'];
$telContato = $_POST['telContato'];
$docContato = $_POST['docContato'];
$endContato = $_POST['endContato'];


if (isset($_POST['id']))
    $idContato = $_POST['id'];
else
    echo "<script> location.href='../contatos';</script>";


$query = "UPDATE `nc_contatos` SET `contato_nome`=?,`contato_email`=?,`contato_telefone`=?,`contato_doc`=?,`contato_endereco`=? WHERE contato_id=?;";  
$stmt = $mysqli->prepare($query);
$stmt->bind_param('sssssi',$nomeContato, $emailContato, $telContato, $docContato, $endContato,$idContato);
$stmt->execute();

if ($stmt->affected_rows==1){
    echo "<script> location.href='../contatos';</script>";
}else{
    echo "<script> location.href='../contatos';</script>";
}

$stmt->close();

exit;


?>