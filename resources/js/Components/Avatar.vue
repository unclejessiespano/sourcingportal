<script setup>
const props = defineProps(['name'])
</script>

<template>
<span class="inline-flex h-14 w-14 items-center justify-center rounded-full bg-gray-500">
    <span class="text-xl font-medium leading-none text-white">{{props.name.substr(0,1)}}</span>
</span>
</template>

<style scoped>

</style>
