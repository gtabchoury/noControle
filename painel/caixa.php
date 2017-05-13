<?php
    
    session_start();
    
    include("../system/sy-conexao.php");
    ini_set('default_charset','UTF-8');
    
    if(!isset($_SESSION['usuario_id'])){
        header('Location: ../login');
        exit;
    }
    
    $userName=$_SESSION['usuario_nome'];
    $userID = $_SESSION['usuario_id'];

    date_default_timezone_set('America/Sao_Paulo');
    $mesAtual = date('m');
    $anoAtual = date('Y');
    
    $mes = $mesAtual;
    $ano = $anoAtual;

    if (isset($_GET['m'])){
        $mes=$_GET['m'];
    }

    if (isset($_GET['y'])){
        $ano=$_GET['y'];
    }

    $mesAtual=$mes;
    $anoAtual=$ano;

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
                                <select onchange="location.href='?m='+this.value+'&y='+document.getElementById('anoContas').value;" id="mesContas" class="form-control chosen" name="mesContas">        
                                    <option value="1" <?php if ($mesAtual=="Janeiro"){echo "selected";}?>>Janeiro</option>
                                    <option value="2" <?php if ($mesAtual=="Fevereiro"){echo "selected";}?>>Fevereiro</option>
                                    <option value="3" <?php if ($mesAtual=="Março"){echo "selected";}?>>Março</option>
                                    <option value="4" <?php if ($mesAtual=="Abril"){echo "selected";}?>>Abril</option>
                                    <option value="5" <?php if ($mesAtual=="Maio"){echo "selected";}?>>Maio</option>
                                    <option value="6" <?php if ($mesAtual=="Junho"){echo "selected";}?>>Junho</option>
                                    <option value="7" <?php if ($mesAtual=="Julho"){echo "selected";}?>>Julho</option>
                                    <option value="8" <?php if ($mesAtual=="Agosto"){echo "selected";}?>>Agosto</option>
                                    <option value="9" <?php if ($mesAtual=="Setembro"){echo "selected";}?>>Setembro</option>
                                    <option value="10" <?php if ($mesAtual=="Outubro"){echo "selected";}?>>Outubro</option>
                                    <option value="11" <?php if ($mesAtual=="Novembro"){echo "selected";}?>>Novembro</option>
                                    <option value="12" <?php if ($mesAtual=="Dezembro"){echo "selected";}?>>Dezembro</option>
                                </select>
                            </div>
                            <div class="col-lg-4">
                                <select onchange="location.href='?m='+document.getElementById('mesContas').value+'&y='+this.value;" class="form-control chosen" name="anoContas" id="anoContas">        
                                    <?php
                                    $query = "SELECT * FROM nc_contas WHERE conta_userID=$userID ORDER BY conta_data;";
                                    $result = mysqli_query($mysqli, $query);
                                    $rowcount=mysqli_num_rows($result);

                                    while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
                                        $data = $row['conta_data'];
                                        $menorAno = date('Y', strtotime($data));
                                        break;
                                    }

                                    $query = "SELECT * FROM nc_contas WHERE conta_userID=$userID ORDER BY conta_data DESC;";
                                    $result = mysqli_query($mysqli, $query);
                                    $rowcount=mysqli_num_rows($result);

                                    while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
                                        $data = $row['conta_data'];
                                        $maiorAno = date('Y', strtotime($data));
                                        break;
                                    }

                                    
                                    for ($i=$menorAno;$i<=$maiorAno;$i++){
                                        if ($i==$anoAtual){
                                            echo "<option selected>$i</option>";
                                        }else{
                                            echo "<option>$i</option>";
                                        }
                                    }
                                    ?>
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
