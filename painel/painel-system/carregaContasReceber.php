<?php

if(!isset($_SESSION['usuario_id'])){
  header('Location: ../../login');
  exit;
}

$userID = $_SESSION['usuario_id'];
$totalR = 0;
$total = 0;

date_default_timezone_set('America/Sao_Paulo');
$mesAtual = date('m');

$query = "SELECT * FROM nc_contas WHERE conta_userID=$userID AND conta_tipo='R' ORDER BY conta_data;";
$result = mysqli_query($mysqli, $query);
$rowcount=mysqli_num_rows($result);

while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
  $data = $row['conta_data'];
  $mesConta = date('m', strtotime($data));
  
  if ($mesAtual == $mesConta){
    $id = $row['conta_id'];
    $nome = $row['conta_nome'];
    $fonteID = $row['conta_fonteID'];
    $fonte = $fonteID;
    $valor = $row['conta_valor'];
    $status = $row['conta_status'];

    $total = $total+$valor;

    if ($status==0){
      $totalR=$totalR+$valor;
    }

    $valor =number_format($valor,2,',','');
    
    if ($fonte!=null){
      $query = "SELECT contato_nome from nc_contatos WHERE contato_id=? ";
      $stmt = $mysqli->prepare($query);
      $stmt->bind_param('i', $fonte);
      $stmt->execute();
      $stmt->bind_result($fonte);

      if (!$stmt->fetch()){
        $fonte="";
      }

      $stmt->close();
    }
    if ($status==1){
      echo "
      <tr>
        <td style='vertical-align: middle;'><font size='3px'>$nome</font></td>
        <td style='vertical-align: middle;'><font size='3px'>$fonte</font></td>
        <td style='vertical-align: middle;'><font size='3px'>R$$valor</font></td>
        <td style='vertical-align: middle;'><font size='3px'>"; echo date('d/m/Y', strtotime($data)); echo"</font></td>
        <td style='vertical-align: middle;' class='center'><font size='3px'><i class='fa fa-check fa-fw'></i> Recebido</font></td>
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
                  <h4 class='modal-title' id='myModalLabel'>Excluir conta</h4>
                </div>
                <div class='modal-body'>
                  Deseja realmente excluir a conta $nome?
                </div>
                <div class='modal-footer'>
                  <form action='painel-system/excluirConta.php?tipo=R' method='POST' role='form'>
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
                  <h4 class='modal-title' id='myModalLabel'>Editar conta</h4>
                </div>
                <form action='painel-system/editarConta.php?tipo=R' method='POST' role='form'>
                  <input type='hidden' name='id' value='$id'>
                  <div class='modal-body'>
                    ";
                    include("camposEditarConta.php");
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
        </td>
      </tr>
      ";
    }else{
      echo "
      <tr>
        <td style='vertical-align: middle;'><font size='3px'>$nome</font></td>
        <td style='vertical-align: middle;'><font size='3px'>$fonte</font></td>
        <td style='vertical-align: middle;'><font size='3px'>R$$valor</font></td>
        <td style='vertical-align: middle;'><font size='3px'>"; echo date('d/m/Y', strtotime($data)); echo"</font></td>
        <td style='vertical-align: middle;' class='center'><font size='3px'><i class='fa fa-times fa-fw'></i> Não recebido</font></td>
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
                  <h4 class='modal-title' id='myModalLabel'>Excluir conta</h4>
                </div>
                <div class='modal-body'>
                  Deseja realmente excluir a conta?
                </div>
                <div class='modal-footer'>
                  <form action='painel-system/excluirConta.php?tipo=R' method='POST' role='form'>
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
                  <h4 class='modal-title' id='myModalLabel'>Editar conta</h4>
                </div>
                <form action='painel-system/editarConta.php?tipo=R' method='POST' role='form'>
                  <input type='hidden' name='id' value='$id'>
                  <div class='modal-body'>
                    ";
                    include("camposEditarConta.php");
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
        </td>
      </tr>
      ";
    }
  }
}

echo "  </tbody>
</table>";

$totalRecebido = $total - $totalR;
$totalR =number_format($totalR,2,',','');
$totalRecebido =number_format($totalRecebido,2,',','');
$total =number_format($total,2,',','');

echo "<br>
<div class='col-lg-12' align='center'>
  <div class='panel panel-default col-lg-4'>
    <div class='panel-body'>
      <h3><b>Recebido</b></h3>
      <h4><p>R$$totalRecebido</p><h4>
      </div>
    </div>
    <div class='panel panel-default col-lg-4'>
      <div class='panel-body'>
        <h3><b>Não Recebido</b></h3>
        <h4><p>R$$totalR</p><h4>
        </div>
      </div>
      <div class='panel panel-default col-lg-4'>
        <div class='panel-body'>
          <h3><b>Total</b></h3>
          <h4><p>R$$total</p><h4>
          </div>
        </div>
      </div>
      ";
      echo "<div class='row' align='center'><div class='col-lg-12'><a href='painel-system/contas_a_receber.php' class='btn btn-primary' target='_blank'>Gerar Arquivo PDF</a></div></div>";
      ?>