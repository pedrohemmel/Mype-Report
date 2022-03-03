<?php

require_once 'models/Relatorios.php';

class RelatoriosDaoMysql implements RelatoriosDAO {

    private $pdo;

    public function __construct(PDO $drivers) {
        $this->pdo = $drivers;
    }

    public function addRelatorios(Relatorios $r) {
        $sql = $this->pdo->prepare("INSERT INTO tb_relatorios(
            id_emp, nome_rel, link_rel, situacao_rel)
            VALUES
            (:id_emp, :nome_rel, :link_rel, :situacao_rel);");
            
        $sql->bindValue(":id_emp", $r->getIdEmp());
        $sql->bindValue(":nome_rel", $r->getNomeRel());
        $sql->bindValue(":link_rel", $r->getLinkRel());
        $sql->bindValue(":situacao_rel", $r->getSituacaoRel());
        $sql->execute();


        return $r;
    }

    public function findByEmpId($id_emp) {
        $id = $id_emp;

        $sql = $this->pdo->query("SELECT * FROM tb_relatorios WHERE id_emp = '".$id."';");

        if($sql->rowCount() > 0) {
            $data  = $sql->fetchAll();
            foreach($data as $item) {
                $r = new Relatorios;
                $r->setIdRel($item['id_rel']);
                $r->setIdEmp($item['id_emp']);
                $r->setNomeRel($item['nome_rel']);
                $r->setLinkRel($item['link_rel']);
                $r->setSituacaoRel($item['situacao_rel']);
                
    
                $array[] = $r;
            }
        }
        return $array;
    }

    public function verifyRowByEmpId($id_emp) {
        $id = $id_emp;

        $sql = $this->pdo->query("SELECT * FROM tb_relatorios WHERE id_emp = '".$id."';");

        return $sql->rowCount() > 0;
    }

    public function verifyRowByLinkRel($link_rel) {
        $link = $link_rel;

        $sql = $this->pdo->query("SELECT * FROM tb_relatorios WHERE link_rel = '".$link."';");

        return $sql->rowCount() > 0;
    }
}

?>