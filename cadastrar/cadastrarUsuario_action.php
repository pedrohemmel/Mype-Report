<?php

session_start();

if(!$_SESSION['loggedAdm']) {
    header('Location:../index.php');
    exit;
}

require '../config.php';
require '../dao/UsuariosDaoMysql.php';

$UsuariosDao = new UsuariosDaoMysql($pdo);

$id_dpto = filter_input(INPUT_POST, 'id_dpto');

$senha = password_hash($_SESSION['senha_usu'], PASSWORD_DEFAULT);



if($_SESSION['nome_usu'] && $_SESSION['username_usu'] && $_SESSION['telefone_usu'] && $_SESSION['email_usu'] && $_SESSION['email_usu_confirm'] && $senha && $_SESSION['senha_usu_confirm'] && $_SESSION['perfil_usu'] && $_SESSION['situacao_usu'] && $_SESSION['id_emp'] && $id_dpto) {
    if($_SESSION['email_usu'] == $_SESSION['email_usu_confirm'] && password_verify($_SESSION['senha_usu_confirm'], $senha)) {
            
        $u = new Usuarios;
        $u->setIdEmp($_SESSION['id_emp']);
        $u->setIdDpto($id_dpto);
        $u->setNomeUsu($_SESSION['nome_usu']);
        $u->setUsernameUsu($_SESSION['username_usu']);
        $u->setTelefoneUsu($_SESSION['telefone_usu']);
        $u->setEmailUsu($_SESSION['email_usu']);
        $u->setSenhaUsu($_SESSION['senha_usu']);
        $u->setPerfilUsu($_SESSION['perfil_usu']);
        $u->setSituacaoUsu($_SESSION['situacao_usu']);

        $UsuariosDao->addUsuarios($u);

        $_SESSION['displayGruposAcesso'] = 'DGAativo';
        $_SESSION['displayGruposAcessoCrypt'] = password_hash($_SESSION['displayGruposAcesso'], PASSWORD_DEFAULT);

        header('Location:../gerenciamentoSist/gerenciamentoSist.php?chaveDispSections='.$_SESSION['displayGruposAcessoCrypt'].'&erroCadUsu='.$_SESSION['erroCadUsuCrypt']);
        exit;
    } else {
        $_SESSION['erroCadUsu'] = 'Os dados inseridos estão incorretos.';
        $_SESSION['erroCadUsuCrypt'] = password_hash($_SESSION['erroCadUsu'], PASSWORD_DEFAULT);

        header('Location:../cadastrar/cadastrarUsuario.php?erroCadUsu='.$_SESSION['erroCadUsuCrypt']);
        exit;
    }
} else {
    
    echo $_SESSION['nome_usu'];
    echo $_SESSION['username_usu'];
    echo $_SESSION['telefone_usu'];
    echo $_SESSION['email_usu'];
    echo $_SESSION['email_usu_confirm'];
    echo $_SESSION['senha_usu'];
    echo $_SESSION['senha_usu_confirm'];
    echo $_SESSION['perfil_usu'];
    echo $_SESSION['id_emp'];
    echo 'meu deus ';
}