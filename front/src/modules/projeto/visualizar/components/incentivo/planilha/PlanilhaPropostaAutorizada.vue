<template>
    <div id="planilha-congelada">
        <Carregando
            v-if="loading"
            :text="'Procurando planilha'"/>
        <Planilha
            v-if="Object.keys(planilha).length > 0"
            :array-planilha="planilha">
            <template slot-scope="slotProps">
                <PlanilhaItensAutorizados :table="slotProps.itens"/>
            </template>
        </Planilha>
        <div
            v-if="semResposta"
            class="card-panel padding 20 center-align">{{ mensagem }}</div>
    </div>
</template>

<script>
import Carregando from '@/components/Carregando';
import Planilha from '@/components/Planilha/Planilha';
import PlanilhaItensAutorizados from '@/components/Planilha/PlanilhaItensAutorizados';
import { mapActions, mapGetters } from 'vuex';

export default {
    name: 'PlanilhaPropostaAutorizada',
    components: {
        Carregando,
        Planilha,
        PlanilhaItensAutorizados,
    },
    data() {
        return {
            loading: true,
            semResposta: false,
            mensagem: '',
        };
    },
    computed: {
        ...mapGetters({
            dadosProjeto: 'projeto/projeto',
            planilha: 'projeto/planilhaAutorizada',
        }),
    },
    watch: {
        dadosProjeto(value) {
            if (typeof value !== 'undefined') {
                this.buscaPlanilhaAutorizada(value.idPronac);
            }
        },
        planilha() {
            this.loading = false;
        },
    },
    mounted() {
        this.buscaPlanilhaAutorizada(this.dadosProjeto.idPronac);
    },
    methods: {
        ...mapActions({
            buscaPlanilhaAutorizada: 'projeto/buscaPlanilhaAutorizada',
        }),
    },
};
</script>
