
<?php

error_reporting(0);
ini_set(“display_errors”, 0 );

session_start();

include("system/sy-conexao.php");
ini_set('default_charset','UTF-8');

if (isset($_GET['success'])){
    $cadastrado=$_GET['success'];
}else{
    $cadastrado=0;
}

if (isset($_GET['erro'])){
    $erro=$_GET['erro'];
}else{
    $erro=0;
}

if (!isset($_SESSION)){
    session_start();
}else{
    if (isset($_SESSION['usuario_id'])){
        $query = "SELECT * FROM nc_users WHERE user_id=? ";
        $stmt = $mysqli->prepare($query);
        $stmt->bind_param('i', $_SESSION['usuario_id']);
        $stmt->execute();
        
        if ($stmt->fetch()){
            //echo "<script>location.href='inicio.php';</script>";
        }else{
            session_destroy();
            header('location:login.php');
        }
        
    }
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
                        <h3>Conecte-se</h3>
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
                                    Usuário ou senha inválidos!
                                </div>


                                ";
                                $erro=0;
                            }else{
                                if ($cadastrado==1){
                                    echo "
                                    <br>
                                    <div class='alert alert-success alert-dismissable'>
                                        Você foi cadastrado com sucesso!
                                    </div>  

                                    ";
                                    $cadastrado=0;
                                    } 
                            } 
                            
                        }

                        
                    ?>
                        <form action="system/sy-login.php" method="POST" role="form" id="loginSap">
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
                                            <a href="newUser.php" class="btn btn-primary btn-block">Cadastre-se</a>
                                        </div>
                                        <div class="col-lg-6">
                                            <button type="submit" class="btn btn-success btn-block">Entrar</button>
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group" align="center">
                                    <p>
                                        <a href="recuperarSenha.php">Esqueci minha senha</a>
                                    </p>
                                </div>
                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <?php include("layout/foot.php");?>

</body>

</html>