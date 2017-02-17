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

$query = "INSERT INTO `nc_contatos`(`contato_userID`, `contato_nome`, `contato_email`,`contato_telefone`, `contato_cpf`, `contato_endereco`) VALUES (?,?,?,?,?,?)";  
$stmt = $mysqli->prepare($query);
$stmt->bind_param('isssss',$userConta, $nomeContato, $emailContato, $telContato, $cpfContato, $endContato);
$stmt->execute();

if ($stmt->affected_rows!=1){
    echo "<script> location.href='../contatos.php?success=0#addContato';</script>";
}else{
    echo "<script> location.href='../contatos.php?success=1#addContato';</script>";
}

$stmt->close();
exit;