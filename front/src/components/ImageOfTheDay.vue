<template>
    <div v-if = "title !== null">
        <b-card>
            <b-media>
                <iframe v-if="mediaType === 'video'" :src="url" allowfullscreen></iframe>
                <b-img v-else-if="mediaType === 'image'" :src="url" slot="aside" blank-color="#ccc" alt="placeholder" />
                <!--<img v-else-if="mediaType === 'image'" :src="url"></img>-->
                <h3>{{ title }} ({{ date | moment("dddd, MMMM Do YYYY") }})</h3>
                <div v-if="copyright" class="copyright">copyright:  <strong>{{ copyright }}</strong></div>
                <div><p><i>{{ explanation }}</i></p></div>
            </b-media>
        </b-card>
    </div>
</template>

<script>
    import axios from 'axios';
    // import * as route from "vue-router";

    export default {
        name: "ImageOfTheDay",
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
                .get(process.env.VUE_APP_API_URL+'/day/'+ this.$route.params.day)
                .then((response) => {
                    let data = response.data;
                    this.date = new Date(data.date);
                    this.title = data.title;
                    this.explanation = data.explanation;
                    this.url = data.url;
                    this.mediaType = data.media_type;
                    this.copyright = data.copyright;
                })
                .catch(function (error) {
                    console.log(error);
                })
        }
    }
</script>

<style scoped>
    .copyright {
        margin-bottom: 30px;
    }
</style>