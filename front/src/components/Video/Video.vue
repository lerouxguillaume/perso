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
    import videojs from 'video.js';

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
            window.playerEvents = this;
            this.player.on('dblclick', this.playerDbClick);
            this.player.on('keydown', this.keyPressed);
            var Button = videojs.getComponent('Button');

            // Extend default
            var PrevButton = videojs.extend(Button, {
                //constructor: function(player, options) {
                constructor: function() {
                    Button.apply(this, arguments);
                    //this.addClass('vjs-chapters-button');
                    this.addClass('icon-angle-left');
                    this.controlText("Previous");
                },
                handleClick: this.backward
            });
            videojs.registerComponent('PrevButton', PrevButton);

            // Extend default
            var NextButton = videojs.extend(Button, {
                //constructor: function(player, options) {
                constructor: function() {
                    Button.apply(this, arguments);
                    //this.addClass('vjs-chapters-button');
                    this.addClass('icon-angle-right');
                    this.controlText("Previous");
                },
                handleClick: this.forward
            });
            videojs.registerComponent('NextButton', NextButton);
            this.player.getChild('controlBar').addChild('PrevButton', {}, 0);
            this.player.getChild('controlBar').addChild('NextButton', {}, 2);
            // this.player.on('click', 'icon-angle-right', this.forward);
            // this.player.on('keydown', this.keyPressed);
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
            backward() {
                this.player.currentTime(this.player.currentTime() - 30);
            },
            forward() {
                this.player.currentTime(this.player.currentTime() + 30);
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
                        this.forward();
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
    .video-holder {
        background: #1b1b1b;
        padding: 10px
    }

    /* CUSTOM BUTTONS */
    [class^="icon-"]:before,
    [class*=" icon-"]:before {
        font-family: FontAwesome;
        font-weight: normal;
        font-style: normal;
        display: inline-block;
        text-decoration: inherit;
        background-color: rebeccapurple !important;
    }
    .icon-angle-left:before {
        content: "\f104";
    }
    .icon-angle-right:before {
        content: "\f105";
    }

    .video-js .icon-angle-right, .video-js .icon-angle-left {
        cursor: pointer;
        -webkit-box-flex: none;
        -moz-box-flex: none;
        -webkit-flex: none;
        -ms-flex: none;
        flex: none;
    }
</style>