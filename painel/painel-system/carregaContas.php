<?php

if(!isset($_SESSION['usuario_id'])){
  header('Location: ../../login');
  exit;
}

$userID = $_SESSION['usuario_id'];
$totalR = 0;
$totalP = 0;
$saldo = 0;

date_default_timezone_set('America/Sao_Paulo');
$mesAtual = date('m');

$query = "SELECT * FROM nc_contas WHERE conta_userID=$userID ORDER BY conta_data;";
$result = mysqli_query($mysqli, $query);
$rowcount=mysqli_num_rows($result);

while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
  $debito=0;
  $credito = 0;

  $data = $row['conta_data'];
  $mesConta = date('m', strtotime($data));
  
  if ($mesAtual == $mesConta){
    $status = $row['conta_status'];

    if($status==1){
      $valor = $row['conta_valor'];
      $desc = $row['conta_nome'];
      $fonteID = $row['conta_fonteID'];
      $doc = $row['conta_documento'];
      if ($fonteID!=null){
        $query = "SELECT contato_nome from nc_contatos WHERE contato_id=? ";
        $stmt = $mysqli->prepare($query);
        $stmt->bind_param('i', $fonteID);
        $stmt->execute();
        $stmt->bind_result($fonte);

        if (!$stmt->fetch()){
          $fonte="";
        }else{
          $desc = $desc . " ($fonte)";
        }

        $stmt->close();
      }

      $tipo = $row['conta_tipo'];

      if ($tipo=="P"){
        $debito = $valor;
        $credito = 0;
        $totalP = $totalP + $valor;
        $saldo = $saldo - $valor;
      }else{
        $debito = 0;
        $credito = $valor;
        $totalR = $totalR + $valor;
        $saldo = $saldo + $valor;
      }

      $debitoP =number_format($debito,2,',','');
      $creditoP =number_format($credito,2,',','');
      $saldoP =number_format($saldo,2,',','');
      

        if ($tipo=='P'){
          echo "<tr class='danger'>";
        }else{
          echo "<tr class='success'>";
        }
        echo "
        
        <td style='vertical-align: middle;'><font size='3px'>"; echo date('d/m/Y', strtotime($data)); echo"</font></td>
        <td style='vertical-align: middle;'><font size='3px'>$desc</font></td>
        <td style='vertical-align: middle;'><font size='3px'>$doc</font></td>";

        if ($debito==0){
          echo "<td style='vertical-align: middle;'><font size='3px'></font></td>";
        }else{
          echo "<td style='vertical-align: middle;'><font size='3px'>R$$debitoP</font></td>";
        }
        if ($credito==0){
          echo "<td style='vertical-align: middle;'><font size='3px'></font></td>";
        }else{
          echo "<td style='vertical-align: middle;'><font size='3px'>R$$creditoP</font></td>";
        }
        echo "
        <td style='vertical-align: middle;'><font size='3px'>R$$saldoP</font></td>
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
      <h3><b>Total Recebido</b></h3>
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
          <h3><b>Total Pago</b></h3>
          <h4><p>R$$totalP</p><h4>
          </div>
        </div>
      </div><br>
      
      ";
      echo "<div class='col-lg-12' align='center'>

      <a href='painel-system/relatorioDeCaixa.php' class='btn btn-primary' target='_blank'>Gerar Relatório</a><br></div><br>";
      ?>