<?php

class tbMovimentacaoBancariaItemxTipoInconsistencia extends MinC_Db_Table_Abstract
{
    protected $_schema  = "SAC";
    protected $_name    = "tbMovimentacaoBancariaItemxTipoInconsistencia";

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
     * @param integer $where
     * @return integer (quantidade de registros exclu�dos)
     */
    public function excluirDados($where)
    {
        $where = "idMovimentacaoBancariaItem = " . $where;
        return $this->delete($where);
    } 
} 
