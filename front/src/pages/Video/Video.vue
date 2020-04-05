<template>
    <div class="video-container">
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
    export default {
        name: "Video",
        currentEpisode: null,
        props: {
            src: {
                type: String,
                default() {
                    return null;
                }
            }
        },
        data() {
            return {
                playerOptions: {
                    // videojs options
                    muted: false,
                    language: 'en',
                    playbackRates: [0.7, 1.0, 1.5, 2.0],
                    aspectRatio:"640:267",

                }
            }
        },
        watch: {
            src : function (newVal) {
                this.player.src({ type: "video/mp4", src: newVal});
                this.player.reset();
                this.player.currentTime(0);
                this.player.play();
            }
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
    .video-container {
        display: flex;
        margin: 20px;
        justify-content: center;
    }
    .video-player {
        width: 50%;
        height: auto;
    }
</style>