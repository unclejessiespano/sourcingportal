<script setup>
import moment from 'moment'
import { ChevronDownIcon } from '@heroicons/vue/20/solid'
import CurrencyConverter from "@/Components/CurrencyConverter.vue"
import SuppliersGridCondensedRow from "@/Pages/Suppliers/Partials/SuppliersGridCondensedRow.vue";
import CommitDate from "@/Pages/Suppliers/Partials/CommitDate.vue";
import LineActivity from "@/Pages/Suppliers/Partials/LineActivity.vue";
import LineValue from "@/Pages/Orders/Partials/LineValue.vue";
const props = defineProps(['orders'])


</script>

<template>
    <div class="px-4 sm:px-6 lg:px-8">

        <div class="flow-root">
            <div class="-mx-4 -my- sm:-mx-6 lg:-mx-8">
                <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                    <table class="min-w-full divide-y divide-gray-300">
                        <thead>
                        <tr>
                            <th scope="col" class="whitespace-nowrap py-3.5 pl-4 pr-3 text-center text-sm font-semibold text-gray-900 sm:pl-0">Date</th>
                            <th scope="col" class="whitespace-nowrap py-3.5 pl-4 pr-3 text-center text-sm font-semibold text-gray-900 sm:pl-0">PO</th>
                            <th scope="col" class="whitespace-nowrap py-3.5 pl-4 pr-3 text-center text-sm font-semibold text-gray-900 sm:pl-0">Supplier</th>
                            <th scope="col" class="whitespace-nowrap py-3.5 pl-4 pr-3 text-center text-sm font-semibold text-gray-900 sm:pl-0">Lines</th>
                            <th scope="col" class="whitespace-nowrap py-3.5 pl-4 pr-3 text-center text-sm font-semibold text-gray-900 sm:pl-0">Value</th>
                            <th v-if="showViewButton" scope="col" class="relative whitespace-nowrap py-3.5 pl-3 pr-4 sm:pr-0">
                                <span class="sr-only-">Edit</span>
                            </th>
                        </tr>

                        </thead>
                        <tbody class="divide-y divide-gray-200 bg-white">
                        <tr v-for="order in orders">
                            <td class="whitespace-nowrap py-2 pl-4 pr-3 text-sm text-gray-500 sm:pl-0">{{ moment(order.document_date).format('L') }}</td>
                            <td class="whitespace-nowrap py-2 pl-4 pr-3 text-sm text-gray-500 sm:pl-0"><a :href="'/order/'+order.id">{{ order.PO }}</a></td>
                            <td class="whitespace-nowrap py-2 pl-4 pr-3 text-sm text-gray-500 sm:pl-0"><a :href="'/supplier/'+order.supplier.slug">{{ order.supplier.name }}</a></td>
                            <td class="whitespace-nowrap py-2 pl-4 pr-3 text-sm text-gray-500 sm:pl-0 text-center"><a :href="'/order/'+order.id">{{ order.lines.length }}</a></td>
                            <td class="whitespace-nowrap py-2 pl-4 pr-3 text-sm text-gray-500 sm:pl-0"><LineValue :lines="order.lines" /></td>
                            <td class="relative whitespace-nowrap py-2 pl-3 pr-4 text-right text-sm font-medium sm:pr-0">
                                <a :href="'/order/'+order.id" type="button" class="rounded bg-indigo-600 px-2 py-1 text-xs font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">View</a>
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
