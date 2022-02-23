<?php

session_start();

if(!$_SESSION['loggedAdm']) {
    header('Location:../index.php');
    exit;
} else {
    $logged = 'ativo';
}

$classeNone = 'displayNone';

//verificando se há valor em todas variaveis sessoes
if($_SESSION['cnpj_emp'] && $_SESSION['razao_social_emp'] && $_SESSION['nome_fantasia_emp'] && $_SESSION['logo_emp'] && $_SESSION['endereco_emp'] && $_SESSION['situacao_emp']) {
    $classeNone = 'displayBlock';
} else {
    $classeNone = 'displayNone';
    $_SESSION['erroEmp'] = 'Não existe uma empresa com esse ID cadastrada no sistema.';
    $_SESSION['erroEmpCrypt'] = password_hash($_SESSION['erroEmp'], PASSWORD_DEFAULT);

    header('Location:../gerenciamentoSist/gerenciamentoSist.php?erroEmp='.$_SESSION['erroEmpCrypt']);
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ver mais</title>
    <!--BOOTSTRAP-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
</head>
<body>

    <section class="<?=$classeNone?> maxWidth maxVhHeight">
        <div class="blocoVermais">
            <div class="row">
                <div class="col-12 col-md-4"><img src="<?=$_SESSION['logo_emp'];?>"/></div>
                <div class="col-12 col-md-4">ID:</div>
                <div class="col-12 col-md-4"><?=$_SESSION['id_emp'];?></div>
                <br><br>
                <div class="col-12 col-md-6">CNPJ: </div>
                <div class="col-12 col-md-6"><?=$_SESSION['cnpj_emp'];?></div>
                <br><br>
                <div class="col-12 col-md-6">Razão Social: </div>
                <div class="col-12 col-md-6"><?=$_SESSION['razao_social_emp'];?></div>
                <br><br>
                <div class="col-12 col-md-6">Nome Fantasia: </div>
                <div class="col-12 col-md-6"><?=$_SESSION['nome_fantasia_emp'];?></div>
                <br><br>
                <div class="col-12 col-md-6">Endereço: </div>
                <div class="col-12 col-md-6"><?=$_SESSION['endereco_emp'];?></div>
                <div class="col-12 col-md-6">Situação: </div>
                <div class="col-12 col-md-6"><?=$_SESSION['situacao_emp'];?></div> 
                <div class="col-12 col-md-6"><a href="../apagar/apagarEmp_action.php?id=<?=$_SESSION['id_emp']?>"><i class="bi bi-trash"></i>  Apagar</a></div>
                <div class="col-12 col-md-6"><a href="../verificar/verificacaoEmp.php?id=<?=$_SESSION['id_emp']?>"><i class="bi bi-pencil"></i> Editar</a></div> 
            </div>
           
        </div>
    </section>
    
</body>
</html>