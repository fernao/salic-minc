<?php

class vwAnexarComprovantes extends MinC_Db_Table_Abstract
{

    protected $_schema = 'SAC';
    protected $_name   = 'vwAnexarComprovantes';

    public function excluirArquivo($idArquivo)
    {
        $where = "idArquivo = " . $idArquivo;
        return $this->delete($where);
    }
}
