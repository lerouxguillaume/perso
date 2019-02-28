<template>
    <div v-if = "title !== null">
        <h4>{{ title }} ({{ date | moment("dddd, MMMM Do YYYY") }})</h4>
        <iframe v-if="mediaType === 'video'" :src="url" allowfullscreen></iframe>
        <img v-else-if="mediaType === 'image'" :src="url" allowfullscreen></img>
        <p>{{ explanation }}</p>
    </div>
</template>

<script>
    import axios from 'axios';

    export default {
        name: "ImageOfTheDay",
        data () {
            return {
                date : null,
                title : null,
                explanation : null,
                url : null,
                mediaType : null
            }
        },
        mounted () {
            axios
                .get(process.env.VUE_APP_API_URL+'/day')
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

</style>