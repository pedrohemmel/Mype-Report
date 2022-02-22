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

$EmpresasDao = new EmpresasDaoMysql($pdo);

$id_emp = filter_input(INPUT_GET, 'id');

//Verificando se realmente tem essa empresa no sistema
if($EmpresasDao->verifyRowById($id_emp)) {
    $EmpresasDao->deleteEmpById($id_emp);

    //Criando mensagem de sucesso ao apagar empresa
    $_SESSION['msgDelEmp'] = 'Empresa excluida com sucesso!';
    $_SESSION['msgDelEmpCrypt'] = password_hash($_SESSION['msgDelEmp'], PASSWORD_DEFAULT);

    header('Location:gerenciamentoSist.php?msgDelEmp='.$_SESSION['msgDelEmpCrypt']);
    exit;
} else {
    //Criando mensagem de falha ao apagar empresa
    $_SESSION['erroEmp'] = 'Não existe uma empresa com esse ID cadastrada no sistema.';
    $_SESSION['erroEmpCrypt'] = password_hash($_SESSION['erroEmp'], PASSWORD_DEFAULT);

    header('Location:gerenciamentoSist.php?erroEmp='.$_SESSION['erroEmpCrypt']);
    exit;
}


?>