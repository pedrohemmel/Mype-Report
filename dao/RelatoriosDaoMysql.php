<?php

require_once 'models/Relatorios.php';

class RelatoriosDaoMysql implements RelatoriosDAO {

    private $pdo;

    public function __construct(PDO $drivers) {
        $this->pdo = $drivers;
    }

}

?>