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
                <form action="painel-system/addConta.php?tipo=R" method="POST" role="form">
                    <div class="row">
                        <div class="form-group col-lg-5">
                            <div class="col-lg-5">
                                <select class="form-control chosen" name="fonteConta">        
                                    <option <?php if ($mesAtual=="Janeiro"){echo "selected";}?>>Janeiro</option>
                                    <option <?php if ($mesAtual=="Fevereiro"){echo "selected";}?>>Fevereiro</option>
                                    <option <?php if ($mesAtual=="Março"){echo "selected";}?>>Março</option>
                                    <option <?php if ($mesAtual=="Abril"){echo "selected";}?>>Abril</option>
                                    <option <?php if ($mesAtual=="Maio"){echo "selected";}?>>Maio</option>
                                    <option <?php if ($mesAtual=="Junho"){echo "selected";}?>>Junho</option>
                                    <option <?php if ($mesAtual=="Julho"){echo "selected";}?>>Julho</option>
                                    <option <?php if ($mesAtual=="Agosto"){echo "selected";}?>>Agosto</option>
                                    <option <?php if ($mesAtual=="Setembro"){echo "selected";}?>>Setembro</option>
                                    <option <?php if ($mesAtual=="Outubro"){echo "selected";}?>>Outubro</option>
                                    <option <?php if ($mesAtual=="Novembro"){echo "selected";}?>>Novembro</option>
                                    <option <?php if ($mesAtual=="Dezembro"){echo "selected";}?>>Dezembro</option>
                                </select>
                            </div>
                            <div class="col-lg-4">
                                <select class="form-control chosen" name="fonteConta">        
                                    <option><?php echo "$anoAtual"; ?></option>
                                </select>
                            </div>
                        </div>                               
                    </div>
                </form>
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
                                        <th width="17%">Data</th>
                                        <th width="24%">Descrição</th>
                                        <th width="20%">Nº do documento</th>
                                        <th width="13%">Débito</th>
                                        <th width="13%">Crédito</th>
                                        <th width="13%">Saldo</th>
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
