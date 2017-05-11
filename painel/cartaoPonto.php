<?php

session_start();

include("../system/sy-conexao.php");
ini_set('default_charset','UTF-8');

if(!isset($_SESSION['usuario_id'])){
    header('Location: ../login.php');
    exit;
}

include("painel-system/contas.php");

$totalB = $_SESSION['totalB'];
$totalR = $_SESSION['totalR'];
$totalP = $_SESSION['totalP'];

$userName=$_SESSION['usuario_nome'];

$anoAtual = date('Y');


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
                <div class="col-lg-12">
                    <h1 class="page-header">Cartão Ponto</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <form action="painel-system/addPonto.php" method="POST" role="form">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="form-group col-lg-3">
                            <div class="form-group">
                                <label>Funcionário</label>
                                <select id="funcionarios" class="form-control chosen" name="fonteConta" onchange="MudarFunc('funcionarios')">         
                                    <option value="0">Selecione o Funcionário</option>
                                    <?php include("painel-system/selectFuncionarios.php"); ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group col-lg-3">
                            <label>Mês</label>
                            <div class="form-group">
                                <select id="dataMes" class="form-control chosen" name="dataMes" onchange="mudaData()">         
                                    <option value="0">Selecione o mês</option>
                                    <option value="01">Janeiro</option>
                                    <option value="02">Fevereiro</option>
                                    <option value="03">Março</option>
                                    <option value="04">Abril</option>
                                    <option value="05">Maio</option>
                                    <option value="06">Junho</option>
                                    <option value="07">Julho</option>
                                    <option value="08">Agosto</option>
                                    <option value="09">Setembro</option>
                                    <option value="10">Outubro</option>
                                    <option value="11">Novembro</option>
                                    <option value="12">Dezembro</option>
                                </select>
                            </div>
                        </div>

                        <div id="ano" class="form-group col-lg-2">
                            <label>Ano</label>
                            <div class="form-group">
                                <input type="number" value="<?php echo "$anoAtual";?>" maxlength="4" name="dataAno" id="dataAno" onchange="mudaData()" class="form-control">
                            </div>
                        </div>
                        <div id="divSalario" class="form-group col-lg-2">
                            <label>Salário</label>
                            <div class="form-group">
                                <div class="input-group">
                                    <span class="input-group-addon">
                                        R$
                                    </span>
                                    <input value="<?php if (isset($salarioF)){echo "$salarioF";}?>" type="text" name="salario" id="salario" disabled class="form-control"
                                    required/>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <br>
                <div align="center" id="topoLista" class="col-lg-12">
                    <div class="row">
                        <div class="col-lg-2">
                            
                        </div>
                        <div class="col-lg-2">
                            
                        </div>
                        <div class="col-lg-4">
                            <h3>Manhã</3>
                        </div>
                        <div class="col-lg-4">
                            <h3>Tarde</h3>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-2">
                            <h4>Data</h4>
                        </div>
                        <div class="col-lg-2">
                            <h4>Dia</h4>
                        </div>
                        <div class="col-lg-2">
                            <h4>Entrada</h4>
                        </div>
                        <div class="col-lg-2">
                            <h4>Saída</h4>
                        </div>
                        <div class="col-lg-2">
                            <h4>Entrada</h4>
                        </div>
                        <div class="col-lg-2">
                            <h4>Saída</h4>
                        </div>
                    </div>
                </div>
                <div class="col-lg-12">
                <input class="btn btn-primary rap" onclick="addDia()" type="hidden" value="Adicionar dia">
                </div>

                <div id="btnFinaliza" class="col-lg-12">
                <br>
                <input id="btnFinaliza" class="btn btn-success rap" type="submit" value="Finalizar Ponto">
                </form>
                <br>
                <br>
                <br>
                <br>
                </div>

            </div>
        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->

    <?php include('layout/footer.php');?>

    <script type="text/javascript">
        var dia = 1;
        function MudarFunc(el) {

            var display = document.getElementById(el);
            var idF = display.value;
            if (idF!=0){
                $.post("painel-system/selectFunc.php", {id: idF}, function(retorno){
                 if(retorno) {
                    var sal = document.getElementById("salario");
                    sal.value=retorno; 
                    document.getElementById("divSalario").style.display = 'block';
                    }
                });
                
            }else{
                var sal = document.getElementById("salario");
                sal.value="";
                document.getElementById("divSalario").style.display = 'none';
            }

        }

        function calculaDia(dia) {
            
            var mes = document.getElementById("dataMes").value;
            var ano = document.getElementById("dataAno").value;

            var semana = ["Domingo", "Segunda-Feira", "Terça-Feira", "Quarta-Feira", "Quinta-Feira", "Sexta-Feira", "Sábado"];
            var data = dia+"/"+mes+"/"+ano;
            var arr = data.split("/").reverse();
            var teste = new Date(arr[0], arr[1] - 1, arr[2]);
            var dia = teste.getDay();
            
            return semana[dia];

        }

        function calculaData(dia) {
            
            var mes = document.getElementById("dataMes").value;
            var ano = document.getElementById("dataAno").value;
            var dia2 = dia;
            if (dia2.toString().length == 1)
                dia2 = "0"+dia2;

            var data = dia2+"/"+mes+"/"+ano;

            return data;

        }

        function mudaData() {

            var mes = document.getElementById("dataMes").value;

            if (mes==0){
                document.getElementById("topoLista").style.display = 'none';
                document.getElementById("btnFinaliza").style.display = 'none';
                if (dia!=0){
                    for (var x=1;x<=dia;x++){
                        var nome = "linhaDia";
                        nome += x;
                        var node = document.getElementById(nome);
                        if (node.parentNode) {
                            node.parentNode.removeChild(node);
                        }
                    }
                    var node = document.getElementById("divNumDias");
                    if (node.parentNode) {
                        node.parentNode.removeChild(node);
                    }
                }
                dia=0;
                return;
            }
            if (dia!=0){
                for (var x=1;x<=dia;x++){
                    var nome = "linhaDia";
                    nome += x;
                    var node = document.getElementById(nome);
                    if (node.parentNode) {
                        node.parentNode.removeChild(node);
                    }
                }
            }else{
                document.getElementById("topoLista").style.display = 'block';
                document.getElementById("btnFinaliza").style.display = 'block';
            }
            dia =0;

            var ano = document.getElementById("dataAno").value;
            var data = dia+"/"+mes+"/"+ano;

            var totalDias = daysInMonth(mes,ano);

            for (var i=0;i<totalDias;i++){
                addDia();
            }
            addInput();
        }

        function daysInMonth(month,year) {
            var m = [31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31];
            if (month != 2) return m[month - 1];
            if (year % 4 != 0) return m[1];
            if (year % 100 == 0 && year%400 != 0) return m[1];
            
            return m[1] + 1;
        }

        window.onload = function(){
            dia = 0;
            document.getElementById("divSalario").style.display = 'none';
            document.getElementById("topoLista").style.display = 'none';
            document.getElementById("btnFinaliza").style.display = 'none';      
        }

        function addDia(){
                dia = dia+1;
                diaSemana = calculaDia(dia);
                data = calculaData(dia);

                var $rap = document.querySelector('.rap'),
                    HTMLNovo = '<div class="row" align="left" id="linhaDia';
                    HTMLNovo += dia;
                    HTMLNovo += '"><div id="data" class="form-group col-lg-2">';
                    HTMLNovo += '<div class="form-group" align="center">';
                    HTMLNovo += '<input type="hidden" name="dataDia';
                    HTMLNovo += dia;
                    HTMLNovo += '" value="';
                    HTMLNovo += data;
                    HTMLNovo += '">';
                    HTMLNovo += '<input type="text" disabled class="form-control" name="data';
                    HTMLNovo += dia;
                    HTMLNovo += '" value="';
                    HTMLNovo += data;
                    HTMLNovo += '"></div>';
                    HTMLNovo += '</div>';
                    HTMLNovo += '<div id="dia" class="form-group col-lg-2">';
                    HTMLNovo += '<div class="form-group" align="center">';
                    HTMLNovo += '<input type="text" value="';
                    HTMLNovo += diaSemana;
                    HTMLNovo += '" maxlength="2" disabled class="form-control">';
                    HTMLNovo += '</div>';
                    HTMLNovo += '</div>';
                    HTMLNovo += '<div id="entrada" class="form-group col-lg-2">';
                    HTMLNovo += '<div class="form-group" align="center">';
                    HTMLNovo += '<input type="time" class="form-control" name="entradaManha';
                    HTMLNovo += dia;
                    HTMLNovo += '"></div>';
                    HTMLNovo += '</div>';
                    HTMLNovo += '<div id="saida" class="form-group col-lg-2">';
                    HTMLNovo += '<div class="form-group" align="center">';
                    HTMLNovo += '<input type="time" class="form-control" name="saidaManha';
                    HTMLNovo += dia;
                    HTMLNovo += '"></div>';
                    HTMLNovo += '</div>';
                    HTMLNovo += '<div id="entrada2" class="form-group col-lg-2">';
                    HTMLNovo += '<div class="form-group" align="center">';
                    HTMLNovo += '<input type="time" class="form-control" name="entradaTarde';
                    HTMLNovo += dia;
                    HTMLNovo += '"></div>';
                    HTMLNovo += '</div>';
                    HTMLNovo += '<div id="saida2" class="form-group col-lg-2">';
                    HTMLNovo += '<div class="form-group" align="center">';
                    HTMLNovo += '<input type="time" class="form-control" name="saidaTarde';
                    HTMLNovo += dia;
                    HTMLNovo += '"></div>';
                    HTMLNovo += '</div>';
                    HTMLNovo += '</div>';

                $rap.insertAdjacentHTML('beforebegin', HTMLNovo);

            }

            function addInput(){
                var $rap = document.querySelector('.rap'),
                    HTMLNovo = '<div id="divNumDias">';
                    HTMLNovo += '<input type="hidden" id="numDias" name="numDias" value="';
                    HTMLNovo += dia;
                    HTMLNovo += '">';
                    HTMLNovo += '</div>';

                $rap.insertAdjacentHTML('beforebegin', HTMLNovo);

            }
    </script>
</body>

</html>
