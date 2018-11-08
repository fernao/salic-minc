<?php

namespace Application\Modules\Projeto\Service\HistoricoEncaminhamento;

use Seguranca;

class HistoricoEncaminhamento implements \MinC\Servico\IServicoRestZend
{
    /**
     * @var \Zend_Controller_Request_Abstract $request
     */
    private $request;

    /**
     * @var \Zend_Controller_Response_Abstract $response
     */
    private $response;

    function __construct($request, $response)
    {
        $this->request = $request;
        $this->response = $response;
    }

    public function buscarHistoricoEncaminhamento()
    {
        $idPronac = $this->request->idPronac;

        if (strlen($idPronac) > 7) {
            $idPronac = Seguranca::dencrypt($idPronac);
        }

        if (!empty($idPronac)) {
            //****** Dados do Projeto - Cabecalho *****//
            $projetos = new \Projetos();
            $DadosProjeto = $projetos->dadosProjeto(array('idPronac = ?' => $idPronac))->current();

            $tbDistribuirParecer = new \tbDistribuirParecer();
            $historicoEncaminhamento = $tbDistribuirParecer->buscarHistoricoEncaminhamento(array('a.idPRONAC = ?'=>$idPronac));
        }
        $resultArray = [];

        $Encaminhamentos = $this->montaArrayHistoricoEncaminhamento($historicoEncaminhamento);

        $resultArray['Encaminhamentos'] = $Encaminhamentos;

        $resultArray = \TratarArray::utf8EncodeArray($resultArray);

        return $resultArray;
    }

    private function montaArrayHistoricoEncaminhamento($historicoEncaminhamento) {
        $result = [];

        foreach ($historicoEncaminhamento as $item) {
            $produto = $item['Produto'];
            $unidade = $item['Unidade'];
            $observacao = $item['Observacao'];
            $objDateTimeDtEnvio = new \DateTime($item['DtEnvio']);
            $objDateTimeDtRetorno = new \DateTime($item['DtRetorno']);

            $result[] = [
                'Produto' => $produto,
                'Unidade' => $unidade,
                'Observacao' => $observacao,
                'DtEnvio' => $objDateTimeDtEnvio->format('d/m/Y H:i:s'),
                'DtRetorno' => $objDateTimeDtRetorno->format('d/m/Y H:i:s'),
                'qtDias' => $item['qtDias']
            ];

        }
        return $result;
    }

}
