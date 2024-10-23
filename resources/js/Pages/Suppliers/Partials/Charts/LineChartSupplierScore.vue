<script>
import VueApexCharts from "vue3-apexcharts";

export default {
    name: 'Chart',
    components: {
        apexcharts: VueApexCharts,
    },
    props:['supplier_scores'],
    data: function(props) {
        return {
            chartOptions: {
                chart: {
                    id: 'basic-bar'
                },
                xaxis: {
                    categories: [1991, 1992, 1993, 1994, 1995, 1996, 1997, 1998]
                },
                yaxis:{
                    show:true,
                    max:100,
                    min:1
                },
                annotations:{
                    yaxis: [{
                        y: 60,
                        borderColor: '#ee4444',
                        label: {
                            borderColor: '#ee4444',
                            style: {
                                color: '#fff',
                                background: '#ee4444',
                            },
                            text: 'Escalation',
                        }
                    }],
                    points: [{
                        x: "2022-03-22",
                        y: 73,
                        marker: {
                            size: 8,
                            fillColor: '#fff',
                            strokeColor: 'red',
                            radius: 2,
                            cssClass: 'apexcharts-custom-class'
                        },
                        label: {
                            borderColor: '#FF4560',
                            offsetY: 0,
                            style: {
                                color: '#fff',
                                background: '#FF4560',
                            },

                            text: 'Commit Expected',
                        }
                    }],
                },
                dataLabels:{
                    enabled:false
                }
            },
            markers:{
                size:40
            },
            series: [{
                name: 'Activity',
                data: props.supplier_scores
            }],

        }

    },
}
</script>

<template>
    <div class="example">
        <apexcharts width="100%" height="350" type="line" :options="chartOptions" :series="series"></apexcharts>
    </div>
</template>

<style scoped>

</style>
