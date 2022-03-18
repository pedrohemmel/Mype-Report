<?php

require_once 'models/Indicadores.php';

class IndicadoresDaoMysql implements IndicadoresDAO {

    private $pdo;

    public function __construct(PDO $drivers) {
        $this->pdo = $drivers;
    }

    public function addIndicadores(Indicadores $i) {
        $sql = $this->pdo->prepare("INSERT INTO tb_indicadores(
            id_rel, id_usu)
            VALUES
            (:id_rel, :id_usu);");
        
        $sql->bindValue(":id_rel", $i->getIdRel());
        $sql->bindValue(":id_usu", $i->getIdUsu());
        $sql->execute();


        return $i;
    }

    public function findByRelId($id_rel) {
        $id = $id_rel;

        $sql = $this->pdo->query("SELECT * FROM tb_indicadores WHERE id_rel = '".$id."';");

        if($sql->rowCount() > 0) {
            $data = $sql->fetchAll();
            foreach($data as $item) {
                $i = new Indicadores;
                $i->setIdInd($item['id_ind']);
                $i->setIdRel($item['id_rel']);
                $i->setIdUsu($item['id_usu']);
                
                $array[] = $i;
            }
        }
        return $array;
    }

    public function verifyRowByUsuId($id_usu) {
        $id = $id_usu;

        $sql = $this->pdo->query("SELECT * FROM tb_indicadores WHERE id_usu = '".$id."';");

        return $sql->rowCount() > 0;
    }

    public function verifyRowByRelId($id_rel) {
        $id = $id_rel;

        $sql = $this->pdo->query("SELECT * FROM tb_indicadores WHERE id_rel = '".$id."';");

        return $sql->rowCount() > 0;
    }
    
}

?>