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

$nomeFunc = $_POST['nomeFuncionario'];
$salFunc = $_POST['salarioFuncionario'];
$salFunc = str_replace(",",".", $salFunc);
$telFunc = $_POST['telFuncionario'];
$cpfFunc = $_POST['cpfFuncionario'];
$endFunc = $_POST['endFuncionario'];


if (isset($_POST['id']))
    $idFunc = $_POST['id'];
else
    echo "<script> location.href='../funcionarios.php';</script>";


$query = "UPDATE `nc_funcionarios` SET `func_nome`=?,`func_salario`=?,`func_telefone`=?,`func_cpf`=?,`func_endereco`=? WHERE func_id=?;";  
$stmt = $mysqli->prepare($query);
$stmt->bind_param('sssssi',$nomeFunc, $salFunc, $telFunc, $cpfFunc, $endFunc,$idFunc);
$stmt->execute();

if ($stmt->affected_rows==1){
    echo "<script> location.href='../funcionarios.php';</script>";
}else{
    echo "<script> location.href='../funcionarios.php';</script>";
}

$stmt->close();

exit;


?>