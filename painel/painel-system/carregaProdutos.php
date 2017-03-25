<?php

if(!isset($_SESSION['usuario_id'])){
  header('Location: ../../login');
  exit;
}

$userID = $_SESSION['usuario_id'];


$query = "SELECT * FROM nc_produtos WHERE pro_userID=$userID  ORDER BY pro_nome;";
$result = mysqli_query($mysqli, $query);
$rowcount=mysqli_num_rows($result);

while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){

  $id = $row['pro_id'];
  $nome = $row['pro_nome'];
  $estoque = $row['pro_estoque'];

  echo "
  <tr>
    <td style='vertical-align: middle;'><font size='3px'>$nome</font></td>
    <td align='center' style='vertical-align: middle;'><font size='3px'>$estoque</font></td>
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
              Deseja realmente excluir o produto $nome?
            </div>
            <div class='modal-footer'>
            <form action='painel-system/excluirProduto.php' method='POST' role='form'>
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
            <form action='painel-system/editarProduto.php' method='POST' role='form'>
              <input type='hidden' name='id' value='$id'>
              <div class='modal-body'>
                ";
                include("camposEditarProdutos.php");
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

echo "  </tbody>
</table>";

echo "<div class='col-lg-12' align='center'><a href='painel-system/lista_produtos.php' class='btn btn-primary' target='_blank'>Gerar Arquivo PDF</a><br></div><br><br>";
?>