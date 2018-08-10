<?php

class vwAnexarDocumentoAgente extends MinC_Db_Table_Abstract
{

    protected $_schema = 'SAC';
    protected $_name   = 'vwAnexarDocumentoAgente';
    protected $_primary = 'idArquivo';


    public function excluirArquivo($arquivo)
    {
        $where = "idArquivo = " . $arquivo;
        return $this->delete($where);
    }

    public function inserirUploads($dados)
    {
        $name                   = $dados['nmArquivo'];
        $fileType               = $dados['sgExtensao'];
        $nrTamanho              = $dados['nrTamanho']; // Null
        $stAtivo                = $dados['stAtivo'];
        $biArquivo              = $dados['biArquivo'];
        $idTipoDocumento        = $dados['idTipoDocumento']; // 36 RPA
        $dsDocumento            = $dados['dsDocumento']; // Null
        $idAgente               = $dados['idAgente'];
        $stAtivoDocumentoAgente = $dados['stAtivoDocumentoAgente'];

        $sql = "INSERT INTO ".$this->_schema.".".$this->_name.
               "(nmArquivo, sgExtensao, nrTamanho, dtEnvio, stAtivo, biArquivo, idTipoDocumento, dsDocumento, idAgente, stAtivoDocumentoAgente) " .
               "VALUES ('$name', '$fileType', '$nrTamanho', GETDATE(), '$stAtivo', $biArquivo, $idTipoDocumento, '$dsDocumento', $idAgente, $stAtivoDocumentoAgente)";

        $db = Zend_Db_Table::getDefaultAdapter();
        $db->setFetchMode(Zend_DB::FETCH_OBJ);
        return $db->query($sql);
    }
}
