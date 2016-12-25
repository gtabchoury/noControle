<?php

include("sy-conexao.php");
ini_set('default_charset','UTF-8');

if (!isset($_SESSION)){
    session_start();
}

if (isset($_POST['userName'])){
    
    if (isset($_POST['userEmail'])){
        
        if (isset($_POST['userPassword'])){
            
            if (isset($_POST['userPasswordConfirm'])){
                
                $userName = $_POST['userName'];
                $userEmail = $_POST['userEmail'];
                $password = $_POST['userPassword'];
                $passwordConfirm = $_POST['userPasswordConfirm'];
                
                if ($password==$passwordConfirm){
                    $userPassword = crypt($password);

                    $query = "INSERT INTO `nc_users`(`user_email`, `user_name`, `user_password`) VALUES (?,?,?)";

                    $stmt = $mysqli->prepare($query);
                    $stmt->bind_param('sss',$userEmail, $userName, $userPassword);
                    $stmt->execute();

                    if ($stmt->affected_rows==1){
                        echo "<script> location.href='../login.php?success=1';</script>";
                    }else{
                        echo "<script> location.href='../newUser.php?success=0';</script>";
                    }

                    $stmt->close();

                    exit;
                }else{
                    echo "<script>location.href='../newUser.php?erro=1';</script>";
                }
            }
        }
    }
}

?>