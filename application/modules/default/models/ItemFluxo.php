<?php 

class ItemFluxo extends MinC_Db_Table_Abstract
{
    protected $_schema = 'SAC';
    protected $_name = 'tbTipoItemFluxo';

    public function buscarItensFluxo()
    {
        $select = $this->select();
        $select->setIntegrityCheck(false);
        return $this->fetchAll($select);
    }
}
