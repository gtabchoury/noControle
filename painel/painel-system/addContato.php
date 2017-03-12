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
$cpfContato = $_POST['cpfContato'];
$cnpjContato = $_POST['cnpjContato'];
$endContato = $_POST['endContato'];

$docContato = "";

if ($cpfContato != ""){
	$docContato = $cpfContato;
}else{
	if ($cnpjContato != ""){
		$docContato = $cnpjContato;
	}
}

$query = "INSERT INTO `nc_contatos`(`contato_userID`, `contato_nome`, `contato_email`,`contato_telefone`, `contato_doc`, `contato_endereco`) VALUES (?,?,?,?,?,?)";  
$stmt = $mysqli->prepare($query);
$stmt->bind_param('isssss',$userConta, $nomeContato, $emailContato, $telContato, $docContato, $endContato);
$stmt->execute();

if ($stmt->affected_rows!=1){
    echo "<script> location.href='../contatos?success=0#addContato';</script>";
}else{
    echo "<script> location.href='../contatos?success=1#addContato';</script>";
}

$stmt->close();
exit;