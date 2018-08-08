<template>
    <div id="planilha-proposta-original">
        <Carregando v-if="loading" :text="'Procurando planilha'"></Carregando>

        <div v-if="Object.keys(planilha).length > 0">

            <div class="right-align">
                <router-link :to="{ name: 'planilhaproposta', params: { idPronac: idPronac }}"
                             class="btn btn-primary">
                    <i class="material-icons left">visibility</i>Planilha Original
                </router-link>
            </div>

            <Planilha :arrayPlanilha="planilha"></Planilha>
        </div>
        <div v-if="semResposta" class="card-panel padding 20 center-align">{{ mensagem }}</div>
    </div>
</template>

<script>
    import Carregando from '@/components/Carregando';
    import Planilha from '@/components/Planilha/Planilha';
    import { mapGetters } from 'vuex';

    export default {
        data() {
            return {
                planilha: [],
                loading: true,
                semResposta: false,
                mensagem: '',
                idPronac: this.$route.params.idPronac,
            };
        },
        components: {
            Carregando,
            Planilha,
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
                /* eslint-disable */
                $3.ajax({
                    url: '/proposta/visualizar/obter-planilha-proposta-adequada-ajax/',
                    data: {
                        idPreProjeto: id,
                    },
                }).done((response) => {
                    self.planilha = response.data;
                }).fail((response) => {
                    self.semResposta = true;
                    self.mensagem = response.responseJSON.msg;
                }).always(() => {
                    self.loading = false;
                });
            },
        },
    };
</script>
