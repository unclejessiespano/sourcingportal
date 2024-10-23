<script setup>
    import SuppliersGridCondensed from "@/Pages/Suppliers/Partials/SuppliersGridCondensed.vue";
    import POFeed from "@/Pages/Suppliers/Partials/POFeed.vue";
    import SupplierTabs from "@/Pages/Suppliers/Partials/SupplierTabs.vue";
    import PortalLayout from "@/Layouts/PortalLayout.vue";
    import SupplierForms from "@/Pages/Suppliers/Partials/SupplierForms.vue";

    const props = defineProps(['supplier'])
</script>

<template>
    <PortalLayout :title="supplier.name" :score="supplier.score">

        <SupplierTabs :supplier="supplier" active="Company"></SupplierTabs>
        <SupplierForms :supplier="supplier" />
    </PortalLayout>
</template>

<style scoped>

</style>
