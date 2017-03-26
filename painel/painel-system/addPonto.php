<?php

include("../../system/sy-conexao.php");

ini_set('default_charset','UTF-8');

if (!isset($_SESSION)){
    session_start();
}

if(!isset($_SESSION['usuario_id'])){
    header('Location: ../../login');
    exit;
}

$userConta=$_SESSION['usuario_id'];
$numDias = $_POST['numDias'];
$mes = $_POST['dataMes'];
$ano = $_POST['dataAno'];
$func = $_POST['fonteConta'];

$query = "SELECT cartao_id from nc_cartoes WHERE cartao_userID=? AND cartao_funcID=? AND cartao_mes=? AND cartao_ano=? ";
$stmt = $mysqli->prepare($query);
$stmt->bind_param('iisi', $userConta, $func, $mes, $ano);
$stmt->execute();
$stmt->bind_result($idCartao);

if ($stmt->fetch()){
    $stmt->close();
    echo "Cartão ja cadastrado!";
}else{
    $stmt->close();
    $query = "INSERT INTO `nc_cartoes`(`cartao_userID`, `cartao_funcID`, `cartao_mes`, `cartao_ano`) VALUES (?,?,?,?)";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param('iisi', $userConta, $func, $mes, $ano);
    $stmt->execute();

    if ($stmt->affected_rows==1){
        $stmt->close();
        $query = "SELECT cartao_id from nc_cartoes WHERE cartao_userID=? AND cartao_funcID=? AND cartao_mes=? AND cartao_ano=? ";
        $stmt = $mysqli->prepare($query);
        $stmt->bind_param('iisi', $userConta, $func, $mes, $ano);
        $stmt->execute();
        $stmt->bind_result($idCartao);

        if ($stmt->fetch()){
            $stmt->close();
            $v=0;
            $totalHoras = $_POST['entradaManha1'] - $_POST['entradaManha1'];
            for ($i=1;$i<=$numDias;$i++){
                $data = $_POST['dataDia'.$i];
                $data = implode("-",array_reverse(explode("/",$data)));
                $entrada1 = $_POST['entradaManha'.$i];
                $saida1 = $_POST['saidaManha'.$i];
                $entrada2 = $_POST['entradaTarde'.$i];
                $saida2 = $_POST['saidaTarde'.$i];

                $hora1 = $saida1-$entrada1;
                $hora2 = $saida2-$entrada2;

                $totalHoras = $totalHoras + $hora1 + $hora2;

                $query = "INSERT INTO `nc_pontos`(`ponto_cartaoID`, `ponto_data`, `ponto_entrada1`, `ponto_saida1`, `ponto_entrada2`, `ponto_saida2`) VALUES (?,?,?,?,?,?)";
                $stmt = $mysqli->prepare($query);
                $stmt->bind_param('isssss', $idCartao, $data, $entrada1, $saida1, $entrada2, $saida2);
                $stmt->execute();

                if ($stmt->affected_rows!=1){
                    $v=1;
                }
                $stmt->close();
            }

            if ($v==0){
                echo "Deu bom!";
                echo "Total de Horas: $totalHoras";
            }else{
                echo "Deu ruim!";
            }

        }else{
            echo "Erro!";
        }

    }else{
        echo "Erro!";
    }

}
?>