<script setup>
import PortalLayout from "@/Layouts/PortalLayout.vue";
import SuppliersGridCondensed from "@/Pages/Suppliers/Partials/SuppliersGridCondensed.vue";

const props = defineProps(['lines'])
</script>

<template>
    <PortalLayout title="Search Results">
        <SuppliersGridCondensed return_to_route="supplier.show" :lines="lines"></SuppliersGridCondensed>
    </PortalLayout>

</template>

<style scoped>

</style>
