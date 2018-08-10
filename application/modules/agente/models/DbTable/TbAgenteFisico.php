<?php

class Agente_Model_DbTable_TbAgenteFisico extends MinC_Db_Table_Abstract
{

    /**
     * _name
     *
     * @var bool
     * @access protected
     */
    protected $_name = 'tbAgenteFisico';

    /**
     * _schema
     *
     * @var string
     * @access protected
     */
    protected $_schema = 'agentes';



    /**
     * M�todo para cadastrar
     * @access public
     * @param array $dados
     * @return integer (retorna o �ltimo id cadastrado)
     */
    public function cadastrarDados($dados)
    {
        return $this->insert($dados);
    } // fecha m�todo cadastrarDados()


    /**
     * M�todo para alterar
     * @access public
     * @param array $dados
     * @param integer $where
     * @return integer (quantidade de registros alterados)
     */
    public function alterarDados($dados, $where)
    {
        $where = "idAgente = " . $where;
        return $this->update($dados, $where);
    } // fecha m�todo alterarDados()
} // fecha class
