<script setup>
    import PortalLayout from "@/Layouts/PortalLayout.vue";
    import SuppliersGrid from "@/Pages/Suppliers/Partials/SuppliersGrid.vue";
    import OrderTable from "@/Pages/Orders/Partials/OrderTable.vue";
    import SuppliersGridCondensed from "@/Pages/Suppliers/Partials/SuppliersGridCondensed.vue";

    const props = defineProps(['lines', 'orders'])
</script>

<template>
    <PortalLayout title="Orders">
        <template #header_button>
            <button type="button" class="ml-3 inline-flex items-center rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-700 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Export</button>
        </template>
        <OrderTable :orders="orders" />
    </PortalLayout>
</template>

<style scoped>

</style>
