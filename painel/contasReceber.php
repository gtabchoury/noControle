<?php
    
    session_start();
    
    include("../system/sy-conexao.php");
    ini_set('default_charset','UTF-8');
    
    if(!isset($_SESSION['usuario_id'])){
        header('Location: ../login.php');
        exit;
    }
    
    $userName=$_SESSION['usuario_nome'];
?>
<!DOCTYPE html>
<html lang="en">

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
                <div class="col-lg-12">
                    <h1 class="page-header">Contas a receber</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            Suas contas a receber
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <table width="100%" class="table table-striped table-bordered table-hover " id="dataTables-example">
                                <thead>
                                    <tr>
                                        <th width="25%">Nome</th>
                                        <th width="20%">Fonte</th>
                                        <th width="15%">Valor</th>
                                        <th width="15%">Data</th>
                                        <th width="15%">Situação</th>
                                        <th width="10%">Ações</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php include("painel-system/carregaContasReceber.php");?>
                                <br>
                                <br>  
                                <div class="col-lg-10">                
                                    <?php  

                                        if (isset($_GET['success'])){
                                            $ok=$_GET['success'];
                                            if ($ok==1){
                                                echo "<div class='row'>
                                                        <div class='alert alert-success'>
                                                            <b>Conta adicionada com sucesso! </b>
                                                            <i class='glyphicon glyphicon-success'></i>
                                                        </div>
                                                    </div> ";
                                            }
                                            if ($ok==0){
                                                echo "<div class='row'>
                                                        <div class='alert alert-danger'>
                                                            <b>Erro ao adicionar conta! </b>
                                                            <i class='glyphicon glyphicon-remove'></i>
                                                        </div>
                                                    </div> ";
                                            }

                                            if ($ok==-1){
                                                echo "<div class='row'>
                                                        <div class='alert alert-danger'>
                                                            <b>Valor inválido!</b>
                                                            <i class='glyphicon glyphicon-remove'></i>
                                                        </div>
                                                    </div> ";
                                            }
                                        }

                                    ?>
                                    <div class="panel panel-default" id="addConta">
                                        <div class="panel-heading">
                                            Adicionar conta
                                        </div>

                                        <div class="panel-body">
                                            <form action="painel-system/addConta.php?tipo=R" method="POST" role="form">
                                                <div class="row">
                                                    <div class="form-group col-lg-5">
                                                        <label class="control-label">Nome</label>
                                                        <div class="input-group">
                                                            <span class="input-group-addon">
                                                                <i class="fa fa-font"></i>
                                                            </span>
                                                            <input type="text" name="nomeConta" class="form-control" placeholder="Nome da conta"
                                                            required/>
                                                        </div>
                                                    </div>
                                                    <div class="form-group col-lg-5">
                                                        <div class="form-group">
                                                            <label>Fonte</label>
                                                            <select class="form-control chosen" name="fonteConta">             
                                                                <option>Selecione o Contato</option>
                                                                <?php include("painel-system/selectContatos.php"); ?>
                                                            </select>
                                                        </div>
                                                    </div>                                  
                                                </div>
                                                <div class="row">
                                                    <div class="form-group col-lg-4">
                                                        <label class="control-label">Valor</label>
                                                        <div class="input-group">
                                                            <span class="input-group-addon">
                                                                R$
                                                            </span>
                                                            <input type="text" name="valorConta" class="form-control" placeholder="ex: 198,99" required>
                                                        </div>
                                                    </div>
                                               
                                                
                                                    <div class="form-group col-lg-4">
                                                        <label class="control-label">Data</label>
                                                        <div class="input-group">
                                                            <span class="input-group-addon">
                                                                <i class="fa fa-calendar"></i>
                                                            </span>
                                                            <input type="date" name="dataConta" class="form-control" required>
                                                        </div>
                                                    </div>
                                                 </div>
                                                <div class="row">
                                                    <div class="form-group col-lg-8">                                       
                                                        <div class="input-group">
                                                            <div class="checkbox">
                                                                <label>
                                                                    <input name="statusConta" type="checkbox" value="">Recebido
                                                                </label>
                                                                <label>
                                                                    <input name="nofique" type="checkbox" value="">Notifique-me
                                                                </label>
                                                                <label>
                                                                    <input name="mensal" type="checkbox" value="">Mensal
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <input type="hidden" name="addConta" />
                                                    <div class="pull-left">
                                                        <button type="submit" class="btn btn-success">Adicionar Conta</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-12 -->
            </div>
            
        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

    <?php include("layout/footer.php");?>

</body>

</html>
