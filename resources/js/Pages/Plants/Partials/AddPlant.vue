<script setup>

import {Dialog, DialogPanel, TransitionChild, TransitionRoot} from "@headlessui/vue";
import AddSupplierForm from "@/Pages/Suppliers/Partials/AddSupplierForm.vue";
import {reactive, ref} from "vue";
import {router} from "@inertiajs/vue3";
let open = ref(false)
const props = defineProps([])
let form = reactive({
    plant_name:null,
    country:null,
    address:null,
    city:null,
    state:null,
    zip:null
})
function submitForm(){
    console.log(form);
    router.post('/save/plant', form, {
        preserveScroll:true,
        preserveState:false,
        onSuccess:(resp)=>{
            open = false;
        }
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
                                            <h2 class="text-base font-semibold leading-7 text-gray-900">Add Plant</h2>

                                            <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                                                <div class="sm:col-span-6">
                                                    <label for="username" class="block text-sm font-medium leading-6 text-gray-900">Plant</label>
                                                    <div class="mt-2">
                                                        <div class="flex rounded-md shadow-sm ring-1 ring-inset ring-gray-300 focus-within:ring-2 focus-within:ring-inset focus-within:ring-indigo-600 sm:max-w-md">
                                                            <input type="text" v-model="form.plant_name" name="name" id="name" class="block flex-1 border-0 bg-transparent py-1.5 pl-1 text-gray-900 placeholder:text-gray-400 focus:ring-0 sm:text-sm sm:leading-6" />
                                                        </div>
                                                    </div>
                                                    <div v-if="$page.props.errors.plant_name" class="mt-2 text-sm text-red-600">{{ $page.props.errors.plant_name }}</div>
                                                </div>
                                                <div class="sm:col-span-6">
                                                    <label for="country" class="block text-sm font-medium leading-6 text-gray-900">Country</label>
                                                    <div class="mt-2">
                                                        <select id="country" v-model="form.country" name="country" autocomplete="country-name" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:max-w-xs sm:text-sm sm:leading-6">
                                                            <option>United States</option>
                                                            <option>Canada</option>
                                                            <option>Mexico</option>
                                                        </select>
                                                    </div>
                                                    <div v-if="$page.props.errors.country" class="mt-2 text-sm text-red-600">{{ $page.props.errors.country }}</div>
                                                </div>

                                                <div class="col-span-full">
                                                    <label for="street-address" class="block text-sm font-medium leading-6 text-gray-900">Street address</label>
                                                    <div class="mt-2">
                                                        <input type="text" v-model="form.address" name="street-address" id="street-address" autocomplete="street-address" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" />
                                                    </div>
                                                    <div v-if="$page.props.errors.address" class="mt-2 text-sm text-red-600">{{ $page.props.errors.address }}</div>
                                                </div>

                                                <div class="sm:col-span-2 sm:col-start-1">
                                                    <label for="city" class="block text-sm font-medium leading-6 text-gray-900">City</label>
                                                    <div class="mt-2">
                                                        <input type="text" v-model="form.city" name="city" id="city" autocomplete="address-level2" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" />
                                                    </div>
                                                    <div v-if="$page.props.errors.city" class="mt-2 text-sm text-red-600">{{ $page.props.errors.city }}</div>
                                                </div>

                                                <div class="sm:col-span-2">
                                                    <label for="region" class="block text-sm font-medium leading-6 text-gray-900">State</label>
                                                    <div class="mt-2">
                                                        <input type="text" v-model="form.state" name="region" id="region" autocomplete="address-level1" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" />
                                                    </div>
                                                    <div v-if="$page.props.errors.state" class="mt-2 text-sm text-red-600">{{ $page.props.errors.state }}</div>
                                                </div>

                                                <div class="sm:col-span-2">
                                                    <label for="postal-code" class="block text-sm font-medium leading-6 text-gray-900">ZIP</label>
                                                    <div class="mt-2">
                                                        <input type="text" v-model="form.zip" name="postal-code" id="postal-code" autocomplete="postal-code" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" />
                                                    </div>
                                                    <div v-if="$page.props.errors.zip" class="mt-2 text-sm text-red-600">{{ $page.props.errors.zip }}</div>
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
    <button @click="open=true" type="button" class="rounded bg-indigo-600 px-2 py-1 text-xs font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Add Plant</button>
</template>

<style scoped>

</style>
