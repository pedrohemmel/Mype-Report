<?php

session_start();

if(!$_SESSION['loggedAdm']) {
    header('Location:../index.php');
    exit;
} else {
    $logged = 'ativo';
}

require '../config.php';
require '../dao/RelatoriosDaoMysql.php';

$RelatoriosDao = new RelatoriosDaoMysql($pdo);

$_SESSION['id_rel'] = filter_input(INPUT_GET, "id_rel");

//parte de receber valores do form e inserir os dados no banco atraves de funções
if(!empty(filter_input(INPUT_GET, "cad"))) {
    $nome_rel = filter_input(INPUT_POST, "nome_rel");
    $link_rel = filter_input(INPUT_POST, "link_rel");
    $situacao = filter_input(INPUT_POST, "situacao_rel");

    if($situacao) {
        $situacao_rel = "inativo";
    } else {
        $situacao_rel = "ativo";
    }
    //atribundo os valores ao objeto relatorio
    $r = new Relatorios;
    $r->setIdRel($_SESSION['id_rel']);
    $r->setNomeRel($nome_rel);
    $r->setLinkRel($link_rel);
    $r->setSituacaoRel($situacao_rel);

    $RelatoriosDao->updateRelatorios($r);

    header('Location:../verMais/verMaisIndicadores.php?id_rel='.$_SESSION['id_rel']);
    exit;
}

if(!empty($_SESSION['id_rel'])) {
    $relatorio = $RelatoriosDao->findById($_SESSION['id_rel']);
    foreach($relatorio as $getRelatorio) {
        $_SESSION['nome_rel'] = $getRelatorio->getNomeRel();
        $_SESSION['link_rel'] = $getRelatorio->getLinkRel();
        $_SESSION['situacao_rel'] = $getRelatorio->getSituacaoRel();
    }

    if($_SESSION['situacao_rel'] == "ativo") {
        $situacao_rel = "";
        $cor_situacao = "#008000";
    } else {
        $situacao_rel = "checked='true'";
        $cor_situacao = "#ff0000";
    }
}




//
$classeNone = 'displayNone';

?>

<html>
    <head>
        <meta charset="UTF-8"/>
        <title>Editar relatória</title>
        <link rel="stylesheet" href="../style/base.css"/>
    </head>
    <body>
    <form action="../editar/editarRelatorio.php?cad=true&id_rel=<?=$_SESSION['id_rel'];?>" method="POST">
        <p class="<?=$classeNone?>"><?=$mensagem?></p>
        <br><br>
        <label>Editar relatório</label>
        <br><br>
        <input type="text" name="nome_rel" placeholder="Digite um nome para o relatório" value="<?=$_SESSION['nome_rel']?>" maxlength="50" required>
        <br><br>
        <input type="text" name="link_rel" placeholder="Digite um link para o relatório" value="<?=$_SESSION['link_rel']?>" maxlength="300" required>
        <br><br>
        <input type="checkbox" name="situacao_rel" <?=$situacao_rel?>>
        <label><span style="font-weight: bold; text-transform: uppercase; color: <?=$cor_situacao;?>;"><?=$_SESSION['situacao_rel'];?></span> Clicando no bloco você vai alterar a situação do relatório.</label>
        <br><br>
        <input type="submit" value="Alterar">

    </form>
    </body>
</html>