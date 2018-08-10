<?php

class tbDepositoIdentificadoCaptacao extends MinC_Db_Table_Abstract
{
    protected $_schema  = "SAC";
    protected $_name    = "tbDepositoIdentificadoCaptacao";

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
     * Executa a Procedure spDepositoIdentificadoCaptacao
     * @access public
     * @return null
     */
    public function DepositoIdentificadoCaptacao()
    {
        $sql ="exec SAC.dbo.spDepositoIdentificadoCaptacao";

        $db = Zend_Db_Table::getDefaultAdapter();
        $db->setFetchMode(Zend_DB :: FETCH_OBJ);

        return $db->query($sql);
    }
}
