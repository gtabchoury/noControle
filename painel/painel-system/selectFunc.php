<?php

ini_set('default_charset','UTF-8');
include("../../system/sy-conexao.php");

$func = $_POST['id'];


$query = "SELECT func_salario from nc_funcionarios WHERE func_id=?";
$stmt = $mysqli->prepare($query);
$stmt->bind_param('i', $func);
$stmt->execute();
$stmt->bind_result($res);

if ($stmt->fetch()){
  $res =number_format($res,2,',','');
  echo "$res";
}else{
  return false;
}

?>