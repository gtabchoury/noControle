<?php

ini_set('default_charset','UTF-8');

include("../../system/sy-conexao.php");

$id = $_POST['id'];
$_SESSION['idFuncCP']=$id;

$query = "SELECT func_salario from nc_funcionarios WHERE func_id=? ";
$stmt = $mysqli->prepare($query);
$stmt->bind_param('i', $id);
$stmt->execute();
$stmt->bind_result($salarioF);

if (!$stmt->fetch()){
	echo false;
}else{
	$salarioF =number_format($salarioF,2,',','');
	echo "$salarioF";
}

$stmt->close();

?>