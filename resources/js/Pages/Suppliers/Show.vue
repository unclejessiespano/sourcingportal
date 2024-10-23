<script setup>
import PortalLayout from "@/Layouts/PortalLayout.vue";
import SuppliersGridCondensed from "@/Pages/Suppliers/Partials/SuppliersGridCondensed.vue";
import SupplierTabs from "@/Pages/Suppliers/Partials/SupplierTabs.vue";
import SupplierScore from "@/Pages/Suppliers/Partials/SupplierScore.vue";
import SubtierSuppliers from "@/Pages/Suppliers/Partials/SubtierSuppliers.vue";
import SupplierTouchpoints from "@/Pages/Suppliers/Partials/SupplierTouchpoints.vue";
import POFeed from "@/Pages/Suppliers/Partials/POFeed.vue";
import SupplierOrder from "@/Pages/Suppliers/Partials/SupplierOrders.vue";
import FileUpload from "@/Pages/Suppliers/Partials/FileUpload.vue";
const props = defineProps(['supplier', 'orders', 'activity', 'lines'])

</script>
<template>
    <PortalLayout :title="supplier.name" :score="supplier.score">

        <SupplierTabs :supplier="supplier" active="Open Orders"></SupplierTabs>
        <FileUpload :supplier_id="supplier.id" />
        <SupplierOrder :orders="orders" :lines="lines" class="hidden" />
        <SuppliersGridCondensed return_to_route="supplier.show" :lines="lines" :orders="orders"></SuppliersGridCondensed>
        <!--
        <POFeed :supplier="supplier" :activity="activity" line=""></POFeed>
        -->
    </PortalLayout>
</template>



<style scoped>

</style>
