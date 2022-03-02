<?php

session_start();

require '../config.php';
require '../dao/DepartamentosDaoMysql.php';

if(!$_SESSION['loggedAdm']) {
    header('Location:../index.php');
    exit;
}

$DepartamentosDao = new DepartamentosDaoMysql($pdo);

//Recebendo variáveis
$nome_dpto = filter_input(INPUT_POST, 'nome_dpto');
$nome_dcusto_dpto = filter_input(INPUT_POST, 'centro_dcusto_dpto');


if($nome_dpto && $nome_dcusto_dpto) {
    if($DepartamentosDao->verifyRowByName($nome_dpto)) {
        $_SESSION['erroCadDpto'] = 'O departamento inserido já existe no sistema.';
        $_SESSION['erroCadDptoCrypt'] = password_hash($_SESSION['erroCadDpto'], PASSWORD_DEFAULT);

        header('Location:../verMais/verMaisEmp_action.php?erroCadDpto='.$_SESSION['erroCadDptoCrypt'].'&id='.$_SESSION['id_emp']);
        exit;
    } else {
        $d = new Departamentos;

        $d->setIdEmp($_SESSION['id_emp']);
        $d->setNomeDpto($nome_dpto);
        $d->setCentroDCustoDpto($nome_dcusto_dpto);
        
        $DepartamentosDao->addDepartamentos($d);

        $_SESSION['msgCadDpto'] = 'Departamento cadastrado com sucesso!';
        $_SESSION['msgCadDptoCrypt'] = password_hash($_SESSION['msgCadDpto'], PASSWORD_DEFAULT);
        header('Location:../verMais/verMaisEmp_action.php?msgCadDpto='.$_SESSION['msgCadDptoCrypt'].'&id='.$_SESSION['id_emp']);
        exit;
    }
} else {
    $_SESSION['erroCadDpto'] = 'Os dados inseridos estão incompletos';
    $_SESSION['erroCadDptoCrypt'] = password_hash($_SESSION['erroCadDpto'], PASSWORD_DEFAULT);

    header('Location:../verMais/verMaisEmp_action.php?erroCadDpto='.$_SESSION['erroCadDptoCrypt'].'&id='.$_SESSION['id_emp']);
    exit;
}

?>

