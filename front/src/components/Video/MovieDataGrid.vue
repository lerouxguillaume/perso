<template>
    <data-grid
            :id="tableId"
            :initial-page="currentPage"
            :per-page="moviePerPage"
            :total-rows="totalMovies"
            :items="items"
            :fields="fields"
            :on-filtered="onFiltered"
            :on-row-clicked="onMovieClicked"
    ></data-grid>
</template>

<script>
    import DataGrid from "../DataGrid";
    import ApiService from "../../services/api.service";

    export default {
        name: "MovieDataGrid",
        components: {DataGrid},
        props: {

        },
        data() {
            return {
                tableId : 'movie-table',
                currentPage: 1,
                moviePerPage: 10,
                totalMovies: 0,
                items : this.movieProvider,
                fields: [
                    {key: 'name', sortable: true},
                    {key: 'genre', sortable: true},
                    {key: 'author', sortable: true},
                ],
                onFiltered: function () {

                }
            }
        },
        computed: {

        },

        methods: {
            onMovieClicked(item) {
                this.$router.push({name: 'movie', params: { id : item.id }})
            },
            movieProvider(ctx, callback) {
                // eslint-disable-next-line no-console
                let params = {
                    'params' : {
                        size : ctx.perPage,
                        page : ctx.currentPage
                    }
                };

                if (ctx.sortBy !== '') {
                    params.params['order['+ctx.sortBy+']'] = ctx.sortDesc ? 'desc':'asc';
                }

                ApiService.get(process.env.VUE_APP_API+'/movies', params)
                    .then(data => {
                        let items = [];
                        let meta = data.data.meta;
                        this.totalMovies = meta.totalItems;
                        data.data.data.forEach(function (datum) {
                            let attribute = datum.attributes;

                            let item = {
                                'id' : attribute.id,
                                'name' : attribute.name,
                                'genre' : attribute.genre,
                                'author' : attribute.author,
                            }
                            items.push(item)
                        })
                        // Pluck the array of items off our axios response
                        // Provide the array of items to the callback
                        callback(items)
                    })
                    .catch((error) => {
                        // eslint-disable-next-line no-console
                        console.error(error);
                        callback([])
                    })

                // Must return null or undefined to signal b-table that callback is being used
                return null
            },
        }
    }
</script>

<style scoped>

</style>