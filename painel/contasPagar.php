<?php
    
    session_start();
    
    include("../system/sy-conexao.php");
    ini_set('default_charset','UTF-8');
    
    if(!isset($_SESSION['usuario_id'])){
        header('Location: ../login');
        exit;
    }
    
    $userName=$_SESSION['usuario_nome'];

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
                    <h1 class="page-header">Pagamentos</h1>
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
                                    <option>2014</option>
                                    <option>2015</option>
                                    <option>2016</option>
                                    <option>2017</option>
                                    <option>2018</option>
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
                            <?php echo "Pagamentos de $mesAtual de $anoAtual"; ?> 
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <table width="100%" class="table table-striped table-bordered table-hover " id="dataTables-example">
                                <thead>
                                    <tr>
                                        <th width="22%">Nome</th>
                                        <th width="18%">Fonte</th>
                                        <th width="13%">Valor</th>
                                        <th width="13%">Data</th>
                                        <th width="20%">Situação</th>
                                        <th width="14%">Ações</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php include("painel-system/carregaContasPagar.php");?>
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
                                            <script type="text/javascript">
                                            window.onload = function(){
                                                var display = document.getElementById("minhaDiv").style.display;
                                                document.getElementById("minhaDiv").style.display = 'block';
                                                Mudarestado('minhaDiv');
                                            }
                                            </script>
                                            <form action="painel-system/addConta.php?tipo=P" method="POST" role="form">
                                                <div class="row">
                                                    <div class="form-group col-lg-5">
                                                        <label class="control-label">Nome*</label>
                                                        <div class="input-group">
                                                            <span class="input-group-addon">
                                                                <i class="fa fa-font"></i>
                                                            </span>
                                                            <input type="text" name="nomeConta" class="form-control" placeholder="Nome da conta"
                                                            required/>
                                                        </div>
                                                    </div>
                                                    <div class="form-group col-lg-5">
                                                        <label class="control-label">Número do Documento</label>
                                                        <div class="input-group">
                                                            <span class="input-group-addon">
                                                                Nº
                                                            </span>
                                                            <input type="text" name="docConta" class="form-control" placeholder="Número do documento">
                                                        </div>
                                                    </div>
                                                                                      
                                                </div>
                                                <div class="row">
                                                    <div class="form-group col-lg-5">
                                                        <label class="control-label">Valor*</label>
                                                        <div class="input-group">
                                                            <span class="input-group-addon">
                                                                R$
                                                            </span>
                                                            <input type="text" name="valorConta" class="form-control" placeholder="ex: 198,99" required>
                                                        </div>
                                                    </div>
                                               
                                                
                                                    <div class="form-group col-lg-5">
                                                        <label class="control-label">Data*</label>
                                                        <div class="input-group">
                                                            <span class="input-group-addon">
                                                                <i class="fa fa-calendar"></i>
                                                            </span>
                                                            <input type="date" name="dataConta" class="form-control" required>
                                                        </div>
                                                    </div>
                                                 </div>

                                                <div class="row">
                                                    
                                                    <div class="form-group col-lg-5">
                                                        <div class="form-group">
                                                            <label>Fonte</label>
                                                            <select class="form-control chosen" name="fonteConta">             
                                                                <option>Selecione o Contato</option>
                                                                <?php include("painel-system/selectContatos.php"); ?>
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="form-group col-lg-5">
                                                        <div class="form-group">
                                                            <label>Tipo de Conta</label>
                                                            <select class="form-control chosen" name="assConta">
                                                                <option>Selecione a conta</option>
                                                                <option>Caixa</option>
                                                                <option>Banco</option>
                                                            </select>
                                                        </div>
                                                    </div>

                                                </div>
                                                <div class="row">
                                                    <div class="form-group col-lg-10">                                       
                                                        <div class="input-group">
                                                            <div class="checkbox">
                                                                <label>
                                                                    <input name="statusConta" type="checkbox" value="">Paga
                                                                </label>
                                                                <label>
                                                                    <input name="nofique" type="checkbox" value="">Notifique-me
                                                                </label>
                                                                <label>
                                                                    <input name="mensal" type="checkbox" value="" onclick="Mudarestado('minhaDiv')">Mensal
                                                                </label>
                                                            </div>
                                                            <div id="minhaDiv" class="row col-lg-7">
                                                                Próximos
                                                                <select class="form-control chosen" name="mesesConta" id="mesesConta">             
                                                                    <option value="1">-------</option>
                                                                    <option value="2">2 meses</option>
                                                                    <option value="3">3 meses</option>
                                                                    <option value="4">4 meses</option>
                                                                    <option value="5">5 meses</option>
                                                                    <option value="6">6 meses</option>
                                                                    <option value="7">7 meses</option>
                                                                    <option value="8">8 meses</option>
                                                                    <option value="9">9 meses</option>
                                                                    <option value="10">10 meses</option>
                                                                    <option value="11">11 meses</option>
                                                                    <option value="12">12 meses</option>
                                                                </select>                           
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


<script type="text/javascript">
    function Mudarestado(el) {
        var display = document.getElementById(el).style.display;
        if(display == "block"){
            document.getElementById(el).style.display = 'none';
            selecionar('1');
        }else{
            document.getElementById(el).style.display = 'block';
            selecionar('1');
        }
    }

    function selecionar(uf)
    {
    var combo = document.getElementById("mesesConta");
    
    for (var i = 0; i < combo.options.length; i++)
    {
        if (combo.options[i].value == uf)
        {
            combo.options[i].selected = "true";
            break;
        }
    }
    }

</script>

</body>

</html>
