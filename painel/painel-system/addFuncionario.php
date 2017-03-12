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

$nomeFunc = $_POST['nomeFuncionario'];
$salFunc = $_POST['salarioFuncionario'];
$salFunc = str_replace(",",".", $salFunc);
$telFunc = $_POST['telFuncionario'];
$cpfFunc = $_POST['cpfFuncionario'];
$endFunc = $_POST['endFuncionario'];

$query = "INSERT INTO `nc_funcionarios`(`func_userID`, `func_nome`, `func_salario`,`func_telefone`, `func_cpf`, `func_endereco`) VALUES (?,?,?,?,?,?)";  
$stmt = $mysqli->prepare($query);
$stmt->bind_param('isssss',$userConta, $nomeFunc, $salFunc, $telFunc, $cpfFunc, $endFunc);
$stmt->execute();

if ($stmt->affected_rows!=1){
    echo "<script> location.href='../funcionarios?success=0#addFuncionario';</script>";
}else{
    echo "<script> location.href='../funcionarios?success=1#addFuncionario';</script>";
}

$stmt->close();
exit;