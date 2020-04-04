<template>
    <div>
        <Video :src="src"></Video>
        <div>
            <b-button v-for="(episode, key) in episodes" class="col-md-4" v-bind:key="key" @click="onSelectEpisode(episode)">
                {{  episode.name }}
            </b-button>
        </div>
    </div>
</template>

<script>
    /* eslint-disable no-console */
    import ApiService from "../../services/api.service";
    import Video from "./Video";

    export default {
        name: "Serie",
        components: {Video},
        data() {
            return {
                currentEpisode: null,
                episodes : [],
            }
        },
        computed: {
            src() {
                return this.currentEpisode !== null ? this.currentEpisode.src : null;
            } ,
        },
        mounted() {
            ApiService.get(process.env.VUE_APP_DOCUMENT_API_URL+'/serie/'+this.$route.params.id)
                .then((response) => {
                    let data = response.data;
                    data['episodes'].forEach(episode => {
                        this.episodes.push({
                            'id' : episode.id,
                            'episode' : episode.episode,
                            'name' : episode.name,
                            'duration' : episode.duration,
                            'src' : process.env.VUE_APP_DOCUMENT_API_URL+'/download/'+this.currentEpisode.id,
                        })
                    })
                })
                .catch(function (error) {
                    console.log(error);
                })
        },
        methods: {
            onSelectEpisode(episode) {
                this.currentEpisode = episode;
            },
        }
    }
</script>

<style scoped>
</style>