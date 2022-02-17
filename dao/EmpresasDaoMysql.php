<?php

require_once 'models/Empresas.php';

class EmpresasDaoMysql implements EmpresasDAO {

    private $pdo;

    public function __construct(PDO $drivers) {
        $this->pdo = $drivers;
    }

    public function addEmpresas(Empresas $e) {
        $sql = $this->pdo->prepare("INSERT INTO tb_empresas(
        cnpj_emp, razao_social_emp, nome_fantasia_emp, logo_emp, cor_pri_emp, cor_sec_emp, endereco_emp, situacao_emp)
        VALUES
        (:cnpj_emp, :razao_social_emp, :nome_fantasia_emp, :logo_emp, :cor_pri_emp, :cor_sec_emp, :endereco_emp, :situacao_emp)");
        
        $sql->bindValue(":cnpj_emp", $e->getCnpjEmp());
        $sql->bindValue(":razao_social_emp", $e->getRazaoSocialEmp());
        $sql->bindValue(":nome_fantasia_emp", $e->getNomeFantasiaEmp());
        $sql->bindValue(":logo_emp", $e->getLogoEmp());
        $sql->bindValue(":cor_pri_emp", $e->getCorPriEmp());
        $sql->bindValue(":cor_sec_emp", $e->getCorSecEmp());
        $sql->bindValue(":endereco_emp", $e->getEnderecoEmp());
        $sql->bindValue(":situacao_emp", $e->getSituacaoEmp());
        $sql->execute();


        return $e;
    }

    public function findAll() {
        $array = [];

        $sql = $this->pdo->query("SELECT * FROM tb_empresas;");

        if($sql->rowCount() > 0) {
            $data = $sql->fetchAll();
            foreach($data as $item) {
                $e = new Empresas;
                $e->setIdEmp($item['id_emp']);
                $e->setCnpjEmp($item['cnpj_emp']);
                $e->setRazaoSocialEmp($item['razao_social_emp']);
                $e->setNomeFantasiaEmp($item['nome_fantasia_emp']);
                $e->setLogoEmp($item['logo_emp']);
                $e->setCorPriEmp($item['cor_pri_emp']);
                $e->setCorSecEmp($item['cor_sec_emp']);  
                $e->setEnderecoEmp($item['endereco_emp']);
                $e->setSituacaoEmp($item['situacao_emp']);
    
                $array[] = $e;
            }
        }

        
        return $array;
    }

    public function findById($id_emp) {
        $id = $id_emp;

        $sql = $this->pdo->query("SELECT * FROM tb_empresas WHERE id_emp = '".$id."';");

        if($sql->rowCount() > 0) {
            $data  = $sql->fetchAll();
            foreach($data as $item) {
                $e = new Empresas;
                $e->setIdEmp($item['id_emp']);
                $e->setCnpjEmp($item['cnpj_emp']);
                $e->setRazaoSocialEmp($item['razao_social_emp']);
                $e->setNomeFantasiaEmp($item['nome_fantasia_emp']);
                $e->setLogoEmp($item['logo_emp']);
                $e->setCorPriEmp($item['cor_pri_emp']);
                $e->setCorSecEmp($item['cor_sec_emp']);  
                $e->setEnderecoEmp($item['endereco_emp']);
                $e->setSituacaoEmp($item['situacao_emp']);
    
                $array[] = $e;
            }
        }
        return $array;
    }

    public function verifyRow() {
        $sql = $this->pdo->query("SELECT * FROM tb_empresas;");

        return $sql->rowCount() > 0;
    }

    public function verifyRowById($id_emp) {
        $id = $id_emp;

        $sql = $this->pdo->query("SELECT * FROM tb_empresas WHERE id_emp = '".$id."';");

        return $sql->rowCount() > 0;
    }

    public function verifyRowByCnpj($cnpj_emp) {
        $cnpj = $cnpj_emp;

        $sql = $this->pdo->query("SELECT * FROM tb_empresas WHERE cnpj_emp = '".$cnpj."';");

        return $sql->rowCount() > 0;
    }

    public function verifyRowByNomeFantasia($nome_fantasia_emp) {
        $nome_fantasia = $nome_fantasia_emp;
    
        $sql = $this->pdo->query("SELECT * FROM tb_empresas WHERE nome_fantasia_emp = '".$nome_fantasia."';");
    
        return $sql->rowCount() > 0;
    }
    
    public function verifyRowByRazaoSocial($razao_social_emp) {
        $razao_social = $razao_social_emp;
    
        $sql = $this->pdo->query("SELECT * FROM tb_empresas WHERE razao_social_emp = '".$razao_social."';");
    
        return $sql->rowCount() > 0;
    }

    public function deleteEmpById($id_emp) {
        $id = $id_emp;

        $sql = $this->pdo->prepare("DELETE FROM tb_empresas WHERE id_emp = '".$id."';");
        $sql->execute();
        
    }
}

?>