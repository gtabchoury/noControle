<?php

 include("sy-conexao.php");
 ini_set('default_charset','UTF-8');

 if (!isset($_SESSION)){
     session_start();
 }

 if (isset($_POST['email'])){
     
    if (isset($_POST['senha'])){
        
        $_SESSION['email'] = $mysqli->escape_string($_POST['email']);
        $senha = $_POST['senha'];

        $email=$_SESSION['email'];

        $query = "SELECT user_password, user_id, user_name from nc_users WHERE user_email=? ";
        $stmt = $mysqli->prepare($query);
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $stmt->bind_result($hash, $user_id, $user_name);

        if ($stmt->fetch()){
            $crypt_senha = crypt($senha,$hash);
    
            if ($crypt_senha==$hash){
                $_SESSION['usuario_id'] = $user_id;
                $_SESSION['usuario_nome'] = $user_name;
                $_SESSION['usuario_email'] = $email;
                echo "<script>location.href='../painel/inicio.php';</script>";
            }else{
                echo "<script>location.href='../login.php?erro=1';</script>";
            }
        }else{
            echo "<script>location.href='../login.php?erro=1';</script>";
        }

        $stmt->close();
    
    }else{
        echo "<script>location.href='../login.php?erro=1';</script>";
    }
    
 }else{
     echo "<script>location.href='../login.php?erro=1';</script>";
 }

?>