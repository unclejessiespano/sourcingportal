<script setup>
import {ref, onMounted} from 'vue'
const props = defineProps(['lines'])
const ordered_qty = ref()
let qty = 0
function add(item, index, arr){
    qty += item.qty
}

onMounted(() => {

    props.lines.forEach(add)

    ordered_qty.value.innerHTML = qty

})
</script>

<template>
    <span ref="ordered_qty" class="text-centered"></span>
</template>

<style scoped>

</style>
