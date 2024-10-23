<script setup>
import {onMounted, ref} from "vue";

const props = defineProps(['lines'])
const line_value = ref()
let value = 0
let USDollar = new Intl.NumberFormat('en-US',{style:'currency', currency:'USD'});
function add(item, index, arr){
    value += parseFloat(item.net_price)
}

onMounted(() => {

    props.lines.forEach(add)
    line_value.value.innerHTML = USDollar.format(value)

})
</script>

<template>
    <span ref="line_value" class="block text-right"></span>
</template>

<style scoped>

</style>
