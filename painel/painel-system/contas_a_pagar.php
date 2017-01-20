<?php

if (!isset($_SESSION)){
    session_start();
}

if(!isset($_SESSION['usuario_id'])){
    header('Location: ../../login.php');
    exit;
}

$userID = $_SESSION['usuario_id'];
$userNome = $_SESSION['usuario_nome'];

$totalP = 0;
$total = 0;

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
Contas a pagar de <b>$mAtual de $anoAtual</b><br><br><br>
<div class='panel-body'>
    <table width='100%'' class='table table-striped table-bordered table-hover ' align='center'>
        <thead>
            <tr align='left'>
                <th width='25%'><font size='22px'>Nome</font></th>
                <th width='18%'><font size='22px'>Fonte</font></th>
                <th width='18%'><font size='22px'>Valor</font></th>
                <th width='16%'><font size='22px'>Data</font></th>
                <th width='23%'><font size='22px'>Situação</font></th>
            </tr>
        </thead>
        <tbody>
           ";

           $query = "SELECT * FROM nc_contas WHERE conta_userID=$userID AND conta_tipo='P' ORDER BY conta_nome;";
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
                    $totalP=$totalP+$valor;
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
               $dt = date('d/m/Y', strtotime($data));
               $codigoHTML=$codigoHTML . "<tr>
               <td style='vertical-align: middle;'><font size='18px'>$nome</font></td>
               <td style='vertical-align: middle;'><font size='18px'>$fonte</font></td>
               <td style='vertical-align: middle;'><font size='18px'>R$$valor</font></td>
               <td style='vertical-align: middle;'><font size='18px'>$dt</font></td>
               <td style='vertical-align: middle;' class='center'><font size='18px'><i class='fa fa-check fa-fw'></i> Paga</font></td>";
           }else{
               $dt = date('d/m/Y', strtotime($data));
               $codigoHTML=$codigoHTML . "<tr>
               <td style='vertical-align: middle;'><font size='18px'>$nome</font></td>
               <td style='vertical-align: middle;'><font size='18px'>$fonte</font></td>
               <td style='vertical-align: middle;'><font size='18px'>R$$valor</font></td>
               <td style='vertical-align: middle;'><font size='18px'>$dt</font></td>
               <td style='vertical-align: middle;' class='center'><font size='18px'><i class='fa fa-check fa-fw'></i>Não Paga</font></td>";
           }
       }
   }
   $totalPago = $total - $totalP;
   $totalP =number_format($totalP,2,',','');
   $totalPago =number_format($totalPago,2,',','');
   $total =number_format($total,2,',','');

   $codigoHTML = $codigoHTML . "
   <table align='center' width='70%'>
      <tr>
        <td align='center'>
            <h3><b>Pago</b></h3>
            <h4><p>R$$totalPago</p><h4>
            </td>
            <td align='center'>
                <h3><b>Total</b></h3>
                <h4><p>R$$total</p><h4>
                </td>
                <td align='center'>
                    <h3><b>Não Pago</b></h3>
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
               "[noControle][Contas a Pagar]$name.pdf", /* Nome do arquivo de saĆ­da */
               array(
                   "Attachment" => false /* Para download, altere para true */
                   )
               );
               ?>
