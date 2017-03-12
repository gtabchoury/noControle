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

if (isset($_GET['tipo'])){
    $tipoConta=$_GET['tipo'];
}else{
    echo "<script> javascript:history.back();</script>";
}

if ($tipoConta=="R"){
    $arquivo="contasReceber";
}

if ($tipoConta=="P"){
    $arquivo="contasPagar";
}

$nomeConta = $_POST['nomeConta'];
$fonteConta = $_POST['fonteConta'];
$valorConta = $_POST['valorConta'];
$valorConta = str_replace(",",".", $valorConta);

if (isset($_POST['id']))
    $idConta = $_POST['id'];
else
    echo "<script> location.href='../$arquivo';</script>";

if ($valorConta==0){
    echo "<script> location.href='../$arquivo';</script>";
}

$dataConta = $_POST['dataConta'];

if (isset($_POST['statusConta'])){
    $statusConta = 1;    
}else{
    $statusConta = 0;
}


if ($fonteConta=="Selecione o Contato"){
    $fonteConta="";
}

if ($tipoConta=="R" || $tipoConta=="P"){

    if ($userConta!=null && $tipoConta!=null && $nomeConta!=null && $valorConta!=null &&$dataConta!=null){

        $query = "UPDATE `nc_contas` SET `conta_nome`=?,`conta_fonteID`=?,`conta_valor`=?,`conta_data`=?,`conta_status`=? WHERE conta_id=?;";  
        $stmt = $mysqli->prepare($query);
        $stmt->bind_param('sssssi',$nomeConta, $fonteConta, $valorConta, $dataConta, $statusConta, $idConta);
        $stmt->execute();

        if ($stmt->affected_rows==1){
            echo "<script> location.href='../$arquivo';</script>";
        }else{
            echo "<script> location.href='../$arquivo';</script>";
        }

        $stmt->close();
        
        exit;

    }else{
        echo "<script> location.href='../$arquivo';</script>";
    }

}else{
    echo "<script> location.href='../$arquivo';</script>";
}


?>