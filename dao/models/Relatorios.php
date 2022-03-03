<?php

class Relatorios {
    private $id_rel;
    private $id_emp;
    private $nome_rel;
    private $link_rel;
    private $situacao_rel;

    public function getIdRel() {
        return $this->$id_rel;
    }

    public function setIdRel($ir) {
        $this->$id_rel = trim($ir);
    }

    public function getIdEmp() {
        return $this->$id_emp;
    }

    public function setIdEmp($ie) {
        $this->$id_emp = trim($ie);
    }

    public function getNomeRel() {
        return $this->$nome_rel;
    }

    public function setNomeRel($nr) {
        $this->$nome_rel = trim($nr);
    }

    public function getLinkRel() {
        return $this->$link_rel;
    }

    public function setLinkRel($lr) {
        $this->$link_rel = trim($lr);
    }

    public function getSituacaoRel() {
        return $this->$situacao_rel;
    }

    public function setSituacaoRel($sr) {
        $this->$situacao_rel = trim($sr);
    }
}

interface RelatoriosDAO {

    public function addRelatorios(Relatorios $r);

    public function findByEmpId($id_emp);

    public function verifyRowByEmpId($id_emp);

    public function verifyRowByLinkRel($link_rel);
}

?>