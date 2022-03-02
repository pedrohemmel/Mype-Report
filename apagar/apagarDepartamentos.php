<?php

session_start();

if(!$_SESSION['loggedAdm']) {
    header('Location:../index.php');
    exit;
} else {
    $logged = 'ativo';
}

require '../config.php';
require '../dao/DepartamentosDaoMysql.php';

$DepartamentosDao = new DepartamentosDaoMysql($pdo);

$id_dpto = filter_input(INPUT_GET, 'id_dpto');



//Verificando se realmente tem essa empresa no sistema
if($DepartamentosDao->verifyRowById($id_dpto)) {
    $DepartamentosDao->deleteDptoById($id_dpto);

    //Criando mensagem de sucesso ao apagar empresa
    $_SESSION['msgDelDpto'] = 'Departamento excluido com sucesso!';
    $_SESSION['msgDelDptoCrypt'] = password_hash($_SESSION['msgDelDpto'], PASSWORD_DEFAULT);

    header('Location:../verMais/verMaisEmp_action.php?msgDelDpto='.$_SESSION['msgDelDptoCrypt'].'&id='.$_SESSION['id_emp']);
    exit;
} else {
    //Criando mensagem de falha ao apagar empresa
    $_SESSION['erroDelDpto'] = 'Departamento excluido com sucesso!';
    $_SESSION['erroDelDptoCrypt'] = password_hash($_SESSION['erroDelDpto'], PASSWORD_DEFAULT);

    header('Location:../verMais/verMaisEmp_action.php?erroDelDpto='.$_SESSION['erroDelDptoCrypt'].'&id='.$_SESSION['id_emp']);
    exit;
}


?>