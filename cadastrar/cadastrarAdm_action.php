<?Php

session_start();

require '../config.php';
require '../dao/UsuarioAdministradorDaoMysql.php';

if(!$_SESSION['cadastroAdm']) {
    header('Location:../index.php');
    exit;
}

$UsuarioAdministradorDao = new UsuarioAdministradorDaoMysql($pdo);

//Recebendo variáveis
$nome_adm = filter_input(INPUT_POST, 'nome_adm');
$username_adm = filter_input(INPUT_POST, 'username_adm');
$telefone_adm = filter_input(INPUT_POST, 'telefone_adm');
$telefone_adm_sub = filter_input(INPUT_POST, 'telefone_adm_sub');
$email_adm_ctt = filter_input(INPUT_POST, 'email_adm_ctt');
$email_adm = filter_input(INPUT_POST, 'email_adm');
$email_adm_confirm = filter_input(INPUT_POST, 'email_adm_confirm');
$senha_adm = filter_input(INPUT_POST, 'senha_adm');
$senha_adm_confirm = filter_input(INPUT_POST, 'senha_adm_confirm');

$senha = password_hash($senha_adm, PASSWORD_DEFAULT);

if(empty($logo_emp)) {
    $logo_emp = '';
}

//Verificando se todos dados foram inseridos corretamente e se ja existe um administrador no sistema
if($nome_adm && $username_adm && $telefone_adm && $email_adm_ctt && $email_adm && $email_adm_confirm && $senha_adm && $senha_adm_confirm) {
    //Verificando se os dados foram confirmados com sucesso
    if($email_adm == $email_adm_confirm && password_verify($senha_adm_confirm, $senha)) {
        if(!$UsuarioAdministradorDao->verifyRow()) {
            $usuarioAdm = new UsuarioAdministrador;
            $usuarioAdm->setNomeAdm($nome_adm);
            $usuarioAdm->setUsernameAdm($username_adm);
            $usuarioAdm->setTelefoneAdm($telefone_adm);
            $usuarioAdm->setTelefoneAdmSub($telefone_adm_sub);
            $usuarioAdm->setEmailAdmCtt($email_adm_ctt);
            $usuarioAdm->setEmailAdm($email_adm);
            $usuarioAdm->setSenhaAdm($senha);

            $UsuarioAdministradorDao->add($usuarioAdm);

            $_SESSION['msgCadAdm'] = 'Usuario cadastrado com sucesso';
            $_SESSION['msgCadAdmCrypt'] = password_hash($_SESSION['msgCadAdm'], PASSWORD_DEFAULT);

            header('Location:../login/login.php?msgCadAdm='.$_SESSION['msgCadAdmCrypt']);
            exit;
        } else {
            header('Location:../index.php');
            exit;
        }
    } else {
        $_SESSION['erroCadAdm'] = 'Os dados foram inseridos incorretamente.';
        $_SESSION['erroCadAdmCrypt'] = password_hash($_SESSION['erroCadAdm'], PASSWORD_DEFAULT);

        header('Location:../cadastrar/cadastrarAdm.php?erroCadAdm='.$_SESSION['erroCadAdmCrypt']);
        exit;
    } 
} else {
    $_SESSION['erroCadAdm'] = 'Os dados estão incompletos.';
    $_SESSION['erroCadAdmCrypt'] = password_hash($_SESSION['erroCadAdm'], PASSWORD_DEFAULT);
    
    header('Location:../cadastrar/cadastrarAdm.php?erroCadAdm='.$_SESSION['erroCadAdmCrypt']);
    exit;
}
?>