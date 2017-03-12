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
                    <h1 class="page-header">Colaboradores</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12" id="topo">
                    <div class="panel panel-default">

                        <div class="panel-heading">
                            Lista de Colaboradores
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <table width="100%" class="table table-striped table-bordered table-hover " id="dataTables-example">
                                <thead>
                                    <tr>
                                        <th width="27%">Nome</th>
                                        <th width="17%">Salário</th>
                                        <th width="18%">Telefone</th>
                                        <th width="18%">CPF</th>
                                        <th width="8%">End.</th>
                                        <th width="12%">Ações</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php include("painel-system/carregaFuncionarios.php");?>
                                <br>
                                <br>  
                                <div class="col-lg-10">                
                                    <?php  

                                        if (isset($_GET['success'])){
                                            $ok=$_GET['success'];
                                            if ($ok==1){
                                                echo "<div class='row'>
                                                        <div class='alert alert-success'>
                                                            <b>Funcionário adicionado com sucesso! </b>
                                                            <i class='glyphicon glyphicon-success'></i>
                                                        </div>
                                                    </div> ";
                                            }
                                            if ($ok==0){
                                                echo "<div class='row'>
                                                        <div class='alert alert-danger'>
                                                            <b>Erro ao adicionar funcionário! </b>
                                                            <i class='glyphicon glyphicon-remove'></i>
                                                        </div>
                                                    </div> ";
                                            }
                                        }

                                    ?>
                                    <div class="panel panel-default" id="addFuncionario">
                                        <div class="panel-heading">
                                            Adicionar Colaborador
                                        </div>

                                        <div class="panel-body">                   
                                            <form action="painel-system/addFuncionario.php" method="POST" role="form">
                                                <div class="row">
                                                    <div class="form-group col-lg-5">
                                                        <label class="control-label">Nome</label>
                                                        <div class="input-group">
                                                            <span class="input-group-addon">
                                                                <i class="fa fa-font"></i>
                                                            </span>
                                                            <input type="text" name="nomeFuncionario" class="form-control" placeholder="Nome"
                                                            required/>
                                                        </div>
                                                    </div>
                                                    <div class="form-group col-lg-5">
                                                        <label class="control-label">Salário</label>
                                                        <div class="input-group">
                                                            <span class="input-group-addon">
                                                                R$
                                                            </span>
                                                            <input type="text" name="salarioFuncionario" class="form-control" placeholder="ex: 2720,75"
                                                            required/>
                                                        </div>
                                                    </div>                                  
                                                </div>
                                                <div class="row">
                                                    <div class="form-group col-lg-5">
                                                        <label class="control-label">Telefone</label>
                                                        <div class="input-group">
                                                            <span class="input-group-addon">
                                                                <i class="fa fa-phone"></i>
                                                            </span>
                                                            <input type="text" name="telFuncionario" id="telefone" class="form-control" placeholder="Telefone" onkeyup="mascara( this, mtel );" maxlength="15"
                                                            required/>
                                                        </div>
                                                    </div>
                                                    <div class="form-group col-lg-5">
                                                        <label class="control-label">CPF</label>
                                                        <div class="input-group">
                                                            <span class="input-group-addon">
                                                                <i class="fa fa-user"></i>
                                                            </span>
                                                            <input type="text" name="cpfFuncionario" class="form-control" placeholder="CPF" maxlength="14" OnKeyPress="formatar('###.###.###-##', this)"
                                                            required/>
                                                        </div>
                                                    </div>                              
                                                </div>
                                                <div class="row">
                                                    <div class="form-group col-lg-10">
                                                        <label class="control-label">Endereço</label>
                                                        <div class="input-group">
                                                            <span class="input-group-addon">
                                                                <i class="fa fa-home"></i>
                                                            </span>
                                                            <input type="text" name="endFuncionario" id="endereco" class="form-control" placeholder="Ex: Rua das Palmeiras, 920 - Centro, Campinas - SP" 
                                                            />
                                                        </div>
                                                    </div>
                                                                             
                                                </div>
                                                <div class="form-group">
                                                    <input type="hidden" name="addFuncionario" />
                                                    <div class="pull-left">
                                                        <button type="submit" class="btn btn-success">Adicionar Colaborador</button>
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
