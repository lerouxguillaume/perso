<template>
    <div id="table-entreprise">
        <b-table striped hover :items="items" :busy="items.length === 0" :fields="fields">
            <template slot="jour" slot-scope="data">
                <span v-bind:class="data.item.jour < 0 ? 'danger' : 'success'">{{ data.item.jour | formatFloat(2) }} %</span>
            </template>
            <template slot="semaine" slot-scope="data">
                <span v-bind:class="data.item.semaine < 0 ? 'danger' : 'success'">{{ data.item.semaine | formatFloat(2) }} %</span>
            </template>
            <template slot="mois" slot-scope="data">
                <span v-bind:class="data.item.mois < 0 ? 'danger' : 'success'">{{ data.item.mois | formatFloat(2) }} %</span>
            </template>
            <template slot="trimestre" slot-scope="data">
                <span v-bind:class="data.item.trimestre < 0 ? 'danger' : 'success'">{{ data.item.trimestre | formatFloat(2) }} %</span>
            </template>
            <template slot="annee" slot-scope="data">
                <span v-bind:class="data.item.annee < 0 ? 'danger' : 'success'">{{ data.item.annee | formatFloat(2) }} %</span>
            </template>
            <template slot="cinq_ans" slot-scope="data">
                <span v-bind:class="data.item.cinq_ans < 0 ? 'danger' : 'success'">{{ data.item.cinq_ans | formatFloat(2) }} %</span>
            </template>
            <template slot="dix_ans" slot-scope="data">
                <span v-bind:class="data.item.dix_ans < 0 ? 'danger' : 'success'">{{ data.item.dix_ans | formatFloat(2) }} %</span>
            </template>
            <template slot="actions" slot-scope="row">
                <b-button size="sm" @click="info(row.item, row.index, $event.target)" class="mr-1">
                    Details
                </b-button>
            </template>
        </b-table>
    </div>
</template>

<script>
    import axios from 'axios';
    import * as router from "vue-router";

    export default {
        name: "TradeList",
        data() {
            return {
                // Note 'isActive' is left out and will not appear in the rendered table
                fields: [
                    { key: 'raison_sociale', sortable: true },
                    { key: 'jour', sortable: true },
                    { key: 'semaine', sortable: true },
                    { key: 'mois', sortable: true },
                    { key: 'trimestre', sortable: true },
                    { key: 'annee', sortable: true },
                    { key: 'cinq_ans', sortable: true },
                    { key: 'dix_ans', sortable: true },
                    { key: 'actions' }
                ],
                items: []
            }
        },
        methods: {
            info(item) {
                this.$router.push({name: 'trading_detail', params: { company : item.code }})
            }
        },
        mounted () {
            axios
                .get(process.env.VUE_APP_TRADE_API_URL+'/entreprises')
                .then((response) => {
                    let data = response.data;
                    for (let key in data) {
                        this.items.push({
                            isActive: true,
                            'raison_sociale' : data[key].entreprise.raison_sociale,
                            'jour' : data[key].day_variance,
                            'semaine' : data[key].week_variance,
                            'mois' : data[key].month_variance,
                            'trimestre' : data[key].trimester_variance,
                            'annee' : data[key].year_variance,
                            'cinq_ans' : data[key].five_year_variance,
                            'dix_ans' : data[key].ten_year_variance,
                            'code' : data[key].entreprise.code
                        })
                    }
                })
                .catch(function (error) {
                    console.log(error);
                })
        }
    }
</script>

<style scoped>
    #table-entreprise {
        width: 80%;
        margin: 20px 10%;
    }
    .success {
        color: green;
    }
    .danger {
        color: red;
    }
</style>
