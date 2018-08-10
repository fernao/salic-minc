<?php 

class Fluxo extends MinC_Db_Table_Abstract
{
    protected $_schema = 'SAC';
    protected $_name = 'tbFluxo';

    /*
     * Metodo: buscarFluxo
     * Entrada: void
     * Saida: Array de Fluxos
    */
    public function buscarFluxo()
    {
        $select = $this->select();
        $select->setIntegrityCheck(false);
        return $this->fetchAll($select);
    }
}
