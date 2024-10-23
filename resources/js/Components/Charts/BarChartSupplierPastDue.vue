<script setup>
import { defineComponent, h, onMounted } from 'vue';

import { GChart } from 'vue-google-charts';
const props = defineProps(['data', 'type'])
const type = 'ColumnChart';
const settings = {
    packages:['corechart']
}

const options = {
    title:"% Past Due by Suppliers",
    bars:'vertical'
};



</script>

<template>
    <GChart
        :type="type"
        :data="data"
        :options="options"
        :settings="settings"
    />
</template>

<style scoped>

</style>
