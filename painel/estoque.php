<?php
    
    session_start();
    
    include("../system/sy-conexao.php");
    ini_set('default_charset','UTF-8');
    
    if(!isset($_SESSION['usuario_id'])){
        header('Location: ../login');
        exit;
    }
    
    $userName=$_SESSION['usuario_nome'];

?>
<!DOCTYPE html>
<html lang="en">

<head>

    <?php include('layout/header.php');?>
    <script type="text/javascript" src="mtel.js"></script>
</head>

<body>

    <script>
    function formatar(mascara, documento){
      var i = documento.value.length;
      var saida = mascara.substring(0,1);
      var texto = mascara.substring(i)
      
      if (texto.substring(0,1) != saida){
            documento.value += texto.substring(0,1);
      }
      
    }

    window.onload = function(){
        document.getElementById("divCnpj").style.display = 'none';
    }

    function mudaDoc(){
      var tipo = document.getElementById("tipoDoc");
      var value = tipo.value;

      if (value==1){
        document.getElementById("divCnpj").style.display = 'none';
        document.getElementById("divCpf").style.display = 'block';
        document.getElementById("inputCpf").value = null;
        document.getElementById("inputCnpj").value = null;
      }else{
        if(value==2){
            document.getElementById("divCpf").style.display = 'none';
            document.getElementById("divCnpj").style.display = 'block';
            document.getElementById("inputCpf").value = null;
            document.getElementById("inputCnpj").value = null;
        }
      }

    }
    </script>
    
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
                    <h1 class="page-header">Estoque</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12" id="topo">
                    <div class="panel panel-default">

                        <div class="panel-heading">
                            Lista de Produtos
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <table width="100%" class="table table-striped table-bordered table-hover " id="dataTables-example">
                                <thead>
                                    <tr>
                                        <th width="70%">Descrição</th>
                                        <th width="18%">Estoque</th>
                                        <th width="12%">Ações</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php include("painel-system/carregaProdutos.php");?>
                                <br>
                                <br>  
                                <div class="col-lg-10">                
                                    <?php  

                                        if (isset($_GET['success'])){
                                            $ok=$_GET['success'];
                                            if ($ok==1){
                                                echo "<div class='row'>
                                                        <div class='alert alert-success'>
                                                            <b>Produto adicionado com sucesso! </b>
                                                            <i class='glyphicon glyphicon-success'></i>
                                                        </div>
                                                    </div> ";
                                            }
                                            if ($ok==0){
                                                echo "<div class='row'>
                                                        <div class='alert alert-danger'>
                                                            <b>Erro ao adicionar produto! </b>
                                                            <i class='glyphicon glyphicon-remove'></i>
                                                        </div>
                                                    </div> ";
                                            }
                                        }

                                    ?>
                                    <div class="panel panel-default" id="addProduto">
                                        <div class="panel-heading">
                                            Adicionar produto
                                        </div>

                                        <div class="panel-body">                   
                                            <form action="painel-system/addProduto.php" method="POST" role="form">
                                                <div class="row">
                                                    <div class="form-group col-lg-7">
                                                        <label class="control-label">Descrição</label>
                                                        <div class="input-group">
                                                            <span class="input-group-addon">
                                                                <i class="fa fa-font"></i>
                                                            </span>
                                                            <input type="text" name="nomeProduto" class="form-control" placeholder="Descrição"
                                                            required/>
                                                        </div>
                                                    </div>
                                                    <div class="form-group col-lg-3">
                                                        <label class="control-label">Estoque</label>
                                                        <div class="input-group">
                                                            <span class="input-group-addon">
                                                                Nº
                                                            </span>
                                                            <input type="text" name="estoqueProduto" class="form-control" placeholder="ex: 10"
                                                            />
                                                        </div>
                                                    </div>                                  
                                                </div>
                                                <div class="form-group">
                                                    <input type="hidden" name="addContato" />
                                                    <div class="pull-left">
                                                        <button type="submit" class="btn btn-success">Adicionar Produto</button>
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
