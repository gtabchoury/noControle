<?php

if(!isset($_SESSION['usuario_id'])){
  header('Location: ../../login.php');
  exit;
}

$userID = $_SESSION['usuario_id'];
$totalR = 0;
$totalP = 0;

date_default_timezone_set('America/Sao_Paulo');
$mesAtual = date('m');

$query = "SELECT * FROM nc_contas WHERE conta_userID=$userID ORDER BY conta_nome;";
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
    $tipo = $row['conta_tipo'];
    

    if ($status==0){
      if ($tipo=='P'){
        $totalP=$totalP+$valor;
        $descTipo="Não paga";
      }
      if ($tipo=='R'){
        $totalR=$totalR+$valor;
        $descTipo="Não recebido";
      }
    }

    if ($status==1){
      if ($tipo=='P'){
        $totalP=$totalP+$valor;
        $descTipo="Paga";
      }
      if ($tipo=='R'){
        $totalR=$totalR+$valor;
        $descTipo="Recebido";
      }
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
      if ($tipo=='P'){
        echo "<tr class='danger'>";
      }else{
        echo "<tr class='success'>";
      }
      echo "
      <td style='vertical-align: middle;'><font size='3px'>$nome</font></td>
      <td style='vertical-align: middle;'><font size='3px'>$fonte</font></td>
      <td style='vertical-align: middle;'><font size='3px'>R$$valor</font></td>
      <td style='vertical-align: middle;'><font size='3px'>"; echo date('d/m/Y', strtotime($data)); echo"</font></td>
      <td style='vertical-align: middle;' class='center'><font size='3px'><i class='fa fa-check fa-fw'></i> $descTipo</font></td>
    </tr>
    ";
  }else{
    if ($tipo=='P'){
      echo "<tr class='danger'>";
    }else{
      echo "<tr class='success'>";
    }
    echo "
    <td style='vertical-align: middle;'><font size='3px'>$nome</font></td>
    <td style='vertical-align: middle;'><font size='3px'>$fonte</font></td>
    <td style='vertical-align: middle;'><font size='3px'>R$$valor</font></td>
    <td style='vertical-align: middle;'><font size='3px'>"; echo date('d/m/Y', strtotime($data)); echo"</font></td>
    <td style='vertical-align: middle;' class='center'><font size='3px'><i class='fa fa-times fa-fw'></i> $descTipo</font></td>
  </tr>
  ";
}
}
}

echo "  </tbody>
</table>";

$total =number_format(($totalR - $totalP),2,',','');
$totalR =number_format($totalR,2,',','');
$totalP =number_format($totalP,2,',','');
echo "<br>
<div class='col-lg-12' align='center'>
  <div class='panel panel-default col-lg-4 alert-success'>
    <div class='panel-body'>
      <h3><b>Contas a Receber</b></h3>
      <h4><p>R$$totalR</p><h4>
      </div>
    </div>
    <div class='panel panel-default col-lg-4'>
      <div class='panel-body'>
        <h3><b>Balanço</b></h3>
        <h4><p>R$$total</p><h4>
        </div>
      </div>
      <div class='panel panel-default col-lg-4 alert-danger'>
        <div class='panel-body'>
          <h3><b>Contas a Pagar</b></h3>
          <h4><p>R$$totalP</p><h4>
          </div>
        </div>
      </div><br><br><br><br><br>
      
      ";
      echo "<div class='col-lg-12' align='center'>

      <a href='painel-system/contas_caixa.php' class='btn btn-primary' target='_blank'>Gerar Arquivo PDF</a><br></div><br><br>";
      ?>