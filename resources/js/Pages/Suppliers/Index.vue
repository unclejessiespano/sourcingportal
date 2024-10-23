<script setup>
import PortalLayout from "@/Layouts/PortalLayout.vue";
import SuppliersGrid from "@/Pages/Suppliers/Partials/SuppliersGrid.vue"

const props = defineProps(['suppliers'])

</script>
<template>
    <PortalLayout title="Suppliers">
        <template #header_button>
            <button type="button" class="ml-3 inline-flex items-center rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-700 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Export</button>
        </template>
        <SuppliersGrid :suppliers="suppliers"></SuppliersGrid>
    </PortalLayout>
</template>



<style scoped>

</style>
