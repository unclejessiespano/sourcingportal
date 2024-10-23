<script setup>
    import OrderedQty from "@/Pages/Parts/Partials/OrderedQty.vue"
    import PartValue from "@/Pages/Parts/Partials/PartValue.vue"
    import {
        CheckCircleIcon,
        ExclamationTriangleIcon,
        ExclamationCircleIcon
    } from '@heroicons/vue/20/solid'
    import {
        FaceFrownIcon,
        FaceSmileIcon,
        FireIcon,
        HandThumbUpIcon,
        HeartIcon,
        XMarkIcon
    } from "@heroicons/vue/20/solid/index.js";
    import moment from "moment/moment.js";
    const props = defineProps(['parts'])

    const statusIcons = [
        { name: 'Good', value: 'good', icon: CheckCircleIcon, iconColor: 'text-white', bgColor: 'bg-green-500' },
        { name: 'Caution', value: 'caution', icon: ExclamationTriangleIcon, iconColor: 'text-white', bgColor: 'bg-amber-500' },
        { name: 'Poor', value: 'poor', icon: ExclamationCircleIcon, iconColor: 'text-white', bgColor: 'bg-red-500' },
    ]
    function formatStatusBadge(number, type){
        let color;
        if(type=='positive'){
            if(number >=80){
                color = "green";
                return "<span class='inline-flex items-center rounded-md bg-"+color+"-500 px-2 py-1 text-xs font-medium text-white ring-1 ring-inset ring-bg-"+color+"-500-600/20'>"+number+"%</span>";
            }
            else if((number >=50) && (number <80)){
                return "<span class='inline-flex items-center rounded-md bg-amber-500 px-2 py-1 text-xs font-medium text-white ring-1 ring-inset ring-bg-amber-500-600/20'>"+number+"%</span>";
            }
            else{
                color = "red";
                return "<span class='inline-flex items-center rounded-md bg-"+color+"-500 px-2 py-1 text-xs font-medium text-white ring-1 ring-inset ring-bg-"+color+"-500-600/20'>"+number+"%</span>";
            }
        }
        else{
            if(number >=80){
                color = "red";
                return "<span class='inline-flex items-center rounded-md bg-"+color+"-500 px-2 py-1 text-xs font-medium text-white ring-1 ring-inset ring-bg-"+color+"-500-600/20'>"+number+"%</span>";
            }
            else if((number >=50) && (number <80)){
                return "<span class='inline-flex items-center rounded-md bg-amber-500 px-2 py-1 text-xs font-medium text-white ring-1 ring-inset ring-bg-amber-500-600/20'>"+number+"%</span>";
            }
            else{
                color = "green";
                return "<span class='inline-flex items-center rounded-md bg-"+color+"-500 px-2 py-1 text-xs font-medium text-white ring-1 ring-inset ring-bg-"+color+"-500-600/20'>"+number+"%</span>";
            }
        }


    }
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
                            <th scope="col" class="px-3 py-3.5 text-center text-sm font-semibold text-gray-900">Lines</th>
                            <th scope="col" class="px-3 py-3.5 text-center text-sm font-semibold text-gray-900">QTY Ordered</th>
                            <th scope="col" class="px-3 py-3.5 text-center text-sm font-semibold text-gray-900">Value</th>
                            <th scope="col" class="px-3 py-3.5 text-center text-sm font-semibold text-gray-900">Late</th>
                            <th scope="col" class="px-3 py-3.5 text-center text-sm font-semibold text-gray-900">Committed</th>
                            <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-0">
                                <span class="sr-only">Edit</span>
                            </th>
                        </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 bg-white">
                        <tr v-for="part in parts" :key="part.id">
                            <td class="whitespace-nowrap py-5 pl-4 pr-3 text-sm sm:pl-0">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0">
                                        <img v-if="part.detail" class="h-11 w-11 rounded-full" :src="part.detail.image" :alt="part.name" />
                                        <img v-else class="inline-block h-14 w-14 rounded-md" src="/images/placeholder.svg" :alt="part.name" />
                                    </div>
                                    <div class="ml-4">
                                        <div class="font-medium text-gray-900"><a :href="route('part.show', [part.id])">{{ part.sku }}</a></div>
                                        <div class="mt-1 text-gray-500">{{ part.short_text }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="whitespace-nowrap px-3 py-5 text-sm text-gray-500">
                                <div class="text-gray-900 text-center">{{part.lines.length}}</div>
                            </td>
                            <td class="whitespace-nowrap px-3 py-5 text-sm text-gray-500 text-center">
                                <OrderedQty :lines="part.lines" />
                            </td>
                            <td class="whitespace-nowrap px-3 py-5 text-sm text-gray-500 text-right">
                                <PartValue :lines="part.lines" />
                            </td>
                            <td class="whitespace-nowrap px-3 py-5 text-sm text-gray-500 text-center" v-html="formatStatusBadge(part.percent_pastdue, 'negative')"></td>
                            <td class="whitespace-nowrap px-3 py-5 text-sm text-gray-500 text-center" v-html="formatStatusBadge(part.percent_committed, 'positive')"></td>
                            <td class="relative whitespace-nowrap py-5 pl-3 pr-4 text-right text-sm font-medium sm:pr-0">
                                <a :href="'/part/'+part.id" type="button" class="rounded bg-indigo-600 px-2 py-1 text-xs font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">View</a>
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
