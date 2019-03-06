<template>
    <div>
        <div id="chart-box" v-if="seriesCandle !== null">
            <div id="chart-candlestick">
                <apexchart height=400 :options="chartOptionsCandlestick" :series="seriesCandle" />
            </div>
            <div id="chart-bar">
                <apexchart height=300 :options="chartOptionsBar" :series="seriesBar" />
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
                seriesBarValue: [],
                seriesBarPercent: [],
                chartOptionsCandlestick: {
                    colors: ['#ff45ed'],
                    tooltip: {
                        theme: 'dark',
                        custom: function({series, seriesIndex, dataPointIndex, w}) {
                            let o = w.globals.seriesCandleO[0][dataPointIndex]
                            let h = w.globals.seriesCandleH[0][dataPointIndex]
                            let l = w.globals.seriesCandleL[0][dataPointIndex]
                            let c = w.globals.seriesCandleC[0][dataPointIndex]
                            let relative = (parseFloat(c) * 100 / parseFloat(o) - 100).toFixed(2);
                            return (
                                '<div class="apexcharts-tooltip-candlestick">' +
                                '<div>Open: <span class="value">' + o + '</span></div>' +
                                '<div>High: <span class="value">' + h + '</span></div>' +
                                '<div>Low: <span class="value">' + l + '</span></div>' +
                                '<div>Close: <span class="value">' + c + '</span></div>' +
                                '<div>Variation: <span class="value">' + relative + ' %</span></div>' +
                                '</div>'
                            )
                        }
                    },
                    stroke: {
                        width: 1,
                    },
                    chart: {
                        id: 'candles',
                        foreColor: '#fff',
                        zoom: {
                            enabled: false
                        },
                    },
                    legend: {
                        show: false
                    },
                    plotOptions: {
                        candlestick: {
                            colors: {
                                upward: '#228B22',
                                downward: '#FF0000'
                            }
                        },
                        line: {
                        }
                    },
                    xaxis: {
                        type: 'datetime'
                    }
                },
                chartOptionsBar: {
                    tooltip: {
                        enabled: true,
                        theme: 'dark',
                    },
                    chart: {
                        foreColor: '#fff',
                        type: 'line',

                        brush: {
                            enabled: true,
                            target: 'candles',
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
                            columnWidth: '90%',
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
                        },
                    },
                    stroke: {
                        width: [0, 4]
                    },
                    xaxis: {
                        type: 'datetime',
                        axisBorder: {
                            offsetX: 13
                        }
                    },
                    yaxis: [{
                        labels: {
                            show: true
                        }},
                        {
                            opposite: true,
                            min:40

                        }]
                }
            }

        },
        mounted () {
            axios
                .get(process.env.VUE_APP_TRADE_API_URL+'/daily/'+this.$route.params.company)
                .then((response) => {
                    let data = response.data;
                    let candelbarData = [];
                    let barAbsoluteData = [];
                    let barVariableData = [];
                    let lineData = [];
                    for (let key in data) {
                        let currentData = data[key];
                        candelbarData.unshift([currentData.timestamp*1000, [currentData.open, currentData.high, currentData.low, currentData.close]])
                        barAbsoluteData.unshift([currentData.timestamp*1000, currentData.close - currentData.open])
                        barVariableData.unshift([currentData.timestamp*1000, currentData.close *100 / currentData.open -100])
                        lineData.unshift([currentData.timestamp*1000, currentData.close ])
                    }
                    this.seriesCandle =  [
                        {
                            name : 'test',
                            type : 'candlestick',
                            data : candelbarData
                        },
                        {
                            name : 'variation_line',
                            type: 'line',
                            data : lineData
                        }
                    ];
                    this.seriesBar =  [
                        {
                            name : 'variation_absolute',
                            type: 'column',
                            data : barAbsoluteData
                        },
                        // {
                        //     name : 'variation_percent',
                        //     type: 'bar',
                        //     data : barVariableData
                        // },
                    ];
                })
                .catch(function (error) {
                    console.log(error);
                })
        }
    }
</script>

<style scoped>

</style>