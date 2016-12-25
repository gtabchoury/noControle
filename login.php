
<?php

session_start();

include("system/conexao.php");
ini_set('default_charset','UTF-8');

if (!isset($_SESSION)){
    $_SESSION['erro']=0;
    session_start();
}else{
    if (isset($_SESSION['usuario_id'])){
       $query = "SELECT * FROM nc_users WHERE user_id=? ";
        $stmt = $mysqli->prepare($query);
        $stmt->bind_param('i', $_SESSION['usuario_id']);
        $stmt->execute();
        
        if ($stmt->fetch()){
            //echo "<script>location.href='inicio.php';</script>";
        } 
        
    }
}

?>
<!DOCTYPE HTML>
<html lang="pt-br">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    
    <link rel="shortcut icon" href="favicon.ico" />
    
    <title>noControle</title>

    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="css/sb-admin.css" rel="stylesheet">

    <!-- Morris Charts CSS -->
    <link href="css/plugins/morris.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

</head>

<body>

    <div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                <div class="login-panel panel panel-default">
                    <br>
                    <div align="center">
                        <img src="img/icone.png">
                    </div>
                    
                    <div class="panel-body">
                    <?php
                        if (isset($_SESSION['erro'])){
                            if ($_SESSION['erro']==1){
                            echo "
                            <div class='alert alert-danger alert-dismissable'>
                                Usuário ou senha inválidos!
                            </div>
                            
                            
                            ";
                            $_SESSION['erro']=0;
                            }    
                            
                        }
                        
                    ?>
                        <form action="system/login.php" method="POST" role="form" id="loginSap">
                            <input type="hidden" name="sent" />
                            <fieldset>
                                <div class="form-group">
                                    Email: <input type="email" value="" name="email" class="form-control" placeholder="Email" required/>
                                </div>
                                <div class="form-group">
                                    Senha:<input type="password" value="" name="senha" class="form-control" placeholder="Senha" required/>
                                </div>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <button type="submit" class="btn btn-primary btn-block">Cadastre-se</button>
                                        </div>
                                        <div class="col-lg-6">
                                            <button type="submit" class="btn btn-success btn-block">Entrar</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <p>
                                        <a href="/forgot.php">Esqueci minha senha</a>
                                    </p>
                                </div>
                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="static/lib/jquery/dist/jquery.min.js"></script>
    <script src="static/lib/bootstrap/dist/js/bootstrap.min.js"></script>
    <script src="static/lib/bootstrapValidator/dist/js/bootstrapValidator.min.js"></script>
    <script src="static/js/login.js"></script>

</body>

</html>