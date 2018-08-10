<?php

class Dbf extends MinC_Db_Table_Abstract
{
    protected $_schema  = "SAC";
    protected $_name    = "Dbf";



    /**
     * M�todo para ignorar a aus�ncia da chave prim�ria
     */
    public function _setupPrimaryKey()
    {
        $this->_primary = "";
    }



    /**
     * M�todo para buscar as informa��es do arquivo DBF
     * @access public
     * @param void
     * @return object
     */
    public function buscarInformacoes()
    {
        $select = $this->select();
        $select->setIntegrityCheck(false);
        $select->from(array($this->_name), array("Informacao"));
        $select->order("Informacao ASC");
        return $this->fetchAll($select);
    } // fecha m�todo buscarInformacoes()
} // fecha class
