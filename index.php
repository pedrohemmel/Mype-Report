<?php

session_start();
$_SESSION['cadastroAdm'] = $_SESSION['cadastroAdm'] ?? false;

require 'config.php';
require 'dao/UsuarioAdministradorDaoMysql.php';

$UsuarioAdministradorDao = new UsuarioAdministradorDaoMysql($pdo);

/*Caso não houver um usuário administrador no sistema, o usuário é redirecionado para 
página de cadastro de administrador*/

if(!$UsuarioAdministradorDao->verifyRow()) {
    $_SESSION['cadastroAdm'] = true;
    header('Location:cadastrarAdm.php');
    exit;
} else {
    header('Location:login.php');
    exit;
}

?>