<?php
    
    session_start();
    
    include("../system/sy-conexao.php");
    ini_set('default_charset','UTF-8');
    
    if(!isset($_SESSION['usuario_id'])){
        header('Location: ../login.php');
        exit;
    }
    
    $userName=$_SESSION['usuario_nome'];

    date_default_timezone_set('America/Sao_Paulo');
    $mesAtual = date('m');
    $anoAtual = date('Y');
    
    switch ($mesAtual) {
        case '01':
            $mesAtual = "Janeiro";
            break;
        case '02':
            $mesAtual = "Fevereiro";
            break;
        case '03':
            $mesAtual = "Março";
            break;
        case '04':
            $mesAtual = "Abril";
            break;
        case '05':
            $mesAtual = "Maio";
            break;
        case '06':
            $mesAtual = "Junho";
            break;
        case '07':
            $mesAtual = "Julho";
            break;
        case '08':
            $mesAtual = "Agosto";
            break;
        case '09':
            $mesAtual = "Setembro";
            break;
        case '10':
            $mesAtual = "Outubro";
            break;
        case '11':
            $mesAtual = "Novembro";
            break;
        case '12':
            $mesAtual = "Dezembro";
            break;
        
        default:
            $mesAtual = "";
            break;
    }
      
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
                    <h1 class="page-header">Caixa</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12" id="topo">
                    <div class="panel panel-default">

                        <div class="panel-heading">
                            <?php echo "Caixa de $mesAtual de $anoAtual"; ?> 
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <table width="100%" class="table table-striped table-bordered table-hover " id="dataTables-example">
                                <thead>
                                    <tr>
                                        <th width="22%">Nome</th>
                                        <th width="15%">Fonte</th>
                                        <th width="16%">Valor</th>
                                        <th width="13%">Data</th>
                                        <th width="20%">Situação</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php include("painel-system/carregaContas.php");?>
                                <br>
                                <br>                           
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
