<?php

error_reporting(0);
ini_set(“display_errors”, 0 );

session_start();

ini_set('default_charset','UTF-8');

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
                        <h3>Senha atualizada</h3>
                    </div>
                    <br>
                    <div align="center">
                        <img src="img/icone.png">
                    </div>
                    <br>
                    <div class='alert alert-success alert-dismissable'>
                        Sua senha foi atualizada com sucesso!
                    </div>
                    <div align="center">
                        <a href="login.php"><button type="button" class="btn btn-primary">Fazer Login</button></a>
                    </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <?php include("layout/header.php");?>

</body>

</html>