<template>
    <div>
        <h1>{{ entreprise.raisonSociale }}</h1>
        <b-nav pills>
            <b-nav-item :active="filter === 'week'" @click="selectPeriod('week')">week</b-nav-item>
            <b-nav-item :active="filter === 'month'" @click="selectPeriod('month')">month</b-nav-item>
            <b-nav-item :active="filter === 'year'" @click="selectPeriod('year')">year</b-nav-item>
            <b-nav-item :active="filter === 'all'" @click="selectPeriod('all')">all</b-nav-item>
        </b-nav>
        <apexchart width="500" type="line" :options="options" :series="series"></apexchart>
    </div>
</template>

<script>
    import axios from 'axios';
    import moment from 'moment';
    /* eslint-disable no-console */

    export default {
        name: "Trade",
        data () {
            return {
                entreprise: {
                    raisonSociale: null,
                },
                filter: 'week',
                // Array will be automatically processed with visualization.arrayToDataTable function
                data: [],
                options: {
                    colors: ['#ff3e31'],
                    stroke: {
                        width: 1
                    },
                    chart: {
                        foreColor: '#fff'
                    },
                    tooltip: {
                        theme: 'dark',
                        x: {
                            format: 'dd/MM/yyyy'
                        }
                    },
                    xaxis: {
                        type: 'datetime',
                        labels: {
                            format: 'dd/MM/yyyy'
                        }
                    }
                }
            }
        },
        computed: {
            series: function() {
                let filter = 0;

                switch (this.filter) {
                    case 'week':
                        filter = moment().subtract(1, 'weeks').startOf('day').unix()*1000;
                        break;
                    case 'month':
                        filter = moment().subtract(1, 'months').startOf('day').unix()*1000;
                        break;
                    case 'year':
                        filter = moment().subtract(1, 'years').startOf('day').unix()*1000;
                        break;
                }
                let data = this.data.filter(data => data[0] >= filter);
                return [
                    {
                        name: 'cours',
                        type: 'area',
                        data: data
                    }
                ]
            }
        },
        methods: {
           selectPeriod: function (filter) {
               this.filter = filter;
           }
        },
        mounted () {
            axios
                .get(process.env.VUE_APP_TRADE_API_URL+'/daily/'+this.$route.params.company)
                .then((response) => {
                    this.entreprise.raisonSociale = response.data.entreprise.raison_sociale;
                    let data = response.data.data;
                    for (let key in data) {
                        let currentData = data[key];
                        this.data.unshift([currentData.timestamp*1000, currentData.close ])
                    }
                })
                .catch(function (error) {
                    console.log(error);
                })
        }
    }
</script>

<style scoped>

</style>