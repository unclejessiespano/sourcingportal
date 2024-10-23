<script setup>
import{reactive, ref, computed} from "vue"
import {router} from "@inertiajs/vue3";

import {
    Combobox,
    ComboboxButton,
    ComboboxInput,
    ComboboxLabel,
    ComboboxOption,
    ComboboxOptions,
} from '@headlessui/vue'
const props = defineProps(['skus', 'finishedgood_id'])
let form = reactive({
    finishedgood_id:props.finishedgood_id,
    sku_id:null,
    selectedSku:null
})

const skus = []
Object.values(props.skus).forEach((value, index)=>{
    const obj = {"id": value.id, "sku": value.sku};
    skus.push(obj);
});
const query = ref('')
const selectedSku = ref(null)
const filteredSku = computed(() =>
    query.value === ''
        ? skus
        : skus.filter((sku) => {
            return sku.sku.toLowerCase().includes(query.value.toLowerCase())
        }),
)
function add(){
    form.selectedSku = selectedSku;
    router.post('/addToFinishedPart', form, {
        preserveScroll:true,
        preserveState:true,
    })
}
</script>

<template>
    <div class="pb-10 flex">
        <Combobox class="py-5 flex-1" as="div" v-model="selectedSku" @update:modelValue="sku_query = ''">
            <ComboboxLabel class="block text-sm font-medium leading-6 text-gray-900">Sku</ComboboxLabel>
            <div class="flex">
                <div class="relative mt-2 flex-1">
                    <ComboboxInput class="w-full rounded-md border-0 bg-white py-1.5 pl-3 pr-10 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" @change="query = $event.target.value" @blur="query = ''" :display-value="(sku) => sku?.sku" />
                    <ComboboxButton class="absolute inset-y-0 right-0 flex items-center rounded-r-md px-2 focus:outline-none">
                        <ChevronUpDownIcon class="h-5 w-5 text-gray-400" aria-hidden="true" />
                    </ComboboxButton>

                    <ComboboxOptions v-if="filteredSku.length > 0" class="absolute z-10 mt-1 max-h-60 w-full overflow-auto rounded-md bg-white py-1 text-base shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none sm:text-sm">
                        <ComboboxOption v-for="sku in skus" :key="sku.id" :value="sku" as="template" v-slot="{ active, selected }">
                            <li :class="['relative cursor-default select-none py-2 pl-8 pr-4', active ? 'bg-indigo-600 text-white' : 'text-gray-900']">
                                <span :class="['block truncate', selected && 'font-semibold']">{{ sku.sku }}</span>

                                <span v-if="selected" :class="['absolute inset-y-0 left-0 flex items-center pl-1.5', active ? 'text-white' : 'text-indigo-600']">
                                <CheckIcon class="h-5 w-5" aria-hidden="true" />
                            </span>
                            </li>
                        </ComboboxOption>
                    </ComboboxOptions>
                </div>
                <button @click="add" class="ml-3 mt-2 flex-0 rounded-md bg-indigo-600 px-2.5 py-1.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Add</button>
            </div>

        </Combobox>


    </div>
</template>

<style scoped>

</style>
