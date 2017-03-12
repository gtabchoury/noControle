<?php

if(!isset($_SESSION['usuario_id'])){
  header('Location: ../../login');
  exit;
}

$userID = $_SESSION['usuario_id'];


$query = "SELECT * FROM nc_contatos WHERE contato_userID=$userID  ORDER BY contato_nome;";
$result = mysqli_query($mysqli, $query);
$rowcount=mysqli_num_rows($result);

while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){

  $id = $row['contato_id'];
  $nome = $row['contato_nome'];
  $email = $row['contato_email'];
  $telefone = $row['contato_telefone'];
  $endereco = $row['contato_endereco'];
  $endereco2 = $endereco;
  $doc = $row['contato_doc'];

  if ($endereco==""){
    $endereco = "$nome não possui um endereço cadastrado!";
  }

  echo "
  <tr>
    <td style='vertical-align: middle;'><font size='3px'>$nome</font></td>
    <td style='vertical-align: middle;'><font size='3px'>$email</font></td>
    <td style='vertical-align: middle;'><font size='3px'>$telefone</font></td>
    <td style='vertical-align: middle;'><font size='3px'>$doc</font></td>
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
              <h4 class='modal-title' id='myModalLabel'>Excluir contato</h4>
            </div>
            <div class='modal-body'>
              Deseja realmente excluir o contato $nome?
            </div>
            <div class='modal-footer'>
            <form action='painel-system/excluirContato.php' method='POST' role='form'>
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
              <h4 class='modal-title' id='myModalLabel'>Editar contato</h4>
            </div>
            <form action='painel-system/editarContato.php' method='POST' role='form'>
              <input type='hidden' name='id' value='$id'>
              <div class='modal-body'>
                ";
                include("camposEditarContatos.php");
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

echo "<div class='col-lg-12' align='center'><a href='painel-system/lista_contatos.php' class='btn btn-primary' target='_blank'>Gerar Arquivo PDF</a><br></div><br><br>";
?>