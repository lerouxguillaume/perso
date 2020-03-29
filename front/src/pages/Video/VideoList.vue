<template>
    <div id="table-entreprise">
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
            >
            </b-table>
        </b-container>
    </div>

</template>

<script>
    import ApiService from "../../services/api.service";
    /* eslint-disable no-console */

    export default {
        name: "VideoList",
        data() {
            return {
                // Note 'isActive' is left out and will not appear in the rendered table
                fields: [
                    { key: 'name', sortable: true },
                    { key: 'type', sortable: true },
                    { key: 'uploadedAt', sortable: true },
                ],
                sortBy: null,
                sortDesc: false,
                sortDirection: 'asc',
                filter: null,
                items: []
            }
        },
        methods: {
            onFiltered() {
                // Trigger pagination to update the number of buttons/pages due to filtering
            },
            onRowClicked(item) {
                this.$router.push({name: 'video', params: { id : item.id }})

                // Trigger pagination to update the number of buttons/pages due to filtering
            }
        },
        mounted () {
            ApiService.get(process.env.VUE_APP_DOCUMENT_API_URL+'/series')
                .then((response) => {
                    let data = response.data;
                    for (let key in data) {
                        this.items.push({
                            isActive: true,
                            'id' : data[key].id,
                            'name' : data[key].name,
                        })
                    }
                })
                .catch(function (error) {
                    console.log(error);
                })
        }
    }
</script>

<style scoped>
    #table-entreprise {
        width: 80%;
        margin: 20px 10%;
    }
    .success {
        color: green;
    }
    .danger {
        color: red;
    }
</style>
