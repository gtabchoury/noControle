<?php

if (!isset($_SESSION)){
  session_start();
}

if(!isset($_SESSION['usuario_id'])){
  header('Location: ../../login');
  exit;
}

$userID = $_SESSION['usuario_id'];
$userNome = $_SESSION['usuario_nome'];

$totalR = 0;
$totalP = 0;
$saldo = 0;


date_default_timezone_set('America/Sao_Paulo');
$name = date('dmYHis');
$date = date('d/m/Y - H:i');
$mesAtual = date('m');
$anoAtual = date('Y');

switch ($mesAtual) {
  case '01':
  $mAtual = "Janeiro";
  break;
  case '02':
  $mAtual = "Fevereiro";
  break;
  case '03':
  $mAtual = "Março";
  break;
  case '04':
  $mAtual = "Abril";
  break;
  case '05':
  $mAtual = "Maio";
  break;
  case '06':
  $mAtual = "Junho";
  break;
  case '07':
  $mAtual = "Julho";
  break;
  case '08':
  $mAtual = "Agosto";
  break;
  case '09':
  $mAtual = "Setembro";
  break;
  case '10':
  $mAtual = "Outubro";
  break;
  case '11':
  $mAtual = "Novembro";
  break;
  case '12':
  $mAtual = "Dezembro";
  break;

  default:
  $mAtual = "";
  break;
}

/* Carrega a classe DOMPdf */
require_once("dompdf/dompdf_config.inc.php");
include("../../system/sy-conexao.php");

$codigoHTML="<p align='right'>$date<p/>
$userNome <br><br>
Caixa de <b>$mAtual de $anoAtual</b><br><br><br>
<div class='panel-body'>
  <table width='100%'' class='table table-striped table-bordered table-hover ' align='center'>
    <thead>
      <tr align='left'>
        <th width='17%'><font size='22px'>Data</font></th>
        <th width='35%'><font size='22px'>Descrição</font></th>
        <th width='16%'><font size='22px'>Débito</font></th>
        <th width='16%'><font size='22px'>Crédito</font></th>
        <th width='16%'><font size='22px'>Saldo</font></th>
      </tr>
    </thead>
    <tbody>
     ";

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

    if ($doc!=""){
      $desc= $desc . " - $doc";
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
    $dt = date('d/m/Y', strtotime($data));

    if ($tipo=="P"){
      $codigoHTML=$codigoHTML . "<tr style='color: #d9534f;'>
      <td style='vertical-align: middle;'><font size='16px'>$dt</font></td>
      <td style='vertical-align: middle;'><font size='16px'>$desc</font></td>";

      if ($debito==0){
          $codigoHTML=$codigoHTML . "<td style='vertical-align: middle;'><font size='16px'></font></td>";
        }else{
          $codigoHTML=$codigoHTML . "<td style='vertical-align: middle;'><font size='16px'>R$$debitoP</font></td>";
        }
        if ($credito==0){
          $codigoHTML=$codigoHTML . "<td style='vertical-align: middle;'><font size='16px'></font></td>";
        }else{
          $codigoHTML=$codigoHTML . "<td style='vertical-align: middle;'><font size='16px'>R$$creditoP</font></td>";
        }
        $codigoHTML=$codigoHTML . "
        <td style='vertical-align: middle;'><font size='16px'>R$$saldoP</font></td>
      ";
    }else{
      $codigoHTML=$codigoHTML . "<tr style='color: #31b131;'>
      <td style='vertical-align: middle;'><font size='16px'>$dt</font></td>
      <td style='vertical-align: middle;'><font size='16px'>$desc</font></td>";

      if ($debito==0){
          $codigoHTML=$codigoHTML . "<td style='vertical-align: middle;'><font size='16px'></font></td>";
        }else{
          $codigoHTML=$codigoHTML . "<td style='vertical-align: middle;'><font size='16px'>R$$debitoP</font></td>";
        }
        if ($credito==0){
          $codigoHTML=$codigoHTML . "<td style='vertical-align: middle;'><font size='16px'></font></td>";
        }else{
          $codigoHTML=$codigoHTML . "<td style='vertical-align: middle;'><font size='16px'>R$$creditoP</font></td>";
        }
        $codigoHTML=$codigoHTML . "
        <td style='vertical-align: middle;'><font size='16px'>R$$saldoP</font></td>
      ";

      }
    }
  }
}

$total =number_format(($totalR - $totalP),2,',','');
$totalR =number_format($totalR,2,',','');
$totalP =number_format($totalP,2,',','');

$codigoHTML = $codigoHTML . "
<table align='center' width='70%'>
  <tr>
    <td align='center' style='color: #31b131'>
      <h3><b>Total Recebido</b></h3>
      <h4><p>R$$totalR</p><h4>
      </td>
      <td align='center' style='color: #000000'>
        <h3><b>Balanço</b></h3>
        <h4><p>R$$total</p><h4>
        </td>
        <td align='center' style='color: #d9534f;'>
          <h3><b>Total Pago</b></h3>
          <h4><p>R$$totalP</p><h4>
          </td>
        </tr>
      </table><br>";

      /* Cria a instĆ¢ncia */
      $dompdf = new DOMPDF();

      /* Carrega seu HTML */
      $dompdf->load_html($codigoHTML);

      /* Renderiza */
      $dompdf->render();

      /* Exibe */
      $dompdf->stream(
       "[noControle][Caixa]$name.pdf", /* Nome do arquivo de saĆ­da */
       array(
         "Attachment" => false /* Para download, altere para true */
         )
       );
?>
