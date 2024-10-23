<script setup>

import {CalendarIcon} from "@heroicons/vue/20/solid/index.js";
import {Dialog, DialogPanel, TransitionChild, TransitionRoot} from "@headlessui/vue";
import {ref} from "vue";
import {router, useForm} from "@inertiajs/vue3";
import VueDatePicker from '@vuepic/vue-datepicker';
import '@vuepic/vue-datepicker/dist/main.css'

const props = defineProps(['po', 'sku', 'line', 'agenda_item_id'])
let open = ref(false)
const form = useForm({
    po:props.po,
    sku:props.sku,
    line:props.line,
    commit_date:null,
    agenda_item_id:(props.agenda_item_id) ? props.agenda_item_id : null,
});

function handleDate(modelData){
    console.log(modelData);
}
function saveCommit(){
    console.log(form);
    router.post('/saveCommit', form, {
        preserveScroll:true,
        preserveState:false,
        onSuccess:()=> open=false
    })
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
                        <DialogPanel class="relative transform rounded-lg bg-white px-4 pb-4 pt-5 text-center shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-sm sm:p-6">
                            <div class="mt-3 text-center sm:mt-5">
                                <VueDatePicker inline auto-apply v-model="form.commit_date" week-start="0" :enable-time-picker="false"></VueDatePicker>
                            </div>
                            <div class="mt-5 sm:mt-6">
                                <button @click="saveCommit" type="button" class="inline-flex w-full justify-center rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Save Commit</button>
                            </div>
                        </DialogPanel>
                    </TransitionChild>
                </div>
            </div>
        </Dialog>
    </TransitionRoot>
    <button @click="open=true" type="button" class="inline-flex items-center gap-x-1.5 rounded-md bg-red-600 px-2 py-1 text-xs font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
        <CalendarIcon class="-ml-0.5 h-5 w-5" aria-hidden="true" />
        Needed
    </button>
</template>

<style scoped>

</style>
