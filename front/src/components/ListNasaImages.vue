<template>
    <div class="row list-images">
        <div v-for="image in images" class="col-md-4">
            <NasaImage
                    v-bind:image="image"
            ></NasaImage>
        </div>
    </div>
</template>

<script>
    import NasaImage from "./NasaImage";
    import axios from 'axios';

    export default {
        name: "ListNasaImages",
        components: {NasaImage},
        data () {
            return {
                images: []
            }
        },
        mounted () {
            axios
                .get(process.env.VUE_APP_API_URL+'/day/last/12')
                .then((response) => {
                    let data = response.data;
                    data.forEach((element) => {
                        let currentImage = {};
                        currentImage.date = new Date(element.date);
                        currentImage.title = element.title;
                        currentImage.explanation = element.explanation;
                        currentImage.url = element.url;
                        currentImage.mediaType = element.media_type;
                        this.images.push(currentImage)
                    });

                })
                .catch(function (error) {
                    console.log(error);
                })
        }
    }
</script>

<style scoped>
    .list-images {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        align-content: center;
        margin: 20px;
    }
</style>