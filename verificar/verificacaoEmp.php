<?php

session_start();

if(!$_SESSION['loggedAdm']) {
    header('Location:../index.php');
    exit;
} else {
    $logged = 'ativo';
}

require '../config.php';
require '../dao/EmpresasDaoMysql.php';

$EmpresasDao = new EmpresasDaoMysql($pdo);

$id_emp = filter_input(INPUT_GET, 'id');

if($EmpresasDao->verifyRowById($id_emp)) {
    $empresa = $EmpresasDao->findById($id_emp);

    foreach($empresa as $getEmpresa) {
        $_SESSION['id_emp'] = $id_emp;
        $_SESSION['cnpj_emp'] = $getEmpresa->getCnpjEmp();
        $_SESSION['razao_social_emp'] = $getEmpresa->getRazaoSocialEmp();
        $_SESSION['nome_fantasia_emp'] = $getEmpresa->getNomeFantasiaEmp();
        $_SESSION['logo_emp'] = $getEmpresa->getLogoEmp();
        $_SESSION['endereco_emp'] = $getEmpresa->getEnderecoEmp();
        $_SESSION['situacao_emp'] = $getEmpresa->getSituacaoEmp();
    }  

    header('Location:../editarEmp.php');
    exit;
    
} else {
    $_SESSION['erroEmp'] = 'Erro ao encontrar empresa.';
    $_SESSION['erroEmpCrypt'] = password_hash($_SESSION['erroEmp'], PASSWORD_DEFAULT);

    header('Location:../gerenciamentoSist/gerenciamentoSist.php?erroEmp='.$_SESSION['erroEmpCrypt']);
    exit;
}

?>