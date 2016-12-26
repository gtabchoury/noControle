<?php

include("sy-conexao.php");
ini_set('default_charset','UTF-8');

if (!isset($_SESSION)){
    session_start();
}

$_SESSION['erroSenha']=0;

if (isset($_POST['userPassword'])){
    
    if (isset($_POST['userPasswordConfirm'])){
        
        if (isset($_SESSION['emailRec'])){
            
            $password = $_POST['userPassword'];
            $passwordConfirm = $_POST['userPasswordConfirm'];
            $userEmail = $_SESSION['emailRec'];
            
            if ($password==$passwordConfirm){
                
                $userPassword = crypt($password);

                $query = "UPDATE `nc_users` set user_password=? where user_email=?";

                $stmt = $mysqli->prepare($query);
                $stmt->bind_param('ss',$userPassword,$userEmail);
                $stmt->execute();

                if ($stmt->affected_rows==1){
                    $_SESSION['emailRec']="";
                    echo "<script> location.href='../senhaAlterada.php';</script>";
                }else{
                    $_SESSION['erroSenha']=2;
                    echo "<script> location.href='../pass-confirm.php?erro=2';</script>";
                }

                $stmt->close();

            }else{
                $_SESSION['erroSenha']=1;
                echo "<script> location.href='../pass-confirm.php?erro=1';</script>";
            }
        }
    }
}

?>