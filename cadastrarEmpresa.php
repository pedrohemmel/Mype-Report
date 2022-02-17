<?php

session_start();

if(!$_SESSION['loggedAdm']) {
    header('Location:index.php');
    exit;
}

$erroCadEmp = filter_input(INPUT_GET, 'erroCadEmp');

$classeNone = 'displayNone';

if(!empty($erroCadEmp)) {
    if(password_verify($_SESSION['erroCadEmp'], $erroCadEmp)) {
        $classeNone = 'displayBlkRed';
        $mensagem = $_SESSION['erroCadEmp'];
    }
}

//requisição de dados

if(isset($_FILES['logo_emp'])) {
    $arquivo = $_FILES['logo_emp'];

    if($arquivo['size'] > 2097152) {
        die("Arquivo muito grande! Max: 2MB");
    } else {
        $pasta = "img/";
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
            $_SESSION['nome_fantasia_emp'] = filter_input(INPUT_POST,  'nome_fantasia_emp');
            $_SESSION['razao_social_emp'] = filter_input(INPUT_POST, 'razao_social_emp');
            $_SESSION['cnpj_emp'] = filter_input(INPUT_POST, 'cnpj_emp');
            $_SESSION['endereco_emp'] = filter_input(INPUT_POST, 'endereco_emp');
            $_SESSION['cor_pri_emp'] = filter_input(INPUT_POST, 'cor_pri_emp');
            $_SESSION['cor_sec_emp'] = filter_input(INPUT_POST, 'cor_sec_emp');
            $_SESSION['situacao_emp'] = filter_input(INPUT_POST, 'situacao_emp');
    
            header('Location:cadastrarEmpresa_action.php');
            exit;
        }
    } else {
        $arquivo['name'] = 'logoPadrao';
        $extensao = 'jpeg';
        $_SESSION["path"] = $pasta . $arquivo['name'] . "." . $extensao;

        $_SESSION['nome_fantasia_emp'] = filter_input(INPUT_POST,  'nome_fantasia_emp');
        $_SESSION['razao_social_emp'] = filter_input(INPUT_POST, 'razao_social_emp');
        $_SESSION['cnpj_emp'] = filter_input(INPUT_POST, 'cnpj_emp');
        $_SESSION['endereco_emp'] = filter_input(INPUT_POST, 'endereco_emp');
        $_SESSION['cor_pri_emp'] = filter_input(INPUT_POST, 'cor_pri_emp');
        $_SESSION['cor_sec_emp'] = filter_input(INPUT_POST, 'cor_sec_emp');
        $_SESSION['situacao_emp'] = filter_input(INPUT_POST, 'situacao_emp');

        header('Location:cadastrarEmpresa_action.php');
        exit;
    }

    
    
    
}
// $arquivo = $_FILES['logo_emp']['name'];
    // $extensao = strtolower(pathinfo($arquivo, PATHINFO_EXTENSION));
    // $novo_nome = md5(time().".".$extensao);
    // $diretorio = "upload/";
    // $move_uploaded_file($_FILES['logo_emp']['tmp_name'], $diretorio . $novo_nome);
    // echo $novo_nome;

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style/base.css"/>
</head>
<body>
    <main>

        <form action="" method="POST" enctype="multipart/form-data">
            <p class="<?=$classeNone?>"><?=$mensagem?></p>
            <label>Selecione uma imagem (JPG, PNG). Recomendável selecionar imagem tamanho 250X250px.</label>
            <input type="file" name="logo_emp">
            <br><br>
            <div class="displayFlex flex-direction-row justify-content-center">
                <label>nome Fantasia</label>
                <input type="text" name="nome_fantasia_emp" placeholder="Nome social da empresa" maxlength="50" required>
                <label>Razão Social</label>
                <input type="text" name="razao_social_emp" placeholder="Razão social da empresa" maxlength="50" required>
            </div>
            <br><br>
            <div class="displayFlex flex-direction-row justify-content-center">
                <label>CNPJ</label>
                <input type="text" name="cnpj_emp" placeholder="Digite o CNPJ da empresa" minLength="14" maxLength="14" required>
                <label>Endereço</label>
                <input type="text" name="endereco_emp" placeholder="Digite o endereço da empresa" maxLength="150" required>   
            </div>
            <br><br>
            <label>Caso queira aplicar uma cor primária e/ou secundária para essa empresa, digite nos campos abaixo utilizando 6 digitos de cores hexagonais. Exemplo: (ff0100; 00ff12; 23f3ad;).</label>
            <div class="displayFlex flex-direction-row justify-content-center">
                <label>Cor Primária da empresa</label>
                <input type="text" name="cor_pri_emp" placeholder="Cor primária">
                <label>Cor Secundária da empresa</label>
                <input type="text" name="cor_sec_emp" placeholder="Cor secundária">
            </div>
            <br><br>
            <input type="checkbox" name="situacao_emp">
            <label>Ao cadastrar uma empresa, automaticamente o status da mesma é ativa, caso queira deixar o status como inativo selecione esta opção.</label>
            <br><br>
            <input type="submit" value="Cadastrar">

        </form>
    </main>
</body>
</html>