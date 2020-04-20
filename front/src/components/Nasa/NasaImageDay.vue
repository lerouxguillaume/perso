<template>
    <div class="card" v-on:click="redirectTo">
        <div class="card-body" v-if="image.date !== null">
            <div class="media">
                <div class="d-flex mr-3 align-self-top">
                    <img v-if="image.mediaType === 'image'" :src="image.url" alt="placeholder" class="" width="400">
                    <iframe v-else-if="image.mediaType === 'video'" :src="image.url" width="520" height="300"></iframe>
                </div>
                <div class="media-body">
                    <h5 class="mt-0">{{ image.title }}</h5>
                    <i>{{ image.date | moment("dddd, MMMM Do YYYY") }}</i>
                    <p>{{ image.explanation }}</p>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: "NasaImageDay",
        props: {
            image: Object
        },
        methods: {
            redirectTo: function() {
                this.$router.push({name: 'nasa_image_detail', params: { id : this.image.id }})
            }
        },
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
        max-height: 200px;
        object-fit: cover;
    }
    iframe {
        color: #222222;
    }
</style>