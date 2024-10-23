<script setup>
import AlertSuccess from "@/Components/Alerts/Success.vue";
import {router} from "@inertiajs/vue3";
import {reactive} from 'vue'

const props = defineProps(['supplier'])

let form = reactive({
    supplier_id:props.supplier.id,
    address:(props.supplier.shippinglocation) ? props.supplier.shippinglocation.address : null,
    city:(props.supplier.shippinglocation) ? props.supplier.shippinglocation.city : null,
    state:(props.supplier.shippinglocation) ? props.supplier.shippinglocation.state : null,
    zip:(props.supplier.shippinglocation) ? props.supplier.shippinglocation.zip : null,
    country:(props.supplier.shippinglocation) ? props.supplier.shippinglocation.country : null,
})
function submitForm(){
    console.log(form);
    router.post('/save/company/plant', form, {
        preserveScroll:true,
        preserveState:true
    })
}
</script>

<template>
    <div class="grid grid-cols-1 gap-x-8 gap-y-8 pt-10 md:grid-cols-3">
        <div class="px-4 sm:px-0">
            <h2 class="text-base font-semibold leading-7 text-gray-900">Plant Information</h2>
            <p class="mt-1 text-sm leading-6 text-gray-600">Where is the material shipping from?</p>
        </div>

        <form @submit.prevent="submitForm" class="bg-white shadow-sm ring-1 ring-gray-900/5 sm:rounded-xl md:col-span-2">

            <div class="px-4 py-6 sm:p-8">
                <div class="grid max-w-2xl grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">

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
                        <label for="region" class="block text-sm font-medium leading-6 text-gray-900">State / Province</label>
                        <div class="mt-2">
                            <input type="text" v-model="form.state" name="region" id="region" autocomplete="address-level1" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" />
                        </div>
                        <div v-if="$page.props.errors.state" class="mt-2 text-sm text-red-600">{{ $page.props.errors.state }}</div>
                    </div>

                    <div class="sm:col-span-2">
                        <label for="postal-code" class="block text-sm font-medium leading-6 text-gray-900">ZIP / Postal code</label>
                        <div class="mt-2">
                            <input type="text" v-model="form.zip" name="postal-code" id="postal-code" autocomplete="postal-code" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" />
                        </div>
                        <div v-if="$page.props.errors.zip" class="mt-2 text-sm text-red-600">{{ $page.props.errors.zip }}</div>
                    </div>

                    <div class="sm:col-span-4">
                        <label for="country" class="block text-sm font-medium leading-6 text-gray-900">Country</label>
                        <div class="mt-2">
                            <select v-model="form.country" id="country" name="country" autocomplete="country-name" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:max-w-xs sm:text-sm sm:leading-6">
                                <option>United States</option>
                                <option>Canada</option>
                                <option>Mexico</option>
                            </select>
                        </div>
                        <div v-if="$page.props.errors.country" class="mt-2 text-sm text-red-600">{{ $page.props.errors.country }}</div>
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
