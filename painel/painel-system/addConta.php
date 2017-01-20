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
$tipoConta=$_GET['tipo'];

if ($tipoConta=="R"){
    $arquivo="contasReceber.php";
}

if ($tipoConta=="P"){
    $arquivo="contasPagar.php";
}

$nomeConta = $_POST['nomeConta'];
$fonteConta = $_POST['fonteConta'];
$valorConta = $_POST['valorConta'];
$valorConta = str_replace(",",".", $valorConta);

if ($valorConta==0){
    echo "<script> location.href='../$arquivo?success=-1#addConta';</script>";
}

$dataConta = $_POST['dataConta'];

if (isset($_POST['statusConta'])){
    $statusConta = 1;    
}else{
    $statusConta = 0;
}

if (isset($_POST['mesesConta'])){
    $mesesConta = $_POST['mesesConta'];    
}else{
    $mesesConta = 1;
}

if ($fonteConta=="Selecione o Contato"){
    $fonteConta="";
}

if ($tipoConta=="R" || $tipoConta=="P"){

    if ($userConta!=null && $tipoConta!=null && $nomeConta!=null && $valorConta!=null &&$dataConta!=null){

        for ($i=0;$i<$mesesConta;$i++){
            $query = "INSERT INTO `nc_contas`(`conta_userID`, `conta_nome`, `conta_fonteID`,`conta_valor`, `conta_data`,`conta_tipo`, `conta_status`) VALUES (?,?,?,?,?,?,?)";  
            $stmt = $mysqli->prepare($query);
            $stmt->bind_param('issssss',$userConta, $nomeConta, $fonteConta, $valorConta, $dataConta, $tipoConta, $statusConta);
            $stmt->execute();

            if ($stmt->affected_rows!=1){
                echo "<script> location.href='../$arquivo?success=0#addConta';</script>";
            }

            $dataConta = date('Y-m-d', strtotime("+1 month", strtotime($dataConta)));
        }

        $stmt->close();
        
        echo "<script> location.href='../$arquivo?success=1#addConta';</script>";

        exit;

    }else{
        echo "<script> location.href='../$arquivo?success=0#addConta';</script>";
    }
}else{
    echo "<script> location.href='../$arquivo?success=0#addConta';</script>";
}

?>