<?php
require '../config.php';
require '../dao/UsuariosDaoMysql.php';
require '../dao/UsuarioAdministradorDaoMysql.php';

session_start();
$_SESSION['loggedUsu'] = $_SESSION['loggedUsu'] ?? false;
$_SESSION['loggedAdm'] = $_SESSION['loggedAdm'] ?? false;

/*Utilizarei os 2 usuarios para verificar qual dos 2 está entrando no sistema, ou se nenhum dos dois esta entrando*/
$UsuariosDao = new UsuariosDaoMysql($pdo);
$UsuarioAdministradorDao = new UsuarioAdministradorDaoMysql($pdo);

//mensagem para o fim de uma sessao nos usuarios
$_SESSION['end'] = 'end';
$_SESSION['msgSair'] = password_hash($_SESSION['end'], PASSWORD_DEFAULT);

$username_email_usu = filter_input(INPUT_POST, 'username_email_usu');
$senha_usu = filter_input(INPUT_POST, 'senha_usu');

if($username_email_usu && $senha_usu) {
    /*SE EXISTIR O EMAIL DIGITADO, NA TABELA usuarios_cliente, OCORRE AS AÇÕES DENTRO DESSE IF*/
    if($UsuariosDao->verifyRowByEmail($username_email_usu) || $UsuariosDao->verifyRowByUsername($username_email_usu)) {
        
        if($UsuariosDao->verifyRowByEmail($username_email_usu)) {

            $emailUsernameUsuarios = new Usuarios;
            $emailUsernameUsuarios->setEmailUsu($username_email_usu);

        } else if($UsuariosDao->verifyRowByUsername($username_email_usu)) {

            $emailUsernameUsuarios = new Usuarios;
            $emailUsernameUsuarios->setUsernameUsu($username_email_usu);

        } else {

            $_SESSION['erroLogin'] = 'Os dados de cadastro do usuário está incompleto.';
            $erroLoginCrypt = password_hash($_SESSION['erroLogin'], PASSWORD_DEFAULT);

            header('Location:../login/login.php?erroLogin='.$erroLoginCrypt);
            exit;

        }
    
        $usuarios = $UsuariosDao->findByUsernameOrEmail($emailUsernameUsuarios);

        foreach($usuarios as $getUsuarios) {
            $nome = $getUsuarios->getNomeUsu();
            $email = $getUsuarios->getEmailUsu();
            $senha = $getUsuarios->getSenhaUsu();
            $perfil = $getUsuarios->getPerfilUsu();
        }

        if($perfil === 'usu') {
            if($email_usu == $email && password_verify($senha_usu, $senha)) {  
                $_SESSION['email'] = $email;
                $_SESSION['senha'] = $senha;
                $_SESSION['nome'] = $nome;
                $_SESSION['loggedUsu'] = true; 
                
                echo 'passei'.$perfil;
            } else {
                $_SESSION['erroLogin'] = 'Usuário ou senha incorretos.';
                $erroLoginCrypt = password_hash($_SESSION['erroLogin'], PASSWORD_DEFAULT);

                header('Location:../login/login.php?erroLogin='.$erroLoginCrypt);
                exit;
            }
        } else if($perfil === 'adm') {
            if($email_usu == $email && password_verify($senha_usu, $senha)) {  
                $_SESSION['email'] = $email;
                $_SESSION['senha'] = $senha;
                $_SESSION['nome'] = $nome;
                $_SESSION['loggedAdm'] = true; 
                
                echo 'passei'.$perfil;
            } else {
                $_SESSION['erroLogin'] = 'Usuário ou senha incorretos.';
                $erroLoginCrypt = password_hash($_SESSION['erroLogin'], PASSWORD_DEFAULT);

                header('Location:../login/login.php?erroLogin='.$erroLoginCrypt);
                exit;
            }
        } else {
            $_SESSION['erroLogin'] = 'Os dados de cadastro do usuário está incompleto.';
            $erroLoginCrypt = password_hash($_SESSION['erroLogin'], PASSWORD_DEFAULT);

            header('Location:../login/login.php?erroLogin='.$erroLoginCrypt);
            exit;
        }
        
        
        /*SE EXISTIR O EMAIL DIGITADO, NA TABELA usuarios_administrador, OCORRE AS AÇÕES DENTRO DESSE ELSE IF*/
    } else if($UsuarioAdministradorDao->verifyRowByEmail($username_email_usu) || $UsuarioAdministradorDao->verifyRowByUsername($username_email_usu)) {

        if($UsuarioAdministradorDao->verifyRowByEmail($username_email_usu)) {

            $emailUsernameUsuarioAdministrador = new UsuarioAdministrador;
            $emailUsernameUsuarioAdministrador->setEmailAdm($username_email_usu);

        } else if($UsuarioAdministradorDao->verifyRowByUsername($username_email_usu)) {

            $emailUsernameUsuarioAdministrador = new UsuarioAdministrador;
            $emailUsernameUsuarioAdministrador->setUsernameAdm($username_email_usu);

        } else {

            $_SESSION['erroLogin'] = 'Os dados de cadastro do usuário está incompleto.';
            $erroLoginCrypt = password_hash($_SESSION['erroLogin'], PASSWORD_DEFAULT);

            header('Location:../login/login.php?erroLogin='.$erroLoginCrypt);
            exit;
            
        }

        $usuarioAdministrador = $UsuarioAdministradorDao->findByUsernameOrEmail($emailUsernameUsuarioAdministrador);

        foreach($usuarioAdministrador as $getUsuario) {
            $nome = $getUsuario->getNomeAdm();
            $email = $getUsuario->getEmailAdm();
            $senha = $getUsuario->getSenhaAdm();
        }

        if($email_usu == $email_adm && password_verify($senha_usu, $senha)) {
            $_SESSION['email'] = $email;
            $_SESSION['senha'] = $senha;
            $_SESSION['nome'] = $nome;
            $_SESSION['loggedAdm'] = true;
            header('Location:../gerenciamentoSist/gerenciamentoSist.php');
            exit;
        } else {
            $_SESSION['erroLogin'] = 'Usuário ou senha incorretos.';
            $erroLoginCrypt = password_hash($_SESSION['erroLogin'], PASSWORD_DEFAULT);

            header('Location:../login/login.php?erroLogin='.$erroLoginCrypt);
            exit;
        }

        /*SE NÃO EXISTIR O EMAIL DIGITADO EM NENHUMA TABELA, OCORRE AS AÇÕES DENTRO DESSE ELSE*/
    } else {
        $_SESSION['erroLogin'] = 'Usuário ou senha incorretos.';
        $erroLoginCrypt = password_hash($_SESSION['erroLogin'], PASSWORD_DEFAULT);

        header('Location:../login/login.php?erroLogin='.$erroLoginCrypt);
        exit;
    }
} else {
    $_SESSION['erroLogin'] = 'Os dados estão incorretos.';
    $erroLoginCrypt = password_hash($_SESSION['erroLogin'], PASSWORD_DEFAULT);

    header('Location:../login/login.php?erroLogin='.$erroLoginCrypt);
    exit;
}


?>