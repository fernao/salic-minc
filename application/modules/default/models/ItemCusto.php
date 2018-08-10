<?php

class ItemCusto extends MinC_Db_Table_Abstract
{
    protected $_name    = 'tbItemCusto';
    protected $_schema  = 'BDCORPORATIVO';

    public function inserirItemCusto($data)
    {
        $insert = $this->insert($data);
        return $insert;
    }

    public function alterarItemCusto($data, $where)
    {
        $update = $this->update($data, $where);
        return $update;
    }

    public function deletarItemCusto($where)
    {
        $delete = $this->delete($where);
        return $delete;
    }
}
