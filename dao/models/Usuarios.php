<?php

class Usuarios {
    private $id_usu;
    private $id_emp;
    private $id_dpto;
    private $nome_usu;
    private $username_usu;
    private $email_usu;
    private $telefone_usu;
    private $perfil_usu;
    private $senha_usu;
    private $situacao_usu;
    private $recuperar_senha_usu;

    public function getIdUsu() {
        return $this->id_usu;
    }

    public function setIdUsu($iu) {
        $this->id_usu = trim($iu);
    }

    public function getIdEmp() {
        return $this->id_emp;
    }

    public function setIdEmp($ie) {
        $this->id_emp = trim($ie);
    }

    public function getIdDpto() {
        return $this->id_dpto;
    }

    public function setIdDpto($id) {
        $this->id_dpto = trim($id);
    }

    public function getNomeUsu() {
        return $this->nome_usu;
    }

    public function setNomeUsu($nu) {
        $this->nome_usu = trim($nu);
    }

    public function getUsernameUsu() {
        return $this->username_usu;
    }

    public function setUsernameUsu($uu) {
        $this->username_usu = trim($uu);
    }

    public function getEmailUsu() {
        return $this->email_usu;
    }

    public function setEmailUsu($eu) {
        $this->email_usu = trim($eu);
    }

    public function getTelefoneUsu() {
        return $this->telefone_usu;
    }

    public function setTelefoneUsu($tu) {
        $this->telefone_usu = trim($tu);
    }

    public function getPerfilUsu() {
        return $this->perfil_usu;
    }

    public function setPerfilUsu($pu) {
        $this->perfil_usu = trim($pu);
    }

    public function getSenhaUsu() {
        return $this->senha_usu;
    }

    public function setSenhaUsu($su) {
        $this->senha_usu = trim($su);
    }

    public function getSituacaoUsu() {
        return $this->situacao_usu;
    }

    public function setSituacaoUsu($su) {
        $this->situacao_usu = trim($su);
    }

    public function getRecuperarSenhaUsu() {
        return $this->recuperar_senha_usu;
    }

    public function setRecuperarSenhaUsu($rsu) {
        $this->recuperar_senha_usu = trim($rsu);
    }
}

interface UsuariosDAO {

    public function addUsuarios(Usuarios $u);

    public function findAll();

    public function findById($id_usu);

    public function findAllAdm();

    public function findAllUsu();

    public function findUsuByEmpId($id_emp);

    public function findByUsernameOrEmail(Usuarios $u);

    public function verifyRowByEmail($email_usu);

    public function verifyRowByUsername($username_usu);

    public function verifyRowByEmpId($id_emp);

    public function updateRecuperarSenha(Usuarios $u);
}
 
?>