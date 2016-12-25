<?php

 include("conexao.php");
 ini_set('default_charset','UTF-8');

 if (!isset($_SESSION)){
     session_start();
 }

 if (isset($_POST['email'])){
     
    if (isset($_POST['senha'])){
        

        $_SESSION['erro']=0;
        $_SESSION['email'] = $mysqli->escape_string($_POST['email']);
        $senha = $_POST['senha'];

        $email=$_SESSION['email'];

        $query = "SELECT user_password, user_id, user_name from nc_users WHERE user_email=? ";
        $stmt = $mysqli->prepare($query);
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $stmt->bind_result($hash, $user_id, $user_name);

        if ($stmt->fetch()){
            $crypt_senha = crypt($senha, $hash);
            if ($crypt_senha==$hash){
                $_SESSION['usuario_id'] = $user_id;
                $_SESSION['usuario_nome'] = $user_name;
                $_SESSION['erro']=0;
                //echo "<script>location.href='../inicio.php';</script>";
                echo "login efetuado";
            }else{
                $_SESSION['erro']=1;
                header('location:../login.php');
            }
        }else{ 
            $_SESSION['erro']=1;
            header('location:../login.php');
        }

        $stmt->close();
    
    }else{
        echo "<script> alert('Senha inválida!');</script>";
    }
    
 }else{
     echo "<script> alert('Email inválido!');</script>";
 }

?>