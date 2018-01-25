<?php

class Admissibilidade_EnquadramentoPropostaController extends MinC_Controller_Action_Abstract
{
    public function init()
    {
        parent::perfil();
        parent::init();
        $this->auth = Zend_Auth::getInstance();
        $this->grupoAtivo = new Zend_Session_Namespace('GrupoAtivo');
    }

    public function indexAction()
    {
        $this->redirect("/admissibilidade/enquadramento-proposta/gerenciar-enquadramento");
    }

    public function sugerirEnquadramentoAction()
    {
        try {
            $get = $this->getRequest()->getParams();
            if (!isset($get['id_preprojeto']) || empty($get['id_preprojeto'])) {
                throw new Exception("Identificador da proposta não informado.");
            }
            $this->view->id_preprojeto = $get['id_preprojeto'];

            $preProjetoDbTable = new Proposta_Model_DbTable_PreProjeto();
            $preprojeto = $preProjetoDbTable->findBy(array('idPreProjeto' => $this->view->id_preprojeto));

            if (!$preprojeto) {
                throw new Exception("Proposta não encontrada.");
            }

            $post = $this->getRequest()->getPost();
            if (!$post['id_area']
                || $post['id_segmento']
                || $post['descricao_motivacao']
            ) {
                $this->carregardadosEnquadramentoProposta($preprojeto);
            } else {
                $this->salvarSugestaoEnquadramento();
            }
        } catch (Exception $objException) {
            parent::message($objException->getMessage(), '/admissibilidade/enquadramento/gerenciar-enquadramento');
        }
    }

    private function salvarSugestaoEnquadramento()
    {
        try {
            $post = $this->getRequest()->getPost();
            $observacao = trim($post['descricao_motivacao']);
            if (empty($observacao)) {
                throw new Exception("O campo 'Parecer de Enquadramento' é de preenchimento obrigatório.");
            }

            $get = $this->getRequest()->getParams();

            $this->view->id_perfil_usuario = $this->grupoAtivo->codGrupo;
            $this->view->id_orgao = $this->grupoAtivo->codOrgao;
            $this->view->id_usuario_avaliador = $this->auth->getIdentity()->usu_codigo;


            $objEnquadramento = new Admissibilidade_Model_DbTable_SugestaoEnquadramento();

            $arrayArmazenamentoEnquadramento = array(
                'id_preprojeto' => $get['id_preprojeto'],
                'id_orgao' => $this->grupoAtivo->codOrgao,
                'id_perfil_usuario' => $this->grupoAtivo->codGrupo,
                'id_usuario_avaliador' => $this->auth->getIdentity()->usu_codigo,
                'id_area' => $post['id_area'],
                'id_segmento' => $post['id_segmento'],
                'descricao_motivacao' => $post['descricao_motivacao'],
                'data_avaliacao' => $objEnquadramento->getExpressionDate(),
            );


            $arrayDadosEnquadramento = $objEnquadramento->findBy(
                [
                    'id_preprojeto' => $get['id_preprojeto'],
                    'id_orgao' => $this->grupoAtivo->codOrgao,
                    'id_perfil_usuario' => $this->grupoAtivo->codGrupo,
                    'id_usuario_avaliador' => $this->auth->getIdentity()->usu_codigo
                ]
            );

            if (count($arrayDadosEnquadramento) < 1) {
                $objEnquadramento->inserir($arrayArmazenamentoEnquadramento);
            } else {
                $objEnquadramento->update($arrayArmazenamentoEnquadramento, [
                    'id_sugestao_enquadramento = ?' => $arrayDadosEnquadramento['id_sugestao_enquadramento']
                ]);
            }

            parent::message('Enquadramento armazenado com sucesso!', "/admissibilidade/admissibilidade/exibirpropostacultural?idPreProjeto={$get['id_preprojeto']}&realizar_analise=sim", 'CONFIRM');
        } catch (Exception $objException) {
            parent::message($objException->getMessage(), "/admissibilidade/enquadramento-proposta/sugerir-enquadramento?id_preprojeto={$get['id_preprojeto']}");
        }
    }

    private function carregardadosEnquadramentoProposta(array $preprojeto)
    {
        $mapperArea = new Agente_Model_AreaMapper();
        $this->view->comboareasculturais = $mapperArea->fetchPairs('Codigo', 'Descricao');
        $this->view->preprojeto = $preprojeto;

        if (count($this->view->comboareasculturais) < 1) {
            throw new Exception("N&atilde;o foram encontradas &Aacute;reas Culturais para o PRONAC informado.");
        }
//        $objSegmentocultural = new Segmentocultural();
//        $this->view->combosegmentosculturais = $objSegmentocultural->buscarSegmento($preprojeto['Area']);

//        if (count($this->view->combosegmentosculturais) < 1) {
//            throw new Exception("N&atilde;o foram encontradas Segmentos Culturais para o PRONAC informado.");
//        }
        $sugestaoEnquadramentoModel = new Admissibilidade_Model_DbTable_SugestaoEnquadramento();
        $this->view->historicoEnquadramento = $sugestaoEnquadramentoModel->obterHistoricoEnquadramento($preprojeto['idPreProjeto']);
    }


}
