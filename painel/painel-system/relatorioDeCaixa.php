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

// Incluimos a classe PHPExcel
include  'phpexcel/Classes/PHPExcel.php';
include("../../system/sy-conexao.php");

// Instanciamos a classe
$objPHPExcel = new PHPExcel();

// Definimos o estilo da fonte
$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);

// Criamos as colunas
$objPHPExcel->setActiveSheetIndex(0)
			->setCellValue('A1', "Relatório de Caixa" )
            ->setCellValue('A2', $userNome )
            ->setCellValue('B2', $mAtual." de ".$anoAtual )
            ->setCellValue("A4", "Saldo Inicial Banco" )
            ->setCellValue("A5", "Saldo Inicial Caixa" )
            ->setCellValue("A6", "Total" )
            ->setCellValue("A8", "Data" )
            ->setCellValue("B8", "Entrada" )
            ->setCellValue("C8", "Nº do documento" )
            ->setCellValue("D8", "Débito" )
            ->setCellValue("E8", "Crédito" )
            ->setCellValue("F8", "Saldo" );

// Podemos configurar diferentes larguras paras as colunas como padrão
$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(25);
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(40);
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(25);
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(15);
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(15);
$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(15);

// EDITANDO

$objPHPExcel->getActiveSheet()->getStyle('A1:F2')->applyFromArray(
        array('fill' => array(
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                'color' => array('rgb' => 'FF8C00'),

            ),
        )
);

$objPHPExcel->getActiveSheet()->getStyle('A1:F200')->applyFromArray(
        array('alignment' => array(
            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            'name'  => 'Arial',
        ),
        )
);

//BORDAS

$styleArray = array(
  'borders' => array(
    'outline' => array(
      'style' => PHPExcel_Style_Border::BORDER_THIN
    )
  )
);

$objPHPExcel->getActiveSheet()->getStyle('A1:F1')->applyFromArray($styleArray);
$objPHPExcel->getActiveSheet()->getStyle('A1:F2')->applyFromArray($styleArray);
$objPHPExcel->getActiveSheet()->getStyle('A4:C5')->applyFromArray($styleArray);
$objPHPExcel->getActiveSheet()->getStyle('A6:C6')->applyFromArray($styleArray);
unset($styleArray);


$objPHPExcel->getActiveSheet()->mergeCells('A1:F1');

$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setSize(14);
$objPHPExcel->getActiveSheet()->getStyle('A2:B2')->getFont()->setSize(12);
$objPHPExcel->getActiveSheet()->getStyle('A4:F200')->getFont()->setSize(10);
$objPHPExcel->getActiveSheet()->getStyle('A1:F8')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_WHITE);
$objPHPExcel->getActiveSheet()->getStyle('A2')->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_WHITE);
$objPHPExcel->getActiveSheet()->getStyle('B2')->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_WHITE);

$objPHPExcel->getActiveSheet()->getStyle('A1:F200')->getFont()->setName('Arial');

$objPHPExcel->getActiveSheet()->getStyle('C4')->getNumberFormat()->setFormatCode("$#,##0.00");
$objPHPExcel->getActiveSheet()->getStyle('C5')->getNumberFormat()->setFormatCode("$#,##0.00");
$objPHPExcel->getActiveSheet()->getStyle('C6')->getNumberFormat()->setFormatCode("$#,##0.00");

// INSERINDO DADOS

// SALDOS INICIAIS
$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, 4, 0);
$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, 5, 0);
$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, 6, 0);

// RELATORIO
$x=9;

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

    $debitoP =number_format($debito,2,'.','');
    $creditoP =number_format($credito,2,'.','');
    $saldoP =number_format($saldo,2,'.','');
    $dt = date('d/m/Y', strtotime($data));

    $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, $x, $doc);

    if ($tipo=="P"){
    	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $x, $dt);
    	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $x, $desc);
      if ($debito==0){
      		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, $x, "");
        }else{
        	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, $x, $debitoP);
        }
        if ($credito==0){
          $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4, $x, "");
        }else{
          $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4, $x, $creditoP);
        }
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(5, $x, $saldoP);
    }else{
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $x, $dt);
    	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(1, $x, $desc);

      if ($debito==0){
      		$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, $x, "");
        }else{
        	$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, $x, $debitoP);
        }
        if ($credito==0){
          $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4, $x, "");
        }else{
          $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4, $x, $creditoP);
        }
        $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(5, $x, $saldoP);

      }
      $x++;
    }
  }
}

$x--;
$objPHPExcel->getActiveSheet()->getStyle('D9:F'.$x)->getNumberFormat()->setFormatCode("$#,##0.00");

$styleArray = array(
  'borders' => array(
    'outline' => array(
      'style' => PHPExcel_Style_Border::BORDER_THIN
    )
  )
);

$objPHPExcel->getActiveSheet()->getStyle('A8:F8')->applyFromArray($styleArray);
unset($styleArray);

//DADOS FINAIS
$x=$x+2;
$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $x, "Total");

$objPHPExcel->getActiveSheet()->getStyle('D'.$x.':F'.$x)->getNumberFormat()->setFormatCode("$#,##0.00");

$total =number_format(($totalR - $totalP),2,'.','');
$totalR =number_format($totalR,2,'.','');
$totalP =number_format($totalP,2,'.','');

$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(3, $x, $totalP);
$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(4, $x, $totalR);
$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(5, $x, $total);

$objPHPExcel->getActiveSheet()->getStyle('A'.$x.':F'.$x)->getFont()->setBold(true);

$styleArray = array(
  'borders' => array(
    'outline' => array(
      'style' => PHPExcel_Style_Border::BORDER_THIN
    )
  )
);

$objPHPExcel->getActiveSheet()->getStyle('A'.$x.':F'.$x)->applyFromArray($styleArray);
$objPHPExcel->getActiveSheet()->getStyle('A8:F'.$x)->applyFromArray($styleArray);
unset($styleArray);


$x=$x+2;
$y=$x+2;
$z=$x+1;
$objPHPExcel->getActiveSheet()->getStyle('C'.$x.':C'.$y)->getNumberFormat()->setFormatCode("$#,##0.00");
$objPHPExcel->getActiveSheet()->getStyle('A'.$x.':C'.$y)->getFont()->setBold(true);

$styleArray = array(
  'borders' => array(
    'outline' => array(
      'style' => PHPExcel_Style_Border::BORDER_THIN
    )
  )
);

$objPHPExcel->getActiveSheet()->getStyle('A'.$x.':C'.$z)->applyFromArray($styleArray);
$objPHPExcel->getActiveSheet()->getStyle('A'.$y.':C'.$y)->applyFromArray($styleArray);
unset($styleArray);

$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $x, "Saldo Final Banco");
$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, $x, 0);
$x++;
$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $x, "Saldo Final Caixa");
$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, $x, 0);
$x++;
$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(0, $x, "Total");
$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, $x, 0);


// Podemos renomear o nome das planilha atual, lembrando que um único arquivo pode ter várias planilhas

if ($mAtual=="Março"){
	$mAtual="Marco";
}

$objPHPExcel->getActiveSheet()->setTitle($mAtual);

// Cabeçalho do arquivo para ele baixar
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="relatorio_'.$mAtual.'.xls"');
header('Cache-Control: max-age=0');
// Se for o IE9, isso talvez seja necessário
header('Cache-Control: max-age=1');

// Acessamos o 'Writer' para poder salvar o arquivo
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');

// Salva diretamente no output, poderíamos mudar arqui para um nome de arquivo em um diretório ,caso não quisessemos jogar na tela
$objWriter->save('php://output'); 

exit;

?>