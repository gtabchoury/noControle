<?php

error_reporting(0);
ini_set(“display_errors”, 0 );
session_start();

include("system/sy-conexao.php");
ini_set('default_charset','UTF-8');

if (!isset($_SESSION)){
    $_SESSION['erro']=0;
    session_start();
}

if (isset($_GET['erro'])){
    $erro=$_GET['erro'];
}else{
    $erro=0;
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
                        <div align="center">
                        <h3>Cadastre-se</h3>
                        </div>
                        <br>
                        <div align="center">
                            <img src="img/icone.png">
                        </div>
                        <?php
                        if (isset($erro)){
                            if ($erro==1){
                                echo "
                                <br>
                                <div class='alert alert-danger alert-dismissable'>
                                    As senhas não coincidem!
                                </div>


                                ";
                                $_SESSION['erro']=0;
                            }
                        }

                        
                        ?>
                        <form action="system/sy-newUser.php" method="POST" role="form" id="newUser" enctype="multipart/form-data">
                            <div class="form-group">
                                <label>Nome</label>
                                <input type="text" name="userName" class="form-control" placeholder="Digite seu nome" required>
                            </div>

                            <div class="form-group">
                                <label>E-mail</label>
                                <input type="email" name="userEmail" class="form-control" placeholder="Digite seu e-mail" required>
                            </div>

                            <div class="form-group">
                                <label>Senha</label>
                                <input type="password" name="userPassword" class="form-control" placeholder="Digite sua senha" required>
                            </div>
                            <div class="form-group">
                                <label>Confirmar Senha</label>
                                <input type="password" name="userPasswordConfirm" class="form-control" placeholder="Confirme sua senha" required>
                            </div>
                            <div class="form-group">
                                <button type="submit" class="btn btn-success btn-block">Cadastrar</button>
                            </div>
                        </form>
                    </div> 
                </div>
            </div>
        </div>
    </div>

    <?php include("layout/header.php");?>

</body>

</html>