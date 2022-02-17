<?php

require_once 'models/Departamentos.php';

class DepartamentosDaoMysql implements DepartamentosDAO {

    private $pdo;

    public function __construct(PDO $drivers) {
        $this->pdo = $drivers;
    }

}

?>