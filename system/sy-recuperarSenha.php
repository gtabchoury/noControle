<?php

require_once("class/class.phpmailer.php");
include("sy-conexao.php");

$mail = new PHPMailer();

$query = "SELECT user_password from nc_users WHERE user_email=? ";
$stmt = $mysqli->prepare($query);
$stmt->bind_param('s', $_POST['email']);
$stmt->execute();
$stmt->bind_result($hash);

if ($stmt->fetch()){

    $mail->SMTPSecure = "ssl";  
    $mail->Host='smtp.gmail.com';  
    $mail->Port='465';   
    $mail->Username   = 'nocontrole.noreply@gmail.com';
    $mail->Password   = 'conpec_nocontrole';  
    $mail->SMTPKeepAlive = true;  
    $mail->Mailer = "smtp"; 
    $mail->IsSMTP();
    $mail->SMTPAuth   = true;
    $mail->CharSet = 'utf-8';  
    $mail->SMTPDebug  = 0;  


    $mail->From = "nocontrole.noreply@gmail.com";
    $mail->FromName = "noControle";

    $mail->AddAddress($_POST['email']);

    $mail->IsHTML(true);

    $mail->Subject  = "[noControle] Recupere sua senha"; // Assunto da mensagem

    $msg="<p>Clique <b><a href='http://projects.conpec.com.br/nocontrole/pass-confirm.php?id=$hash'>neste link</a></b> para redefinir sua senha. </p>

    ";

    $mail->Body = $msg;


    $enviado = $mail->Send();

    $mail->ClearAllRecipients();
    $mail->ClearAttachments();

    if ($enviado) {
      echo "<script>location.href='../recuperarSenha.php?success=1';</script>";
    } else {
      echo "<script>location.href='../recuperarSenha.php?success=2';</script>";
    }
    
}else{
    echo "<script>location.href='../recuperarSenha.php?success=3';</script>";
}