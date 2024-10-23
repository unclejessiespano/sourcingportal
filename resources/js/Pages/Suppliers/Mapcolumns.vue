<script setup>
import SupplierTabs from "@/Pages/Suppliers/Partials/SupplierTabs.vue";
import {reactive, ref} from "vue";
import {router} from "@inertiajs/vue3";
import PortalLayout from "@/Layouts/PortalLayout.vue";
const props = defineProps(['request', 'columns', 'supplier', 'supplier_columns'])
let form = reactive({
    supplier_id:props.supplier.id,
    columns:[],
})
function submitForm(){
    router.post('/map-column-supplier', form, {
        preserveScroll:true,
        preserveState:false,
        onSuccess:()=> open=false
    })
}
</script>

<template>
    <PortalLayout :title="supplier.name" :score="supplier.score">

        <SupplierTabs :supplier="supplier" active="Open Orders"></SupplierTabs>
        <form @submit.prevent="submitForm" class="relative flex-auto">
        <div class="columns-2 p-4" v-for="(column, index) in columns">
            <div>
                <div>{{column.name}}</div>
                <small v-if="column.description">{{column.description}}</small>
            </div>
            <div>
                <label :for="column.column_name" class="sr-only">{{column.name}}</label>
                <select :name="form.columns" v-model="form.columns[index]" :id="column.column_name" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                    <option></option>
                    <option v-for="suppliercolumn in supplier_columns">{{suppliercolumn}}</option>
                </select>
            </div>
        </div>
        <div class="p-4 text-right">
            <button type="submit" class="rounded-md bg-blue px-2.5 py-1.5 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50">Save</button>
        </div>
        </form>
    </PortalLayout>
</template>

<style scoped>

</style>
