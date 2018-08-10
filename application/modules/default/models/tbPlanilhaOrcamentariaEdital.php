<?php

class tbPlanilhaOrcamentariaEdital extends MinC_Db_Table_Abstract
{
    protected $_schema  = "SAC";
    protected $_name    = 'tbPlanilhaOrcamentariaEdital';


    public function buscarPlanilhaIdCategoria($idCategoria)
    {
        $select = $this->select();
        $select->setIntegrityCheck(false);
        $select->where('idCategoria = ?', $idCategoria);
        return $this->fetchRow($select);
    }
}
