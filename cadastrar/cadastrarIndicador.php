<?php

session_start();

if(!$_SESSION['loggedAdm']) {
    header('Location:../index.php');
    exit;
}

require '../config.php';
require '../dao/IndicadoresDaoMysql.php';

$IndicadoresDao = new IndicadoresDaoMysql($pdo);



$id_usu = filter_input(INPUT_GET, "id_usu");
$id_rel = filter_input(INPUT_GET, "id_rel");

if($id_usu && $id_rel) {
    if($IndicadoresDao->verifyRowByUsuId($id_usu) && $IndicadoresDao->verifyRowByRelId($id_rel)) {
        $_SESSION['erroCadInd'] = 'O usuário já está vinculado no relatório!';
        $_SESSION['erroCadIndCrypt'] = password_hash($_SESSION['erroCadInd'], PASSWORD_DEFAULT);
        header('Location:../verMais/verMaisIndicadores.php?erroCadInd='.$_SESSION['erroCadIndCrypt'].'&id_rel='.$id_rel); 
        exit;
    } else {
        $i = new Indicadores;
        $i->setIdRel($id_rel);
        $i->setIdUsu($id_usu);

        $IndicadoresDao->addIndicadores($i);

        $_SESSION['msgCadInd'] = 'Usuario vinculado ao relatório com sucesso!';
        $_SESSION['msgCadIndCrypt'] = password_hash($_SESSION['msgCadInd'], PASSWORD_DEFAULT);
        header('Location:../verMais/verMaisIndicadores.php?msgCadInd='.$_SESSION['msgCadIndCrypt'].'&id_rel='.$id_rel); 
        exit;
    }
    
    
} else {
    header('Location:../index.php');
    exit; 
}
?>