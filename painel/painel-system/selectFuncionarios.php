<?php

ini_set('default_charset','UTF-8');

if(!isset($_SESSION['usuario_id'])){
    header('Location: ../../login');
    exit;
}

$userID = $_SESSION['usuario_id'];
$_SESSION['count']=0;

$idF=$_SESSION['idFuncCP'];

$query = "SELECT * FROM nc_funcionarios WHERE func_userID=$userID ";
$result = mysqli_query($mysqli, $query);
$rowcount=mysqli_num_rows($result);

while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
    $nome = $row['func_nome'];
    $id = $row['func_id'];
    $_SESSION['user_funcionarios'][$_SESSION['count']]=$nome;
    $_SESSION['user_funcionarios_ids'][$_SESSION['count']]=$id;
    $_SESSION['count']=$_SESSION['count']+1;

    if($id==$idF){
      $sel="selected";
    }else{
      $sel="";
    }

    echo "
    <option $sel value='$id'>
       $nome
    </option>
   ";
}

?>