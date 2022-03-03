<?php

session_start();

if(!$_SESSION['loggedAdm']) {
    header('Location:../index.php');
    exit;
}

$erroCadAdm = filter_input(INPUT_GET, 'erroCadInd');

$classeNone = 'displayNone';

if(!empty($erroCadAdm)) {
    if(password_verify($_SESSION['erroCadInd'], $erroCadInd)) {
        $classeNone = 'displayBlkRed';
        $mensagem = $_SESSION['erroCadInd'];
    }
}



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar Indicador</title>
    <link rel="stylesheet" href="../style/base.css"/>
</head>
<body>
    <!--Formulário de cadastro do usuário administrador-->
    <div class="container">
        <form method="POST" action="../cadastrar/cadastrarIndicador_action.php">
            <p class="<?=$classeNone?>"><?=$mensagem?></p>
            <input type="text" name="nome_rel" placeholder="Digite o nome do relatório" maxlength="75" required>
            <br><br>
            <input type="text" name="link_rel" placeholder="Digite o link do relatório" maxlength="300" required>
            <br><br>
            <input type="checkbox" name="situacao_rel">
            <label>Ao cadastrar um relatório, automaticamente o status do mesmo é ativo, caso queira deixar o status como inativo, selecione esta opção.</label>
            <br><br>
            <input type="submit" value="Cadastrar">
        </form>
    </div>
    
    <script src="../js/cadastrarAdmScript.js"></script>
</body>
</html>
