<?php

class tbPlanilhaItemPlanilhaEtapa extends MinC_Db_Table_Abstract
{
    protected $_schema  = "SAC";
    protected $_name    = 'tbPlanilhaItemPlanilhaEtapa';

    
    public function buscarEtapaItensPorPlanilhaOrc($idPlanOrcamentaria)
    {
        $slct = $this->select();
        $slct->setIntegrityCheck(false);
        $slct->where('idPlanOrcEdital = ?', $idPlanOrcamentaria);
        return $this->fetchAll($slct);
    }
    
    public function salvarPlanilhaEtapaPlanilhaItem($dadosPlanilhaItemPlanilhaEtapa)
    {
        return $this->insert($dadosPlanilhaItemPlanilhaEtapa);
    }
}
