<script setup>

import PartRow from "@/Pages/FinishedParts/Partials/PartRow.vue";
</script>

<template>
    <table class="mt-16 w-full whitespace-nowrap text-left text-sm leading-6">
        <colgroup>
            <col class="w-full" />
            <col />
            <col />
            <col />
        </colgroup>
        <thead class="border-b border-gray-200 text-gray-900">
        <tr>
            <th scope="col" class="px-0 py-3 font-semibold">Part</th>
            <th scope="col" class="hidden py-3 pl-8 pr-0 text-right font-semibold sm:table-cell">Lines</th>
        </tr>
        </thead>
        <tbody>
        <template v-for="part in finishedpart.parts" :key="part.id">
            <tr class="border-b border-gray-100">
                <td class="max-w-0 px-0 py-5 align-top">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <img v-if="part.detail" class="h-11 w-11 rounded-full" :src="part.detail.image" :alt="part.name" />
                            <img v-else class="inline-block h-14 w-14 rounded-md" src="/images/placeholder.svg" :alt="part.name" />
                        </div>
                        <div class="ml-4">
                            <div class="font-medium text-gray-900"><a :href="route('part.show', [part.id])">{{ part.sku.sku }}</a></div>
                            <div class="mt-1 text-gray-500">{{ part.short_text }}</div>
                        </div>
                    </div>
                </td>
                <td class="hidden py-5 pl-8 pr-0 text-right align-top tabular-nums text-gray-700 sm:table-cell">{{ part.sku.lines.length }}</td>
            </tr>
            <tr v-if="part.sku.lines.length !=0">
                <td colspan="2">
                    <table class="whitespace-nowrap text-left text-xs leading-6">
                        <colgroup>
                            <col />
                            <col class="w-full" />
                            <col />
                            <col />
                            <col />
                        </colgroup>
                        <thead class="border-b border-gray-200 text-gray-900">
                        <tr>
                            <th scope="col" class="hidden py-3 pl-8 pr-0 text-center font-semibold sm:table-cell">&nbsp;</th>
                            <th scope="col" class="hidden py-3 pl-8 pr-0 text-left font-semibold sm:table-cell">Supplier</th>
                            <th scope="col" class="hidden py-3 pl-8 pr-0 text-right font-semibold sm:table-cell">Order Date</th>
                            <th scope="col" class="hidden py-3 pl-8 pr-0 text-right font-semibold sm:table-cell">Due Date</th>
                            <th scope="col" class="hidden py-3 pl-8 pr-0 text-right font-semibold sm:table-cell">Commit Date</th>
                        </tr>
                        </thead>
                        <tbody>
                        <PartRow v-for="line in part.sku.lines" :line="line" />
                        </tbody>
                    </table>

                </td>
            </tr>
        </template>

        </tbody>
    </table>
</template>

<style scoped>

</style>
