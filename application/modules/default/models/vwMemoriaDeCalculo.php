<?php

class vwMemoriaDeCalculo extends MinC_Db_Table_Abstract
{

    protected $_schema = 'SAC';
    protected $_name   = 'vwMemoriaDeCalculo';

    public function busca($idPronac)
    {
        $select =  new Zend_Db_Expr("
                SELECT idPronac,PRONAC,ValorProposta,OutrasFontes,ValorSolicitado,
                       Elaboracao,ValorParecer,ValorSugerido
                FROM SAC.dbo.vwMemoriaDeCalculo
                WHERE idPronac = $idPronac ");
        try {
            $db= Zend_Db_Table::getDefaultAdapter();
            $db->setFetchMode(Zend_DB::FETCH_OBJ);
        } catch (Zend_Exception_Db $e) {
            $this->view->message = $e->getMessage();
        }
        return $db->fetchAll($select);
    }
}
