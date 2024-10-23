<script setup>
import { defineComponent, h, onMounted } from 'vue';

import { GChart } from 'vue-google-charts';
const props = defineProps(['data', 'type'])
const type = 'Gauge';
const settings = {
    packages:['gauge']
}
const data2 = [
    ['Label', 'Value'],
    ['Memory', 80]
];
let options;
if(props.type=='positive'){
    options = {
        width: 800,
        height: 200,
        greenFrom: 90,
        greenTo: 100,
        yellowFrom: 75,
        yellowTo: 90,
        minorTicks: 5,
    };
}
else{
    options = {
        width: 800,
        height: 200,
        redFrom: 90,
        redTo: 100,
        yellowFrom: 75,
        yellowTo: 90,
        minorTicks: 5,
    };
}


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
                    packages: ['gauge'],
                },
            });
    },
});
</script>

<template>
    <GChart
        type="Gauge"
        :data="data"
        :options="options"
        :settings="settings"
    />
</template>

<style scoped>

</style>
