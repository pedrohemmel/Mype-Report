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
        
        $sql->bindValue(":id_rel", $r->getIdRel());
        $sql->bindValue(":id_usu", $r->getIdUsu());
        $sql->execute();


        return $i;
    }

    
}

?>