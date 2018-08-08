<template>
    <div id="planilha-homologada">
        <Carregando v-if="loading" :text="'Procurando planilha'"></Carregando>

        <Planilha v-if="Object.keys(planilha).length > 0" :arrayPlanilha="planilha">
            <template slot-scope="slotProps">
                <PlanilhaItensReadequados :table="slotProps.itens"></PlanilhaItensReadequados>
            </template>
        </Planilha>
        <div v-if="semResposta" class="card-panel padding 20 center-align">{{ mensagem }}</div>
    </div>
</template>

<script>
    import Carregando from '@/components/Carregando';
    import Planilha from '@/components/Planilha/Planilha';
    import PlanilhaItensReadequados from '@/components/Planilha/PlanilhaItensReadequados';
    import { mapGetters } from 'vuex';

    export default {
        /* eslint-disable */
        name: 'PlanilhaPropostaReadequada',
        data: function () {
            return {
                planilha: [],
                loading: true,
                semResposta: false,
                mensagem: ''
            };
        },
        components: {
            Carregando,
            Planilha,
            PlanilhaItensReadequados
        },
        mounted: function () {
            if (typeof this.dadosProjeto !== 'undefined') {
                this.fetch(this.dadosProjeto.idPronac);
            }
        },
        watch: {
            dadosProjeto: function (value) {
                if (typeof value !== 'undefined') {
                    this.fetch(value.idPronac);
                }
            }
        },
        computed: {
            ...mapGetters({
                dadosProjeto: 'projeto/projeto'
            })
        },
        methods: {
            fetch: function (id) {
                if (typeof id == 'undefined') {
                    return;
                }

                let self = this;
                $3
                    .ajax({
                        url: '/projeto/orcamento/obter-planilha-readequada-ajax/',
                        data: {
                            idPronac: id,
                        },
                    })
                    .done((response) => {
                        self.planilha = response.data;
                    })
                    .fail((response) => {
                        self.semResposta = true;
                        self.mensagem = response.responseJSON.msg;
                    })
                    .always(() => {
                        self.loading = false;
                    });
            },
        },
    };
</script>
