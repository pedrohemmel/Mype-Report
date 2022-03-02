<?php

session_start();

if(!$_SESSION['loggedAdm']) {
    header('Location:../index.php');
    exit;
}

require '../config.php';
require '../dao/EmpresasDaoMysql.php';

$EmpresasDao = new EmpresasDaoMysql($pdo);


if(!$_SESSION['situacao_emp']) {
    $situacao_emp = 'ativo';
} else {
    $situacao_emp = 'inativo';
}

if(!empty($_SESSION['path'])) {
    $logo = $_SESSION['path'];
} else {
    $logo = '../img/logoPadrao.png';
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

        $_SESSION['displayEmpresas'] = 'DEativo';
        $_SESSION['displayEmpresasCrypt'] = password_hash($_SESSION['displayEmpresas'], PASSWORD_DEFAULT);

        header('Location:../gerenciamentoSist/gerenciamentoSist.php?chaveDispSections='.$_SESSION['displayEmpresasCrypt'].'&msgCadEmp='.$_SESSION['msgCadEmpCrypt']);
        exit;
    }
} else {
    $_SESSION['erroCadEmp'] = 'Os dados inseridos estão incompletos';
    $_SESSION['erroCadEmpCrypt'] = password_hash($_SESSION['erroCadEmp'], PASSWORD_DEFAULT);

    header('Location:../cadastrar/cadastrarEmpresa.php?erroCadEmp='.$_SESSION['erroCadEmpCrypt']);
    exit;
}

?>