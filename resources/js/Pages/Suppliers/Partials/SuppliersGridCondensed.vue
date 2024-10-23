<script setup>
import { ref } from 'vue'
import { Switch } from '@headlessui/vue'
import { CalendarIcon } from '@heroicons/vue/20/solid'
import SuppliersGridCondensedRow from "@/Pages/Suppliers/Partials/SuppliersGridCondensedRow.vue";
const props = defineProps(['po','orders', 'line', 'lineActivities', 'showViewButton', 'return_to_route', 'lines', 'type'])
const show_view_button = props.showViewButton


const enabled = ref(false)
function formatStatusBadge(status){
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
    <div class="px-4 sm:px-6 lg:px-8">

        <div class="flow-root">
            <div class="-mx-4 -my- sm:-mx-6 lg:-mx-8">
                <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                    <table class="min-w-full divide-y divide-gray-300">
                        <thead>
                        <tr v-if="type='orders'">
                            <th scope="col" class="whitespace-nowrap py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-0">&nbsp;</th>
                            <th scope="col" class="whitespace-nowrap py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-0">Date</th>
                            <th scope="col" class="whitespace-nowrap py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-0">PO</th>
                            <th scope="col" class="whitespace-nowrap px-2 py-3.5 text-left text-sm font-semibold text-gray-900">SKU</th>
                            <th scope="col" class="whitespace-nowrap px-2 py-3.5 text-left text-sm font-semibold text-gray-900">Line</th>
                            <th scope="col" class="whitespace-nowrap px-2 py-3.5 text-left text-sm font-semibold text-gray-900">Due Date</th>
                            <th scope="col" class="whitespace-nowrap px-2 py-3.5 text-left text-sm font-semibold text-gray-900">Stat Rel Del Date</th>
                            <th scope="col" class="whitespace-nowrap px-2 py-3.5 text-left text-sm font-semibold text-gray-900">Commit Date</th>
                            <th scope="col" class="whitespace-nowrap px-2 py-3.5 text-left text-sm font-semibold text-gray-900">Price</th>
                            <th scope="col" class="whitespace-nowrap px-2 py-3.5 text-left text-sm font-semibold text-gray-900">Quantity</th>
                            <th scope="col" class="whitespace-nowrap px-2 py-3.5 text-left text-sm font-semibold text-gray-900">Net amount</th>
                            <th scope="col" class="whitespace-nowrap px-2 py-3.5 text-left text-sm font-semibold text-gray-900">&nbsp;</th>
                            <th v-if="showViewButton" scope="col" class="relative whitespace-nowrap py-3.5 pl-3 pr-4 sm:pr-0">
                                <span class="sr-only-">Edit</span>
                            </th>
                        </tr>
                        <tr v-else>
                            <th scope="col" class="whitespace-nowrap py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-0">&nbsp;</th>
                            <th scope="col" class="whitespace-nowrap py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-0">Date</th>
                            <th scope="col" class="whitespace-nowrap py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-0">PO</th>
                            <th scope="col" class="whitespace-nowrap px-2 py-3.5 text-left text-sm font-semibold text-gray-900">SKU</th>
                            <th scope="col" class="whitespace-nowrap px-2 py-3.5 text-left text-sm font-semibold text-gray-900">Line</th>
                            <th scope="col" class="whitespace-nowrap px-2 py-3.5 text-left text-sm font-semibold text-gray-900">Due Date</th>
                            <th scope="col" class="whitespace-nowrap px-2 py-3.5 text-left text-sm font-semibold text-gray-900">Stat Rel Del Date</th>
                            <th scope="col" class="whitespace-nowrap px-2 py-3.5 text-left text-sm font-semibold text-gray-900">Commit Date</th>
                            <th scope="col" class="whitespace-nowrap px-2 py-3.5 text-left text-sm font-semibold text-gray-900">Price</th>
                            <th scope="col" class="whitespace-nowrap px-2 py-3.5 text-left text-sm font-semibold text-gray-900">Quantity</th>
                            <th scope="col" class="whitespace-nowrap px-2 py-3.5 text-left text-sm font-semibold text-gray-900">Net amount</th>
                            <th scope="col" class="whitespace-nowrap px-2 py-3.5 text-left text-sm font-semibold text-gray-900">&nbsp;</th>
                            <th v-if="showViewButton" scope="col" class="relative whitespace-nowrap py-3.5 pl-3 pr-4 sm:pr-0">
                                <span class="sr-only-">Edit</span>
                            </th>
                        </tr>

                        </thead>
                        <tbody class="divide-y divide-gray-200 bg-white">
                            <SuppliersGridCondensedRow :return_to_route="return_to_route" :type="type" :orders="orders" :lines="lines" :line="line" :lineActivities="lineActivities" :show_ViewButton="show_view_button" />

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</template>

