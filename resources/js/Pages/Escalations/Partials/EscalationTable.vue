<script setup>
import moment from 'moment';
import ScoreBadge from "@/Pages/Suppliers/Partials/ScoreBadge.vue"

const props = defineProps(['escalations'])
</script>

<template>
    <div class="px-4 sm:px-6 lg:px-8">
        <div class="mt-8 flow-root">
            <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                    <table class="min-w-full divide-y divide-gray-300">
                        <thead>
                        <tr>
                            <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-0">Name</th>
                            <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900 text-center">Days in Escalation</th>
                            <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Escalated On</th>
                            <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900 text-center">Reasons</th>
                            <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900 text-center">Lines</th>
                            <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-0">
                                <span class="sr-only">Edit</span>
                            </th>
                        </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 bg-white">
                        <tr v-for="(escalation, supplier) in escalations">
                            <td class="whitespace-nowrap py-5 pl-4 pr-3 text-sm sm:pl-0">
                                <div class="flex items-center">
                                    <div class="h-11 w-11 flex-shrink-0">
                                        <ScoreBadge :score="escalation.score" />
                                    </div>
                                    <div class="ml-4">
                                        <div class="font-medium text-gray-900">{{supplier}}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="whitespace-nowrap px-3 py-5 text-sm text-gray-500 text-center">{{moment().diff(moment(escalation.created_at), 'days')}}</td>
                            <td class="whitespace-nowrap px-3 py-5 text-sm text-gray-500">
                                <div class="text-gray-900">{{ moment(escalation.created_at).format('LLL') }}</div>
                            </td>

                            <td class="whitespace-nowrap px-3 py-5 text-sm text-gray-500 text-center">{{escalation.reason_count}}</td>
                            <td class="whitespace-nowrap px-3 py-5 text-sm text-gray-500 text-center">{{escalation.lines.length}}</td>
                            <td class="relative whitespace-nowrap py-5 pl-3 pr-4 text-right text-sm font-medium sm:pr-0">
                                <a :href="'/escalation/'+escalation.id" class="rounded bg-indigo-600 px-2 py-1 text-xs font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">View</a>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped>

</style>
