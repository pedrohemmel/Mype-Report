
<?php
require '../config.php';
require '../dao/UsuariosDaoMysql.php';
require '../dao/UsuarioAdministradorDaoMysql.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
require 'lib/vendor/autoload.php';
$mail = new PHPMailer(true);

$email_usu = filter_input(INPUT_POST, 'email_usu');
$erroAtualizaSenhaCrypt = filter_input(INPUT_GET, 'erro');

$erroAtualizaSenha = 'Erro ao acessar página, solicite um novo link';

$_SESSION['msg'] = '';

$classeNone = 'displayNone';

if(!empty($email_usu)) {
    
    $UsuariosDao = new UsuariosDaoMysql($pdo);
    $UsuarioAdministradorDao = new UsuarioAdministradorDaoMysql($pdo);

    if($UsuariosDao->verifyRowByEmail($email_usu)) {

        $usuarios = $UsuariosDao->findByEmail($email_usu);
        $usuarioAdministrador = $UsuarioAdministradorDao->findAll();

        foreach($usuarios as $getUsuarios) {
            $id_usu = $getUsuarios->getIdCli();
            $nome_usu = $getUsuarios->getNomeCli();
        }  

        foreach($usuarioAdministrador as $getUsuarioAdministrador) {
            $nome_adm = $getUsuarioAdministrador->getNomeAdm();
            $telefone_adm = $getUsuarioAdministrador->getTelefoneAdm();
            if(!empty($getUsuarioAdministrador->getTelefoneAdmSub())) {
                $interligaTelefone = ' | '; 
                $telefone_adm_sub = $getUsuarioAdministrador->getTelefoneAdmSub();
            }
            
        }  

        $chave_recuperar_senha = password_hash($id_usu, PASSWORD_DEFAULT);

        $usuario_recuperar_senha = new Usuarios;
        $usuario_recuperar_senha->setIdUsu($id_usu);
        $usuario_recuperar_senha->setRecuperaSenhaUsu($chave_recuperar_senha);

        $UsuariosDao->updateRecuperarSenha($usuario_recuperar_senha);
        
        $link = 'http://localhost/saas-report/recuperarSenha/atualizarSenha.php?chave='.$chave_recuperar_senha;

        try {
            //$mail->SMTPDebug = SMTP::DEBUG_SERVER;   
            $mail->CharSet = 'UTF-8';                 
            $mail->isSMTP();                                           
            $mail->Host       = 'smtp.mailtrap.io';                 
            $mail->SMTPAuth   = true;                               
            $mail->Username   = '8ac89040fac6e3';              
            $mail->Password   = '227792651bb216';                           
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;   
            $mail->Port       = 2525; 

            $mail->AddEmbeddedImage('../img/logo.jpg', 'Logo');

            $mail->setFrom('atendimento@mailtrap.com', 'Atendimento');
            $mail->addAddress($email_usu, $nome_usu);  

            $mail->isHTML(true);                                  //Set email format to HTML
            $mail->Subject = 'Recuperar senha';
            $mail->Body    = "
            
            <div style='border: 1px solid #00f;'>
                Prezado(a) ".$nome_usu.". Você solicitou alteração de senha.

                <br><br>


                Para continuar com o processo de recuperação de sua senha, clique no link abaixo ou cole
                o endereço no seu navegador:

                <br><br>

                <a href'".$link."'>".$link."</a>
                
                <br><br>
                
                Se você não solicitou essa alteração, nenhuma ação é necessária. Sua senha permanecerá
                a mesma até que você ative esse código.
                
                <br><br>
                
                --
                
                <br><br>
                
                Att.
                
                <h5>".$nome_adm."</h5>
                
                MypeReport | MycroMype Solutions
                
                <br><br>
                
                Endereço: Rua Exemplo de nome, 00
                
                <br><br>
                
                Tel. ".$telefone_adm."".$interligaTelefone."".$telefone_adm_sub."
                
                <br><br>
                
                <img src='cid:logo_saas'>
            </div>";

            

            
            $mail->AltBody = "Prezado(a) ".$nome_usu.". Você solicitou alteração de senha.

            \n\n

            Para continuar com o processo de recuperação de sua senha, clique no link abaixo ou cole
            o endereço no seu navegador:

            \n\n

            ".$link."
            
            \n\n
            
            Se você não solicitou essa alteração, nenhuma ação é necessária. Sua senha permanecerá
            a mesma até que você ative esse código.
            
            \n\n
            
            --
            
            \n\n
            
            Att.

            \n\n
            
            ".$nome_adm."

            \n\n
            
            MypeReport | MycroMype Solutions
            
            \n\n
            
            Endereço: Rua Exemplo de nome, 00
            
            \n\n
            
            Tel. ".$telefone_adm."".$interligaTelefone."".$telefone_adm_sub."
            
            \n\n";

            $mail->send();

            $classeNone = 'displayBlkGreen';
            $_SESSION['msg'] = "Foi enviado e-mail com instruções para recuperar a senha.
            Acesse a sua caixa de e-mail para recuperar a senha!";

            

        } catch (Exception $e) {
            $classeNone = 'displayBlkRed';
            $_SESSION['msg'] = "Erro: E-mail não enviado. Mailer Error: {$mail->ErrorInfo}";
        }

    } else {
        $classeNone = 'displayBlkRed';
        $_SESSION['msg'] = 'E-mail não existente no sistema';
    }

    
}
if(!empty($erroAtualizaSenhaCrypt)) {
    if(password_verify($erroAtualizaSenha, $erroAtualizaSenhaCrypt)) {
        $classeNone = 'displayBlkRed';
        $_SESSION['msg'] = 'Erro ao acessar página, solicite um novo link';
    }
}

$mensagem = $_SESSION['msg'];



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recuperar senha</title>
    <!--BOOTSTRAP-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <!--ARQUIVO CSS-->
    <link rel="stylesheet" href="../style/base.css"/>
    <!--FONTE MARCELLUS-SC-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Marcellus+SC&display=swap" rel="stylesheet">
</head>
<body>
    
    <main class="container">
      
    
        <form method="POST" action="../recuperarSenha/recuperarSenha.php"> <!--ENVIA OS DADOS PARA VERIFICAR SE ESSE USUARIO EXISTE E SE ELE TEM ACESSO AO RELATORIO-->
            <p class="<?=$classeNone?> text-center"><?=$mensagem?></p>

            <input class="inputAlt maxWidth" type="text" name="email_usu" placeholder="Digite o email para recuperação de senha" required>

            <br><br>

            <input class="border-radius-button submit-padding-top-bottom maxWidth background-primary-color border-none color-white" type="submit" value="Recuperar senha">
        </form>
        <br>

        <hr>

        <a class="noDecorations color-primary text-center link-color-primary" href="../login/login.php">Fazer login</a>
    
        
    </main>
</body>
</html>