<?php

ini_set('default_charset','UTF-8');
$userID = $_SESSION['usuario_id'];
$_SESSION['count']=0;

$query = "SELECT * FROM nc_contatos WHERE contato_userID=$userID ";
$result = mysqli_query($mysqli, $query);
$rowcount=mysqli_num_rows($result);

while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
    $nome = $row['contato_nome'];
    $id = $row['contato_id'];
    $_SESSION['user_contatos'][$_SESSION['count']]=$nome;
    $_SESSION['user_contatos_ids'][$_SESSION['count']]=$id;
    $_SESSION['count']=$_SESSION['count']+1;
    echo "
	    <option value='$id'>
	        $nome
	    </option>
	    ";
}

?>