<?php

error_reporting(0);
ini_set(“display_errors”, 0 );

session_start();

include("system/sy-conexao.php");
ini_set('default_charset','UTF-8');

if (isset($_GET['success'])){
    $ok=$_GET['success'];
}else{
    $ok=0;
}

if (!isset($_SESSION)){
    session_start();
}


?>
<!DOCTYPE HTML>
<html lang="pt-br">

<head>

    <?php include("layout/header.php");?>

</head>

<body>

    <div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                <div class="login-panel panel panel-default">
                    <div class="panel-body">
                    <br>
                    <div align="center">
                        <h3>Recupere sua senha</h3>
                    </div>
                    <br>
                    <div align="center">
                        <img src="img/icone.png">
                    </div>
                    
                    <?php
                        if (isset($ok)){
                            if ($ok==1){
                                echo "
                                <br>
                                <div class='alert alert-success alert-dismissable'>
                                    Um e-mail para redefinir sua senha foi enviado!
                                </div>

                                ";
                                $apaga=1;
                            }else{
                                if ($ok==2){
                                    echo "
                                    <br>
                                    <div class='alert alert-danger alert-dismissable'>
                                        Erro ao enviar e-mail para redefinir a senha.
                                    </div>  

                                    ";
                                    $apaga=0;
                                }else{
                                    if ($ok==3){
                                        echo "
                                        <br>
                                        <div class='alert alert-danger alert-dismissable'>
                                            E-mail não cadastrado no sistema.
                                        </div>  

                                        ";
                                        $apaga=0;
                                    }
                                } 
                            } 
                            
                        }
                        
                        if ($apaga==0){
                            echo"
                                <form action='system/sy-recuperarSenha.php' method='POST' role='form'>
                                    <input type='hidden' name='sent' />
                                    <fieldset>
                                        <div class='form-group'>
                                            Email: <input type='email' name='email' class='form-control' placeholder='Digite seu email para recuperação' required/>
                                        </div>
                                        <div class='form-group'>
                                            <button type='submit' class='btn btn-success btn-block'>Recuperar senha</button>
                                        </div>
                                    </fieldset>
                                </form>
                            ";
                        }
                        
                        ?>
                        <div align="center">
                            <a href="login.php"><button class="btn btn-primary">Voltar para o Login</button></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <?php include("layout/foot.php");?>

</body>

</html>