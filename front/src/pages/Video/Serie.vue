<template>
    <div>
        <Video :src="src"></Video>
        <b-pagination
                :total-rows="rows"
                :per-page="1"
                first-text="⏮"
                prev-text="⏪"
                next-text="⏩"
                last-text="⏭"
                class="mt-4"
                @input="onSelectEpisode"
                align="center"
        ></b-pagination>
    </div>
</template>

<script>
    /* eslint-disable no-console */
    import ApiService from "../../services/api.service";
    import Video from "../../components/Video/Video";

    export default {
        name: "Serie",
        components: {Video},
        data() {
            return {
                id: null,
                name: null,
                currentEpisode: null,
                episodes : [],
                currentEpisodeNumber : 1,
            }
        },
        computed: {
            src() {
                return this.currentEpisode !== null ? this.currentEpisode.src : null;
            },
            rows() {
                return this.episodes.length;
            },
        },
        mounted() {
            ApiService.get(process.env.VUE_APP_API+'/series/'+this.$route.params.id)
                .then((response) => {
                    let data = response.data.data.attributes;
                    this.id = data.id;
                    this.name = data.name;

                    let episodes = [];
                    data.episodes.forEach(function (item) {
                        let episode = item.data.attributes;
                        episodes.push({
                            'id' : episode.id,
                            'episode' : episode.episode,
                            'name' : episode.name,
                            'duration' : episode.duration,
                            'src' : episode.videoUrl,
                        })
                    })
                    this.episodes = episodes;
                    this.episodes.sort((a,b) => {
                        let comparison = 0;
                        if (a.episode > b.episode) {
                            comparison = 1;
                        } else if (a.episode < b.episode) {
                            comparison = -1;
                        }
                        return comparison;
                    })
                })
                .catch(function (error) {
                    console.log(error);
                })
        },
        methods: {
            onSelectEpisode(episode) {
                let current = this.episodes[episode-1];
                this.currentEpisode = typeof current === 'undefined' ? null : current
            },
        }
    }
</script>

<style scoped>
</style>