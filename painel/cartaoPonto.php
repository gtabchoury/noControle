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
                                <select id="funcionarios" class="form-control chosen" name="mes">         
                                    <option value="0">Selecione o mês</option>
                                    <option value="1">Janeiro</option>
                                    <option value="2">Fevereiro</option>
                                    <option value="3">Março</option>
                                    <option value="4">Abril</option>
                                    <option value="5">Maio</option>
                                    <option value="6">Junho</option>
                                    <option value="7">Julho</option>
                                    <option value="8">Agosto</option>
                                    <option value="9">Setembro</option>
                                    <option value="10">Outubro</option>
                                    <option value="11">Novembro</option>
                                    <option value="12">Dezembro</option>
                                </select>
                            </div>
                        </div>

                        <div id="ano" class="form-group col-lg-2">
                            <label>Ano</label>
                            <div class="form-group">
                                <input type="number" value="<?php echo "$anoAtual";?>" maxlength="4" name="ano" class="form-control">
                            </div>
                        </div>
                        <div id="divSalario" class="form-group col-lg-3">
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
                <div class="row" id="">
                    <div class="col-lg-12">
                        <div id="dia" class="form-group col-lg-1">
                            <label>Dia</label>
                            <div class="form-group" align="center">
                                <input type="number"  value="1" disabled class="form-control">
                            </div>
                        </div>
                        <div id="entrada" class="form-group col-lg-2">
                            <label>Entrada</label>
                            <div class="form-group" align="center">
                                <input type="time"  class="form-control">
                            </div>
                        </div>
                        <div id="saida" class="form-group col-lg-2">
                            <label>Saída</label>
                            <div class="form-group" align="center">
                                <input type="time"  class="form-control">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row" align="left">
                    <input type="hidden" id="dia" name="1">
                    <div id="addDia" class="form-group col-lg-12">
                            <div class="form-group" align="center">
                                <input class="btn btn-primary rap" onclick="addDia()" type="button" value="Adicionar dia">
                            </div>
                    </div>
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

        window.onload = function(){
            dia = 1;
            document.getElementById("divSalario").style.display = 'none';
        }

        function addDia(){
                dia = dia+1;
                var $rap = document.querySelector('.rap'),
                    HTMLNovo = '<div class="row">';
                    HTMLNovo += '<div class="col-lg-12">';
                    HTMLNovo += '<div id="dia" class="form-group col-lg-1">';
                    HTMLNovo += '<label>Dia</label>';
                    HTMLNovo += '<div class="form-group" align="center">';
                    HTMLNovo += '<input type="number" value="';
                    HTMLNovo += dia;
                    HTMLNovo += '" maxlength="2" disabled class="form-control">';
                    HTMLNovo += '</div>';
                    HTMLNovo += '</div>';
                    HTMLNovo += '<div id="entrada" class="form-group col-lg-2">';
                    HTMLNovo += '<label>Entrada</label>';
                    HTMLNovo += '<div class="form-group" align="center">';
                    HTMLNovo += '<input type="time" class="form-control">';
                    HTMLNovo += '</div>';
                    HTMLNovo += '</div>';
                    HTMLNovo += '<div id="saida" class="form-group col-lg-2">';
                    HTMLNovo += '<label>Saída</label>';
                    HTMLNovo += '<div class="form-group" align="center">';
                    HTMLNovo += '<input type="time"  class="form-control">';
                    HTMLNovo += '</div>';
                    HTMLNovo += '</div>';
                    HTMLNovo += '</div>';
                    HTMLNovo += '</div>';

                $rap.insertAdjacentHTML('beforebegin', HTMLNovo);

            }
    </script>
</body>

</html>
