<script setup>

import {CalendarIcon} from "@heroicons/vue/20/solid/index.js";
import {Switch} from "@headlessui/vue";
</script>

<template>
    <td class="whitespace-nowrap py-2 pl-4 pr-3 text-sm text-gray-500 sm:pl-0"></td>
    <td class="whitespace-nowrap py-2 pl-4 pr-3 text-sm text-gray-500 sm:pl-0">{{ order.document_date }}</td>
    <td class="whitespace-nowrap py-2 pl-4 pr-3 text-sm text-gray-500 sm:pl-0">{{ order.PO }}</td>
    <td class="whitespace-nowrap px-2 py-2 text-sm font-medium text-gray-500">1</td>
    <td class="whitespace-nowrap px-2 py-2 text-sm text-gray-500">2</td>
    <td class="whitespace-nowrap px-2 py-2 text-sm text-gray-500">{{ 3 }}</td>
    <td class="whitespace-nowrap px-2 py-2 text-sm text-gray-500">{{ 4 }}</td>
    <td class="whitespace-nowrap px-2 py-2 text-sm text-gray-500">
        <button type="button" class="inline-flex items-center gap-x-1.5 rounded-md bg-red-600 px-2 py-1 text-xs font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
            <CalendarIcon class="-ml-0.5 h-5 w-5" aria-hidden="true" />
            Commit Needed
        </button>
    </td>
    <td class="whitespace-nowrap px-2 py-2 text-sm text-gray-500">net price</td>
    <td class="whitespace-nowrap px-2 py-2 text-sm text-gray-500">qty</td>
    <td class="whitespace-nowrap px-2 py-2 text-sm text-gray-500">net price</td>
    <td class="whitespace-nowrap px-2 py-2 text-sm text-gray-500">
        <Switch v-model="enabled" class="group relative inline-flex h-5 w-10 flex-shrink-0 cursor-pointer items-center justify-center rounded-full focus:outline-none focus:ring-2 focus:ring-indigo-600 focus:ring-offset-2">
            <span class="sr-only">Use setting</span>
            <span aria-hidden="true" class="pointer-events-none absolute h-full w-full rounded-md bg-white" />
            <span aria-hidden="true" :class="[enabled ? 'bg-indigo-600' : 'bg-gray-200', 'pointer-events-none absolute mx-auto h-4 w-9 rounded-full transition-colors duration-200 ease-in-out']" />
            <span aria-hidden="true" :class="[enabled ? 'translate-x-5' : 'translate-x-0', 'pointer-events-none absolute left-0 inline-block h-5 w-5 transform rounded-full border border-gray-200 bg-white shadow ring-0 transition-transform duration-200 ease-in-out']" />
        </Switch>
    </td>
    <td class="relative whitespace-nowrap py-2 pl-3 pr-4 text-right text-sm font-medium sm:pr-0">
        <a :href="'/supplier/ferguson/'+1" type="button" class="rounded bg-indigo-600 px-2 py-1 text-xs font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">View</a>
    </td>
</template>

<style scoped>

</style>
