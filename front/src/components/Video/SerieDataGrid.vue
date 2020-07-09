<template>
    <data-grid
            :id="tableId"
            :initial-page="currentPage"
            :per-page="moviePerPage"
            :total-rows="totalMovies"
            :items="items"
            :fields="fields"
            :on-filtered="onFiltered"
            :on-row-clicked="onSerieClicked"
    ></data-grid>
</template>

<script>
    import DataGrid from "../DataGrid";
    import ApiService from "../../services/api.service";

    export default {
        name: "SerieDataGrid",
        components: {DataGrid},
        props: {

        },
        data() {
            return {
                tableId : 'serie-table',
                currentPage: 1,
                moviePerPage: 10,
                totalMovies: 0,
                items : this.serieProvider,
                fields : [],
                onFiltered: function () {

                }
            }
        },
        computed: {

        },

        methods: {
            onSerieClicked(item) {
                this.$router.push({name: 'serie', params: {id: item.id}})
            },
            serieProvider(ctx, callback) {
                let params = {
                    'params': {
                        size: ctx.perPage,
                        page: ctx.currentPage
                    }
                };
                ApiService.get(process.env.VUE_APP_API + '/series', params)
                    .then(response => {
                        let items = [];
                        this.totalMovies = response.data['hydra:totalItems'];

                        response.data['hydra:member'].forEach(function (datum) {
                            let item = {
                                'id': datum.id,
                                'name': datum.name
                            }
                            items.push(item)
                        })
                        // Pluck the array of items off our axios response
                        // Provide the array of items to the callback
                        callback(items)
                    })
                    .catch(() => {
                        callback([])
                    })

                // Must return null or undefined to signal b-table that callback is being used
                return null
            }
        }
    }
</script>

<style scoped>

</style>