<template>
    <div class="row list-images">
        <div class="col-md-12" v-if="images.length > 0">
            <NasaImageDay :image="imageOfTheDay"/>
        </div>
        <div class="list-images-wrapper">
            <span href="#" role="button" v-if="page > 1" @click="previous" class="carousel-control-prev">
                <span aria-hidden="true" class="carousel-control-prev-icon"></span>
                <span class="sr-only">Previous Slide</span>
            </span>
            <b-row class="list-images-container" v-if="images.length > 0">
                <div v-for="(image, key) in otherImages" class="col-md-4" v-bind:key="key">
                    <NasaImageCard
                            v-bind:image="image"
                    >
                    </NasaImageCard>
                </div>
            </b-row>
            <b-row class="text-center" v-else>
                <div class="text-center">
                    <b-spinner label="Spinning"></b-spinner>
                </div>
            </b-row>
            <span href="#" role="button" @click="next" class="carousel-control-next">
                <span aria-hidden="true" class="carousel-control-next-icon"></span>
                <span class="sr-only">Next Slide</span>
            </span>
        </div>
    </div>
</template>

<script>
    import axios from 'axios';
    import NasaImageDay from "../../components/Nasa/NasaImageDay";
    import NasaImageCard from "../../components/Nasa/NasaImageCard";
    import * as moment from "moment";
    /* eslint-disable no-console */

    export default {
        name: "ListNasaImages",
        components: {NasaImageDay, NasaImageCard},
        data () {
            return {
                page: this.$route.params.page === undefined ? 1 : this.$route.params.page,
                maxDate : moment().subtract(2, "days"),
                images: [],
            }
        },
        computed: {
            imageOfTheDay () {
                return this.images.length > 0 ? this.images[0] : null
            },
            otherImages () {
                return this.images.length > 0 ? this.images.slice(1, this.images.length) : null
            }
        },
        methods: {
            previous () {
                this.page--;
                this.$router.push({name: 'nasa_list_image', params: { page : this.page }})
                this.images = loadData(this.page);
            },
            next () {
                this.page++;
                this.$router.push({name: 'nasa_list_image', params: { page : this.page }})
                this.images = loadData(this.page);
            }
        },
        mounted () {
            this.images = loadData(this.page);
        }
    }

    /**
     * @param page
     * @returns {Array}
     */
    function loadData(page) {
        let res = [];
        let param = {
            'headers' : {
                'Accept' : 'application/vnd.api+json'
            },
            'params' : {
                'order[date]': 'desc',
                'page': page
            }
        };
        axios
            .get(process.env.VUE_APP_API+'/image_of_the_days', param)
            .then((response) => {
                let data = response.data;
                data.data.forEach((element) => {
                    element = element.attributes;
                    let currentImage = {};
                    currentImage.date = new Date(element.date);
                    currentImage.title = element.title;
                    currentImage.explanation = element.explanation;
                    currentImage.url = element.url;
                    currentImage.mediaType = element.mediaType;
                    res.push(currentImage)
                });
            })
            .catch(function (error) {
                console.log(error);
            });
        return res;
    }
</script>

<style scoped>
    div {
        display: flex;
    }
    .text-center {
        margin-bottom: 10px;
        width: 100%;
        justify-content: center;
    }
    .carousel-control-prev, .carousel-control-next {
        position: relative;
        width: 25px;
        margin: 0 5px;
    }
    .list-images-container {
        margin: 0 5px;
    }
    .list-images-wrapper {
        width: 100%;
    }
    .list-images {
        align-items: center;
        align-content: center;
        margin: 0 20px 20px;
        background-color: black;
        box-shadow: 10px 10px 24px #555;
        border-radius: 10px;
        color: white;
    }
</style>