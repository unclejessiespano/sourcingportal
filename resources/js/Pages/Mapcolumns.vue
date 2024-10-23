<script setup>
import {reactive, ref} from "vue";
import {router} from "@inertiajs/vue3";
import PortalLayout from "@/Layouts/PortalLayout.vue";
const props = defineProps(['request', 'columns'])
let form = reactive({
    column_name:null,
    map_column:null
})
function map_column(e){
    form.column_name = e.target.id;
    form.map_column = e.target.value;
    router.post('/map-column', form, {
        preserveScroll:true,
        preserveState:false,
    })
}
</script>

<template>
    <PortalLayout title="Map Columns">
        {{request}}
        <div class="columns-2 p-4" v-for="column in columns">
            <div>
                <div>{{column.name}}</div>
                <small v-if="column.description">{{column.description}}</small>
            </div>
            <div>
                <label :for="column.column_name" class="sr-only">{{column.name}}</label>
                <input @blur="map_column($event)" type="text" :name="column.column_name" :id="column.column_name" :value="column.column_id" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" />
            </div>
        </div>
    </PortalLayout>
</template>

<style scoped>

</style>
