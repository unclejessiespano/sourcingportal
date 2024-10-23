<script setup>
import { ArrowDownIcon, ArrowUpIcon } from '@heroicons/vue/20/solid'
const props = defineProps(['escalations', 'escalations_stats'])
const stats = [
    { name: 'Suppliers', stat: props.escalations_stats.count, previousStat: '70,946', change: '12%', changeType: 'increase' },
    { name: 'Avg. Supplier Score', stat: props.escalations_stats.average_supplier_score, previousStat: '56.14%', change: '2.02%', changeType: 'increase' },
    { name: 'Lines', stat: props.escalations_stats.total_lines, previousStat: '28.62%', change: '4.05%', changeType: 'decrease' },
]
</script>

<template>
    <div>
        <h3 class="text-base font-semibold leading-6 text-gray-900">Last 30 days</h3>
        <dl class="mt-5 grid grid-cols-1 divide-y divide-gray-200 overflow-hidden rounded-lg bg-white shadow md:grid-cols-3 md:gap-4 md:divide-x md:divide-y-0">
            <div v-for="item in stats" :key="item.name" class="px-4 py-5 sm:p-6">
                <dt class="text-base font-normal text-gray-900">{{ item.name }}</dt>
                <dd class="mt-1 flex items-baseline justify-between md:block lg:flex">
                    <div class="flex items-baseline text-2xl font-semibold text-indigo-600">
                        {{ item.stat }}
                    </div>


                </dd>
            </div>
        </dl>
    </div>
</template>

<style scoped>

</style>
