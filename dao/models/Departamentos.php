<?php

class Departamentos {
    private $id_dpto;
    private $id_emp;
    private $nome_dpto;
    private $centro_dcusto_dpto;

    public function getIdDpto() {
        return $this->id_dpto;
    }

    public function setIdDpto($id) {
        $this->id_dpto = trim($id);
    }

    public function getIdEmp() {
        return $this->id_emp;
    }

    public function setIdEmp($ie) {
        $this->id_emp = trim($ie);
    }

    public function getNomeDpto() {
        return $this->nome_dpto;
    }

    public function setNomeDpto($nd) {
        $this->nome_dpto = trim($nd);
    }

    public function getCentroDCustoDpto() {
        return $this->centro_dcusto_dpto;
    }

    public function setCentroDCustoDpto($cdcd) {
        $this->centro_dcusto_dpto = trim($cdcd);
    }
}

interface DepartamentosDAO {

    public function addDepartamentos(Departamentos $d);

    public function findAll();

    public function findByIdEmp($id_emp);

    public function verifyRow();

    public function verifyRowByEmpId($id_emp);

    //preciso de 2 parametros para pegar qual empresa o departamento está
    public function verifyRowById($id_dpto);

    public function verifyRowByName($nome_dpto);

    public function deleteDptoById($id_dpto);
    
}

?>
