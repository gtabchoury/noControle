<?php

ini_set('default_charset','UTF-8');
$userID = $_SESSION['usuario_id'];

$query = "SELECT * FROM nc_contatos WHERE contato_userID=$userID ";
$result = mysqli_query($mysqli, $query);
$rowcount=mysqli_num_rows($result);

while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
    $nome = $row['contato_nome'];
    $id = $row['contato_id'];
    echo "
	    <option value='$id'>
	        $nome
	    </option>
	    ";
}

?>