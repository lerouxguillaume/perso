<template>
    <div>
        <video-player
                id="my_video_1"
                class="video-js vjs-default-skin"
                controls
                preload="none"
                ref="videoPlayer"
                :options="playerOptions"
                :playsinline="true"
                @play="onPlayerPlay($event)"
                @pause="onPlayerPause($event)"
                @ready="playerReadied"
                @statechanged="playerStateChanged($event)">
        </video-player>
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

    export default {
        name: "Serie",
        currentEpisode: null,
        props: {
            options: {
                type: Object,
                default() {
                    return {};
                }
            }
        },
        data() {
            return {
                episodes : [],
                playerOptions: {
                    // videojs options
                    muted: false,
                    language: 'en',
                    playbackRates: [0.7, 1.0, 1.5, 2.0],
                    aspectRatio:"640:267",
                }
            }
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
                        })
                    })
                })
                .catch(function (error) {
                    console.log(error);
                })
        },
        computed: {
            player() {
                return this.$refs.videoPlayer.player
            }
        },
        methods: {
            onSelectEpisode(episode) {
                this.currentEpisode = episode;
                this.player.src({ type: "video/mp4", src: process.env.VUE_APP_DOCUMENT_API_URL+'/download/'+this.currentEpisode.id });
                this.player.reset()
                this.player.currentTime(0);
                this.player.play();

            },
            // listen event
            onPlayerPlay() {
                // console.log('player play!', player)
            },
            onPlayerPause() {
                // console.log('player pause!', player)
            },
            // ...player event

            // or listen state event
            playerStateChanged() {
                // console.log('player current update state', playerCurrentState)
            },
            // player is ready
            playerReadied() {
                // console.log('the player is readied', player)
                // you can use it to do something...
                // player.[methods]
            }
        }
    }
</script>

<style scoped>
</style>