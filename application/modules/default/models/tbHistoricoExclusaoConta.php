<?php

class tbHistoricoExclusaoConta extends MinC_Db_Table_Abstract
{
    protected $_schema = "SAC";
    protected $_name   = "tbHistoricoExclusaoConta";

    /**
     * @access public
     * @param array $dados
     * @return integer (retorna o �ltimo id cadastrado)
     */
    public function cadastrarDados($dados)
    {
        return $this->insert($dados);
    }
}
