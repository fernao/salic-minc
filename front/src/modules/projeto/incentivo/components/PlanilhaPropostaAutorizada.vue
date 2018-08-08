<template>
    <div id="planilha-congelada">
        <Carregando v-if="loading" :text="'Procurando planilha'"></Carregando>
        <Planilha v-if="Object.keys(planilha).length > 0" :arrayPlanilha="planilha">
            <template slot-scope="slotProps">
                <PlanilhaItensAutorizados :table="slotProps.itens"></PlanilhaItensAutorizados>
            </template>
        </Planilha>
        <div v-if="semResposta" class="card-panel padding 20 center-align">{{ mensagem }}</div>
    </div>
</template>

<script>
    import Carregando from '@/components/Carregando';
    import Planilha from '@/components/Planilha/Planilha';
    import PlanilhaItensAutorizados from '@/components/Planilha/PlanilhaItensAutorizados';
    import { mapGetters } from 'vuex';

    export default {
        name: 'PlanilhaPropostaAutorizada',
        data() {
            return {
                planilha: [],
                loading: true,
                semResposta: false,
                mensagem: '',
            };
        },
        components: {
            Carregando,
            Planilha,
            PlanilhaItensAutorizados,
        },
        mounted() {
            if (typeof this.dadosProjeto !== 'undefined') {
                this.fetch(this.dadosProjeto.idPreProjeto);
            }
        },
        watch: {
            dadosProjeto(value) {
                if (typeof value !== 'undefined') {
                    this.fetch(value.idPreProjeto);
                }
            },
        },
        computed: {
            ...mapGetters({
                dadosProjeto: 'projeto/projeto',
            }),
        },
        methods: {
            fetch(id) {
                if (typeof id === 'undefined') {
                    return;
                }

                const self = this;
                /* eslint-disable-next-line */
                $3
                    .ajax({
                        url: '/proposta/visualizar/obter-planilha-proposta-original-ajax/',
                        data: {
                            idPreProjeto: id,
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
