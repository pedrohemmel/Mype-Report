<?php

class Indicadores {
    private $id_ind;
    private $id_rel;
    private $id_usu;

    public function getIdInd() {
        return $this->id_ind;
    }

    public function setIdInd($ii) {
        $this->id_ind = trim($ii);
    }

    public function getIdRel() {
        return $this->id_rel;
    }

    public function setIdRel($ir) {
        $this->id_rel = trim($ir);
    }

    public function getIdUsu() {
        return $this->id_usu;
    }

    public function setIdUsu($iu) {
        $this->id_usu = trim($iu);
    }

  
}

interface IndicadoresDAO {
    public function addIndicadores(Indicadores $i);
}

?>