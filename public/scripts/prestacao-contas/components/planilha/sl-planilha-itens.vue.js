Vue.component('sl-planilha-itens',{
    props: ['itens','idpronac','uf',
        'cdproduto','cdcidade','cdetapa'],
    template: `<table class="bordered">
                <thead>
                    <tr>
                        <th>Item de Custo</th>
                        <th style="text-align: right">Valor Aprovado</th>
                        <th style="text-align: right">Valor Comprovado</th>
                        <th style="text-align: right">Valor a Comprovar</th>
                        <th style="text-align: center"> </th>
                    </tr>
                </thead>
                <tbody>
                    <tr :item="item"
                       v-for="(item, index) in itens"
                       :key="index"
                       v-if="isObject(item)">
                        <td>
                            {{ item.item }}
                        </td>
                        <td style="text-align: right"> R$ {{ converterParaReal(item.varlorAprovado) }} </td>
                        <td style="text-align: right"> R$ {{ converterParaReal(item.varlorComprovado) }} </td>
                        <td style="text-align: right"> R$ {{ converterParaReal(item.varlorAprovado - item.varlorComprovado)  }} </td>
                        <td style="text-align: right"><a class="btn" title="Comprovar item"
                            :href="url(item.idPlanilhaAprovacao, item.idPlanilhaItens)"
                           ><i class="material-icons small">attach_money</i></a></td>
                    </tr>
                </tbody>
            </table> `,
    methods: {
        isObject: function (el) {

            return typeof el === "object";

        },
        converterParaReal: function (value) {
            value = parseFloat(value);
            return numeral(value).format('0,0.00');
        },
        url: function (idPlanilhaAprovacao, idPlanilhaItens) {
            return '/prestacao-contas/gerenciar/comprovar'
            + '/idpronac/' + this.idpronac
            + '/uf/' + this.uf
            + '/produto/' + this.cdproduto
            + '/cidade/' + this.cdcidade
            + '/etapa/' + this.cdetapa
            + '/idPlanilhaAprovacao/' + idPlanilhaAprovacao
            + '/idPlanilhaItens/' + idPlanilhaItens;
        }
    }


})