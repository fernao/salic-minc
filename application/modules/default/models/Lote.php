<?php

class Lote extends MinC_Db_Table_Abstract
{
    protected $_schema = 'SAC';
    protected $_name =  'tbLote';

    public function inserirLote($dados)
    {
        $insert = $this->insert($dados);
        return $insert;
    }
}
