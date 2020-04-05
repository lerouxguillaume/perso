<template>
    <div class="video-container">
        <video-player
                id="my_video_1"
                class="video-js vjs-default-skin"
                controls
                preload="none"
                ref="videoPlayer"
                :options="playerOptions"
                @play="onPlayerPlay($event)"
                @pause="onPlayerPause($event)"
                @ready="playerReadied"
                @statechanged="playerStateChanged($event)"
                @click="playerDbClick($event)"
        >
        </video-player>
    </div>
</template>

<script>
    /* eslint-disable no-console */
    import KEY_CODES from "bootstrap-vue/esm/utils/key-codes";
    require('videojs-mobile-ui');
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
                    aspectRatio:"2:1",

                }
            }
        },
        watch: {
            src : function (newVal) {
                this.player.src({ type: "video/mp4", src: newVal});
                // this.player.reset();
                this.player.play();
                // this.player.focus();
            }
        },
        computed: {
            player() {
                return this.$refs.videoPlayer.player
            }
        },
        mounted(){
            this.player.mobileUi();
            window.playerEvents = this;
            this.player.on('dblclick', this.playerDbClick);
            this.player.on('keydown', this.keyPressed);
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
            },
            playerDbClick() {
                if (this.player.isFullscreen()) {
                    this.player.exitFullscreen();
                } else {
                    this.player.requestFullscreen();
                }
            },
            keyPressed(key) {
                switch (key.keyCode) {
                    case KEY_CODES.SPACE :
                        if (this.player.paused()) {
                            this.player.play();
                        } else {
                            this.player.pause();
                        }
                        break;
                    case KEY_CODES.LEFT :
                        this.player.currentTime(this.player.currentTime() - 30);
                        break;
                    case KEY_CODES.RIGHT :
                        this.player.currentTime(this.player.currentTime() + 30);
                        break;
                    case KEY_CODES.UP :
                        this.player.volume(this.player.volume() + 0.1);
                        break;
                    case KEY_CODES.DOWN :
                        this.player.volume(this.player.volume() - 0.1);
                        break;
                }
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