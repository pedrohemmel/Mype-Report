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

$id_rel = filter_input(INPUT_GET, "id_rel");

//logica para verificar as cores e não retornar undefined
if(empty($_SESSION['cor_pri_emp']) && empty($_SESSION['cor_sec_emp'])) {
    $cor_pri_emp = "";
    $cor_sec_emp = "";
} else if(empty($_SESSION['cor_pri_emp']) && !empty($_SESSION['cor_sec_emp'])) {
    $cor_pri_emp = "";
    $cor_sec_emp = $_SESSION['cor_sec_emp'];
} else if(!empty($_SESSION['cor_pri_emp']) && empty($_SESSION['cor_sec_emp'])) {
    $cor_pri_emp = $_SESSION['cor_pri_emp'];
    $cor_sec_emp = "";
} else {
   $cor_pri_emp = $_SESSION['cor_pri_emp'];
   $cor_sec_emp = $_SESSION['cor_sec_emp'];
}

if(isset($_FILES['logo_emp'])) {
    $arquivo = $_FILES['logo_emp'];

    if($arquivo['size'] > 2097152) {
        die("Arquivo muito grande! Max: 2MB");
    } else {
        $pasta = "../img/";
        $nomeDoArquivo = $arquivo['name'];
        $novoNomeDoArquivo = uniqid();
        $extensao = strtolower(pathinfo($nomeDoArquivo, PATHINFO_EXTENSION));
        
    }

    if($extensao != "jpg" && $extensao != "png" && !empty($arquivo['name'])) {
        die('Tipo de arquivo não reconhecido');
    }

    if(!empty($arquivo['name'])) {
        $_SESSION["path"] = $pasta . $novoNomeDoArquivo . "." . $extensao;
        $deuCerto = move_uploaded_file($arquivo["tmp_name"], $_SESSION["path"]);
        if($deuCerto) {
            $logo_emp = $_SESSION['path'];
        }
    } else {
        $logo_emp = $_SESSION['logo_emp'];

    }
}

$nome_fantasia_emp = filter_input(INPUT_POST,  'nome_fantasia_emp');
$razao_social_emp = filter_input(INPUT_POST, 'razao_social_emp');
$cnpj_emp = filter_input(INPUT_POST, 'cnpj_emp');
$endereco_emp = filter_input(INPUT_POST, 'endereco_emp');
$cor_pri_emp = filter_input(INPUT_POST, 'cor_pri_emp');
$cor_sec_emp = filter_input(INPUT_POST, 'cor_sec_emp');
$situacao = filter_input(INPUT_POST, 'situacao_emp');

if(!$situacao) {
    $situacao_emp = 'ativo';
} else {
    $situacao_emp = 'inativo';
}

