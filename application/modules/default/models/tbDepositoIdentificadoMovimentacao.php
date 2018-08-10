<?php

class tbDepositoIdentificadoMovimentacao extends MinC_Db_Table_Abstract
{
    protected $_schema  = "SAC";
    protected $_name    = "tbDepositoIdentificadoMovimentacao";


    /**
     * M�todo para cadastrar
     * @access public
     * @param array $dados
     * @return integer (retorna o �ltimo id cadastrado)
     */
    public function cadastrarDados($dados)
    {
        return $this->insert($dados);
    }
        
        
        
    /**
     * Executa a Procedure spDepositoIdentificadoMovimentacao
     * @access public
     * @return null
     */
    public function DepositoIdentificadoMovimentacao()
    {
        $sql ="exec SAC.dbo.spDepositoIdentificadoMovimentacao";
            
        $db = Zend_Db_Table::getDefaultAdapter();
        $db->setFetchMode(Zend_DB :: FETCH_OBJ);

        return $db->query($sql);
    }
}
