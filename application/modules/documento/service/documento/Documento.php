<?php

namespace Application\Modules\Documento\Service\Documento;

use MinC\Servico\IServicoRestZend;

class Documento implements IServicoRestZend
{
    /**
     * @var \Zend_Controller_Request_Abstract $request
     */
    private $request;

    /**
     * @var \Zend_Controller_Response_Abstract $response
     */
    private $response;

    private $fileTypes;

    private $defaultMaxFileSize = 5242880; // 5MB

    private $metadata = [
        'idTipoDocumento' => null,
        'dsDocumento' => '',
        'dtEmissaoDocumento' => null,
        'dtValidadeDocumento' => null,
        'idTipoEventoOrigem' => null,
        'nmTitulo' => ''
    ];

    function __construct($request, $response)
    {
        $this->request = $request;
        $this->response = $response;
        $this->setFileTypes();
    }

    public function setFileTypes(array $fileTypes = [])
    {
        $this->fileTypes = [
            'pdf' => [
                'pdf' => 'application/pdf',
            ],
            'images' => [
                'jpg' => 'image/jpeg',
                'jpeg' => 'image/jpeg',
                'png' =>  'image/png',
            ],
        ];
    }

    public function setMetadata($metadata = [])
    {
        if (!empty($metadata)) {
            foreach($metadata as $key => $value) {
                if (in_array($key, array_keys($this->metadata))) {
                    $this->metadata[$key] = $value;
                }
            }
        }
    }
    
    public function formatBytes($bytes, $precision = 2)
    { 
        $units = ['B', 'KB', 'MB', 'GB', 'TB']; 

        $bytes = max($bytes, 0); 
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024)); 
        $pow = min($pow, count($units) - 1); 

        return round($bytes, $precision) . ' ' . $units[$pow]; 
    }
    
    public function inserir(
        array $params,
        string $fileType,
        array $metadata = null,
        integer $maxFileSize = null
    ) {
         if (!in_array($fileType, array_keys($this->fileTypes))) {
            $errorMessage = "Tipo de arquivo {$fileType} não suportado!";
            throw new \Exception($errorMessage);
        }

        $this->setMetadata($metadata);
        $tbArquivo = new \tbArquivo();
        $tbArquivoImagem = new \tbArquivoImagem();
        $tbDocumento = new \tbDocumento();
        
        $arquivoNome = $params['name'];
        $arquivoTipo = $params['type'];
        $arquivoTemp = $params['tmp_name'];
        $arquivoErro = $params['error'];
        $arquivoTamanho = $params['size'];
        
        $arquivoFormato = preg_split('/\//', $arquivoTipo)[1];
        
        if (!array_search($arquivoTipo, $this->fileTypes[$arquivoFormato])) {
            $errorMessage = "Tipo de arquivo {$fileType} não permitido! Envie somente arquivos do tipo '$fileType'.";
            throw new \Exception($errorMessage);
        }
        
        $idDocumento = null;
        if (!empty($arquivoTemp)) {
            $arquivoExtensao = \Upload::getExtensao($arquivoNome);
            $arquivoBinario = \Upload::setBinario($arquivoTemp);
            $arquivoHash = \Upload::setHash($arquivoTemp);
            
            $maxFileSize = ($maxSize > 0) ? $maxSize : $this->defaultMaxFileSize;
            if ($arquivoTamanho > $maxFileSize) {
                throw new \Exception("O arquivo não pode ser maior do que " . $this->formatBytes($maxFileSize) . "!");
            }
            
            $dadosArquivo = [
                'nmArquivo' => $arquivoNome,
                'sgExtensao' => $arquivoExtensao,
                'dsTipoPadronizado' => $arquivoTipo,
                'nrTamanho' => $arquivoTamanho,
                'dtEnvio' => new \Zend_Db_Expr('GETDATE()'),
                'dsHash' => $arquivoHash,
                'stAtivo' => 'A'
            ];
            $idArquivo = $tbArquivo->inserir($dadosArquivo);

            $dadosBinario = [
                'idArquivo' => $idArquivo,
                'biArquivo' => new \Zend_Db_Expr("CONVERT(varbinary(MAX), {$arquivoBinario})")
            ];
            $idArquivo = $tbArquivoImagem->inserir($dadosBinario);

            $dados = [
                'idTipoDocumento' => $this->metadata['idTipoDocumento'],
                'idArquivo' => $idArquivo,
                'dsDocumento' => $this->metadata['dsDocumento'],
                'dtEmissaoDocumento' => $this->metadata['dtEmissaoDocumento'],
                'dtValidadeDocumento' => $this->metadata['dtValidadeDocumento'],
                'idTipoEventoOrigem' => $this->metadata['idTipoEventoOrigem'],
                'nmTitulo' => $this->metadata['nmTitulo'],
            ];
            
            $documento = $tbDocumento->inserir($dados);
            
            return $documento['idDocumento'];
        }
    }
    
    public function excluir($idDocumento)
    {
        $tbDocumento = new \tbDocumento();
        return $tbDocumento->excluirDocumento($idDocumento);
    }
}
