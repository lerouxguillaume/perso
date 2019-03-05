<template>
    <div class="card" v-on:click="redirectTo">
        <div class="card-body" v-if="date !== null">
            <div class="media">
                <div class="d-flex mr-3 align-self-top">
                    <img v-if="mediaType === 'image'" :src="url" alt="placeholder" class="" width="400">
                    <iframe v-else-if="mediaType === 'video'" :src="url" width="520" height="300"></iframe>
                </div>
                <div class="media-body">
                    <h5 class="mt-0">{{ title }}</h5>
                    <i>{{ date | moment("dddd, MMMM Do YYYY") }}</i>
                    <p>{{ explanation }}</p>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

    import * as router from "vue-router";
    import * as moment from "moment";
    import axios from 'axios';

    export default {
        name: "NasaImageDay",
        data: () => {
            return {
                date: null,
                title: null,
                explanation: null,
                url: null,
                mediaType: null,
                router: router
            }
        },
        methods: {
            redirectTo: function() {
                this.$router.push({name: 'nasa_image_detail', params: { day : (moment(this.date).format('DD-MM-YYYY')) }})
            }
        },
        mounted () {
            axios
                .get(process.env.VUE_APP_NASA_API_URL+'/day')
                .then((response) => {
                    let data = response.data;
                    this.date = new Date(data.date);
                    this.title = data.title;
                    this.explanation = data.explanation;
                    this.url = data.url;
                    this.mediaType = data.media_type;
                })
                .catch(function (error) {
                    console.log(error);
                })
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
    .card {
        margin: 10px 0;
        width: 100%;
    }
    img {
        height: 100%;
    }
    iframe {
        color: #222222;
    }
</style>