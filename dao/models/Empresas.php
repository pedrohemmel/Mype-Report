<?php

class Empresas {
    private $id_emp;
    private $cnpj_emp;
    private $razao_social_emp;
    private $nome_fantasia_emp;
    private $logo_emp;
    private $cor_pri_emp;
    private $cor_sec_emp;
    private $endereco_emp;
    private $situacao_emp;

    public function getIdEmp() {
        return $this->id_emp;
    }

    public function setIdEmp($ie) {
        $this->id_emp = trim($ie);
    }

    public function getCnpjEmp() {
        return $this->cnpj_emp;
    }

    public function setCnpjEmp($ce) {
        $this->cnpj_emp = trim($ce);
    }

    public function getRazaoSocialEmp() {
        return $this->razao_social_emp;
    }

    public function setRazaoSocialEmp($rse) {
        $this->razao_social_emp = trim($rse);
    }

    public function getNomeFantasiaEmp() {
        return $this->nome_fantasia_emp;
    }

    public function setNomeFantasiaEmp($nfe) {
        $this->nome_fantasia_emp = trim($nfe);
    }

    public function getLogoEmp() {
        return $this->logo_emp;
    }

    public function setLogoEmp($le) {
        $this->logo_emp = trim($le);
    }

    public function getCorPriEmp() {
        return $this->cor_pri_emp;
    }

    public function setCorPriEmp($cpe) {
        $this->cor_pri_emp = trim($cpe);
    }

    public function getCorSecEmp() {
        return $this->cor_sec_emp;
    }

    public function setCorSecEmp($cse) {
        $this->cor_sec_emp = trim($cse);
    }

    public function getEnderecoEmp() {
        return $this->endereco_emp;
    }

    public function setEnderecoEmp($ee) {
        $this->endereco_emp = trim($ee);
    }

    public function getSituacaoEmp() {
        return $this->situacao_emp;
    }

    public function setSituacaoEmp($se) {
        $this->situacao_emp = trim($se);
    }
}

interface EmpresasDAO {
    public function addEmpresas(Empresas $e);

    public function findAll();

    public function findById($id_emp);

    public function verifyRow();

    public function verifyRowById($id_emp);

    public function verifyRowByCnpj($cnpj_emp);

    public function verifyRowByNomeFantasia($nome_fantasia_emp);

    public function verifyRowByRazaoSocial($razao_social_emp);

    public function updateEmpresas(Empresas $e);

    public function deleteEmpById($id_emp);
}

?>