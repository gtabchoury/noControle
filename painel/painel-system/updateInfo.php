<?php

include("../../system/sy-conexao.php");

if (!isset($_SESSION)){
    session_start();
}

if(!isset($_SESSION['usuario_id'])){
    header('Location: ../../login');
    exit;
}

$userName = $_POST['name'];
$userEmail = $_POST['email'];

$query = "UPDATE `nc_users` set user_name=?, user_email=? where user_id=?";
$stmt = $mysqli->prepare($query);
$stmt->bind_param('ssi', $userName, $userEmail, $_SESSION['usuario_id']);
$stmt->execute();

if ($stmt->affected_rows==1){
    $_SESSION['usuario_nome']=$userName;
    $_SESSION['usuario_email']=$userEmail;
    echo "<script> location.href='../perfil?ok=1';</script>";
}else{
    if ($stmt->affected_rows==0){
        echo "<script> location.href='../perfil';</script>";
    }else{ 
        echo "<script> <script> location.href='../perfil?ok=0';</script>";
    }
}

?>