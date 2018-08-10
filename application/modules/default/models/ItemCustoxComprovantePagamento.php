<?php

class ItemCustoxComprovantePagamento extends MinC_Db_Table_Abstract
{
    protected $_name    = 'tbItemCustoxComprovantePagamento';
    protected $_schema  = 'BDCORPORATIVO';

    public function inserirItemCustoxComprovantePagamento($data)
    {
        $insert = $this->insert($data);
        return $insert;
    }

    public function alterarItemCustoxComprovantePagamento($data, $where)
    {
        $update = $this->update($data, $where);
        return $update;
    }

    public function deletarItemCustoxComprovantePagamento($where)
    {
        $delete = $this->delete($where);
        return $delete;
    }
}
