<?php

class tbAgenteRelatorio extends MinC_Db_Table_Abstract
{
    protected $_schema = "SAC";
    protected $_name   = "tbAgenteRelatorio";

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
        $where = "idAgenteRelatorio = " . $where;
        return $this->update($dados, $where);
    }
}
