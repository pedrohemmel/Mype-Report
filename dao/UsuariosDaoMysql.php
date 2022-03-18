<?php

require_once 'models/Usuarios.php';

class UsuariosDaoMysql implements UsuariosDAO {

    private $pdo;

    public function __construct(PDO $drivers) {
        $this->pdo = $drivers;
    }

    public function addUsuarios(Usuarios $u) {
        $sql = $this->pdo->prepare('INSERT INTO 
        tb_usuarios(id_emp, id_dpto, nome_usu, username_usu, email_usu, telefone_usu, perfil_usu, senha_usu, situacao_usu, recupera_senha_usu)
            VALUES
        (:id_emp, :id_dpto, :nome_usu, :username_usu, :email_usu, :telefone_usu, :perfil_usu, :senha_usu, :situacao_usu, :recupera_senha_usu);');

        $sql->bindValue(':id_emp', $u->getIdEmp());
        $sql->bindValue(':id_dpto', $u->getIdDpto()); 
        $sql->bindValue(':nome_usu', $u->getNomeUsu());
        $sql->bindValue(':username_usu', $u->getUsernameUsu());
        $sql->bindValue(':email_usu', $u->getEmailUsu());
        $sql->bindValue(':telefone_usu', $u->getTelefoneUsu());
        $sql->bindValue(':perfil_usu', $u->getPerfilUsu());
        $sql->bindValue(':senha_usu', $u->getSenhaUsu());
        $sql->bindValue(':situacao_usu', $u->getSituacaoUsu());
        $sql->bindValue(':recupera_senha_usu', $u->getRecuperarSenhaUsu());
        $sql->execute();


        return $u;
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

    public function findById($id_usu) {
        $array = [];

        $id = $id_usu;

        $sql = $this->pdo->query("SELECT * FROM tb_usuarios WHERE id_usu = '".$id."';");

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
                if($uc->getRecuperarSenhaUsu()) {
                    $uc->setRecuperarSenhaUsu($item['recuperar_senha_usu']);
                } else {
                    $uc->setRecuperarSenhaUsu(""); 
                }
                
        
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

    public function findUsuByEmpId($id_emp) {
        $id = $id_emp;
        $array = [];

        $sql = $this->pdo->query("SELECT * FROM tb_usuarios WHERE id_emp = '".$id."';");

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
                if($uc->getRecuperarSenhaUsu()) {
                    $uc->setRecuperarSenhaUsu($item['recuperar_senha_usu']);
                } else {
                    $uc->setRecuperarSenhaUsu(""); 
                }
                
        
                $array[] = $uc;
            }
        
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

    public function verifyRowByEmpId($id_emp) {
        $id = $id_emp;

        $sql = $this->pdo->query("SELECT * FROM tb_usuarios where id_emp = '".$id."';");

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