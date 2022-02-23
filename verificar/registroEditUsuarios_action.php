<?php

session_start();

if(!$_SESSION['loggedAdm']) {
    header('Location:../index.php');
    exit;
}

$chave = filter_input(INPUT_GET, 'chave');

//DEFININDO VALOR AS SESSÕES PARA DEPOIS NÃO DAR UNDEFINED

$_SESSION['displayRegistrosSistema'] = '';
$_SESSION['displayGruposAcesso'] = '';
$_SESSION['displayIndicadores'] = '';
$_SESSION['displayEmpresas'] = '';
$_SESSION['displayUsuarios'] = '';
$_SESSION['displayUsuariosGruposAcesso'] = '';
$_SESSION['displayAdministradorGruposAcesso'] = '';
$_SESSION['displayFechaAdministradorGruposAcesso'] = '';
$_SESSION['displayFechaUsuariosGruposAcesso'] = '';

/* REGISTRO DO SISTEMA */

/* SECTIONS DE REGISTRO DO SISTEMA  */

if(!empty($chave)) {
    if(password_verify($_SESSION['registrosSistema'], $chave)) {

        $_SESSION['displayRegistrosSistema'] = 'DRSativo';
        $_SESSION['displayRegistrosSistemaCrypt'] = password_hash($_SESSION['displayRegistrosSistema'], PASSWORD_DEFAULT);

        header('Location:../gerenciamentoSist/gerenciamentoSist.php?chaveDispSections='.$_SESSION['displayRegistrosSistemaCrypt']);
        exit;

    } else if(password_verify($_SESSION['gruposAcesso'], $chave)) {

        $_SESSION['displayGruposAcesso'] = 'DGAativo';
        $_SESSION['displayGruposAcessoCrypt'] = password_hash($_SESSION['displayGruposAcesso'], PASSWORD_DEFAULT);

        header('Location:../gerenciamentoSist/gerenciamentoSist.php?chaveDispSections='.$_SESSION['displayGruposAcessoCrypt']);
        exit;

    } else if(password_verify($_SESSION['indicadores'], $chave)) {

        $_SESSION['displayIndicadores'] = 'DIativo';
        $_SESSION['displayIndicadoresCrypt'] = password_hash($_SESSION['displayIndicadores'], PASSWORD_DEFAULT);

        header('Location:../gerenciamentoSist/gerenciamentoSist.php?chaveDispSections='.$_SESSION['displayIndicadoresCrypt']);
        exit;
        
    } else if(password_verify($_SESSION['empresas'], $chave)) {

        $_SESSION['displayEmpresas'] = 'DEativo';
        $_SESSION['displayEmpresasCrypt'] = password_hash($_SESSION['displayEmpresas'], PASSWORD_DEFAULT);

        header('Location:../gerenciamentoSist/gerenciamentoSist.php?chaveDispSections='.$_SESSION['displayEmpresasCrypt']);
        exit;
        
    } else if(password_verify($_SESSION['usuarios'], $chave)) {
        
        $_SESSION['displayUsuarios'] = 'DUativo';
        $_SESSION['displayUsuariosCrypt'] = password_hash($_SESSION['displayUsuarios'], PASSWORD_DEFAULT);

        header('Location:../gerenciamentoSist/gerenciamentoSist.php?chaveDispSections='.$_SESSION['displayUsuariosCrypt']);
        exit;

    }
    
    /* OPCOES DENTRO DAS SECTIONS DE REGISTRO DO SISTEMA */
    
    else if(password_verify($_SESSION['usuariosGruposAcesso'], $chave)) {

        $_SESSION['displayUsuariosGruposAcesso'] = 'UGAativo';
        $_SESSION['displayUsuariosGruposAcessoCrypt'] = password_hash($_SESSION['displayUsuariosGruposAcesso'], PASSWORD_DEFAULT);

        header('Location:../gerenciamentoSist/gerenciamentoSist.php?chaveDispSections='.$_SESSION['displayUsuariosGruposAcessoCrypt']);
        exit;

    }else if(password_verify($_SESSION['fechaUsuariosGruposAcesso'], $chave)) {
        $_SESSION['displayFechaUsuariosGruposAcesso'] = 'UGAativo';
        $_SESSION['displayFechaUsuariosGruposAcessoCrypt'] = password_hash($_SESSION['displayFechaUsuariosGruposAcesso'], PASSWORD_DEFAULT);

        header('Location:../gerenciamentoSist/gerenciamentoSist.php?chaveDispSections='.$_SESSION['displayFechaUsuariosGruposAcessoCrypt']);
        exit;
    } else if(password_verify($_SESSION['administradorGruposAcesso'], $chave)) {

        $_SESSION['displayAdministradorGruposAcesso'] = 'UGAativo';
        $_SESSION['displayAdministradorGruposAcessoCrypt'] = password_hash($_SESSION['displayAdministradorGruposAcesso'], PASSWORD_DEFAULT);

        header('Location:../gerenciamentoSist/gerenciamentoSist.php?chaveDispSections='.$_SESSION['displayAdministradorGruposAcessoCrypt']);
        exit;

    } else if(password_verify($_SESSION['fechaAdministradorGruposAcesso'], $chave)) {
        $_SESSION['displayFechaAdministradorGruposAcesso'] = 'UGAativo';
        $_SESSION['displayFechaAdministradorGruposAcessoCrypt'] = password_hash($_SESSION['displayFechaAdministradorGruposAcesso'], PASSWORD_DEFAULT);

        header('Location:../gerenciamentoSist/gerenciamentoSist.php?chaveDispSections='.$_SESSION['displayFechaAdministradorGruposAcessoCrypt']);
        exit;
    }

} else {
    header('Location:../gerenciamentoSist/gerenciamentoSist.php');
    exit;
}

/* FIM DO REGISTRO DO SISTEMA */

?>