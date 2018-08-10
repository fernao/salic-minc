<?php 

class TipoPremiacao extends MinC_Db_Table_Abstract
{
    protected $_schema = 'SAC';
    protected $_name = 'tbTipoPremiacao';

    /*
     * Metodo: buscarTipoPremiacao
     * Entrada: void
     * Saida: Array de Tipos de Premia��es
    */
    public function buscarTipoPremiacao()
    {
        $select = $this->select();
        $select->setIntegrityCheck(false);
        return $this->fetchAll($select);
    }
}
