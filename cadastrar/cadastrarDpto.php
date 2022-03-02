<?php

session_start();

if(!$_SESSION['loggedAdm']) {
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
        <form method="POST" action="../cadastrar/cadastrarDpto_action.php">
            <p class="<?=$classeNone?>"><?=$mensagem?></p>
            <input type="text" name="nome_dpto" placeholder="Digite o nome do departamento" maxlength="75" required>
            <br><br>
            <input type="text" name="centro_dcusto_dpto" placeholder="Digite o nome do centro de custo do departamento" maxlength="50" required>
            <br><br>
            <input type="submit" value="Cadastrar">
        </form>
    </div>
    
    <script src="../js/cadastrarAdmScript.js"></script>
</body>
</html>
