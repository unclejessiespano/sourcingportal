<script setup>
import PortalLayout from "@/Layouts/PortalLayout.vue";
import SuppliersGridCondensed from "@/Pages/Suppliers/Partials/SuppliersGridCondensed.vue";
import SupplierTabs from "@/Pages/Suppliers/Partials/SupplierTabs.vue";
import SupplierScore from "@/Pages/Suppliers/Partials/SupplierScore.vue";
import POFeed from "@/Pages/Suppliers/Partials/POFeed.vue";
import PartialShipments from "@/Pages/Suppliers/Partials/PartialShipments.vue";
const props = defineProps(['line', 'lineActivities', 'activity', 'supplier', 'tracking_info'])

</script>
<template>
    <PortalLayout :title="supplier.name" :score="supplier.score">
        <SupplierTabs :supplier="supplier" active="Open Orders"></SupplierTabs>

        <SuppliersGridCondensed return_to_route="line.show" po="true" type="line" :showViewButton="false" :line="line" :lineActivities="lineActivities"></SuppliersGridCondensed>

        <div class="flex gap-x-10">
            <div class="basis-1/2">
                <div class="my-4 divide-y divide-gray-200 rounded-lg bg-white shadow">
                    <div class="px-4 py-5 sm:px-6 bg-gray-100">
                        <h3 class="text-1xl font-bold leading-tight tracking-tight text-gray-400">Activity</h3>
                    </div>
                    <div class="px-4 py-5 sm:p-6">
                        <POFeed :activity="activity" :line="line"></POFeed>
                    </div>
                </div>
            </div>
            <div class="basis-1/2">
                <PartialShipments :shipments="line.shipments" :tracking_info="tracking_info" />
            </div>
        </div>

    </PortalLayout>
</template>



<style scoped>

</style>
