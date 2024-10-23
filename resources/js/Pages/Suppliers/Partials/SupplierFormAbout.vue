<script setup>
    import {PhotoIcon, UserCircleIcon} from "@heroicons/vue/24/solid/index.js";
    import AlertSuccess from "@/Components/Alerts/Success.vue";
    import {router} from "@inertiajs/vue3";
    import {reactive} from 'vue'

    const props = defineProps(['supplier'])

    let form = reactive({
        supplier_id:props.supplier.id,
        url:props.supplier.url,
        description:props.supplier.description
    })
    function submitForm(){
        console.log(form);
        router.post('/save/company/info', form, {
            preserveScroll:true,
            preserveState:true
        })
    }
    function generateSupplierInfo(){
        console.log(form);
        router.post('/generateSupplierInfo', form, {
            preserveScroll:true,
            preserveState:true
        })
    }
</script>

<template>
    <div class="grid grid-cols-1 gap-x-8 gap-y-8 md:grid-cols-3">
        <div class="px-4 sm:px-0">
            <h2 class="text-base font-semibold leading-7 text-gray-900">Company Info</h2>
            <p class="mt-1 text-sm leading-6 text-gray-600"></p>
        </div>

        <form @submit.prevent="submitForm" class="bg-white shadow-sm ring-1 ring-gray-900/5 sm:rounded-xl md:col-span-2">

            <div class="px-4 py-6 sm:p-8">
                <div class="grid max-w-2xl grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                    <div class="sm:col-span-4">
                        <label for="website" class="block text-sm font-medium leading-6 text-gray-900">Website</label>
                        <div class="mt-2">
                            <div class="flex rounded-md shadow-sm ring-1 ring-inset ring-gray-300 focus-within:ring-2 focus-within:ring-inset focus-within:ring-indigo-600 sm:max-w-md">
                                <input type="text" v-model="form.url" name="website" id="website" class="block flex-1 border-0 bg-transparent py-1.5 pl-1 text-gray-900 placeholder:text-gray-400 focus:ring-0 sm:text-sm sm:leading-6" placeholder="www.example.com" />
                            </div>
                        </div>
                        <div v-if="$page.props.errors.url" class="mt-2 text-sm text-red-600">{{ $page.props.errors.url }}</div>
                    </div>

                    <div class="col-span-full">
                        <label for="about" class="block text-sm font-medium leading-6 text-gray-900">About</label>
                        <div class="mt-2">
                            <textarea v-model="form.description" id="about" name="about" rows="3" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" />
                        </div>
                        <div v-if="$page.props.errors.description" class="mt-2 text-sm text-red-600">{{ $page.props.errors.description }}</div>
                        <div class="flex items-center">
                            <p class="flex-1 mt-3 text-sm leading-6 text-gray-600">Write a few sentences about the supplier.</p>
                            <a href="#" @click="generateSupplierInfo" type="flex-1 button" class="mt-3 text-sm font-semibold leading-6 text-gray-900">Generate with Chat GPT</a>
                        </div>
                    </div>


                    <div class="col-span-2">
                        <label for="cover-photo" class="block text-sm font-medium leading-6 text-gray-900">Logo</label>
                        <div class="mt-2 flex justify-center rounded-lg border border-dashed border-gray-900/25 px-6 py-10">
                            <div class="text-center">
                                <PhotoIcon class="mx-auto h-12 w-12 text-gray-300" aria-hidden="true" />
                                <div class="mt-4 text-sm leading-6 text-gray-600">
                                    <label for="file-upload" class="relative cursor-pointer rounded-md bg-white font-semibold text-indigo-600 focus-within:outline-none focus-within:ring-2 focus-within:ring-indigo-600 focus-within:ring-offset-2 hover:text-indigo-500">
                                        <div class="text-center">Upload a file</div>
                                        <input id="file-upload" name="file-upload" type="file" class="sr-only" />
                                    </label>

                                </div>
                                <p class="pl-1">or drag and drop</p>
                                <p class="text-xs leading-5 text-gray-600">PNG, JPG, GIF up to 10MB</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="flex items-center justify-end gap-x-6 border-t border-gray-900/10 px-4 py-4 sm:px-8">
                <button type="button" class="text-sm font-semibold leading-6 text-gray-900">Cancel</button>
                <button type="submit" class="rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Save</button>
            </div>
        </form>
    </div>
</template>

<style scoped>

</style>
