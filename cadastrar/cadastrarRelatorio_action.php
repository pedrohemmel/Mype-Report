<?php

session_start();

require '../config.php';
require '../dao/RelatoriosDaoMysql.php';

if(!$_SESSION['loggedAdm']) {
    header('Location:../index.php');
    exit;
}

$RelatoriosDao = new RelatoriosDaoMysql($pdo);

//Recebendo variáveis
$nome_rel = filter_input(INPUT_POST, 'nome_rel');
$link_rel = filter_input(INPUT_POST, 'link_rel');
$situacao = filter_input(INPUT_POST, 'situacao_rel');


if($situacao) {
    $situacao_rel = "inativo";
} else {
    $situacao_rel = "ativo";
}  


echo $nome_rel;
echo $link_rel;
echo $situacao_rel;
echo $_SESSION['id_emp'];

if($nome_rel && $link_rel && $situacao_rel) {
    
        $r = new Relatorios;

        $r->setIdEmp($_SESSION['id_emp']);
        $r->setNomeRel($nome_rel);
        $r->setLinkRel($link_rel);
        $r->setSituacaoRel($situacao_rel);
        
        $RelatoriosDao->addRelatorios($r);

        $_SESSION['msgCadRel'] = 'Relatório cadastrado com sucesso!';
        $_SESSION['msgCadRelCrypt'] = password_hash($_SESSION['msgCadRel'], PASSWORD_DEFAULT);

        header('Location:../verMais/verMaisRelatorios.php?msgCadRel='.$_SESSION['msgCadRelCrypt'].'&id_emp='.$_SESSION['id_emp']);
        exit;
    
} else {
    $_SESSION['erroCadRel'] = 'Os dados inseridos estão incompletos';
    $_SESSION['erroCadRelCrypt'] = password_hash($_SESSION['erroCadRel'], PASSWORD_DEFAULT);

    header('Location:../verMais/verMaisRelatorios.php?erroCadRel='.$_SESSION['erroCadRelCrypt'].'&id_emp='.$_SESSION['id_emp']);
    exit;
}

?>

