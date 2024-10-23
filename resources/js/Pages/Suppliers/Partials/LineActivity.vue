<script setup>

import {Listbox, ListboxButton, ListboxLabel, ListboxOption, ListboxOptions, Dialog, DialogPanel, DialogTitle, TransitionChild, TransitionRoot} from "@headlessui/vue";
import {
    BoltIcon,
    FaceFrownIcon,
    FaceSmileIcon,
    FireIcon,
    HandThumbUpIcon,
    HeartIcon, XMarkIcon,
    SignalIcon,
    TruckIcon,
    ClockIcon,
    ExclamationCircleIcon,
} from "@heroicons/vue/20/solid/index.js";
import { CheckIcon } from '@heroicons/vue/24/outline'
import {ref,reactive} from "vue";
import {router} from "@inertiajs/vue3";



let open = ref(false)
let openLineDelayed = ref(false)
const moods = [
    { name: 'Requested Update', slug: 'requested-update', icon: SignalIcon, iconColor: 'text-white', bgColor: 'bg-blue-500', value:0 },
    { name: 'Line Shipped', slug: 'line-shipped', icon: TruckIcon, iconColor: 'text-white', bgColor: 'bg-green-500', value:0 },
    { name: 'Line Delayed', slug: 'line-delayed', icon: ClockIcon, iconColor: 'text-white', bgColor: 'bg-amber-500', value:0 },
    { name: 'Line Delivered', slug: 'line-delivered', icon: TruckIcon, iconColor: 'text-white', bgColor: 'bg-green-500', value:0 },
    { name: 'Escalate', slug: 'escalate', icon: ExclamationCircleIcon, iconColor: 'text-gray-400', bgColor: 'bg-red-500', value:0 },
]
const props = defineProps(['line', 'lineActivities', 'selected_activity', 'return_to_route'])
const selected_mood = getIndex();


const selected = ref(moods[selected_mood])
let form = reactive({
    po_id:props.line.po_id,
    sku_id:props.line.sku_id,
    line:props.line.line,
    slug:null,
    return_to_route:props.return_to_route
})
let form_qty = reactive({
    po_id:props.line.po_id,
    sku_id:props.line.sku_id,
    line:props.line.line,
    line_qty:props.line.qty,
    qty:props.line.qty,
    slug:'line-shipped',
    identifier:props.line.identifier,
    supplier_id:props.line.supplier_id,
    return_to_route:props.return_to_route,
    tracking:null
})
let form_linedelayed = reactive({
    identifier:props.line.identifier,
    supplier_id:props.line.supplier_id,
    po_id:props.line.po_id,
    sku_id:props.line.sku_id,
    line:props.line.line,
    slug:'line-delayed',
    reason:null,
    return_to_route:props.return_to_route
})
function getIndex(){
    for(const[key,value] of Object.entries(moods)){
        for(const[mood_key, mood_value] of Object.entries(value)){
            if(mood_value==props.selected_activity){
                return key;
            }

        }

    }
}
function trackActivity(event){
    console.log(event.target.dataset.slug);
    if(event.target.dataset.slug=='line-shipped'){
        open = ref(true);
    }
    else if(event.target.dataset.slug=='line-delayed'){
        openLineDelayed = ref(true);
    }
    else{
        form.slug = event.target.dataset.slug;
        router.post('/saveLineActivity', form, {
            preserveScroll:true,
            preserveState:false
        })
    }
}
function submitQtyShippedForm(){
    router.post('/saveLineActivity', form_qty, {
        preserveScroll:true,
        preserveState:true
    })
    open = ref(false)
}
function submitLineDelayedForm(){
    console.log(form_linedelayed)
    router.post('/saveLineDelayedReason', form_linedelayed, {
        preserveScroll:true,
        preserveState:true
    })
    openLineDelayed = ref(false)
}
</script>

