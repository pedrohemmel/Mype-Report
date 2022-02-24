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
$nome_dcusto_dpto = filter_input(INPUT_POST, 'nome_dcusto_dpto');




?>

