<?php

ini_set('default_charset','UTF-8');

if(!isset($_SESSION['usuario_id'])){
    header('Location: ../../login');
    exit;
}

$userID = $_SESSION['usuario_id'];
$_SESSION['count']=0;

date_default_timezone_set('America/Sao_Paulo');
    $mesAtual = date('m');
    $anoAtual = date('Y');
    
    switch ($mesAtual) {
        case '01':
            $mesAtual = "Janeiro";
            break;
        case '02':
            $mesAtual = "Fevereiro";
            break;
        case '03':
            $mesAtual = "Março";
            break;
        case '04':
            $mesAtual = "Abril";
            break;
        case '05':
            $mesAtual = "Maio";
            break;
        case '06':
            $mesAtual = "Junho";
            break;
        case '07':
            $mesAtual = "Julho";
            break;
        case '08':
            $mesAtual = "Agosto";
            break;
        case '09':
            $mesAtual = "Setembro";
            break;
        case '10':
            $mesAtual = "Outubro";
            break;
        case '11':
            $mesAtual = "Novembro";
            break;
        case '12':
            $mesAtual = "Dezembro";
            break;
        
        default:
            $mesAtual = "";
            break;
    }

$query = "SELECT * FROM nc_contas WHERE conta_userID=$userID AND conta_tipo='R' ORDER BY conta_data";
$result = mysqli_query($mysqli, $query);
$rowcount=mysqli_num_rows($result);

while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
    $data = $row['conta_data'];
    $mes = date($data, 'm');

    echo "
    <option value='$mes'>
       $data
   </option>
   ";
}

?>