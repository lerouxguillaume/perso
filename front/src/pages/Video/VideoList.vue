<template>
    <div id="video-datagrid-content">
        <b-tabs content-class="mt-3">
            <b-tab title="Series"><p>Series</p>
                <SerieDataGrid></SerieDataGrid>
            </b-tab>
            <b-tab title="Movies" active><p>Movies</p>
                <MovieDataGrid></MovieDataGrid>
            </b-tab>
        </b-tabs>
    </div>
</template>

<script>
    import MovieDataGrid from "../../components/Video/MovieDataGrid.vue";
    import SerieDataGrid from "../../components/Video/SerieDataGrid";

    export default {
        name: "VideoList",
        components: {SerieDataGrid, MovieDataGrid},
    }
</script>

<style scoped>
    #video-datagrid-content {
        width: 80%;
        margin: 20px 10%;
    }
</style>
