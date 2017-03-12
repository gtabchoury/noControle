<?php

if(!isset($_SESSION['usuario_id'])){
  header('Location: ../../login');
  exit;
}

$userID = $_SESSION['usuario_id'];


$query = "SELECT * FROM nc_funcionarios WHERE func_userID=$userID  ORDER BY func_nome;";
$result = mysqli_query($mysqli, $query);
$rowcount=mysqli_num_rows($result);

while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){

  $id = $row['func_id'];
  $nome = $row['func_nome'];
  $salario = $row['func_salario'];
  $salario =number_format($salario,2,',','');
  $telefone = $row['func_telefone'];
  $endereco = $row['func_endereco'];
  $endereco2 = $endereco;
  $cpf = $row['func_cpf'];

  if ($endereco==""){
    $endereco = "$nome não possui um endereço cadastrado!";
  }

  echo "
  <tr>
    <td style='vertical-align: middle;'><font size='3px'>$nome</font></td>
    <td style='vertical-align: middle;'><font size='3px'>R$$salario</font></td>
    <td style='vertical-align: middle;'><font size='3px'>$telefone</font></td>
    <td style='vertical-align: middle;'><font size='3px'>$cpf</font></td>
    <td style='vertical-align: middle;' align='center'>
      <a data-toggle='modal' data-target='#end$id'>
        <font color='#337ab7'><i class='fa fa-home btn btn-info'></i></font>
      </a>
    </td>
    <td style='vertical-align: middle;' align='center'>
      <a data-toggle='modal' data-target='#exc$id'>
        <font color='#d9534f'><i class='fa fa-remove btn btn-danger'></i></font>
      </a>
      <a data-toggle='modal' data-target='#edit$id'>
        <font color='#337ab7'><i class='fa fa-pencil btn btn-primary'></i></font>
      </a>
      

      <div class='modal fade' id='exc$id' tabindex='-1' role='dialog' aria-labelledby='myModalLabel'>
        <div class='modal-dialog' role='document'>
          <div class='modal-content'>
            <div class='modal-header'>
              <button type='button' class='close' data-dismiss='modal' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
              <h4 class='modal-title' id='myModalLabel'>Excluir funcionário</h4>
            </div>
            <div class='modal-body'>
              Deseja realmente excluir o funcionário $nome?
            </div>
            <div class='modal-footer'>
            <form action='painel-system/excluirFunc.php' method='POST' role='form'>
                <input type='hidden' name='id' value='$id'>
                <button type='button' class='btn btn-default' data-dismiss='modal'>Cancelar</button>
                <button type='submit' class='btn btn-danger'>Excluir</button>
              </form>
            </div>
          </div>
        </div>
      </div>

      <div class='modal fade' id='edit$id' tabindex='-1' role='dialog' aria-labelledby='myModalLabel'>
        <div class='modal-dialog' role='document'>
          <div class='modal-content'>
            <div class='modal-header'>
              <button type='button' class='close' data-dismiss='modal' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
              <h4 class='modal-title' id='myModalLabel'>Editar funcionário</h4>
            </div>
            <form action='painel-system/editarFuncionario.php' method='POST' role='form'>
              <input type='hidden' name='id' value='$id'>
              <div class='modal-body'>
                ";
                include("camposEditarFuncionarios.php");
                echo"
              </div>
              <div class='modal-footer'>
                <button type='button' class='btn btn-default' data-dismiss='modal'>Cancelar</button>
                <button type='submit' class='btn btn-success'>Salvar Alterações</button>
              </div>
            </form>
          </div>
        </div>
      </div>

      <div class='modal fade' id='end$id' tabindex='-1' role='dialog' aria-labelledby='myModalLabel'>
        <div class='modal-dialog' role='document'>
          <div class='modal-content'>
            <div class='modal-header'>
              <button type='button' class='close' data-dismiss='modal' aria-label='Close'><span aria-hidden='true'>&times;</span></button>
              <h4 class='modal-title' id='myModalLabel'>Endereço $nome</h4>
            </div>
            <div class='modal-body'>
              $endereco
            </div>
          </div>
        </div>
      </div>
    </td>
  </tr>
  ";
}

echo "  </tbody>
</table>";

echo "<div class='col-lg-12' align='center'><a href='painel-system/lista_funcionario.php' class='btn btn-primary' target='_blank'>Gerar Arquivo PDF</a><br></div><br><br>";
?>