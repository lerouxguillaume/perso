<template>
    <b-container fluid>
        <!-- User Interface controls -->
        <b-row>
            <b-col md="6" class="my-1">
                <b-form-group label-cols-sm="3" label="Recherche" class="mb-0">
                    <b-input-group>
                        <b-form-input v-model="filter" placeholder="Type to Search" />
                        <b-input-group-append>
                            <b-button :disabled="!filter" @click="filter = ''">Clear</b-button>
                        </b-input-group-append>
                    </b-input-group>
                </b-form-group>
            </b-col>
        </b-row>

        <b-table striped hover :items="items" :busy="items.length === 0" :fields="fields"
                 :filter="filter"
                 @filtered="onFiltered"
                 @row-clicked="onRowClicked"
                 :per-page="perPage"
                 :current-page="currentPage"
        >
        </b-table>
        <b-pagination
                v-model="currentPage"
                :total-rows="totalRows"
                :per-page="perPage"
                aria-controls="my-table"
        ></b-pagination>
    </b-container>
</template>

<script>
    export default {
        name: "DataGrid",
        props: {
            id : String,
            fields : Array,
            items : Function,
            initialPage : {
                type: Number,
                default: 1,
            },
            perPage : Number,
            totalRows : Number,
            filter: String,
            onFiltered: Function,
            onRowClicked: Function
        },
        data() {
            return {
                currentPage: this.initialPage
            }
        }
    }
</script>

<style scoped>

</style>