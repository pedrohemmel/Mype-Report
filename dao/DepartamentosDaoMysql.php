<?php

require 'models/Departamentos.php';

class DepartamentosDaoMysql implements DepartamentosDAO {

    private $pdo;

    public function __construct(PDO $drivers) {
        $this->pdo = $drivers;
    }

    public function addDepartamentos(Departamentos $d) {
        $sql = $this->pdo->prepare("INSERT INTO tb_departamentos(
            id_emp, nome_dpto, centro_dcusto_dpto)
            VALUES
            (:id_emp, :nome_dpto, :centro_dcusto_dpto);");
            
        $sql->bindValue(":id_emp", $d->getIdEmp());
        $sql->bindValue(":nome_dpto", $d->getNomeDpto());
        $sql->bindValue(":centro_dcusto_dpto", $d->getCentroDCustoDpto());
        $sql->execute();


        return $d;
    }

    public function findAll() {
        
    }

    public function findByIdEmp($id_emp) {
        $id = $id_emp;

        $sql = $this->pdo->query("SELECT * FROM tb_departamentos WHERE id_emp = '".$id."';");

        if($sql->rowCount() > 0) {
            $data  = $sql->fetchAll();
            foreach($data as $item) {
                $d = new Departamentos;
                $d->setIdDpto($item['id_dpto']);
                $d->setIdEmp($item['id_emp']);
                $d->setNomeDpto($item['nome_dpto']);
                $d->setCentroDCustoDpto($item['centro_dcusto_dpto']);
                
    
                $array[] = $d;
            }
        }
        return $array;
    }

    public function verifyRowByEmpId($id_emp) {
        $id = $id_emp;

        $sql = $this->pdo->query("SELECT * FROM tb_departamentos WHERE id_emp = '".$id."';");

        return $sql->rowCount() > 0;
    }

    //preciso de 2 parametros para pegar qual empresa o departamento está
    public function verifyRowById($id_dpto) {
        $id = $id_dpto;
        $sql = $this->pdo->query("SELECT * FROM tb_departamentos WHERE id_dpto = '".$id."';");

        return $sql->rowCount() > 0;
    }

    
    public function verifyRowByName($nome_dpto) {
        $nome = $nome_dpto;

        $sql = $this->pdo->query("SELECT * FROM tb_departamentos WHERE nome_dpto = '".$nome."';");

        return $sql->rowCount() > 0;
    }
   

    public function deleteDptoById($id_dpto) {
        $id = $id_dpto;

        $sql = $this->pdo->query("DELETE FROM tb_departamentos WHERE id_dpto = '".$id."';");

        $sql->execute();
    }

}

?>
