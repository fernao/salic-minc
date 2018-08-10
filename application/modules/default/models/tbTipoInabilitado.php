<?php

class tbTipoInabilitado extends MinC_Db_Table_Abstract
{
    protected $_name   = 'tbTipoInabilitado';
    protected $_schema = 'SAC';


    public function cadastrarinabilitacao($data)
    {
        $insert = $this->insert($data);
        return $insert;
    }
}
