<?php

session_start();

if(!$_SESSION['loggedAdm']) {
    header('Location:../index.php');
    exit;
} else {
    $logged = 'ativo';
}

require '../config.php';
require '../dao/EmpresasDaoMysql.php';
require '../dao/RelatoriosDaoMysql.php';

$EmpresasDao = new EmpresasDaoMysql($pdo);
$RelatoriosDao = new RelatoriosDaoMysql($pdo);

$_SESSION['id_emp'] = filter_input(INPUT_POST, 'id_emp');

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Relatórios</title>
    <!--BOOTSTRAP-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
    <!--CSS-->
    <link rel="stylesheet" href="../style/base.css"/>
</head>
<body>

    <div class="sectionEmpresa <?=$classeEmpresas?>">
        <div class="tituloPaginas">
            <h2>Relatórios</h2>
        </div>
        <div class="tamanhoConteudo addEmpresa displayFlex flex-direction-row align-items-center">
            <a href="../cadastrar/cadastrarIndicador.php" style="margin-right: 10px;" class="bi bi-plus-lg iconAdd color-black background-secondary-color border-radius-10-px"></a>
            <p style="margin: 0;">Adicionar um novo relatório</p>
        </div>
        <section class="tamanhoConteudo displayFlex flex-direction-row justify-content-center">
            <?php   
                if($RelatoriosDao->verifyRowByEmpId($_SESSION['id_emp'])):
                    $relatorios = $RelatoriosDao->findByEmpId($id_emp);
                    foreach($relatorios as $getRelatorios):
            ?>
            <div style="margin: 20px; width:200px" class="displayFlex flex-direction-column align-items-center justify-content-center background-secondary-color padding-10-px border-radius-10-px">
                
                <h6><?=$getRelatorios->getNomeRel();?></h6>
                <div class="displayFlex flex-direction-row align-items-center justify-content-center">
                    <a href="../verMais/verMaisEmp_action.php?id=<?=$getEmpresas->getIdEmp()?>">Ver mais</a>  
                    
                </div>
                
            </div>
            <?php       
                    endforeach;
                else: 
            ?>
                <span>Não há relatórios nessa empresa no momento.</span>
            <?php
                endif;
            ?>
        </section>
    <div>
</body>
</html>



