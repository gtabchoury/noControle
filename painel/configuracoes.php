<?php
    
    session_start();
    
    include("../system/sy-conexao.php");
    ini_set('default_charset','UTF-8');
    
    if(!isset($_SESSION['usuario_id'])){
        header('Location: ../login');
        exit;
    }
    
    $userName=$_SESSION['usuario_nome'];
    $userEmail=$_SESSION['usuario_email'];
    $userID=$_SESSION['usuario_id'];

    $query = "SELECT user_saldoCaixa, user_saldoBanco from nc_users WHERE user_id=?";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param('i', $userID);
    $stmt->execute();
    $stmt->bind_result($saldoC, $saldoB);
    $stmt->fetch();

    if (isset($_GET['ok'])){
        $ok=$_GET['ok'];
    }else{
        $ok=-1;
    }

    $saldoC =number_format($saldoC,2,',','');
    $saldoB =number_format($saldoB,2,',','');
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
                ?>
                    <div class="col-lg-5">
                        <div class="panel panel-default">
                            <div class="panel-heading">Configurações Bancárias</div>
                            <div class="panel-body">
                                <form action="painel-system/updateConfigBanc.php" method="POST" role="form" id="updateInfoForm">
                                    <div class="form-group">
                                        <label for="user_name" class="control-label">Saldo em Caixa</label>
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                R$
                                            </span>
                                            <input type="text" name="saldoC" class="form-control" id="saldoC" placeholder="ex: 1279,90"
                                            value="<?php echo "$saldoC"; ?>" required/>
                                        </div>
                                    </div>                           
                                    <div class="form-group">
                                        <label for="user_email" class="control-label">Saldo no Banco</label>
                                        <div class="input-group">
                                            <span class="input-group-addon">
                                                R$
                                            </span>
                                            <input type="text" name="saldoB" class="form-control" id="saldoB" placeholder="ex: 1279,90"
                                            value="<?php echo "$saldoB"; ?>" required/>
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
                    
                    
                    <!-- /.col-lg-6 -->
                    

            </div>
          
        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

    <?php include('layout/footer.php');?>

</body>

</html>
