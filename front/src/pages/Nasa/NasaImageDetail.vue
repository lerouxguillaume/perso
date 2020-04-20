<template>
    <div class="card" v-if = "title !== null">
        <div class="card-body" v-if="date !== null">
            <div class="media">
                <div class="d-flex mr-3 align-self-top">
                    <img v-if="mediaType === 'image'" :src="url" alt="placeholder" class="">
                    <iframe v-else-if="mediaType === 'video'" :src="url" width="720" height="405"></iframe>
                </div>
                <div class="media-body">
                    <h1 class="mt-0">{{ title }}</h1>
                    <div v-if="copyright" class="copyright">copyright:  <strong>{{ copyright }}</strong></div>
                    <i>{{ date | moment("dddd, MMMM Do YYYY") }}</i>
                    <p>{{ explanation }}</p>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import axios from 'axios';
    /* eslint-disable no-console */

    export default {
        name: "NasaImageDetail",
        data () {
            return {
                date : null,
                title : null,
                explanation : null,
                url : null,
                mediaType : null,
                copyright : null
            }
        },
        mounted () {
            axios
                .get(process.env.VUE_APP_API+'/image_of_the_days/'+ this.$route.params.id)
                .then((response) => {
                    let data = response.data.data.attributes;
                    this.date = new Date(data.date);
                    this.title = data.title;
                    this.explanation = data.explanation;
                    this.url = data.url;
                    this.mediaType = data.mediaType;
                    this.copyright = data.copyright;
                })
                .catch(function (error) {
                    console.log(error);
                })
        }
    }
</script>

<style scoped>
    .card {
        color: white;
        width: 80%;
        margin: 0 10%;
        align-self: center;
        background-color: black;
        box-shadow: 10px 10px 24px #555;
        border-radius: 10px;
    }
    img {
        max-height: 720px;
        max-width: 1000px;
    }
    .copyright {
        margin-bottom: 30px;
    }
</style>