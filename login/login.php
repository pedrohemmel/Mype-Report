<?php

session_start();

$msgCadAdm = filter_input(INPUT_GET, 'msgCadAdm');
$erroLogin = filter_input(INPUT_GET, 'erroLogin');

$classeNone = 'displayNone';

if(!empty($msgCadAdm)) {
    if(password_verify($_SESSION['msgCadAdm'], $msgCadAdm)) {
        $classeNone = 'displayBlkGreen';
        $mensagem = $_SESSION['msgCadAdm'];
    }
} else if(!empty($erroLogin)) {
    if(password_verify($_SESSION['erroLogin'], $erroLogin)) {
        $classeNone = 'displayBlkRed';
        $mensagem = $_SESSION['erroLogin'];
    }
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="style/base.css"/>
</head>
<body>
    <div class="container">
        <form method="POST" action="verificarUsuario.php">
            <p class="<?=$classeNone?>"><?=$mensagem?></p>
            <input type="text" name="username_email_usu" placeholder="Digite seu username ou e-mail" maxlength="75" required>
            <br><br>
            <input type="password" name="senha_usu" placeholder="Digite sua senha" minlength="8" maxlength="100" required>
            <br><br>
            <input type="submit" value="Entrar">
        </form>
        <hr>
        <a href="recuperarSenha.php">Esqueci a senha</a>
    </div>
</body>
</html>