<template>
    <div class="row list-images">
        <div class="col-md-12">
            <NasaImageDay/>
        </div>
        <div v-for="(image, key) in images" class="col-md-4" v-bind:key="key" v-if="key > 0">
            <NasaImageCard
                    v-bind:image="image"
            ></NasaImageCard>
        </div>
    </div>
</template>

<script>
    import axios from 'axios';
    import NasaImageDay from "../../components/Nasa/NasaImageDay";
    import NasaImageCard from "../../components/Nasa/NasaImageCard";

    export default {
        name: "ListNasaImages",
        components: {NasaImageDay, NasaImageCard},
        data () {
            return {
                images: []
            }
        },
        mounted () {
            axios
                .get(process.env.VUE_APP_NASA_API_URL+'/day/last/10')
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
        margin: 0 20px 20px;
        background-color: black;
        box-shadow: 10px 10px 24px #555;
        border-radius: 10px;
        color: white;
    }
</style>