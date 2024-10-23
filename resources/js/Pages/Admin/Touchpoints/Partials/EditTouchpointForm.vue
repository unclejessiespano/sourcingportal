<script setup>
import {router} from "@inertiajs/vue3";
import {reactive} from 'vue'
import { PhotoIcon, UserCircleIcon } from '@heroicons/vue/24/solid'

const props = defineProps(['errors', 'touchpoint'])
const verb = "Update";

let form = reactive({
    touchpoint_id: props.touchpoint.id,
    code: props.touchpoint.code,
    touchpoint: props.touchpoint.touchpoint,
    touchpoint_value: props.touchpoint.value,
    description:props.touchpoint.description
})

function submitForm(){
    router.post('/admin/touchpoint/store', form, {
        preserveScroll:true,
        preserveState:true
    })
}
</script>

<template>
    <form @submit.prevent="submitForm">
        <div class="space-y-12">
            <div class="border-b border-gray-900/10 pb-12">
                <template v-if="touchpoint"></template>
                <template v-else>
                    <h2 class="text-base font-semibold leading-7 text-gray-900">Create a touchpoint</h2>
                    <p class="mt-1 text-sm leading-6 text-gray-600">A touchpoint represents any interaction with a supplier. Touchpoints are used to score suppliers.</p>
                </template>


                <div class="mt-10 grid grid-cols-6 gap-x-6 gap-y-8 sm:grid-cols-2">

                    <div class="col-span-full">
                        <label for="username" class="block text-sm font-medium leading-6 text-gray-900">Touchpoint</label>
                        <div class="mt-2">
                            <div class="flex rounded-md shadow-sm ring-1 ring-inset ring-gray-300 focus-within:ring-2 focus-within:ring-inset focus-within:ring-indigo-600 sm:max-w-md">
                                <input type="text" v-model="form.touchpoint" name="touchpoint" id="touchpoint" class="block flex-1 border-0 bg-transparent py-1.5 pl-1 text-gray-900 placeholder:text-gray-400 focus:ring-0 sm:text-sm sm:leading-6" />
                            </div>
                            <div v-if="$page.props.errors.touchpoint" class="mt-2 text-sm text-red-600">{{ $page.props.errors.touchpoint }}</div>
                        </div>
                    </div>
                    <div>
                        <label for="code" class="block text-sm font-medium leading-6 text-gray-900">Code</label>
                        <div class="mt-2">
                            <div class="flex rounded-md shadow-sm ring-1 ring-inset ring-gray-300 focus-within:ring-2 focus-within:ring-inset focus-within:ring-indigo-600 sm:max-w-md">
                                <input type="text" maxlength="6" disabled v-model="form.code" name="code" id="code" class="block flex-1 border-0 bg-transparent py-1.5 pl-1 text-gray-900 placeholder:text-gray-400 focus:ring-0 sm:text-sm sm:leading-6" />
                            </div>
                            <div v-if="$page.props.errors.code" class="mt-2 text-sm text-red-600">{{ $page.props.errors.code }}</div>
                        </div>
                    </div>
                    <div>
                        <label for="username" class="block text-sm font-medium leading-6 text-gray-900">Value</label>
                        <div class="mt-2">
                            <div class="flex rounded-md shadow-sm ring-1 ring-inset ring-gray-300 focus-within:ring-2 focus-within:ring-inset focus-within:ring-indigo-600 sm:max-w-md">
                                <input type="text" v-model="form.touchpoint_value" name="touchpoint_value" id="touchpoint_value" class="block flex-1 border-0 bg-transparent py-1.5 pl-1 text-gray-900 placeholder:text-gray-400 focus:ring-0 sm:text-sm sm:leading-6" />
                            </div>
                            <div v-if="$page.props.errors.touchpoint_value" class="mt-2 text-sm text-red-600">{{ $page.props.errors.touchpoint_value }}</div>
                        </div>
                    </div>
                    <div class="col-span-full">
                        <label for="about" class="block text-sm font-medium leading-6 text-gray-900">Description</label>
                        <div class="mt-2">
                            <textarea id="about" name="about" rows="3" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" />
                        </div>
                        <p class="mt-3 text-sm leading-6 text-gray-600">What is this touchpoint about?</p>
                    </div>


                </div>
            </div>
        </div>

        <div class="mt-6 flex items-center justify-end gap-x-6">
            <button type="button" class="text-sm font-semibold leading-6 text-gray-900">Cancel</button>
            <button type="submit" class="rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">{{verb}} Touchpoint</button>
        </div>
    </form>
</template>

<style scoped>

</style>
