<script setup>

import AddSupplierForm from "@/Pages/Suppliers/Partials/AddSupplierForm.vue";
import {Dialog, DialogPanel, TransitionChild, TransitionRoot} from "@headlessui/vue";
import {computed, reactive, ref} from "vue";
import {router} from "@inertiajs/vue3";
import {PhotoIcon} from "@heroicons/vue/24/solid/index.js";
const open = ref(false)
const file = ref([])
const props = defineProps(['supplier']);
let form = reactive({
    name:null,
    description:null,
    image:null
})
const uploadInfo = computed(() => {
    return file.value.length === 1 ? file.value[0].name : `${file.value.length} files selected`
})
function handleUpload(e){
    file.value = Array.from(e.target.files) || []
    form.file = file.value
}
function submitForm(){
    router.post('/finishedpart', form, {
        preserveScroll:true,
        preserveState:false
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
                        <DialogPanel class="relative transform overflow-hidden rounded-lg bg-white px-4 pb-4 pt-5 text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-sm sm:p-6">
                            <div>
                                <form @submit.prevent="submitForm">
                                    <div class="space-y-12">
                                        <div class="border-b border-gray-900/10 pb-12">
                                            <h2 class="text-base font-semibold leading-7 text-gray-900">Add Finished Good</h2>
                                            <p class="mt-1 text-sm leading-6 text-gray-600"></p>

                                            <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                                                <div class="col-span-full">
                                                    <label for="username" class="block text-sm font-medium leading-6 text-gray-900">Name</label>
                                                    <div class="mt-2">
                                                        <div class="flex rounded-md shadow-sm ring-1 ring-inset ring-gray-300 focus-within:ring-2 focus-within:ring-inset focus-within:ring-indigo-600 sm:max-w-md">
                                                            <input type="text" v-model="form.name" name="name" id="name" class="block flex-1 border-0 bg-transparent py-1.5 pl-1 text-gray-900 placeholder:text-gray-400 focus:ring-0 sm:text-sm sm:leading-6" />
                                                        </div>
                                                    </div>
                                                </div>


                                                <div class="col-span-full">
                                                    <label for="street-address" class="block text-sm font-medium leading-6 text-gray-900">Description</label>
                                                    <div class="mt-2">
                                                        <textarea rows="6" type="text" v-model="form.description" name="description" id="description" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" />
                                                    </div>
                                                </div>

                                                <div class="col-span-full">
                                                    <div class="mt-2 flex justify-center rounded-lg border border-dashed border-gray-900/25 px-6 py-10">

                                                        <div class="text-center">
                                                            <PhotoIcon class="mx-auto h-12 w-12 text-gray-300" aria-hidden="true" />
                                                            <div class="mt-4 flex text-sm leading-6 text-gray-600">
                                                                <label for="file-upload" class="relative cursor-pointer rounded-md bg-white font-semibold text-indigo-600 focus-within:outline-none focus-within:ring-2 focus-within:ring-indigo-600 focus-within:ring-offset-2 hover:text-indigo-500">
                                                                    <span>Upload a file</span>
                                                                    <input id="file-upload" @change="handleUpload" name="file-upload" type="file" class="sr-only" />
                                                                </label>
                                                                <p class="pl-1">or drag and drop</p>
                                                            </div>
                                                            <p class="text-xs leading-5 text-gray-600">File must be an image.</p>
                                                            <div v-if="file.length" class="text-center">
                                                                <small :class="`text-indigo-600 block`">
                                                                    <slot name="file" :files="file" :uploadInfo="uploadInfo">
                                                                        {{ uploadInfo }}
                                                                    </slot>
                                                                </small>
                                                            </div>
                                                            <div v-if="$page.props.errors.file" class="mt-2 text-sm text-red-600">{{ $page.props.errors.file }}</div>
                                                        </div>


                                                    </div>
                                                </div>
                                            </div>
                                        </div>




                                    </div>

                                    <div class="mt-6 flex items-center justify-end gap-x-6">
                                        <button type="button" class="text-sm font-semibold leading-6 text-gray-900">Cancel</button>
                                        <button type="submit" class="rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Save</button>
                                    </div>
                                </form>
                            </div>
                        </DialogPanel>
                    </TransitionChild>
                </div>
            </div>
        </Dialog>
    </TransitionRoot>

    <button @click="open = true" type="button" class="rounded bg-indigo-600 px-2 py-1 text-xs font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Add</button>
</template>

<style scoped>

</style>
