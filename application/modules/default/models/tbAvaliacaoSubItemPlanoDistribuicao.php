<?php

class tbAvaliacaoSubItemPlanoDistribuicao extends MinC_Db_Table_Abstract
{
    protected $_schema  = "BDCORPORATIVO";
    protected $_name    = "tbAvaliacaoSubItemPlanoDistribuicao";

    public function buscarAvaliacao($idPlano, $idAvaliacao)
    {
        $select = $this->select();
        $select->setIntegrityCheck(false);
        $select->from(
            array('a' => $this->_schema .'.'. $this->_name),
            array()
        );
        $select->joinInner(
            array('b' => 'tbAvaliacaoSubItemPedidoAlteracao'),
            'a.idAvaliacaoSubItemPedidoAlteracao = b.idAvaliacaoSubItemPedidoAlteracao',
            array('b.idAvaliacaoSubItemPedidoAlteracao as idAvaliacaoSubItem', 'b.stAvaliacaoSubItemPedidoAlteracao as avaliacao', 'b.dsAvaliacaoSubItemPedidoAlteracao as descricao'),
            'BDCORPORATIVO.scSAC'
        );
        $select->where('a.idPlano = ?', $idPlano);
        $select->where('b.idAvaliacaoItemPedidoAlteracao = ?', $idAvaliacao);

        return $this->fetchRow($select);
    }
}
