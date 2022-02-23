<?php

class UsuarioAdministrador {
    private $id_adm;
    private $nome_adm;
    private $username_adm;
    private $email_adm;
    private $email_adm_ctt;
    private $telefone_adm;
    private $telefone_adm_sub;
    private $senha_adm;

    public function getIdAdm() {
        return $this->id_adm;
    }

    public function setIdAdm($ia) {
        $this->id_adm = trim($ia);
    }

    public function getNomeAdm() {
        return $this->nome_adm;
    }

    public function setNomeAdm($na) {
        $this->nome_adm = trim($na);
    }
    public function getUsernameAdm() {
        return $this->username_adm;
    }

    public function setUserNameAdm($ua) {
        $this->username_adm = trim($ua);
    }

    public function getEmailAdm() {
        return $this->email_adm;
    }

    public function setEmailAdm($ea) {
        $this->email_adm = trim($ea);
    }

    public function getEmailAdmCtt() {
        return $this->email_adm_ctt;
    }

    public function setEmailAdmCtt($eac) {
        $this->email_adm_ctt = trim($eac);
    }

    public function getTelefoneAdm() {
        return $this->telefone_adm;
    }

    public function setTelefoneAdm($ta) {
        $this->telefone_adm = trim($ta);
    }

    public function getTelefoneAdmSub() {
        return $this->telefone_adm_sub;
    }

    public function setTelefoneAdmSub($tas) {
        $this->telefone_adm_sub = trim($tas);
    }

    public function getSenhaAdm() {
        return $this->senha_adm;
    }

    public function setSenhaAdm($sa) {
        $this->senha_adm = trim($sa);
    }
}

interface UsuarioAdministradorDAO {

    public function add(UsuarioAdministrador $ua);

    public function findAll();

    public function findByUsernameOrEmail(UsuarioAdministrador $ua);

    public function verifyRow();

    public function verifyRowByEmail($email_adm);

    public function verifyRowByUsername($username_adm);
}

?>