<?php

class tbMovimentacaoBancariaItem extends MinC_Db_Table_Abstract
{
    protected $_schema   = "SAC";
    protected $_name    = "tbMovimentacaoBancariaItem";

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
        $select->order('dtAberturaConta');
        $select->order('dtMovimento');
        return $this->fetchAll($select);
    }

    /**
     * @access public
     * @param array $dados
     * @return integer (retorna o �ltimo id cadastrado)
     */
    public function cadastrarDados($dados)
    {
        return $this->insert($dados);
    }

    /**
     * @access public
     * @param array $dados
     * @param integer $where
     * @return integer (quantidade de registros alterados)
     */
    public function alterarDados($dados, $where)
    {
        $where = "idMovimentacaoBancariaItem = " . $where;
        return $this->update($dados, $where);
    }

    /**
     * @access public
     * @param integer $where
     * @return integer (quantidade de registros exclu�dos)
     */
    public function excluirDados($where)
    {
        $where = "idMovimentacaoBancariaItem = " . $where;
        return $this->delete($where);
    }
}
