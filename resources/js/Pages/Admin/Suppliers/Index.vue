<script setup>

import PortalLayout from "@/Layouts/PortalLayout.vue";
import TouchpointsTable from "@/Pages/Admin/Touchpoints/Partials/TouchpointsTable.vue";
import SupplierList from "@/Pages/Admin/Suppliers/Partials/SupplierList.vue"
const props = defineProps(['suppliers'])
</script>

<template>
    <PortalLayout title="Suppliers">
        <SupplierList :suppliers="suppliers" />
    </PortalLayout>
</template>

<style scoped>

</style>
