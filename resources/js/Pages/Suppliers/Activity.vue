<script setup>

import SupplierTouchpoints from "@/Pages/Suppliers/Partials/SupplierTouchpoints.vue";
import PortalLayout from "@/Layouts/PortalLayout.vue";
import LineChartSupplierScore from "@/Pages/Suppliers/Partials/Charts/LineChartSupplierScore.vue";
import POFeed from "@/Pages/Suppliers/Partials/POFeed.vue";
import SupplierTabs from "@/Pages/Suppliers/Partials/SupplierTabs.vue";
const props = defineProps(['supplier', 'activity', 'supplier_scores'])
</script>

<template>
    <PortalLayout :title="supplier.name" :score="supplier.score">
        <SupplierTabs :supplier="supplier" active="Activity"></SupplierTabs>
        <LineChartSupplierScore :supplier_scores="supplier_scores"></LineChartSupplierScore>
        <!--
        <POFeed :activity="activity" :supplier="supplier" line=""></POFeed>
        -->
        <SupplierTouchpoints :supplier="supplier" :activity="activity"></SupplierTouchpoints>
    </PortalLayout>
</template>

<style scoped>

</style>
