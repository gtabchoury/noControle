<?php
    
    session_start();
    
    include("../system/sy-conexao.php");
    ini_set('default_charset','UTF-8');
    
    if(!isset($_SESSION['usuario_id'])){
        header('Location: ../login.php');
        exit;
    }
    
    $userName=$_SESSION['usuario_nome'];
    $userEmail=$_SESSION['usuario_email'];

    if (isset($_GET['ok'])){
        $ok=$_GET['ok'];
    }else{
        $ok=-1;
    }
?>
<!DOCTYPE html>

<html lang="pt-br">

<head>

    <?php include('layout/header.php');?>

</head>

<body>

    <div id="wrapper">

        <!-- Navigation -->
        <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
            
            <?php include('layout/barraTopo.php');?>

            <!-- /.navbar-top-links -->

            <?php include('layout/menuLateral.php');?>

            <!-- /.navbar-static-side -->
        </nav>

        <div id="page-wrapper">
            <div class="row">
                <div class="col-lg-10">
                    <h1 class="page-header">Configurações</h1>
                </div>
                <!-- /.col-lg-12 -->
                <?php
                    if ($ok==0){
                        echo "<div class='col-lg-10'>
                            <div class='alert alert-danger'>
                                <b>Erro ao atualizar dados! </b>
                                <i class='glyphicon glyphicon-remove'></i>
                            </div>
                        </div> ";
                    }
                    if ($ok==1){
                        echo "<div class='col-lg-10'>
                            <div class='alert alert-success'>
                                <b>Dados atualizados com sucesso! </b>
                                <i class='glyphicon glyphicon-success'></i>
                            </div>
                        </div> ";
                    }
                    if ($ok==2){
                        echo "<div class='col-lg-10'>
                            <div class='alert alert-success'>
                                <b>Senha alterada com sucesso! </b>
                                <i class='glyphicon glyphicon-success'></i>
                            </div>
                        </div> ";
                    }
                    if ($ok==3){
                        echo "<div class='col-lg-10'>
                            <div class='alert alert-danger'>
                                <b>Erro ao alterar senha! </b>
                                <i class='glyphicon glyphicon-remove'></i>
                            </div>
                        </div> ";
                    }
                    if ($ok==4){
                        echo "<div class='col-lg-10'>
                            <div class='alert alert-danger'>
                                <b>As senhas não coincidem! </b>
                                <i class='glyphicon glyphicon-remove'></i>
                            </div>
                        </div> ";
                    }
                ?>
                    <div class="col-lg-5">
                        <div class="panel panel-default">
                            <div class="panel-heading">Dados gerais</div>
                            <div class="panel-body">
                                <form action="painel-system/updateInfo.php" method="POST" role="form" id="updateInfoForm">
                                    <div class="form-group">
                                        <label for="user_name" class="control-label">Nome</label>
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                <i class="fa fa-font"></i>
                                            </span>
                                            <input type="text" name="name" class="form-control" id="user_name" placeholder="Nome"
                                            value="<?php echo "$userName"; ?>" required/>
                                        </div>
                                    </div>                           
                                    <div class="form-group">
                                        <label for="user_email" class="control-label">Email</label>
                                        <div class="input-group">
                                            <span class="input-group-addon">@</span>
                                            <input type="email" name="email" class="form-control" id="user_email" placeholder="Email"
                                            value="<?php echo "$userEmail"; ?>" required/>
                                        </div>
                                    </div>


                                    <div class="form-group">
                                        <input type="hidden" name="updateInfo" />
                                        <div class="pull-right">
                                            <button type="submit" class="btn btn-success">Salvar</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!-- /.col-lg-6 -->
                    
                    <div class="col-lg-5">
                        <div class="panel panel-default">
                            <div class="panel-heading">Alterar senha</div>
                            <div class="panel-body">
                                <form action="painel-system/updatePassword.php" method="POST" role="form" id="updatePasswordForm">
                                    <div class="form-group">
                                        <label for="user_password" class="control-label">Senha</label>
                                        <input type="password" class="form-control" name="password" id="user_password" placeholder="Nova senha" required/>
                                    </div>
                                    <div class="form-group">
                                        <label for="user_confirm_password" class="control-label">Confirmar senha</label>
                                        <input type="password" class="form-control" name="confirmPassword" id="user_confirm_password" placeholder="Confimar senha" required/>
                                    </div>
                                    <div class="form-group">
                                        <input type="hidden" name="updatePassword" />
                                        <div class="pull-right">
                                            <button type="submit" class="btn btn-success">Alterar</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!-- /.col-lg-6 -->
                    

            </div>
          
        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

    <?php include('layout/footer.php');?>

</body>

</html>
