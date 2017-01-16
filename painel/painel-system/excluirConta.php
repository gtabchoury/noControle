<?php
include("../../system/sy-conexao.php");
ini_set('default_charset','UTF-8');

    if (!isset($_SESSION)){
        session_start();
    }

    if (isset($_POST['id']))
        $contaID = $_POST['id'];
    else
        header('Location: ../contasReceber.php');

        $query = "DELETE FROM `nc_contas` where conta_id=?";
        $stmt = $mysqli->prepare($query);
        $stmt->bind_param('i', $contaID);
        $stmt->execute();

        if ($stmt->affected_rows==1){
            echo "<script> location.href='../contasReceber.php?success=2';</script>";
        }else{
            echo "<script> location.href='../contasReceber.php?success=-2;</script>";
        }

        $stmt->close();

?>