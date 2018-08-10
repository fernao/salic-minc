<?php

class tbTipoDocumento extends MinC_Db_Table_Abstract
{
    protected $_schema  = "SAC";
    protected $_name    = "tbTipoDocumento";


    /**
     * @access public
     * @param array $dados
     * @param integer $where
     * @return integer (quantidade de registros alterados)
     */
    public function consultarDados($idTipoDocumento = null)
    {
        $select = $this->select();
        $select->setIntegrityCheck(false);
        $select->from(
                array('T' => $this->_name)
        );
        if ($idTipoDocumento) {
            $select->where('T.idTipoDocumento = ?', $idTipoDocumento);
        }
        $select->where('T.stEstado = ?', 1);
        $select->order('T.dsTipoDocumento');

        return $this->fetchAll($select);
    }
}
