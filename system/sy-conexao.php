<?php
	
	$host = 'localhost';
	$usuario = 'nocontrole';
	$senha = 'conpec_nocontrole';
	$database = 'nocontrole';

	$mysqli = new mysqli($host, $usuario, $senha, $database);

	if ($mysqli->connect_errno){
		echo "Falha na conexão: ".$mysqli->connect_errno.") ".$mysqli->connect_errno;
	}

?>
