<script setup>
import PortalLayout from "@/Layouts/PortalLayout.vue";
import SuppliersGridCondensed from "@/Pages/Suppliers/Partials/SuppliersGridCondensed.vue";
import SupplierTabs from "@/Pages/Suppliers/Partials/SupplierTabs.vue";
import SupplierScore from "@/Pages/Suppliers/Partials/SupplierScore.vue";
import SubtierSuppliers from "@/Pages/Suppliers/Partials/SubtierSuppliers.vue";
import SupplierTouchpoints from "@/Pages/Suppliers/Partials/SupplierTouchpoints.vue";
import POFeed from "@/Pages/Suppliers/Partials/POFeed.vue";
import SupplierOrder from "@/Pages/Suppliers/Partials/SupplierOrders.vue";
import GChart from "@/Components/Charts/GChart.vue";
import Stats from "@/Pages/Suppliers/Partials/Stats.vue";
import CommitCalendar from "@/Pages/FinishedParts/Partials/CommitCalendar.vue";
const props = defineProps(['supplier', 'sankeyLineStats', 'stats', 'averageDaysLate', 'commitsForCalendar'])

</script>
<template>
    <PortalLayout :title="supplier.name" :score="supplier.score">

        <SupplierTabs :supplier="supplier" active="Dashboard"></SupplierTabs>
        <Stats stat1Name="Lines" :stat1Value="stats.lineCount" stat2Name="Past Due %" :stat2Value="stats.percentPastDue" stat3Name="Average Days Late" :stat3Value="stats.averageDaysLate" />
        <CommitCalendar :commitsForCalendar="commitsForCalendar" />
        <GChart :supplychain="sankeyLineStats" />
    </PortalLayout>
</template>



<style scoped>

</style>
