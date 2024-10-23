<script setup>
import { ArrowDownCircleIcon, ArrowPathIcon, ArrowUpCircleIcon, ExclamationTriangleIcon } from '@heroicons/vue/20/solid'
import moment from 'moment'
const props = defineProps(['touchpoints', 'escalation', 'line'])
let USDollar = new Intl.NumberFormat('en-US',{style:'currency', currency:'USD'});

function calculateDaysLate(due_date){
    var today = moment();
    var duedate = moment(due_date);
    return today.diff(duedate, 'days');
}
function calculateValue(item){
    return USDollar.format(item.qty*item.net_price);
}
</script>

<template>

    <table class="w-full text-left">
        <thead>
        <tr>
            <th>PO</th>
            <th>SKU</th>
            <th>Line</th>
            <th>Qty</th>
            <th>Value</th>
            <th>Due Date</th>
            <th>Commit Date</th>
            <th>Days Late</th>
            <th>&nbsp;</th>
        </tr>
        </thead>
        <tbody>
        <template v-for="(touchpoint, index) in touchpoints" :key="index">
            <tr class="text-sm leading-6 text-gray-900">
                <th scope="colgroup" colspan="4" class="relative isolate py-2 font-semibold">
                    {{index}}
                    <div class="absolute inset-y-0 right-full -z-10 w-screen border-b border-gray-200 bg-gray-50" />
                    <div class="absolute inset-y-0 left-0 -z-10 w-screen border-b border-gray-200 bg-gray-50" />
                </th>
            </tr>
            <template v-for="items in touchpoint" :key="items.id">
                <tr v-for="item in items">

                    <td class="relative py-5 pr-6">
                        <div class="flex gap-x-6">{{item.order.PO}}</div>
                        <div class="absolute bottom-0 right-full h-px w-screen bg-gray-100" />
                        <div class="absolute bottom-0 left-0 h-px w-screen bg-gray-100" />
                    </td>
                    <td class="hidden py-5 pr-6 sm:table-cell">{{item.sku.sku}}</td>
                    <td class="py-5">{{item.line_id}}</td>
                    <td class="py-5"><template v-if="item.liner">{{item.liner.qty}}</template></td>
                    <td class="py-5"><template v-if="item.liner"><span v-html="calculateValue(item.liner)"></span></template></td>
                    <td class="py-5"><template v-if="item.liner">{{moment(item.liner.delivery_date).format('LL')}}</template></td>
                    <td class="py-5">
                        <template v-if="item.liner">
                            <template v-if="item.liner.commit_date">{{moment(item.liner.commit_date).format('LL')}}</template>
                            <template v-else>
                                <span class="inline-flex items-center rounded-full bg-yellow-100 px-3 py-2 text-xs font-medium text-yellow-800"> <ExclamationTriangleIcon class="h-5 w-5 text-yellow-400" aria-hidden="true" /> Commit Needed</span>
                            </template>
                        </template></td>
                    <td class="py-5"><template v-if="item.liner"><span v-html="calculateDaysLate(moment(item.liner.delivery_date).format('LL'))"></span></template></td>
                    <td class="py-5">
                        <template v-if="line"></template>
                        <template v-else>
                            <template v-if="item.liner">
                                <a :href="'/escalation/'+escalation.id+'/'+item.liner.identifier" class="rounded bg-indigo-600 px-2 py-1 text-xs font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">View</a>
                            </template>
                        </template>
                    </td>
                </tr>
            </template>

        </template>
        </tbody>
    </table>
</template>

<style scoped>

</style>
