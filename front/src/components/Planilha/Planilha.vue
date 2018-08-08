<template>
    <div v-if="planilha" class="planilha-orcamentaria card">
        <ul class="collapsible no-margin" data-collapsible="expandable">
            <li v-for="(fontes, fonte, indexFonte) of planilhaCompleta" v-if="isObject(fontes)" :key="indexFonte">
                <div class="collapsible-header active red-text fonte" :class="converterStringParaClasseCss(fonte)">
                    <i class="material-icons">beenhere</i>{{fonte}}<span class="badge">R$ {{fontes.total}}</span>
                </div>
                <div class="collapsible-body no-padding">
                    <ul class="collapsible no-border no-margin" data-collapsible="expandable">
                        <li v-for="(produtos, produto, indexProduto) of fontes" v-if="isObject(produtos)"
                            :key="indexProduto">
                            <div class="collapsible-header active green-text" style="padding-left: 30px;"
                                 :class="converterStringParaClasseCss(produto)">
                                <i class="material-icons">perm_media</i>{{produto}}<span class="badge">R$ {{produtos.total}}</span>
                            </div>
                            <div class="collapsible-body no-padding no-border">
                                <ul class="collapsible no-border no-margin" data-collapsible="expandable">
                                    <li v-for="(etapas, etapa, indexEtapa) of produtos" v-if="isObject(etapas)"
                                        :key="indexEtapa">
                                        <div class="collapsible-header active orange-text" style="padding-left: 50px;"
                                             :class="converterStringParaClasseCss(etapa)">
                                            <i class="material-icons">label</i>{{etapa}}<span class="badge">R$ {{etapas.total}}</span>
                                        </div>
                                        <div class="collapsible-body no-padding no-border">
                                            <ul class="collapsible no-border no-margin" data-collapsible="expandable">
                                                <li v-for="(locais, local, indexLocal) of etapas"
                                                    v-if="isObject(locais)" :key="indexLocal">
                                                    <div class="collapsible-header active blue-text"
                                                         style="padding-left: 70px;"
                                                         :class="converterStringParaClasseCss(local)">
                                                        <i class="material-icons">place</i>{{local}} <span
                                                        class="badge">R$ {{locais.total}}</span>
                                                    </div>
                                                    <div class="collapsible-body no-padding margin20 scroll-x">
                                                        <slot v-bind:itens="locais">
                                                            <PlanilhaItensPadrao :table="locais"></PlanilhaItensPadrao>
                                                        </slot>
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </li>
                    </ul>
                </div>
            </li>
        </ul>
        <div class="card-action right-align">
            <span><b>Valor total do projeto:</b> R$ {{planilhaCompleta.total}}</span>
        </div>
    </div>
    <div v-else>Nenhuma planilha encontrada</div>
</template>

<script>
    import numeral from 'numeral';
    import 'numeral/locales';
    import PlanilhaItensPadrao from '@/components/Planilha/PlanilhaItensPadrao';
    import planilhas from '@/mixins/planilhas';

    export default {
        /* eslint-disable */
        name: 'Planilha',
        data() {
            return {
                planilha: []
            };
        },
        mixins: [planilhas],
        components: {
            PlanilhaItensPadrao,
        },
        props: {
            arrayPlanilha: {},
            componenteTabelaItens: {
                default: 'PlanilhaItensPadrao',
                type: String
            }
        },
        mounted() {
            if (typeof this.arrayPlanilha !== 'undefined') {
                this.planilha = this.arrayPlanilha;
            }

            numeral.locale('pt-br');
            numeral.defaultFormat('0,0.00');
        },
        computed: {
            planilhaCompleta() {
                if (!this.planilha) {
                    return 0;
                }

                let novaPlanilha = {},
                    totalProjeto = 0,
                    totalFonte = 0,
                    totalProduto = 0,
                    totalEtapa = 0,
                    totalLocal = 0;

                novaPlanilha = this.planilha;
                Object.entries(this.planilha).forEach(([fonte, produtos]) => {
                    totalFonte = 0;
                    Object.entries(produtos).forEach(([produto, etapas]) => {
                        totalProduto = 0;
                        Object.entries(etapas).forEach(([etapa, locais]) => {
                            totalEtapa = 0;
                            Object.entries(locais).forEach(([local, itens]) => {
                                totalLocal = 0;
                                Object.entries(itens).forEach(([column, cell]) => {
                                    if (cell.tpAcao && cell.tpAcao === 'E') {
                                        return;
                                    }

                                    // planilha homologada e readequada o valor total � a soma do vlAprovado
                                    if (cell.vlAprovado || cell.vlAprovado >= 0) {
                                        totalLocal += cell.vlAprovado;
                                    } else {
                                        totalLocal += cell.vlSolicitado;
                                    }
                                });
                                this.$set(
                                    this.planilha[fonte][produto][etapa][local],
                                    'total',
                                    numeral(totalLocal).format('0,0.00')
                                );
                                totalEtapa += totalLocal;
                            });
                            this.$set(
                                this.planilha[fonte][produto][etapa],
                                'total',
                                numeral(totalEtapa).format('0,0.00')
                            );
                            totalProduto += totalEtapa;
                        });
                        this.$set(
                            this.planilha[fonte][produto],
                            'total',
                            numeral(totalProduto).format('0,0.00')
                        );
                        totalFonte += totalProduto;
                    });
                    this.$set(
                        this.planilha[fonte],
                        'total',
                        numeral(totalFonte).format('0,0.00')
                    );
                    totalProjeto += totalFonte;
                });
                this.$set(novaPlanilha, 'total', numeral(totalProjeto).format('0,0.00'));

                return novaPlanilha;
            }
        },
        watch: {
            arrayPlanilha(value) {
                this.planilha = value;
                this.iniciarCollapsible();
            }
        },
        methods: {
            iniciarCollapsible() {
                $3(".planilha-orcamentaria .collapsible").each(function () {
                    $3(this).collapsible();
                });
            },
        },
    };
</script>
