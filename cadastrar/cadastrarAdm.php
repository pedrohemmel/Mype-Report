<?php

session_start();

if(!$_SESSION['cadastroAdm']) {
    header('Location:../index.php');
    exit;
}

$erroCadAdm = filter_input(INPUT_GET, 'erroCadAdm');

$classeNone = 'displayNone';

if(!empty($erroCadAdm)) {
    if(password_verify($_SESSION['erroCadAdm'], $erroCadAdm)) {
        $classeNone = 'displayBlkRed';
        $mensagem = $_SESSION['erroCadAdm'];
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar Administrador</title>
    <link rel="stylesheet" href="../style/base.css"/>
</head>
<body>
    <!--Formulário de cadastro do usuário administrador-->
    <div class="container">
        <form method="POST" action="../cadastrar/cadastrarAdm_action.php">
            <p class="<?=$classeNone?>"><?=$mensagem?></p>
            <input type="text" name="nome_adm" placeholder="Digite seu nome completo" maxlength="100" required>
            <br><br>
            <input type="text" name="username_adm" placeholder="Digite seu nome de usuário" maxlength="50" required>
            <br><br>
            <input class="tel" type="tel" name="telefone_adm" placeholder="Digite seu número de telefone" minlength="10" maxlength="11" required>
            <input class="tel" type="tel" name="telefone_adm_sub" placeholder="Digite outro número de telefone" minlength="10" maxlength="11">
            <br><br>
            <input type="email" name="email_adm_ctt" placeholder="Digite seu e-mail de contato" maxlength="75" required>
            <br><br>
            <input type="email" name="email_adm" placeholder="Digite seu e-mail de acesso" maxlength="75" required>
            <input type="email" name="email_adm_confirm" placeholder="Confirme seu e-mail de acesso" maxlength="75" required>
            <br><br>
            <input type="password" name="senha_adm" placeholder="Digite sua senha" minlength="8" maxlength="100" required>
            <input type="password" name="senha_adm_confirm" placeholder="Confirme sua senha" minlength="8" maxlength="100" required>
            <br><br>
            <input type="submit" value="Cadastrar-se">
        </form>
    </div>
    
    <script src="../js/cadastrarAdmScript.js"></script>
</body>
</html>