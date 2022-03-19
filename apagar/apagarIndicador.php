<?php

session_start();

if(!$_SESSION['loggedAdm']) {
    header('Location:../index.php');
    exit;
}

require '../config.php';
require '../dao/IndicadoresDaoMysql.php';

$IndicadoresDao = new IndicadoresDaoMysql($pdo);

$id_ind = filter_input(INPUT_GET, 'id_ind');
$id_rel = filter_input(INPUT_GET, 'id_rel');

//Verificando se realmente tem esse indicador no sistema
if($IndicadoresDao->verifyRowById($id_ind)) {
    $IndicadoresDao->deleteById($id_ind);

    //Criando mensagem de sucesso ao apagar indicador
    $_SESSION['msgDelInd'] = 'Indicador excluido com sucesso!';
    $_SESSION['msgDelIndCrypt'] = password_hash($_SESSION['msgIndEmp'], PASSWORD_DEFAULT);

    header('Location:../verMais/verMaisIndicadores.php?msgDelInd='.$_SESSION['msgDelIndCrypt'].'&id_rel='.$id_rel);
    exit;
} else {
    //Criando mensagem de falha ao apagar indicador
    $_SESSION['erroInd'] = 'Não existe uma empresa com esse ID cadastrada no sistema.';
    $_SESSION['erroIndCrypt'] = password_hash($_SESSION['erroInd'], PASSWORD_DEFAULT);

    header('Location:../verMais/verMaisIndicadores.php?erroInd='.$_SESSION['erroIndCrypt'].'&id_rel='.$id_rel);
    exit;
}


?>