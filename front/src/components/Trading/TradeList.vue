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
                    { key: 'code', sortable: true },
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
                            'raison_sociale' : data[key].raison_sociale,
                            'code' : data[key].code
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