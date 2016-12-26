<?php

error_reporting(0);
ini_set(“display_errors”, 0 );

session_start();

include("system/sy-conexao.php");
ini_set('default_charset','UTF-8');

if (isset($_GET['id'])){
    $id=$_GET['id'];
    $query = "SELECT user_email,user_name from nc_users WHERE user_password=? ";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param('s', $id);
    $stmt->execute();
    $stmt->bind_result($emailRec, $nameRec);

    if ($stmt->fetch()){
        $_SESSION['emailRec']=$emailRec;
        $_SESSION['nameRec']=$nameRec;
        header('location:pass-confirm.php');
    }else{
        header('location:login.php');
    }
    
}else{
    if (!isset($_SESSION['emailRec']) || $_SESSION['emailRec']==null){
        header('location:login.php');
    }else{
        $emailConfirm = $_SESSION['emailRec'];
        $nameConfirm = $_SESSION['nameRec'];
    }
}

if (isset($_GET['erro'])){
    $erro = $_GET['erro'];
}else{
    $erro=0;
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
                    <div align="center">
                        <h3>Redefinir senha</h3>
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
                                $erro=0;
                            } else{
                                if ($erro==2){
                                    echo "
                                    <br>
                                    <div class='alert alert-danger alert-dismissable'>
                                        Erro em redefinir senha!
                                    </div>
                                    ";
                                    $erro=0;
                                }
                            }
                        }

                        
                        ?>
                        <form action="system/sy-redefinirSenha.php" method="POST" role="form" id="loginSap">
                            <input type="hidden" name="sent" />
                            <fieldset>
                                <h5>Olá <b><?php echo "$nameConfirm";?></b>, vamos redefinir sua senha!</h5>
                                <div class="form-group">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                        <i class="glyphicon glyphicon-lock"></i>
                                        </span>
                                        <input type="password" name="userPassword" class="form-control" placeholder="Nova senha" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="input-group">
                                        <span class="input-group-addon">
                                        <i class="glyphicon glyphicon-lock"></i>
                                        </span>
                                        <input type="password" name="userPasswordConfirm" class="form-control" placeholder="Confirme sua nova senha" required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn btn-success btn-block">Redefinir Senha</button>
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