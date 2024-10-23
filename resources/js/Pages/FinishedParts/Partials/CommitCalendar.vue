<script setup>
import { GChart } from 'vue-google-charts'
import {defineComponent, h} from "vue";
const props = defineProps(['supplychain', 'commitsForCalendar', 'part'])
const type='Sankey';


let title;
title = (props.part) ? props.part+" Commit Calendar" : "Commit Calendar";

const settings = {
    packages:['calendar']
}

const data = [
    [{type:'date', id:'Date'},{type:'number',id:'Commits'}]
];
const options = {
    title:title,

};
for(const[key,value] of Object.entries(props.commitsForCalendar)){
    data.push([new Date(value[0], value[1], value[2]), value[3]]);
}
</script>

<template>
    <GChart
        type="Calendar"
        :data="data"
        :options="options"
        :settings="settings"
    />
</template>

<style scoped>

</style>
