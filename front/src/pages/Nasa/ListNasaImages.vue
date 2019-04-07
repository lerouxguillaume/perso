<template>
    <div class="row list-images">
        <div class="col-md-12">
            <NasaImageDay/>
        </div>
        <div class="list-images-wrapper">
            <span href="#" role="button" v-if="baseDate < maxDate" @click="previous" aria-controls="carousel-1___BV_inner_" class="carousel-control-prev">
                <span aria-hidden="true" class="carousel-control-prev-icon"></span>
                <span class="sr-only">Previous Slide</span>
            </span>
            <b-row class="list-images-container" v-if="images.length > 0">
                <div v-for="(image, key) in images" class="col-md-4" v-bind:key="key">
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
            <span href="#" role="button" @click="next" aria-controls="carousel-1___BV_inner_" class="carousel-control-next">
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

    export default {
        name: "ListNasaImages",
        components: {NasaImageDay, NasaImageCard},
        data () {
            return {
                limit : 9,
                page: this.$route.params.page === undefined ? 0 : this.$route.params.page,
                maxDate : moment().subtract(2, "days"),
                images: []
            }
        },
        computed: {
            baseDate: function () {
                return moment().subtract(1 + (this.limit*this.page), "days");
            }
        },
        methods: {
            previous () {
                this.page--;
                this.$router.push({name: 'nasa_list_image', params: { page : this.page }})
                this.images = loadData(this.page, this.limit);
            },
            next () {
                this.page++;
                this.$router.push({name: 'nasa_list_image', params: { page : this.page }})
                this.images = loadData(this.page, this.limit);
            }
        },
        mounted () {
            this.images = loadData(this.page, this.limit);
        }
    }

    /**
     * @param page
     * @param limit
     * @returns {Array}
     */
    function loadData(page, limit) {
        let datetime = moment().subtract(1 + (limit*page), "days");
        let res = [];
        axios
            .get(process.env.VUE_APP_NASA_API_URL+'/search/'+moment(datetime).format('DD-MM-YYYY')+'/'+limit)
            .then((response) => {
                let data = response.data;
                data.forEach((element) => {
                    let currentImage = {};
                    currentImage.date = new Date(element.date);
                    currentImage.title = element.title;
                    currentImage.explanation = element.explanation;
                    currentImage.url = element.url;
                    currentImage.mediaType = element.media_type;
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
    .list-images-container {
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