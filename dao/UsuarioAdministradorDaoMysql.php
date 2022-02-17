<?php

require_once 'models/UsuarioAdministrador.php';


class UsuarioAdministradorDaoMysql implements UsuarioAdministradorDAO {

    private $pdo;

    public function __construct(PDO $drivers) {
        $this->pdo = $drivers;
    }

    public function add(UsuarioAdministrador $ua) {
        $sql = $this->pdo->prepare('INSERT INTO 
        tb_usuario_administrador(nome_adm, username_adm, email_adm, email_adm_ctt, telefone_adm, telefone_adm_sub, senha_adm)
            VALUES
        (:nome_adm, :username_adm, :email_adm, :email_adm_ctt, :telefone_adm, :telefone_adm_sub, :senha_adm);');

        $sql->bindValue(':nome_adm', $ua->getNomeAdm());
        $sql->bindValue(':username_adm', $ua->getUsernameAdm());
        $sql->bindValue(':email_adm', $ua->getEmailAdm());
        $sql->bindValue(':email_adm_ctt', $ua->getEmailAdmCtt());
        $sql->bindValue(':telefone_adm', $ua->getTelefoneAdm());
        $sql->bindValue(':telefone_adm_sub', $ua->getTelefoneAdmSub());
        $sql->bindValue(':senha_adm', $ua->getSenhaAdm());
        $sql->execute();


        return $ua;
    }

    public function findAll() {
        $array = [];

        $sql = $this->pdo->query("SELECT * FROM tb_usuario_administrador;");

        if($sql->rowCount() > 0) {
            $data = $sql->fetchAll();
            foreach($data as $item) {
                $uc = new UsuarioAdministrador;
                $uc->setIdAdm($item['id_adm']);
                $uc->setNomeAdm($item['nome_adm']);
                $uc->setUsernameAdm($item['username_adm']);
                $uc->setEmailAdm($item['email_adm']);
                $uc->setEmailAdmCtt($item['email_adm_ctt']);
                $uc->setTelefoneAdm($item['telefone_adm']);
                $uc->setTelefoneAdmSub($item['telefone_adm_sub']);
        
                $array[] = $uc;
            }
        
        }
        return $array;
    }

    public function findByUsernameOrEmail(UsuarioAdministrador $ua) {
        $array = [];

        if(!empty($ua->getUsernameAdm())) {
            $username = $ua->getUsernameAdm();
            $sql = $this->pdo->query("SELECT * FROM tb_usuario_administrador WHERE username_adm = '".$username."';");

        } else if(!empty($ua->getEmailAdm())) {
            $email = $ua->getEmailAdm();
            $sql = $this->pdo->query("SELECT * FROM tb_usuario_administrador WHERE email_adm = '".$email."';");

        }

        if($sql->rowCount() > 0) {
            $data = $sql->fetchAll();
        }

        foreach($data as $item) {
            $uc = new UsuarioAdministrador;
            $uc->setIdAdm($item['id_adm']);
            $uc->setNomeAdm($item['nome_adm']);
            $uc->setUsernameAdm($item['username_adm']);
            $uc->setEmailAdm($item['email_adm']);
            $uc->setEmailAdmCtt($item['email_adm_ctt']);
            $uc->setTelefoneAdm($item['telefone_adm']);
            $uc->setTelefoneAdmSub($item['telefone_adm_sub']);
            $uc->setSenhaAdm($item['senha_adm']);

            $array[] = $uc;
        }
        return $array;
    }

    public function verifyRow() {
        $sql = $this->pdo->query('SELECT * FROM tb_usuario_administrador');

        return $sql->rowCount() > 0;
    }

    public function verifyRowByEmail($email_adm) {
        $email = $email_adm;

        $sql = $this->pdo->query("SELECT * FROM tb_usuario_administrador where email_adm = '".$email."';");

        return $sql->rowCount() > 0;
    }

    public function verifyRowByUsername($username_adm) {
        $username = $username_adm;

        $sql = $this->pdo->query("SELECT * FROM tb_usuario_administrador where username_adm = '".$username."';");

        return $sql->rowCount() > 0;
    }
}

?>