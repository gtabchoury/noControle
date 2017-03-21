<?php

include("../../system/sy-conexao.php");

if (!isset($_SESSION)){
    session_start();
}

if(!isset($_SESSION['usuario_id'])){
    header('Location: ../../login');
    exit;
}

$saldoC = $_POST['saldoC'];
$saldoB = $_POST['saldoB'];
$saldoC = str_replace(",",".", $saldoC);
$saldoB = str_replace(",",".", $saldoB);

$query = "UPDATE `nc_users` set user_saldoCaixa=?, user_saldoBanco=? where user_id=?";
$stmt = $mysqli->prepare($query);
$stmt->bind_param('ssi', $saldoC, $saldoB, $_SESSION['usuario_id']);
$stmt->execute();

if ($stmt->affected_rows==1){
    echo "<script> location.href='../configuracoes?ok=1';</script>";
}else{
    if ($stmt->affected_rows==0){
        echo "<script> location.href='../configuracoes';</script>";
    }else{ 
        echo "<script> <script> location.href='../configuracoes?ok=0';</script>";
    }
}

?>