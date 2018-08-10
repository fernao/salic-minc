<?php

class tbTipoInconsistencia extends MinC_Db_Table_Abstract
{
    protected $_schema  = "SAC";
    protected $_name    = "tbTipoInconsistencia";
    protected $_primary = "idTipoInconsistencia";

    /**
     * @access public
     * @param void
     * @return object/array
     */
    public function buscarDados()
    {
        $select = $this->select();
        $select->setIntegrityCheck(false);
        $select->from($this);
        $select->order('idTipoInconsistencia');
        return $this->fetchAll($select);
    }
}
