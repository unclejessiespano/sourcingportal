<script setup>
import {ref} from "vue";
import { Switch } from '@headlessui/vue'

import {CalendarIcon, ClockIcon, ExclamationCircleIcon, SignalIcon, TruckIcon} from "@heroicons/vue/20/solid/index.js";
import moment from 'moment';

import CommitDate from '@/Pages/Suppliers/Partials/CommitDate.vue'
import LineActivity from '@/Pages/Suppliers/Partials/LineActivity.vue'

const enabled = ref(false)
const props = defineProps(['orders', 'line', 'lines', 'lineActivities', 'show_ViewButton', 'return_to_route'])
//const selected_activity2 = (props.line) ? props.line.lineactivity.slug : "";
const selected_activity = ""



let USDollar = new Intl.NumberFormat('en-US',{style:'currency', currency:'USD'});
function calculateNet(price, qty){
    var net = price*qty;
    return USDollar.format(net);
}

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
    <template v-for="line in lines">
        <tr :class="[line.escalation ? 'bg-yellow-50' : '', '']">
            <td v-html="formatStatusBadge(moment(line.delivery_date).format('L'))" class="whitespace-nowrap py-2 pl-4 pr-3 text-sm text-gray-500 sm:pl-0"></td>
            <td class="whitespace-nowrap py-2 pl-4 pr-3 text-sm text-gray-500 sm:pl-0">{{ moment(line.order.document_date).format('L') }}</td>
            <td class="whitespace-nowrap py-2 pl-4 pr-3 text-sm text-gray-500 sm:pl-0"><a :href="'/order/'+line.order.id">{{ line.order.PO }}</a></td>
            <td v-if="line.sku" class="whitespace-nowrap px-2 py-2 text-sm font-medium text-gray-500"><a :href="'/part/'+line.sku.id">{{line.sku.sku}}</a></td>
            <td v-else class="whitespace-nowrap px-2 py-2 text-sm font-medium text-gray-500">&nbsp;</td>
            <td class="whitespace-nowrap px-2 py-2 text-sm text-gray-500">{{line.line}}</td>
            <td class="whitespace-nowrap px-2 py-2 text-sm text-gray-500">{{ moment(line.delivery_date).format('L') }}</td>
            <td class="whitespace-nowrap px-2 py-2 text-sm text-gray-500">{{ moment(line.stat_del_date).format('L') }}</td>
            <td v-if="line.commit_date" class="whitespace-nowrap px-2 py-2 text-sm text-gray-500">{{ moment(line.commit_date).format('L') }}</td>
            <td v-else class="whitespace-nowrap px-2 py-2 text-sm text-gray-500">
                <CommitDate :po="line.po_id" :sku="line.sku_id" :line="line.line"></CommitDate>

            </td>
            <td class="whitespace-nowrap px-2 py-2 text-right text-sm text-gray-500">{{USDollar.format(line.net_price)}}</td>
            <td class="whitespace-nowrap px-2 py-2 text-sm text-gray-500">{{line.qty}}</td>
            <td class="whitespace-nowrap px-2 py-2 text-right text-sm text-gray-500">{{calculateNet(line.net_price, line.qty)}}</td>
            <td class="whitespace-nowrap px-2 py-2 text-sm text-gray-500">
                <LineActivity :return_to_route="return_to_route" :line="line" :lineActivities="lineActivities" :selected_activity="selected_activity" />
            </td>
            <td class="relative whitespace-nowrap py-2 pl-3 pr-4 text-right text-sm font-medium sm:pr-0">
                <a :href="'/supplier/'+line.order.supplier.slug+'/'+line.po_id+'/'+line.sku_id+'/'+line.line" type="button" class="rounded bg-indigo-600 px-2 py-1 text-xs font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">View</a>
            </td>

        </tr>
    </template>

    <template v-if="line">
        <tr :class="[line.escalation=='y' ? 'bg-amber-500' : '', '']">
            <td v-html="formatStatusBadge(moment(line.delivery_date).format('L'))" class="whitespace-nowrap py-2 pl-4 pr-3 text-sm text-gray-500 sm:pl-0"></td>
            <td class="whitespace-nowrap py-2 pl-4 pr-3 text-sm text-gray-500 sm:pl-0">{{ moment(line.order.document_date).format('L') }}</td>
            <td class="whitespace-nowrap py-2 pl-4 pr-3 text-sm text-gray-500 sm:pl-0"><a :href="'/order/'+line.order.id">{{ line.order.PO }}</a></td>
            <td v-if="line.sku" class="whitespace-nowrap px-2 py-2 text-sm font-medium text-gray-500">{{line.sku.sku}}</td>
            <td v-else class="whitespace-nowrap px-2 py-2 text-sm font-medium text-gray-500">&nbsp;</td>
            <td class="whitespace-nowrap px-2 py-2 text-sm text-gray-500">{{line.line}}</td>
            <td class="whitespace-nowrap px-2 py-2 text-sm text-gray-500">{{ moment(line.delivery_date).format('L') }}</td>
            <td class="whitespace-nowrap px-2 py-2 text-sm text-gray-500">{{ moment(line.stat_del_date).format('L') }}</td>
            <td v-if="line.commit_date" class="whitespace-nowrap px-2 py-2 text-sm text-gray-500">{{ moment(line.commit_date).format('L') }}</td>
            <td v-else class="whitespace-nowrap px-2 py-2 text-sm text-gray-500">
                <CommitDate :po="line.po_id" :sku="line.sku_id" :line="line.line"></CommitDate>
            </td>
            <td class="whitespace-nowrap px-2 py-2 text-right text-sm text-gray-500">{{USDollar.format(line.net_price)}}</td>
            <td class="whitespace-nowrap px-2 py-2 text-sm text-gray-500">{{line.qty}}</td>
            <td class="whitespace-nowrap px-2 py-2 text-right text-sm text-gray-500">{{calculateNet(line.net_price, line.qty)}}</td>
            <td class="whitespace-nowrap px-2 py-2 text-sm text-gray-500 align-center">
                <LineActivity :return_to_route="return_to_route" :line="line" :lineActivities="lineActivities" :selected_activity="selected_activity" />
            </td>
            <td v-if="show_ViewButton" class="relative whitespace-nowrap py-2 pl-3 pr-4 text-right text-sm font-medium sm:pr-0">
                <a :href="'/supplier/'+line.order.supplier.slug+'/'+line.po_id+'/'+line.sku_id+'/'+line.line" type="button" class="rounded bg-indigo-600 px-2 py-1 text-xs font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">View</a>
            </td>
        </tr>
    </template>




</template>

<style scoped>

</style>
