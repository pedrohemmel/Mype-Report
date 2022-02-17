<?php

require_once 'models/Usuarios.php';

class UsuariosDaoMysql implements UsuariosDAO {

    private $pdo;

    public function __construct(PDO $drivers) {
        $this->pdo = $drivers;
    }

    public function findAll() {
        $array = [];

        $sql = $this->pdo->query("SELECT * FROM tb_usuarios;");

        if($sql->rowCount() > 0) {
            $data = $sql->fetchAll();
            foreach($data as $item) {
                $uc = new Usuarios;
                $uc->setIdUsu($item['id_usu']);
                $uc->setIdEmp($item['id_emp']);
                $uc->setIdDpto($item['id_dpto']);
                $uc->setNomeUsu($item['nome_usu']);
                $uc->setUsernameUsu($item['username_usu']);
                $uc->setEmailUsu($item['email_usu']);
                $uc->setTelefoneUsu($item['telefone_usu']);
                $uc->setPerfilUsu($item['perfil_usu']);
                $uc->setSituacaoUsu($item['situacao_usu']);
                $uc->setRecuperarSenhaUsu($item['recuperar_senha_usu']);
        
                $array[] = $uc;
            }
        
        }
        return $array;
    }

    public function findAllAdm() {
        $array = [];

        $sql = $this->pdo->query("SELECT * FROM tb_usuarios WHERE perfil_usu = 'adm';");
        $sql->execute();


        if($sql->rowCount() > 0) {
            $data = $sql->fetchAll();
            foreach($data as $item) {
                $uc = new Usuarios;
                $uc->setIdUsu($item['id_usu']);
                $uc->setIdEmp($item['id_emp']);
                $uc->setIdDpto($item['id_dpto']);
                $uc->setNomeUsu($item['nome_usu']);
                $uc->setUsernameUsu($item['username_usu']);
                $uc->setEmailUsu($item['email_usu']);
                $uc->setTelefoneUsu($item['telefone_usu']);
                $uc->setPerfilUsu($item['perfil_usu']);
                $uc->setSituacaoUsu($item['situacao_usu']);
                $uc->setRecuperarSenhaUsu($item['recuperar_senha_usu']);
        
                $array[] = $uc;
            }
        
        }
        return $array;
    }

    public function findAllUsu() {
        $array = [];

        $sql = $this->pdo->query("SELECT * FROM tb_usuarios WHERE perfil_usu = 'usu';");

        if($sql->rowCount() > 0) {
            $data = $sql->fetchAll();
            foreach($data as $item) {
                $uc = new Usuarios;
                $uc->setIdUsu($item['id_usu']);
                $uc->setIdEmp($item['id_emp']);
                $uc->setIdDpto($item['id_dpto']);
                $uc->setNomeUsu($item['nome_usu']);
                $uc->setUsernameUsu($item['username_usu']);
                $uc->setEmailUsu($item['email_usu']);
                $uc->setTelefoneUsu($item['telefone_usu']);
                $uc->setPerfilUsu($item['perfil_usu']);
                $uc->setSituacaoUsu($item['situacao_usu']);
                $uc->setRecuperarSenhaUsu($item['recuperar_senha_usu']);
        
                $array[] = $uc;
            }
        
        }

        
        return $array;
    }

    public function findByUsernameOrEmail(Usuarios $u) {
        $array = [];

        if(!empty($u->getUsernameUsu())) {
            $sql = $this->pdo->query("SELECT * FROM tb_usuarios WHERE username_usu = :username_usu;");

            $sql->bindValue(':username_usu', $u->getUsernameUsu());
            $sql->execute();
        } else if(!empty($u->getEmailUsu())) {
            $sql = $this->pdo->query("SELECT * FROM tb_usuarios WHERE email_usu = :email_usu;");

            $sql->bindValue(':email_usu', $u->getEmailUsu());
            $sql->execute();
        }

        if($sql->rowCount() > 0) {
            $data = $sql->fetchAll();
        }

        foreach($data as $item) {
            $uc = new Usuarios;
            $uc->setIdUsu($item['id_usu']);
            $uc->setIdEmp($item['id_emp']);
            $uc->setIdDpto($item['id_dpto']);
            $uc->setNomeUsu($item['nome_usu']);
            $uc->setUsernameUsu($item['username_usu']);
            $uc->setEmailUsu($item['email_usu']);
            $uc->setTelefoneUsu($item['telefone_usu']);
            $uc->setPerfilUsu($item['perfil_usu']);
            $uc->setSenhaUsu($item['senha_usu']);
            $uc->setSituacaoUsu($item['situacao_usu']);
    
            $array[] = $uc;
        }
        return $array;
    }

    public function verifyRowByEmail($email_usu) {
        $email = $email_usu;

        $sql = $this->pdo->query("SELECT * FROM tb_usuarios where email_usu = '".$email."';");

        return $sql->rowCount() > 0;
    }

    public function verifyRowByUsername($username_usu) {
        $username = $username_usu;

        $sql = $this->pdo->query("SELECT * FROM tb_usuarios where username_usu = '".$username."';");

        return $sql->rowCount() > 0;
    }
    
    public function updateRecuperarSenha(Usuarios $u) {
        $sql = $this->pdo->prepare('UPDATE tb_usuarios SET recupera_senha_usu = :recupera_senha_usu WHERE id_usu = :id_usu;');
        $sql->bindValue(':recupera_senha_usu', $u->getRecuperaSenhaUsu());
        $sql->bindValue(':id_usu', $u->getIdUsu());
        $sql->execute();

        return $u;
    }
}
?>