<script setup>
import {Dialog, DialogPanel, DialogTitle, TransitionChild, TransitionRoot} from "@headlessui/vue";
import { CheckIcon } from '@heroicons/vue/24/outline'
import { PhotoIcon, UserCircleIcon } from '@heroicons/vue/24/solid'
import {ArrowUpTrayIcon} from "@heroicons/vue/24/outline/index.js";

const props = defineProps(['image', 'part'])
import { computed, ref } from 'vue'
import {router, useForm} from '@inertiajs/vue3'

let open = ref(false)
const file = ref([])
const form = useForm({
    file:null
});
const uploadInfo = computed(() => {
    return file.value.length === 1 ? file.value[0].name : `${file.value.length} files selected`
})
function handleUpload(e){
    file.value = Array.from(e.target.files) || []
    form.part_id = props.part.id
    form.file = file.value
}
function submitForm(){
    console.log(form);
    router.post('/upload/partImage', form, {
        preserveScroll:true,
        preserveState:false,
        onSuccess:()=> {open=false}
    })
}
</script>

<template>
    {{image}}
    <img @click="open=true" v-if="part.detail" :src="part.detail.image" :alt="part.sku" class="object-cover object-center" />
    <img @click="open=true" v-else class="object-cover object-center" src="/images/placeholder.svg" :alt="part.name" />

    <TransitionRoot as="template" :show="open">
        <Dialog as="div" class="relative z-10" @close="open = false">
            <TransitionChild as="template" enter="ease-out duration-300" enter-from="opacity-0" enter-to="opacity-100" leave="ease-in duration-200" leave-from="opacity-100" leave-to="opacity-0">
                <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" />
            </TransitionChild>

            <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
                <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                    <TransitionChild as="template" enter="ease-out duration-300" enter-from="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" enter-to="opacity-100 translate-y-0 sm:scale-100" leave="ease-in duration-200" leave-from="opacity-100 translate-y-0 sm:scale-100" leave-to="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
                        <DialogPanel class="relative transform overflow-hidden rounded-lg bg-white px-4 pb-4 pt-5 text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-sm sm:p-6">
                            <form @submit.prevent="submitForm">
                                <div>
                                    <div class="mt-3 text-center sm:mt-5">
                                        <DialogTitle as="h3" class="text-base font-semibold leading-6 text-gray-900">Upload Part Image</DialogTitle>
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
                                <div class="mt-5 sm:mt-6">
                                    <button type="submit" class="inline-flex w-full justify-center rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600" @click="open = false">Upload</button>
                                </div>
                            </form>
                        </DialogPanel>
                    </TransitionChild>
                </div>
            </div>
        </Dialog>
    </TransitionRoot>
</template>

<style scoped>

</style>
