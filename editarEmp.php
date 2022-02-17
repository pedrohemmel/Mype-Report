<?php

session_start();

if(!$_SESSION['loggedAdm']) {
    header('Location:index.php');
    exit;
} else {
    $logged = 'ativo';
}

require 'config.php';
require 'dao/EmpresasDaoMysql.php';

if(!($_SESSION['id_emp'] && $_SESSION['cnpj_emp'] && $_SESSION['razao_social_emp'] && $_SESSION['nome_fantasia_emp'] && $_SESSION['logo_emp'] && $_SESSION['endereco_emp'] && $_SESSION['situacao_emp'])) {
    $_SESSION['erroEmp'] = 'Erro ao encontrar empresa.';
    $_SESSION['erroEmpCrypt'] = password_hash($_SESSION['erroEmp'], PASSWORD_DEFAULT);

    header('Location:gerenciamentoSist.php?erroEmp='.$_SESSION['erroEmpCrypt']);
    exit;
}

//logica para verificar as cores e não retornar undefined
if(empty($_SESSION['cor_pri_emp']) && empty($_SESSION['cor_sec_emp'])) {
    $cor_pri_emp = "";
    $cor_sec_emp = "";
} else if(empty($_SESSION['cor_pri_emp']) && !empty($_SESSION['cor_sec_emp'])) {
    $cor_pri_emp = "";
    $cor_sec_emp = $_SESSION['cor_sec_emp'];
} else if(!empty($_SESSION['cor_pri_emp']) && empty($_SESSION['cor_sec_emp'])) {
    $cor_pri_emp = $_SESSION['cor_pri_emp'];
    $cor_sec_emp = "";
} else {
   $cor_pri_emp = $_SESSION['cor_pri_emp'];
   $cor_sec_emp = $_SESSION['cor_sec_emp'];
}

//
$classeNone = 'displayNone';

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar empresa</title>
    <link rel="stylesheet" href="style/base.css"/>
</head>
<body>
    <form action="" method="POST" enctype="multipart/form-data">
        <p class="<?=$classeNone?>"><?=$mensagem?></p>
        <label>Selecione uma imagem (JPG, PNG). Recomendável selecionar imagem tamanho 250X250px.</label>
        <input type="file" name="logo_emp">
        <br><br>
        <div class="displayFlex flex-direction-row justify-content-center">
            <label>nome Fantasia</label>
            <input type="text" name="nome_fantasia_emp" placeholder="Nome social da empresa" value="<?=$_SESSION['nome_fantasia_emp']?>" maxlength="50" required>
            <label>Razão Social</label>
            <input type="text" name="razao_social_emp" placeholder="Razão social da empresa" value="<?=$_SESSION['razao_social_emp']?>" maxlength="50" required>
        </div>
        <br><br>
        <div class="displayFlex flex-direction-row justify-content-center">
            <label>CNPJ</label>
            <input type="text" name="cnpj_emp" placeholder="Digite o CNPJ da empresa" value="<?=$_SESSION['cnpj_emp']?>" minLength="14" maxLength="14" required>
            <label>Endereço</label>
            <input type="text" name="endereco_emp" placeholder="Digite o endereço da empresa" value="<?=$_SESSION['endereco_emp']?>" maxLength="150" required>   
        </div>
        <br><br>
        <label>Caso queira aplicar uma cor primária e/ou secundária para essa empresa, digite nos campos abaixo utilizando 6 digitos de cores hexagonais. Exemplo: (ff0100; 00ff12; 23f3ad;).</label>
        <div class="displayFlex flex-direction-row justify-content-center">
            <label>Cor Primária da empresa</label>
            <input type="text" name="cor_pri_emp" value="<?=$cor_pri_emp?>" placeholder="Cor primária">
            <label>Cor Secundária da empresa</label>
            <input type="text" name="cor_sec_emp" value="<?=$cor_sec_emp?>" placeholder="Cor secundária">
        </div>
        <br><br>
        <input type="checkbox" name="situacao_emp">
        <label>Ao cadastrar uma empresa, automaticamente o status da mesma é ativa, caso queira deixar o status como inativo selecione esta opção.</label>
        <br><br>
        <input type="submit" value="Cadastrar">

    </form>
</body>
</html>