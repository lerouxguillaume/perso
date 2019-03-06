<template>
    <div id="table-entreprise">
        <b-table striped hover :items="items" :fields="fields">
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
                items: [
                ]
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
                            'jour' : data[key].day_variance.toFixed(2) + ' %',
                            'semaine' : data[key].week_variance.toFixed(2) + ' %',
                            'mois' : data[key].month_variance.toFixed(2) + ' %',
                            'trimestre' : data[key].trimester_variance.toFixed(2) + ' %',
                            'annee' : data[key].year_variance.toFixed(2) + ' %',
                            'cinq_ans' : data[key].five_year_variance.toFixed(2) + ' %',
                            'dix_ans' : data[key].ten_year_variance.toFixed(2) + ' %',
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
</style>