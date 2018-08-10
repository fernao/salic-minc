<?php
class tbOrgaos extends MinC_Db_Table_Abstract
{
    protected $_schema = "TABELAS";
    protected $_name   = "Orgaos";

    public function orgaosXprojetos($idOrgao)
    {
        $select = $this->select();
        $select->setIntegrityCheck(false);
        $select->from(
                array('oxp'=>'dbo.Orgaos'),
                array('org_superior')
        );
        $select->where('oxp.org_codigo = ?', $idOrgao);

        return $this->fetchAll($select);
    }
}
