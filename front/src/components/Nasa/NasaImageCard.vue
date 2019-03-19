<template>
    <b-card no-body class="overflow-hidden" v-on:click="redirectTo">
        <b-row no-gutters>
            <b-col md="6" class="image-card">
                <b-card-img v-if="image.mediaType === 'image'" v-bind:src="image.url" class="rounded-0" />
                <iframe v-else-if="image.mediaType === 'video'" :src="image.url" width="250"></iframe>
            </b-col>
            <b-col md="6">
                <b-card-body v-bind:title="image.title">
                    <b-card-text>
                        {{ image.explanation | truncate(200, '...', true) }}
                    </b-card-text>
                </b-card-body>
            </b-col>
        </b-row>
    </b-card>
</template>

<script>

    import * as router from "vue-router";
    import * as moment from "moment";

    export default {
        name: "NasaImageCard",
        props: {
            image: {
                date: null,
                title: String,
                explanation: String,
                url: String,
                mediaType: String
            }
        },
        data: () => {
            return {
                router: router
            }
        },
        methods: {
            redirectTo: function() {
                this.$router.push({name: 'nasa_image_detail', params: { day : (moment(this.image.date).format('DD-MM-YYYY')) }})
            }
        }
    }
</script>

<style scoped>
    .card-title {
        font-size: 20px;
    }
    .card-text {
        font-size: 14px;
        text-align: left;
        max-height: 120px;
        overflow: fragments;
    }
    img {
        max-height: 250px;
        max-width: 250px;
    }
    iframe {
        color: #222222;
    }
    .image-card {
        align-self: center;
    }
    .row {
        min-height: 250px;
        flex-grow: 1;
    }
</style>