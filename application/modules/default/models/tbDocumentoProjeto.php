<?php
class tbDocumentoProjeto extends MinC_Db_Table_Abstract
{
    protected $_schema  = "BDCORPORATIVO";
    protected $_name   = "tbDocumentoProjeto";

    public function excluir($where)
    {
        return $this->delete($where);
    }
}
