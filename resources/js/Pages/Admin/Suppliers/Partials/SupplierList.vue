<script setup>
import ScoreBadge from "@/Pages/Suppliers/Partials/ScoreBadge.vue";
const props = defineProps(['suppliers'])
</script>

<template>
    <ul role="list" class="divide-y divide-gray-100">
        <li v-for="(value, key) in suppliers" :key="value.id" class="flex justify-between gap-x-6 py-5">
            <div class="flex min-w-0 gap-x-4 items-center">
                <div class="flex-auto">
                    <ScoreBadge :score="value.score" />
                </div>
                <div class="min-w-0 flex-auto">
                    <p class="text-sm font-semibold leading-6 text-gray-900">{{key}}</p>
                </div>
            </div>
            <div class="hidden shrink-0 sm:flex sm:flex-col sm:items-end">
                <a :href="'/admin/supplier/'+value.slug+'/scores'" class="rounded-md bg-indigo-600 px-3.5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Go</a>
            </div>
        </li>
    </ul>
</template>

<style scoped>

</style>
