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
Lista de Produtos - Estoque<br><br>
<div class='panel-body'>
  <table width='100%'' class='table table-striped table-bordered table-hover ' align='center'>
    <thead>
      <tr align='left'>
        <th width='75%'><font size='22px'>Descrição</font></th>
        <th width='25%'><font size='22px'>Estoque</font></th>
      </tr>
    </thead>
    <tbody>
     ";

     $query = "SELECT * FROM nc_produtos WHERE pro_userID=$userID  ORDER BY pro_nome;";
     $result = mysqli_query($mysqli, $query);
     $rowcount=mysqli_num_rows($result);

     while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){

      $nome = $row['pro_nome'];
      $estoque = $row['pro_estoque'];


      $codigoHTML=$codigoHTML . "<tr>
      <td style='vertical-align: middle;'><font size='18px'>$nome</font></td>
      <td style='vertical-align: middle;'><font size='18px'>$estoque</font></td>
      ";
    }


    /* Cria a instĆ¢ncia */
    $dompdf = new DOMPDF();

    /* Carrega seu HTML */
    $dompdf->load_html($codigoHTML);

    /* Renderiza */
    $dompdf->render();

    /* Exibe */
    $dompdf->stream(
     "[noControle][Estoque]$name.pdf", /* Nome do arquivo de saĆ­da */
     array(
       "Attachment" => false /* Para download, altere para true */
       )
     );
     ?>
