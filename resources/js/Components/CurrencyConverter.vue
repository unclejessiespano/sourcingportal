<script setup>
    import {ref, onMounted} from 'vue';
    import {router, useForm} from "@inertiajs/vue3";

    const props = defineProps(['currency', 'amount', 'amt'])
    const amount = props.amount
    let amt = ref(null);
    let USDollar = new Intl.NumberFormat('en-US', {
        style: 'currency',
        currency: 'USD',
    });
    onMounted(()=>{
        if(props.currency=='MXN'){
            amt.value = amount*0.059
        }
        else{
            amt.value = amount
        }
        console.log(amt)
    })
</script>

<template>
    {{USDollar.format(amt)}}
</template>

<style scoped>

</style>