if($nome_fantasia_emp && $razao_social_emp && $cnpj_emp) {
    if((($EmpresasDao->verifyRowByNomeFantasia($nome_fantasia_emp) && ($nome_fantasia_emp === $_SESSION['nome_fantasia_emp'])) && ($EmpresasDao->verifyRowByRazaoSocial($razao_social_emp) && ($razao_social_emp === $_SESSION['razao_social_emp'])) && ($EmpresasDao->verifyRowByCnpj($cnpj_emp) && ($cnpj_emp === $_SESSION['cnpj_emp']))) || 
    (($EmpresasDao->verifyRowByNomeFantasia($nome_fantasia_emp) && ($nome_fantasia_emp === $_SESSION['nome_fantasia_emp'])) && (!$EmpresasDao->verifyRowByRazaoSocial($razao_social_emp) && ($razao_social_emp != $_SESSION['razao_social_emp'])) && (!$EmpresasDao->verifyRowByCnpj($cnpj_emp) && ($cnpj_emp != $_SESSION['cnpj_emp']))) || 
    ((!$EmpresasDao->verifyRowByNomeFantasia($nome_fantasia_emp) && ($nome_fantasia_emp != $_SESSION['nome_fantasia_emp'])) && ($EmpresasDao->verifyRowByRazaoSocial($razao_social_emp) && ($razao_social_emp === $_SESSION['razao_social_emp'])) && (!$EmpresasDao->verifyRowByCnpj($cnpj_emp) && ($cnpj_emp != $_SESSION['cnpj_emp']))) || 
    ((!$EmpresasDao->verifyRowByNomeFantasia($nome_fantasia_emp) && ($nome_fantasia_emp != $_SESSION['nome_fantasia_emp'])) && (!$EmpresasDao->verifyRowByRazaoSocial($razao_social_emp) && ($razao_social_emp != $_SESSION['razao_social_emp'])) && ($EmpresasDao->verifyRowByCnpj($cnpj_emp) && ($cnpj_emp === $_SESSION['cnpj_emp']))) || 
    ((!$EmpresasDao->verifyRowByNomeFantasia($nome_fantasia_emp) && ($nome_fantasia_emp != $_SESSION['nome_fantasia_emp'])) && ($EmpresasDao->verifyRowByRazaoSocial($razao_social_emp) && ($razao_social_emp === $_SESSION['razao_social_emp'])) && ($EmpresasDao->verifyRowByCnpj($cnpj_emp) && ($cnpj_emp === $_SESSION['cnpj_emp']))) || 
    (($EmpresasDao->verifyRowByNomeFantasia($nome_fantasia_emp) && ($nome_fantasia_emp === $_SESSION['nome_fantasia_emp'])) && ($EmpresasDao->verifyRowByRazaoSocial($razao_social_emp) && ($razao_social_emp === $_SESSION['razao_social_emp'])) && (!$EmpresasDao->verifyRowByCnpj($cnpj_emp) && ($cnpj_emp != $_SESSION['cnpj_emp']))) || 
    (($EmpresasDao->verifyRowByNomeFantasia($nome_fantasia_emp) && ($nome_fantasia_emp === $_SESSION['nome_fantasia_emp'])) && (!$EmpresasDao->verifyRowByRazaoSocial($razao_social_emp) && ($razao_social_emp != $_SESSION['razao_social_emp'])) && ($EmpresasDao->verifyRowByCnpj($cnpj_emp) && ($cnpj_emp === $_SESSION['cnpj_emp'])))) {
        
        $e = new Empresas;
        $e->setIdEmp($_SESSION['id_emp']);
        $e->setNomeFantasiaEmp($nome_fantasia_emp);
        $e->setRazaoSocialEmp($razao_social_emp);
        $e->setCnpjEmp($cnpj_emp);
        $e->setLogoEmp($logo_emp);
        $e->setEnderecoEmp($endereco_emp);
        $e->setCorPriEmp($cor_pri_emp);
        $e->setCorSecEmp($cor_sec_emp);
        $e->setSituacaoEmp($situacao_emp);

        $EmpresasDao->updateEmpresas($e);

        $_SESSION['msgEdit'] = 'Dados atualizados com sucesso.';
        $_SESSION['msgEditCrypt'] = password_hash($_SESSION['msgEdit'], PASSWORD_DEFAULT);
        header('Location:../verMais/verMaisEmp_action.php?msgEdit='.$_SESSION['msgEditCrypt'].'&id='.$_SESSION['id_emp']);
        exit;
        
    } else if((($EmpresasDao->verifyRowByNomeFantasia($nome_fantasia_emp) && ($nome_fantasia_emp != $_SESSION['nome_fantasia_emp'])) && ($EmpresasDao->verifyRowByRazaoSocial($razao_social_emp) && ($razao_social_emp != $_SESSION['razao_social_emp'])) && ($EmpresasDao->verifyRowByCnpj($cnpj_emp) && ($cnpj_emp != $_SESSION['cnpj_emp']))) ||
            (($EmpresasDao->verifyRowByNomeFantasia($nome_fantasia_emp) && ($nome_fantasia_emp != $_SESSION['nome_fantasia_emp'])) && ($EmpresasDao->verifyRowByRazaoSocial($razao_social_emp) && ($razao_social_emp === $_SESSION['razao_social_emp'])) && ($EmpresasDao->verifyRowByCnpj($cnpj_emp) && ($cnpj_emp === $_SESSION['cnpj_emp']))) ||
            (($EmpresasDao->verifyRowByNomeFantasia($nome_fantasia_emp) && ($nome_fantasia_emp === $_SESSION['nome_fantasia_emp'])) && ($EmpresasDao->verifyRowByRazaoSocial($razao_social_emp) && ($razao_social_emp != $_SESSION['razao_social_emp'])) && ($EmpresasDao->verifyRowByCnpj($cnpj_emp) && ($cnpj_emp === $_SESSION['cnpj_emp']))) ||
            (($EmpresasDao->verifyRowByNomeFantasia($nome_fantasia_emp) && ($nome_fantasia_emp === $_SESSION['nome_fantasia_emp'])) && ($EmpresasDao->verifyRowByRazaoSocial($razao_social_emp) && ($razao_social_emp === $_SESSION['razao_social_emp'])) && ($EmpresasDao->verifyRowByCnpj($cnpj_emp) && ($cnpj_emp != $_SESSION['cnpj_emp']))) ||
            (($EmpresasDao->verifyRowByNomeFantasia($nome_fantasia_emp) && ($nome_fantasia_emp != $_SESSION['nome_fantasia_emp'])) && ($EmpresasDao->verifyRowByRazaoSocial($razao_social_emp) && ($razao_social_emp === $_SESSION['razao_social_emp'])) && ($EmpresasDao->verifyRowByCnpj($cnpj_emp) && ($cnpj_emp != $_SESSION['cnpj_emp']))) ||
            (($EmpresasDao->verifyRowByNomeFantasia($nome_fantasia_emp) && ($nome_fantasia_emp === $_SESSION['nome_fantasia_emp'])) && ($EmpresasDao->verifyRowByRazaoSocial($razao_social_emp) && ($razao_social_emp != $_SESSION['razao_social_emp'])) && ($EmpresasDao->verifyRowByCnpj($cnpj_emp) && ($cnpj_emp != $_SESSION['cnpj_emp']))) ||
            (($EmpresasDao->verifyRowByNomeFantasia($nome_fantasia_emp) && ($nome_fantasia_emp != $_SESSION['nome_fantasia_emp'])) && ($EmpresasDao->verifyRowByRazaoSocial($razao_social_emp) && ($razao_social_emp != $_SESSION['razao_social_emp'])) && ($EmpresasDao->verifyRowByCnpj($cnpj_emp) && ($cnpj_emp === $_SESSION['cnpj_emp'])))) {

        $_SESSION['erroEdit'] = 'Alguem já está utilizando os dados inseridos.';
        $_SESSION['erroEditCrypt'] = password_hash($_SESSION['erroEdit'], PASSWORD_DEFAULT);
        header('Location:../editar/editarEmp.php?erroEdit='.$_SESSION['erroEditCrypt']);
        exit;

    } else {
        $_SESSION['erroEdit'] = 'Erro ao editar empresa.';
        $_SESSION['erroEditCrypt'] = password_hash($_SESSION['erroEdit'], PASSWORD_DEFAULT);
        header('Location:../editar/editarEmp.php?erroEdit='.$_SESSION['erroEditCrypt']);
        exit;
    }

} 

//
$classeNone = 'displayNone';

?>