<template>
    <b-card no-body class="overflow-hidden" style="max-width: 540px; max-height: 540px;">
        <b-row no-gutters>
            <b-col md="6">
                <b-card-img v-if="image.mediaType === 'image'" v-bind:src="image.url" class="rounded-0" />
                <iframe v-else-if="image.mediaType === 'video'" :src="image.url" allowfullscreen></iframe>
            </b-col>
            <b-col md="6">
                <b-card-body v-bind:title="image.title">
                    <b-card-text>
                        {{ image.explanation | truncate(200, '...', true) }}
                    </b-card-text>
                </b-card-body>
            </b-col>
        </b-row>
    </b-card>
</template>

<script>
    export default {
        name: "NasaImage",
        props: {
            image: {
                date: null,
                title: String,
                explanation: String,
                url: String,
                mediaType: String
            }
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
    }
</style>