<script setup>
    import CommitDate from "@/Pages/Suppliers/Partials/CommitDate.vue"
    const props = defineProps(['agendaItems', 'agendaStats'])
</script>

<template>
    <ul role="list" class="divide-y divide-gray-200">
        <li v-for="(items, key) in agendaItems" :key="items.id" :id="items[0].line.identifier" class="px-4 py-4 sm:px-0 mb-10">
            <div class="divide-y divide-gray-200 overflow-hidden rounded-lg bg-gray-100">
                <div class="px-4 py-5 sm:px-6 flex">


                    <div class="flex-auto"><span class="uppercase text-xs block font-bold">PO:</span> {{items[0].line.order.PO}}</div>
                    <div class="flex-auto"><span class="uppercase text-xs block font-bold">Material:</span> {{items[0].line.sku.sku}}</div>
                    <div class="flex-auto"><span class="uppercase text-xs block font-bold">Line:</span> {{items[0].line.line}}</div>

                </div>
                <div class="px-4 py-5 sm:p-6">
                    <div class="space-y-5 ml-4">
                        <ol class="list-decimal">
                            <li v-for="item in items" class="pb-10">
                                <label for="comments" class="font-medium text-gray-900">{{item.item}}</label>
                                <p v-if="item.description" id="comments-description" class="text-gray-500">{{item.description}}</p>

                                <div v-if="item.item=='Commit Needed'">
                                    <CommitDate :po="item.line.order.PO" :sku="item.line.sku.sku" :line="item.line.line" :agenda_item_id="item.id" />
                                </div>
                                <div v-else>
                                    <div class="mt-2 w-full">
                                        <textarea rows="4" name="comment" id="comment" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" />
                                    </div>
                                </div>
                            </li>
                        </ol>


                    </div>
                </div>
                <div class="px-4 py-4 sm:px-6 text-right"><a href="#"  class="rounded bg-indigo-600 px-2 py-1 text-xs font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">View Line</a></div>
            </div>
        </li>
    </ul>
    <!--
    <fieldset class="border-b border-t border-gray-200">
        <legend class="sr-only">Notifications</legend>
        <div class="divide-y divide-gray-200">
            <div v-for="agendaItem in agendaItems" key="agendaItem.id" class="relative flex items-start pb-4 pt-3.5">
                <div class="min-w-0 flex-1 text-sm leading-6">
                    <label for="comments" class="font-medium text-gray-900">{{agendaItem.item}}</label>
                    <p v-if="agendaItem.description" class="text-gray-500">{{agendaItem.description}}</p>
                </div>
                <div class="ml-3 flex h-6 items-center">
                    <input id="comments" aria-describedby="comments-description" name="comments" type="checkbox" class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-600" />
                </div>
            </div>

        </div>
    </fieldset>
    -->
</template>

<style scoped>

</style>
