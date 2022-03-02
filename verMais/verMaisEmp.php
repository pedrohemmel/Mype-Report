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
require '../dao/DepartamentosDaoMysql.php';

$DepartamentosDao = new DepartamentosDaoMysql($pdo);
$EmpresasDao = new EmpresasDaoMysql($pdo);
$empresas = $EmpresasDao->findById($_SESSION['id_emp']);

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
    <!--CSS-->
    <link rel="stylesheet" href="../style/base.css"/>
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
        <section class="margin-top-bottom-2-em departmentos displayFlex flex-direction-row justify-content-center">
            <h3>Departamentos</h3>
            <div class="displayFlex flex-direction-row justify-content-center">
                <a href="../cadastrar/cadastrarDpto.php?id_emp=<?=$_SESSION['id_emp']?>" style="margin-right: 10px;" class="bi bi-plus-lg iconAdd color-black background-secondary-color border-radius-10-px"></a>
                <p style="margin: 0;">Adicionar um novo departamento</p>  
            </div>
            <table class="table-primary tamanhoConteudo border-radius-10-px">
                    <?php 

                    //logica de cores da fonte para que não fique dificil de ver
                        if(!empty($_SESSION['cor_pri_emp'])) {
                            if(intval($_SESSION['cor_pri_emp']) > 888888) {
                                $corFont = '000'; 
                            } else if(intval($_SESSION['cor_pri_emp']) < 888888) {
                                $corFont = 'fff';
                            } else {
                                $corFont = $_SESSION['cor_sec_emp'];
                            }
                            $cor_pri_emp = $_SESSION['cor_pri_emp'];
                        } else {
                            $cor_pri_emp = '000000';
                            $corFont = 'ffffff';
                        }
                    ?>
                    <thead style="background-color:#<?=$cor_pri_emp?>">
                    <tr>
                        <th scope="col" style="color:#<?=$corFont?>" class="padding-10-px">Id</th>
                        <th scope="col" style="color:#<?=$corFont?>" class="padding-10-px">Nome</th>
                        <th scope="col" style="color:#<?=$corFont?>" class="padding-10-px">Centro de Custo</th>
                        <th scope="col" style="color:#<?=$corFont?>" class="padding-10-px">Ações</th>
            
                    </tr>
                </thead>
                <tbody>
                
                    <?php foreach($empresas as $getEmpresas):
                    
                    if($DepartamentosDao->verifyRowByEmpId($_SESSION['id_emp'])):
                        $departamentos = $DepartamentosDao->findByIdEmp($_SESSION['id_emp']);

                        foreach($departamentos as $getDepartamentos):
                    ?>
                        <tr class="">
                            <td class="padding-10-px"><p  class="color-black text-decoration-none"><?=$getDepartamentos->getIdDpto();?></p></td>
                            <td class="padding-10-px"><p  class="color-black text-decoration-none"><?=$getDepartamentos->getNomeDpto();?></p></td>
                            <td class="padding-10-px"><p  class="color-black text-decoration-none"><?=$getDepartamentos->getCentroDCustoDpto();?></p></td>
                            <td class="padding-10-px"><a href="../apagar/apagarDepartamentos.php?id_dpto=<?=$getDepartamentos->getIdDpto();?>" class="color-black">Apagar</p></td>
                        </tr>
                    <?php
                        endforeach;
                    else:?>
                        <tr class="">
                            <td class="padding-10-px"><p  class="color-black" i style="padding-left: 50px">Não há departamentos cadastrados nessa empresa.</p></td>
                        </tr>
                    <?php

                    endif;

                    endforeach; ?>
                   
                </tbody>
            </table>
            

        </section>

    </section>
    
</body>
</html>



