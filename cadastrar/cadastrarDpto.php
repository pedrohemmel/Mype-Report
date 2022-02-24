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

if($_SESSION['cnpj_emp'] && $_SESSION['razao_social_emp'] && $_SESSION['nome_fantasia_emp'] && $_SESSION['endereco_emp'] && $situacao_emp) {
    if($EmpresasDao->verifyRowByCnpj($_SESSION['cnpj_emp']) or $EmpresasDao->verifyRowByNomeFantasia($_SESSION['razao_social_emp']) or $EmpresasDao->verifyRowByRazaoSocial($_SESSION['nome_fantasia_emp'])) {
        $_SESSION['erroCadEmp'] = 'Já existe uma empresa com esses dados no sistema.';
        $_SESSION['erroCadEmpCrypt'] = password_hash($_SESSION['erroCadEmp'], PASSWORD_DEFAULT);

        header('Location:../cadastrar/cadastrarEmpresa.php?erroCadEmp='.$_SESSION['erroCadEmpCrypt']);
        exit;
    } else {
        $e = new Empresas;

        $e->setCnpjEmp($_SESSION['cnpj_emp']);
        $e->setRazaoSocialEmp($_SESSION['razao_social_emp']);
        $e->setNomeFantasiaEmp($_SESSION['nome_fantasia_emp']);
        $e->setLogoEmp($logo);
        $e->setCorPriEmp($_SESSION['cor_pri_emp']);
        $e->setCorSecEmp($_SESSION['cor_sec_emp']);
        $e->setEnderecoEmp($_SESSION['endereco_emp']);
        $e->setSituacaoEmp($situacao_emp);

        $EmpresasDao->addEmpresas($e);

        $_SESSION['msgCadEmp'] = 'Empresa cadastrada com sucesso!';
        $_SESSION['msgCadEmpCrypt'] = password_hash($_SESSION['msgCadEmp'], PASSWORD_DEFAULT);

        header('Location:../gerenciamentoSist/gerenciamentoSist.php?msgCadEmp='.$_SESSION['msgCadEmpCrypt']);
        exit;
    }
} else {
    $_SESSION['erroCadEmp'] = 'Os dados inseridos estão incompletos';
    $_SESSION['erroCadEmpCrypt'] = password_hash($_SESSION['erroCadEmp'], PASSWORD_DEFAULT);

    header('Location:../cadastrar/cadastrarEmpresa.php?erroCadEmp='.$_SESSION['erroCadEmpCrypt']);
    exit;
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
            <input type="submit" value="Cadastrar-se">
        </form>
    </div>
    
    <script src="../js/cadastrarAdmScript.js"></script>
</body>
</html>
