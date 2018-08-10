<?php 

class NovoEdital extends MinC_Db_Table_Abstract
{
    protected $_schema = 'SAC';
    protected $_name = 'tbEdital';

    
    public function buscarEdital()
    {
    }
    
    public function alterarEdital()
    {
    }
    
    public function salvarEdital($dados)
    {
        $insert = $this->insert($dados);
        return $insert;
    }
    
    public function salvarFluxoEdital($dados)
    {
        $insert = $this->insert($dados);
        return $insert;
    }
    
    public function salvardadosgerais($dados, $where)
    {
        $update = $this->update($dados, $where);
        return $update;
    }
    
    public function excluirEdital()
    {
    }
    
    public function buscarIdTipoEdital($idEdital)
    {
        $select = $this->select()
                ->setIntegrityCheck(false)
                ->from('tbEdital', array('idTpEdital'))
                ->where('idEdital = ?', $idEdital);
        return $this->fetchRow($select);
    }
}
