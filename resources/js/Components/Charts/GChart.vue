<script setup>
import { GChart } from 'vue-google-charts'
import {defineComponent, h} from "vue";
const props = defineProps(['supplychain'])
const type='Sankey';
const chartData = [
    ['Year', 'Sales', 'Expenses', 'Profit'],
    ['2014', 1000, 400, 200],
    ['2015', 1170, 460, 250],
    ['2016', 660, 1120, 300],
    ['2017', 1030, 540, 350]
]

const chartOptions = {
    chart: {
        title: 'Company Performance',
        subtitle: 'Sales, Expenses, and Profit: 2014-2017',
    }
}

const settings = {
    packages:['sankey']
}

const data = [
    ['From', 'To', 'Weight'],
    ['A', 'X', 1],
    ['A', 'Y', 1],
    ['A', 'Z', 1],
    ['B', 'X', 1],
    ['B', 'Y', 1],
    ['B', 'Z', 1],
    ['X', 'Boomsnap', 1]
];
const options = {
    width:1200,
    height:800

};
defineComponent({
    name: 'GoogleChart',
    components: {
        GChart,
    },
    setup() {
        return () =>
            h(GChart, {
                data,
                options,
                type,
                settings: {
                    packages: ['sankey'],
                },
            });
    },
});
</script>

<template>
    <GChart
        type="Sankey"
        :data="supplychain"
        :options="options"
        :settings="settings"
    />
    <GoogleChart />
</template>

<style scoped>

</style>
