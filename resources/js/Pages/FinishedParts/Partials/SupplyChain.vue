<script setup>
import { CheckCircleIcon, ExclamationCircleIcon } from '@heroicons/vue/20/solid'
import moment from 'moment'
const props = defineProps(['supplychain'])
function formatStatusBadge(dueDate){
    var status = "ontime";
    var today = moment().format('L');

    const date1 = new Date(dueDate);
    const date2 = new Date(today);

    if(date2>date1){
        status = "late";
    }
    var color = null;
    switch(status){
        case "ontime":
            color = "green";
            break;
        case "attention":
            color = "yellow";
            break;
        case "late":
            color = "red";
            break;

    }
    return "<span class='inline-flex items-center rounded-md bg-"+color+"-50 px-2 py-1 text-xs font-medium text-"+color+"-700 ring-1 ring-inset ring-"+color+"-600/20'>"+status+"</span>";
}
</script>

<template>
    <div class="flow-root">
        <ul role="list" class="-mb-8">
            <li v-for="(item, index) in supplychain" :key="index">
                <div class="relative pb-8">
                    <span v-if="index !== supplychain.length - 1" class="absolute left-5 top-5 -ml-px h-full w-0.5 bg-gray-200" aria-hidden="true" />
                    <div class="relative flex items-start space-x-3">
                        <template v-if="item.type === 'part'">
                            <div class="relative">
                                <img class="flex h-10 w-10 items-center justify-center rounded-full bg-gray-400 ring-8 ring-white" :src="item.image" :alt="item.sku" />
                            </div>
                            <div class="min-w-0 flex-1">
                                <div>
                                    <div class="text-sm">
                                        <a :href="'/part/'+item.sku_id" class="text-2xl font-bold text-gray-900">{{ item.sku }}</a>
                                    </div>
                                </div>
                            </div>
                        </template>
                        <template v-else-if="item.type === 'line'">
                            <div>
                                <div class="relative px-1">
                                    <div class="flex h-8 w-8 items-center justify-center rounded-full bg-gray-100 ring-8 ring-white">
                                        <ExclamationCircleIcon v-if="item.status=='late'" class="h-5 w-5 text-red-500" aria-hidden="true" />
                                        <CheckCircleIcon v-else class="h-5 w-5 text-green-500" aria-hidden="true" />
                                    </div>
                                </div>
                            </div>
                            <div class="min-w-0 flex-1 py-1.5">
                                <div class="text-sm text-gray-500" v-html="item.message"></div>
                            </div>
                        </template>

                    </div>
                </div>
            </li>
        </ul>
    </div>
</template>

<style scoped>

</style>
