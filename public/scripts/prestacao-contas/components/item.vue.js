// (function (global, factory) {
//     if (typeof define === 'function' && define.amd) {
//         define(['../numeral'], factory);
//     } else if (typeof module === 'object' && module.exports) {
//         factory(require('../numeral'));
//     } else {
//         factory(global.numeral);
//     }
// }(this, function (numeral) {
//     numeral.register('locale', 'pt-br', {
//         delimiters: {
//             thousands: '.',
//             decimal: ','
//         },
//         abbreviations: {
//             thousand: 'mil',
//             million: 'milh�es',
//             billion: 'b',
//             trillion: 't'
//         },
//         ordinal: function (number) {
//             return '�';
//         },
//         currency: {
//             symbol: 'R$'
//         }
//     });
// }));

numeral.locale('pt-br');

function converteParaReal(value) {
    value = parseFloat(value);
    return numeral(value).format('0,0.00');
}

Vue.component('item', {
    props: ['idpronac', 'uf', 'etapa', 'cidade', 'produto', 'idplanilhaitens'],
    template: `<div class="col s12 m12" :informacoes = "informacoes">
                    <div class="card horizontal">
                        <div class="card-stacked">
                            <div class="center-align card-title lighten-4">
                                Item
                            </div>
                            <div class="card-content">
                                <table class="bordered">
                                    <thead>
                                        <tr>
                                            <th>Produto</th>
                                            <th>Etapa</th>
                                            <th>UF</th>
                                            <th>Cidade</th>
                                            <th>Itens de Custo</th>
                                            <th style="text-align: right">Valor Aprovado</th>
                                            <th style="text-align: right">Total Comprovado</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td v-html="informacoes.Produto"></td>
                                            <td>{{ informacoes.Etapa }}</td>
                                            <td>{{ informacoes.uf }}</td>
                                            <td>{{ informacoes.cidade }}</td>
                                            <td>{{ informacoes.Item }}</td>
                                            <td style="text-align: right">R$ {{ converterParaReal(informacoes.vlAprovado) }}</td>
                                            <td style="text-align: right">R$ {{ converterParaReal(informacoes.vlComprovado) }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>`,
    created: function () {
        let vue = this;
        this.$root.$on('novo-comprovante-nacional', function(data) {
            vue.informacoes.vlComprovado = parseFloat(vue.informacoes.vlComprovado) + parseFloat(data.valor);
        })

        this.$root.$on('atualizado-comprovante-nacional', function(data) {
            vue.informacoes.vlComprovado = (parseFloat(vue.informacoes.vlComprovado) - parseFloat(data.valorAntigo)) + parseFloat(data.valor);
        })

        this.$root.$on('excluir-comprovante-nacional', function(data) {
            vue.informacoes.vlComprovado = parseFloat(vue.informacoes.vlComprovado) - parseFloat(data.valor);
        })

        this.$root.$on('novo-comprovante-internacional', function(data) {
            vue.informacoes.vlComprovado = parseFloat(vue.informacoes.vlComprovado) + parseFloat(data.valor);
        })

        this.$root.$on('atualizado-comprovante-internacional', function(data) {
            console.log(data.valorAntigo, data.valor);
            vue.informacoes.vlComprovado = (parseFloat(vue.informacoes.vlComprovado) - parseFloat(data.valorAntigo)) + parseFloat(data.valor);
        })

    },
    mounted: function () {
        let vue = this;
        $3.ajax({
            url: "/prestacao-contas/pagamento/item/idpronac/" + this.idpronac
            + "/uf/" + this.uf
            + "/etapa/" + this.etapa
            + "/cidade/" + this.cidade
            + "/produto/"+ this.produto
            + "/idPlanilhaItens/" + this.idplanilhaitens
        }).done(function( data ) {
            vue.$data.informacoes = data;
        });
    },
    data: function () {
        return {
            informacoes: []
        };
    },
    methods:{
        converterParaReal: function (value) {
            value = parseFloat(value);
            return numeral(value).format('0,0.00');
        }
    }
})
