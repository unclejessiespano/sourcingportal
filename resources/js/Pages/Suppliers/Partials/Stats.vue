<script setup>
const props = defineProps(['stat1Name', 'stat1Value', 'stat2Name', 'stat2Value', 'stat3Name', 'stat3Value'])
const stats = [
    { name: props.stat1Name, stat: props.stat1Value },
    { name: props.stat2Name, stat: props.stat2Value },
    { name: props.stat3Name, stat: props.stat3Value },
]

</script>

<template>
    <div>
        <h3 class="text-base font-semibold leading-6 text-gray-900">Last 30 days</h3>
        <dl class="mt-5 grid grid-cols-1 gap-5 sm:grid-cols-3">
            <div v-for="item in stats" :key="item.name" class="overflow-hidden rounded-lg bg-white px-4 py-5 shadow sm:p-6">
                <dt class="truncate text-sm font-medium text-gray-500">{{ item.name }}</dt>
                <dd class="mt-1 text-3xl font-semibold tracking-tight text-gray-900">{{ item.stat }}</dd>
            </div>
        </dl>
    </div>
</template>

<style scoped>

</style>
