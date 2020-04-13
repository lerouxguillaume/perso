<template>
    <div>
        <Video :src="src">
        </Video>
    </div>
</template>

<script>
    /* eslint-disable no-console */
    import ApiService from "../../services/api.service";
    import Video from "../../components/Video/Video";

    export default {
        name: "Movie",
        components: {Video},
        data() {
            return {
                id : null,
                name : '',
                src: null,
            }
        },
        mounted() {
            ApiService.get(process.env.VUE_APP_DOCUMENT_API_URL+'/video/'+this.$route.params.id)
                .then((response) => {
                    let data = response.data;
                    this.id = data.id;
                    this.name = data.name;
                    this.src = process.env.VUE_APP_DOCUMENT_API_URL+'/video/smovie/'+this.id ;
                })
                .catch(function (error) {
                    console.log(error);
                })
        },
    }
</script>

<style scoped>
</style>