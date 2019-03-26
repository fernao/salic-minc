import * as readequacaoHelperAPI from '@/helpers/api/Readequacao';
import * as types from './types';

export const obterListaDeReadequacoes = async ({ commit }, params) => {
    const resultado = await readequacaoHelperAPI.getReadequacoes(params)
        .then((response) => {
            const { data } = response.data;
            switch (params.stStatusAtual) {
            case 'proponente':
                commit(types.GET_READEQUACOES_PROPONENTE, data);
                break;
            case 'analise':
                commit(types.GET_READEQUACOES_ANALISE, data);
                break;
            case 'finalizadas':
                commit(types.GET_READEQUACOES_FINALIZADAS, data);
                break;
            default:
                break;
            }
            return data;
        });
    return resultado;
};

export const buscaReadequacao = ({ commit }, params) => {
    readequacaoHelperAPI.buscaReadequacao(params)
        .then((response) => {
            const { data } = response.data.data.items;
            commit(types.SET_READEQUACAO, { readequacao: data });
        });
};

export const buscaReadequacaoPronacTipo = ({ commit }, params) => {
    readequacaoHelperAPI.buscaReadequacaoPronacTipo(params)
        .then((response) => {
            const { data } = response.data;
            let readequacao = {};
            if (data.items.length > 1) {
                readequacao = { items: data.data.items };
            } else {
                readequacao = { items: data.data.items[0] };
            }
            commit(types.SET_READEQUACAO, readequacao);
        });
};

export const adicionarDocumento = ({ commit }, params) => {
    readequacaoHelperAPI.adicionarDocumento(params)
        .then((response) => {
            const { documento } = response.data.documento;
            commit(types.ADICIONAR_DOCUMENTO, documento);
        });
};

export const excluirDocumento = ({ commit }, params) => {
    readequacaoHelperAPI.excluirDocumento(params)
        .then(() => {
            commit(types.EXCLUIR_DOCUMENTO);
        });
};

export const excluirReadequacao = ({ commit }, params) => {
    readequacaoHelperAPI.excluirReadequacao(params)
        .then(() => {
            commit(types.EXCLUIR_READEQUACAO);
        });
};

export const updateReadequacao = ({ commit }, params) => {
    readequacaoHelperAPI.updateReadequacao(params)
        .then((response) => {
            commit(types.UPDATE_READEQUACAO, response.data.data.items);
        });
};

export const updateReadequacaoDsSolicitacao = ({ commit }, params) => {
    commit(types.UPDATE_READEQUACAO_DS_SOLICITACAO, params);
};

export const updateReadequacaoSaldoAplicacao = ({ commit }, params) => {
    readequacaoHelperAPI.updateReadequacaoSaldoAplicacao(params)
        .then((response) => {
            const { readequacao } = response.data;
            commit(types.UPDATE_READEQUACAO_SALDO_APLICACAO, readequacao);
        });
};

export const updateReadequacaoSaldoAplicacaoDsSolicitacao = ({ commit }, dsSolicitacao) => {
    commit(types.UPDATE_READEQUACAO_SALDO_APLICACAO_DS_SOLICITACAO, dsSolicitacao);
};

export const obterDisponivelEdicaoItemSaldoAplicacao = ({ commit }, params) => {
    readequacaoHelperAPI.obterDisponivelEdicaoItemSaldoAplicacao(params)
        .then((response) => {
            const { data } = response.data.disponivelParaEdicao;
            commit(types.OBTER_DISPONIVEL_EDICAO_ITEM_SALDO_APLICACAO, data);
        });
};

export const obterCampoAtual = ({ commit }, params) => {
    readequacaoHelperAPI.obterCampoAtual(params)
        .then((response) => {
            const { data } = response.data;
            commit(types.SET_CAMPO_ATUAL, data.items[0]);
        });
};

export const obterTiposDisponiveis = ({ commit }, params) => {
    readequacaoHelperAPI.obterTiposDisponiveis(params)
        .then((response) => {
            commit(types.SET_TIPOS_DISPONIVEIS, response.data.data.items);
        });
};

export const inserirReadequacao = async ({ commit }, params) => {
    const resultado = await readequacaoHelperAPI.inserirReadequacao(params)
        .then((response) => {
            const { data } = response.data;
            commit(types.SET_READEQUACAO, data);
            commit(types.SET_READEQUACOES_PROPONENTE, data);
            return data;
        });
    return resultado;
};
