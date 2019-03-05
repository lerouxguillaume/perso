<template>
    <div>
        <div id="chart-box" v-if="seriesCandle !== null">
            <div id="chart-candlestick">
                <apexchart type=candlestick height=400 :options="chartOptionsCandlestick" :series="seriesCandle" />
            </div>
            <div id="chart-bar">
                <apexchart type=bar height=300 :options="chartOptionsBar" :series="seriesBar" />
            </div>
        </div>
    </div>
</template>

<script>
    import axios from 'axios';

    export default {
        name: "Trade",
        data () {
            return {
                // Array will be automatically processed with visualization.arrayToDataTable function
                seriesCandle: null,
                seriesBar: [],
                chartOptionsCandlestick: {
                    tooltip: {
                        theme: 'dark',
                        type: 'candlestick',
                        // custom: function({series, seriesIndex, dataPointIndex, w}) {
                        //     console.log(series, seriesIndex, dataPointIndex, w)
                        //     return '<div class="arrow_box">' +
                        //         '<span>' + series[seriesIndex][dataPointIndex] + '</span>' +
                        //         '</div>'
                        // }
                        // y: {
                        //     formatter: undefined,
                        //     title: {
                        //         formatter: function (seriesName) {
                        //             console.log(seriesName);
                        //             return seriesName
                        //         }
                        //     }
                        // },
                        // y: {
                        //     formatter: function (seriesName) {
                        //         console.log(this);
                        //         return seriesName
                        //     },
                        //     title: 'Size: '
                        // },
                    },
                    chart: {
                        id: 'candles',
                        foreColor: '#fff',
                        toolbar: {
                            autoSelected: 'pan',
                            show: true
                        },
                        zoom: {
                            enabled: false
                        },
                    },
                    plotOptions: {
                        candlestick: {
                            colors: {
                                upward: '#228B22',
                                downward: '#FF0000'
                            }
                        }
                    },
                    xaxis: {
                        type: 'datetime'
                    }
                },
                chartOptionsBar: {
                    chart: {
                        foreColor: '#fff',
                        brush: {
                            enabled: true,
                            target: 'candles'
                        },
                        selection: {
                            enabled: true,
                            fill: {
                                color: '#ccc',
                                opacity: 0.4
                            },
                            stroke: {
                                color: '#228B22',
                            }
                        },
                    },
                    dataLabels: {
                        enabled: false
                    },
                    plotOptions: {
                        bar: {
                            columnWidth: '80%',
                            colors: {
                                ranges: [{
                                    from: -1000,
                                    to: 0,
                                    color: '#FF0000'
                                }, {
                                    from: 0,
                                    to: 10000,
                                    color: '#228B22'
                                }],

                            },
                        }
                    },
                    stroke: {
                        width: 0
                    },
                    xaxis: {
                        type: 'datetime',
                        axisBorder: {
                            offsetX: 13
                        }
                    },
                    yaxis: {
                        labels: {
                            show: true
                        }
                    }
                }
            }

        },
        mounted () {
            axios
                .get(process.env.VUE_APP_TRADE_API_URL+'/daily/AF')
                .then((response) => {
                    let data = response.data;
                    let candelbarData = [];
                    let barData = [];
                    for (let key in data) {
                        let currentData = data[key];
                        candelbarData.unshift([currentData.timestamp*1000, [currentData.ohlc_format.open, currentData.ohlc_format.high, currentData.ohlc_format.low, currentData.ohlc_format.close]])
                        barData.unshift([currentData.timestamp*1000, currentData.ohlc_format.close - currentData.ohlc_format.open])
                    }
                    this.seriesCandle =  [{
                        name : 'test',
                        data : candelbarData
                    }];
                    this.seriesBar =  [{
                        name : 'test-bar',
                        data : barData
                    }];
                    // this.chartData.unshift(['date', 'cote'])
                })
                .catch(function (error) {
                    console.log(error);
                })
        }
    }
</script>

<style scoped>

</style>