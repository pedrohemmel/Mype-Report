<?php

require 'models/Departamentos.php';

class DepartamentosDaoMysql implements DepartamentosDAO {

    private $pdo;

    public function __construct(PDO $drivers) {
        $this->pdo = $drivers;
    }

    public function addDepartamentos(Departamentos $d) {
        $sql = $this->pdo->prepare("INSERT INTO tb_empresas(
            id_emp, nome_dpto, centro_dcusto_dpto)
            VALUES
            (:id_emp, :nome_dpto, :centro_dcusto_dpto)");
            
        $sql->bindValue(":id_emp", $e->getIdEmp());
        $sql->bindValue(":nome_dpto", $e->getNomeDpto());
        $sql->bindValue(":centro_dcusto_dpto", $e->getCentroDCustoDpto());
        $sql->execute();


        return $d;
    }

    public function findAll() {
        
    }

    public function verifyRowByEmpId($id_emp) {
        $id = $id_emp;

        $sql = $this->pdo->query("SELECT * FROM tb_departamentos WHERE id_dpto = '".$id."';");

        return $sql->rowCount() > 0;
    }

    //preciso de 2 parametros para pegar qual empresa o departamento está
    public function verifyRowById(Departamentos $d) {

    }

    

   

    

}

?>
