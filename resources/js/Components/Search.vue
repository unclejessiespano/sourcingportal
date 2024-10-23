<script setup>
import {reactive} from "vue";
import {router} from "@inertiajs/vue3";

const props = defineProps([]);
let form = reactive({
    order:null,
    sku:null,
    line:null
})
function submitForm(){
    console.log(form);
    router.post('/search', form, {
        preserveScroll:true,
        preserveState:false
    })
}
</script>

<template>
    <form @submit.prevent="submitForm">
        <div class="flex">
            <div class="flex items-center">
                <label for="order" class="block text-sm font-medium leading-6 text-gray-900">Purchase Order:</label>
                <div class="px-2">
                    <div class="flex rounded-md shadow-sm ring-1 ring-inset ring-gray-300 focus-within:ring-2 focus-within:ring-inset focus-within:ring-indigo-600 sm:max-w-md">
                        <input type="text" v-model="form.order" name="order" id="order" class="block flex-1 border-0 bg-transparent py-1.5 pl-1 text-gray-900 placeholder:text-gray-400 focus:ring-0 sm:text-sm sm:leading-6" />
                    </div>
                </div>
            </div>
            <div class="flex items-center">
                <label for="order" class="block text-sm font-medium leading-6 text-gray-900">SKU:</label>
                <div class="px-2">
                    <div class="flex rounded-md shadow-sm ring-1 ring-inset ring-gray-300 focus-within:ring-2 focus-within:ring-inset focus-within:ring-indigo-600 sm:max-w-md">
                        <input type="text" v-model="form.sku" name="sku" id="sku" class="block flex-1 border-0 bg-transparent py-1.5 pl-1 text-gray-900 placeholder:text-gray-400 focus:ring-0 sm:text-sm sm:leading-6" />
                    </div>
                </div>
            </div>
            <div class="flex items-center">
                <label for="order" class="block text-sm font-medium leading-6 text-gray-900">Line:</label>
                <div class="px-2">
                    <div class="flex rounded-md shadow-sm ring-1 ring-inset ring-gray-300 focus-within:ring-2 focus-within:ring-inset focus-within:ring-indigo-600 sm:max-w-md">
                        <input type="text" v-model="form.line" name="line" id="line" class="block flex-1 border-0 bg-transparent py-1.5 pl-1 text-gray-900 placeholder:text-gray-400 focus:ring-0 sm:text-sm sm:leading-6" />
                    </div>
                </div>
            </div>
            <div class="flex items-center">
                <button type="submit" class="rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Find</button>
            </div>
        </div>
    </form>
</template>

<style scoped>

</style>