<template>
    <TransitionRoot as="template" :show="open">
        <Dialog as="div" class="relative z-10" @close="open = false">
            <TransitionChild as="template" enter="ease-out duration-300" enter-from="opacity-0" enter-to="opacity-100" leave="ease-in duration-200" leave-from="opacity-100" leave-to="opacity-0">
                <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" />
            </TransitionChild>

            <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
                <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                    <TransitionChild as="template" enter="ease-out duration-300" enter-from="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" enter-to="opacity-100 translate-y-0 sm:scale-100" leave="ease-in duration-200" leave-from="opacity-100 translate-y-0 sm:scale-100" leave-to="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
                        <DialogPanel class="relative transform overflow-hidden rounded-lg bg-white px-4 pb-4 pt-5 text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-sm sm:p-6">
                            <div>
                                <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-green-500">
                                    <TruckIcon class="h-6 w-6 text-white" aria-hidden="true" />
                                </div>
                                <div class="mt-3 text-center sm:mt-5">
                                    <DialogTitle as="h3" class="text-base font-semibold leading-6 text-gray-900">What quantity shipped?</DialogTitle>
                                    <form @submit.prevent="submitQtyShippedForm" class="mt-5">
                                        <div class="w-full mb-4">
                                            <label for="qty_shipped" class="block text-sm font-medium leading-6 text-gray-900 text-left">Email</label>
                                            <input type="text" v-model="form_qty.qty" name="qty_shipped" id="qty_shipped" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" />
                                        </div>
                                        <div class="w-full mb-4">
                                            <label for="tracking" class="block text-sm font-medium leading-6 text-gray-900 text-left">Tracking</label>
                                            <input type="text" v-model="form_qty.tracking" name="tracking" id="tracking" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" />
                                        </div>
                                        <button type="submit" class="mt-3 inline-flex w-full items-center justify-center rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 sm:ml-3 sm:mt-0 sm:w-auto">Save</button>
                                    </form>
                                </div>
                            </div>
                        </DialogPanel>
                    </TransitionChild>
                </div>
            </div>
        </Dialog>
    </TransitionRoot>
    <TransitionRoot as="template" :show="openLineDelayed">
        <Dialog as="div" class="relative z-10" @close="open = false">
            <TransitionChild as="template" enter="ease-out duration-300" enter-from="opacity-0" enter-to="opacity-100" leave="ease-in duration-200" leave-from="opacity-100" leave-to="opacity-0">
                <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" />
            </TransitionChild>

            <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
                <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                    <TransitionChild as="template" enter="ease-out duration-300" enter-from="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" enter-to="opacity-100 translate-y-0 sm:scale-100" leave="ease-in duration-200" leave-from="opacity-100 translate-y-0 sm:scale-100" leave-to="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
                        <DialogPanel class="relative transform overflow-hidden rounded-lg bg-white px-4 pb-4 pt-5 text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-sm sm:p-6">
                            <div>
                                <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-amber-500">
                                    <ClockIcon class="h-6 w-6 text-white" aria-hidden="true" />
                                </div>
                                <div class="mt-3 text-center sm:mt-5">
                                    <DialogTitle as="h3" class="text-base font-semibold leading-6 text-gray-900">Why is the line delayed?</DialogTitle>
                                    <form @submit.prevent="submitLineDelayedForm" class="mt-5 sm:items-center">
                                        <div class="flex-1">
                                            <label for="lineDelayedReason" class="sr-only">Email</label>
                                            <textarea v-model="form_linedelayed.reason" name="lineDelayedReason" id="lineDelayedReason" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" />
                                        </div>
                                        <div class="mt-2 justify-end">
                                            <button type="submit" class="mt-3 w-full items-center justify-center rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600 sm:ml-3 sm:mt-0 sm:w-auto">Save</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </DialogPanel>
                    </TransitionChild>
                </div>
            </div>
        </Dialog>
    </TransitionRoot>
    <Listbox as="div" v-model="selected">
        <ListboxLabel class="sr-only">Your mood</ListboxLabel>
        <div class="relative">
            <ListboxButton class="relative flex h-10 w-10 items-center justify-center rounded-full text-white hover:text-gray-900">
                <span class="flex items-center justify-center">
                    <span v-if="selected.value === null">
                        <BoltIcon class="h-5 w-5 flex-shrink-0" aria-hidden="true" />
                        <span class="sr-only">Add your mood</span>
                    </span>
                    <span v-if="!(selected.value === null)">
                        <span :class="[selected.bgColor, 'flex h-8 w-8 items-center justify-center rounded-full']">
                            <component :is="selected.icon" class="h-5 w-5 flex-shrink-0 text-white" aria-hidden="true" />
                        </span>
                        <span class="sr-only">{{ selected.name }}</span>
                    </span>
                </span>
            </ListboxButton>

            <transition leave-active-class="transition ease-in duration-100" leave-from-class="opacity-100" leave-to-class="opacity-0">
                <ListboxOptions class="absolute bottom-10 z-10 -ml-6 w-60 rounded-lg bg-white py-3 text-base shadow ring-1 ring-black ring-opacity-5 focus:outline-none sm:ml-auto sm:w-64 sm:text-sm">
                    <ListboxOption as="template" v-for="mood in moods" :key="mood.value" :value="mood" v-slot="{ active }">
                        <li @click="trackActivity" :class="[active ? 'bg-gray-100' : 'bg-white', 'relative cursor-default select-none px-3 py-2']">
                            <div class="flex items-center">
                                <div :class="[mood.bgColor, 'flex h-8 w-8 items-center justify-center rounded-full']">
                                    <component :is="mood.icon" :class="[mood.iconColor, 'h-5 w-5 flex-shrink-0']" aria-hidden="true" />
                                </div>
                                <span :data-po_id="line.po_id" :data-sku_id="line.sku_id" :data-line="line.line" :data-slug="mood.slug" class="ml-3 block truncate font-medium">{{ mood.name }}</span>
                            </div>
                        </li>
                    </ListboxOption>
                </ListboxOptions>
            </transition>
        </div>
    </Listbox>
</template>

<style scoped>

</style>
