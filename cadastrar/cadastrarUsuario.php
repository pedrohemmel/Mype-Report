<?php

session_start();

if(!$_SESSION['loggedAdm']) {
    header('Location:../index.php');
    exit;
}

$erroCadUsu = filter_input(INPUT_GET, 'erroCadUsu');

$classeNone = 'displayNone';

if(!empty($erroCadUsu)) {
    if(password_verify($_SESSION['erroCadUsu'], $erroCadUsu)) {
        $classeNone = 'displayBlkRed';
        $mensagem = $_SESSION['erroCadUsu'];
    }
}

?>

id_emp int not null,
id_dpto int not null,
nome_usu varchar(100) not null,
username_usu varchar(50) not null unique,
email_usu varchar(75) not null unique,
telefone_usu char(14) not null unique,
perfil_usu char(3) not null check(perfil_usu = 'adm' || perfil_usu = 'usu'),
senha_usu varchar(100) not null,
situacao_usu char(7) not null check(situacao_usu = 'ativo' || situacao_usu = 'inativo'),
recupera_senha_usu varchar(100),

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar Usuário</title>
    <link rel="stylesheet" href="../style/base.css"/>
</head>
<body>
    <!--Formulário de cadastro do usuário administrador-->
    <div class="container">
        <form method="POST" action="../cadastrar/cadastrarUsu_action.php">
            <p class="<?=$classeNone?>"><?=$mensagem?></p>
            <input type="text" name="nome_usu" placeholder="Digite seu nome completo" maxlength="100" required>
            <br><br>
            <input type="text" name="username_usu" placeholder="Digite seu nome de usuário" maxlength="50" required>
            <br><br>
            <input class="tel" type="tel" name="telefone_usu" placeholder="Digite seu número de telefone" minlength="10" maxlength="11" required>
            <br><br>
            <input type="email" name="email_usu" placeholder="Digite seu e-mail de acesso" maxlength="75" required>
            <input type="email" name="email_usu_confirm" placeholder="Confirme seu e-mail de acesso" maxlength="75" required>
            <br><br>
            <label>Seleciona o tipo usuário</label>
            <select name="perfil_usu">
                <option value="usu">Usuário</option>
                <option value="adm">Administrador</option>
            </select>
            <br><br>
            <input type="password" name="senha_usu" placeholder="Digite sua senha" minlength="8" maxlength="100" required>
            <input type="password" name="senha_usu_confirm" placeholder="Confirme sua senha" minlength="8" maxlength="100" required>
            <br><br>
            <input type="checkbox" name="situacao_emp">
            <label>Ao cadastrar uma empresa, automaticamente o status da mesma é ativa, caso queira deixar o status como inativo selecione esta opção.</label>
            <br><br>
            <input type="submit" value="Cadastrar-se">
        </form>
    </div>
    
    <script src="../js/cadastrarAdmScript.js"></script>
</body>
</html>