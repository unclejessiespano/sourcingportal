<script setup>
import moment from "moment/moment.js";

const props = defineProps(['line'])
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
    <tr class="border-b border-gray-100">
        <td class="hidden py-5 pl-8 pr-8 text-center align-top tabular-nums text-gray-700 sm:table-cell" v-html="formatStatusBadge(moment(line.delivery_date).format('L'))"></td>
        <td class="max-w-0 px-0 py-5 align-top">
            <div class="truncate font-medium text-gray-900">{{ line.supplier.name }}</div>
        </td>
        <td class="hidden py-5 pl-8 pr-8 text-right align-top tabular-nums text-gray-700 sm:table-cell">{{ line.document_date }}</td>
        <td class="hidden py-5 pl-8 pr-8 text-right align-top tabular-nums text-gray-700 sm:table-cell">{{ line.delivery_date }}</td>
        <td class="hidden py-5 pl-8 pr-8 text-right align-top tabular-nums text-gray-700 sm:table-cell">{{ line.commit_date }}</td>
    </tr>
</template>

<style scoped>

</style>
