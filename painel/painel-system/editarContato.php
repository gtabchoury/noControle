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

$userConta=$_SESSION['usuario_id'];

$nomeContato = $_POST['nomeContato'];
$emailContato = $_POST['emailContato'];
$telContato = $_POST['telContato'];
$cpfContato = $_POST['cpfContato'];
$endContato = $_POST['endContato'];

if (isset($_POST['id']))
    $idContato = $_POST['id'];
else
    echo "<script> location.href='../contatos.php';</script>";


$query = "UPDATE `nc_contatos` SET `contato_nome`=?,`contato_email`=?,`contato_telefone`=?,`contato_cpf`=?,`contato_endereco`=? WHERE contato_id=?;";  
$stmt = $mysqli->prepare($query);
$stmt->bind_param('sssssi',$nomeContato, $emailContato, $telContato, $cpfContato, $endContato,$idContato);
$stmt->execute();

if ($stmt->affected_rows==1){
    echo "<script> location.href='../contatos.php';</script>";
}else{
    echo "<script> location.href='../contatos.php';</script>";
}

$stmt->close();

exit;


?>