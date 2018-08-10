<?php 

class tbEditalComposicao extends MinC_Db_Table_Abstract
{
    protected $_schema = 'SAC';
    protected $_name = 'tbEditalComposicao';

    /*
     * Metodo: buscarComposicaoEdital
     * Entrada: void
     * Saida: Array de Composi��es
    */
    public function buscarComposicaoEdital()
    {
        $select = $this->select();
        $select->setIntegrityCheck(false);
        return $this->fetchAll($select);
    }
    
    
    public function salvarEditalComposicao($dados)
    {
        $insert = $this->insert($dados);
        return $insert;
    }
}
