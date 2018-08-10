<?php

class Mecanismo extends MinC_Db_Table_Abstract
{
    protected $_name    = 'Mecanismo';
    protected $_schema  = 'SAC';

    const INCENTIVO_FISCAL = 109;

    public function buscarMecanismo()
    {
        // criando objeto do tipo select
        $slct = $this->select();
        $slct->setIntegrityCheck(false);
        $slct->from(array('mec' => $this->_name), array('*'));
        return $this->fetchAll($slct);
    }

    public function obterLabelMecanismo($id)
    {
        switch ($id) {
            case 1:
                $mecanismo = "Mecenato";
                break;
            case 2:
                $mecanismo = "FNC";
                break;
            case 6:
                $mecanismo = "Recurso do Tesouro";
                break;
            default:
                $mecanismo = "Outro";
                break;
        }

        return $mecanismo;
    }
}
