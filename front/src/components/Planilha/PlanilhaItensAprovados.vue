<template>
    <div class="itens">
        <table class="bordered">
            <thead>
            <tr>
                <th>#</th>
                <th>Item</th>
                <th>Dias</th>
                <th>Qtde</th>
                <th>Ocor.</th>
                <th>Vl. Unit&aacute;rio</th>
                <th>Vl. Solicitado</th>
                <th>#</th>
            </tr>
            </thead>
            <tbody>
            <tr v-for="row of table"
                :key="row.idPlanilhaProposta"
                v-if="isObject(row)"
                :class="definirClasseItem(row)">
                <td>{{row.Seq}}</td>
                <td>{{row.Item}}</td>
                <td>{{row.QtdeDias}}</td>
                <td>{{row.Quantidade}}</td>
                <td>{{row.Ocorrencia}}</td>
                <td>{{ row.vlUnitario | formatarParaReal }}</td>
                <td>{{ row.vlSolicitado | formatarParaReal }}</td>
                <td>
                    <a v-if="row.JustProponente.length > 3"
                       class="tooltipped"
                       data-position="left"
                       data-delay="50"
                       v-bind:data-tooltip="row.JustProponente"
                    ><i class="material-icons tiny">message</i>
                    </a>
                </td>
            </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
    import planilhas from '@/mixins/planilhas';

    export default {
        mixins: [planilhas],
        props: {
            table: {},
        },
    };
</script>
