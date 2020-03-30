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
    </div>
</template>

<script>
    /* eslint-disable no-console */
    import ApiService from "../../services/api.service";

    export default {
        name: "Movie",
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
                id : null,
                name : '',
                playerOptions: {
                    // videojs options
                    muted: false,
                    language: 'en',
                    playbackRates: [0.7, 1.0, 1.5, 2.0],
                    // aspectRatio:"640:267",
                }
            }
        },
        mounted() {
            ApiService.get(process.env.VUE_APP_DOCUMENT_API_URL+'/video/'+this.$route.params.id)
                .then((response) => {
                    let data = response.data;
                    this.id = data.id;
                    this.name = data.name;
                    this.player.src({ type: "video/mp4", src: process.env.VUE_APP_DOCUMENT_API_URL+'/download/'+this.id });
                    this.player.reset()
                    this.player.currentTime(0);
                    this.player.play();
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