<?php

session_start();

if(!$_SESSION['loggedAdm']) {
    header('Location:../index.php');
    exit;
}

require "../config.php";
require "../dao/EmpresasDaoMysql.php";
require "../dao/DepartamentosDaoMysql.php";

$DepartamentosDao = new DepartamentosDaoMysql($pdo);
$EmpresasDao = new EmpresasDaoMysql($pdo);

if(!$EmpresasDao->verifyRow()) {
    if(!$DepartamentosDao->verifyRow()) {
        $_SESSION['erroCadUsu'] = 'Erro ao cadastrar usuário, é necessário criar um departamento primeiro para que possa cadastrar um usuário, entre em uma empresa e cadastre os departamentos da mesma.';
        $_SESSION['erroCadUsuCrypt'] = password_hash($_SESSION['erroCadUsu'], PASSWORD_DEFAULT);
        $_SESSION['displayGruposAcesso'] = 'DGAativo';
        $_SESSION['displayGruposAcessoCrypt'] = password_hash($_SESSION['displayGruposAcesso'], PASSWORD_DEFAULT);

        header('Location:../gerenciamentoSist/gerenciamentoSist.php?chaveDispSections='.$_SESSION['displayGruposAcessoCrypt'].'&erroCadUsu='.$_SESSION['erroCadUsuCrypt']);
        exit;
    }
    $_SESSION['erroCadUsu'] = 'Erro ao cadastrar usuário, é necessário criar uma empresa primeiro para que possa cadastrar um usuário.';
    $_SESSION['erroCadUsuCrypt'] = password_hash($_SESSION['erroCadUsu'], PASSWORD_DEFAULT);
    $_SESSION['displayGruposAcesso'] = 'DGAativo';
    $_SESSION['displayGruposAcessoCrypt'] = password_hash($_SESSION['displayGruposAcesso'], PASSWORD_DEFAULT);

    header('Location:../gerenciamentoSist/gerenciamentoSist.php?chaveDispSections='.$_SESSION['displayGruposAcessoCrypt'].'&erroCadUsu='.$_SESSION['erroCadUsuCrypt']);
    exit;
}


$erroCadUsu = filter_input(INPUT_GET, 'erroCadUsu');

$classeNone = 'displayNone';

if(!empty($erroCadUsu)) {
    if(password_verify($_SESSION['erroCadUsu'], $erroCadUsu)) {
        $classeNone = 'displayBlkRed';
        $mensagem = $_SESSION['erroCadUsu'];
    }
}



//recebendo valores, verificando a empresa que foi selecionada e dando a opção dos departamentos
$nome_usu = filter_input(INPUT_POST, 'nome_usu');
$username_usu = filter_input(INPUT_POST, 'username_usu');
$telefone_usu = filter_input(INPUT_POST, 'telefone_usu');
$email_usu = filter_input(INPUT_POST, 'email_usu');
$email_usu_confirm = filter_input(INPUT_POST, 'email_usu_confirm');
$senha_usu = filter_input(INPUT_POST, 'senha_usu');
$senha_usu_confirm = filter_input(INPUT_POST, 'senha_usu_confirm');
$perfil_usu = filter_input(INPUT_POST, 'perfil_usu');
$id_emp = filter_input(INPUT_POST, 'id_emp');
$situacao = filter_input(INPUT_POST, 'situacao_usu');

//atribuindo variaveis a sessoes para passagem de telas
$_SESSION['nome_usu'] = $nome_usu;
$_SESSION['username_usu'] = $username_usu;
$_SESSION['telefone_usu'] = $telefone_usu;
$_SESSION['email_usu'] = $email_usu;
$_SESSION['email_usu_confirm'] = $email_usu_confirm;
$_SESSION['senha_usu'] = $senha_usu;
$_SESSION['senha_usu_confirm'] = $senha_usu_confirm;
$_SESSION['perfil_usu'] = $perfil_usu;
$_SESSION['id_emp'] = $id_emp;



if($situacao) {
    $_SESSION['situacao_usu'] = 'inativo';
} else {
    $_SESSION['situacao_usu'] = 'ativo';
}

$classeDpto = 'displayNone';

if(!empty($_SESSION['perfil_usu'])) {
    if($_SESSION['perfil_usu'] = 'usu') {
        $classeDpto = 'fundoPretoAbsolute';
    }
}

echo $classeDpto;
echo $_SESSION['id_emp'];



?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar Usuário</title>
    <link rel="stylesheet" href="../style/base.css"/>
</head>
<body>
    <!--Formulário de cadastro do usuário administrador-->
    <div class="container">
        <form method="POST" action="">
            <p class="<?=$classeNone?>"><?=$mensagem?></p>
            <input type="text" name="nome_usu" placeholder="Digite seu nome completo" maxlength="100" required>
            <br><br>
            <input type="text" name="username_usu" placeholder="Digite seu nome de usuário" maxlength="50" required>
            <br><br>
            <input class="tel" type="tel" name="telefone_usu" placeholder="Digite seu número de telefone" minlength="10" maxlength="11" required>
            <br><br>
            <input type="email" name="email_usu" placeholder="Digite seu e-mail de acesso" maxlength="75" required>
            <input type="email" name="email_usu_confirm" placeholder="Confirme seu e-mail de acesso" maxlength="75" required>
            <br><br>
            <input type="password" name="senha_usu" placeholder="Digite sua senha" minlength="8" maxlength="100" required>
            <input type="password" name="senha_usu_confirm" placeholder="Confirme sua senha" minlength="8" maxlength="100" required>
            <br><br>
            <label>Seleciona o tipo usuário</label>
            <br>
            <select name="perfil_usu" required>
                <option value="usu">Usuário</option>
                <option value="adm">Administrador</option>
            </select>
            <br><br>
            <label>Caso seja um usuário comum do sistema, selecione a empresa que o mesmo se encontra, se não, destarte essa opção.</label>
            <br>
            <select name="id_emp" required>
                <?php
                    $empresas = $EmpresasDao->findAll();     
                    foreach($empresas as $getEmpresas):
                ?>
                <option value="<?=$getEmpresas->getIdEmp();?>"><?=$getEmpresas->getNomeFantasiaEmp()?></option>
                <?php
                    endforeach;
                ?>
            </select>
            <br><br>
            
            <input type="checkbox" name="situacao_usu">
            <label>Ao cadastrar uma empresa, automaticamente o status da mesma é ativa, caso queira deixar o status como inativo selecione esta opção.</label>
            <br><br>
            <input type="submit" value="Cadastrar-se">
        </form>
    </div>

    <section class="<?=$classeDpto?> ">
        <form class="background-white-color padding-10-px" method="POST" action="../cadastrar/cadastrarUsuario_action.php">
            <label for="">Selecione o departamento em que o usuário vai se encontrar no sistema.</label>
            <select name="id_dpto">
                <?php
                if($DepartamentosDao->verifyRowByEmpId($id_emp)) {
                    $departamentos = $DepartamentosDao->findByIdEmp($id_emp);
                } else {
                    
                }
                    foreach($departamentos as $getDepartamentos):
                ?>
                <option value="<?=$getDepartamentos->getIdDpto();?>"><?=$getDepartamentos->getNomeDpto();?></option>
                <?php
                    
                    endforeach;
                ?>
                <input type="submit" value="Cadastrar-se">
            </select>
        </form>
    </section>
    
    <script src="../js/cadastrarAdmScript.js"></script>
</body>
</html>