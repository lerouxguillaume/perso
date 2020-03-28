<template>
    <video :src=src autoplay="" controls>
    </video>
</template>

<script>
    export default {
        name: "Document",
        data() {
            return {
                src :  process.env.VUE_APP_DOCUMENT_API_URL+'/download/'+this.$route.params.id
            }
        }
    }
</script>

<style scoped>

</style>