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

    $valor = $row['conta_valor'];
    $tipo = $row['conta_tipo'];
    
    if ($tipo=='P'){
      $totalP=$totalP+$valor;
    }
    if ($tipo=='R'){
      $totalR=$totalR+$valor;
    }

    $_SESSION['totalB'] =number_format(($totalR-$totalP),2,',','');
    $_SESSION['totalR'] =number_format($totalR,2,',','');
    $_SESSION['totalP'] =number_format($totalP,2,',','');
  }
}