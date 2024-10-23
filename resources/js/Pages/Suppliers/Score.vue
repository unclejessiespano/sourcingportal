<script setup>
import PortalLayout from "@/Layouts/PortalLayout.vue";
import SuppliersGridCondensed from "@/Pages/Suppliers/Partials/SuppliersGridCondensed.vue";
import SupplierTabs from "@/Pages/Suppliers/Partials/SupplierTabs.vue";
import SupplierScore from "@/Pages/Suppliers/Partials/SupplierScore.vue";

</script>
<template>
    <PortalLayout title="Ferguson">
        <SupplierTabs></SupplierTabs>
        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4">
            <div class="col-span-1 flex flex-col divide-y divide-gray-200 rounded-lg bg-white text-center">
                <div class="flex flex-1 flex-col p-8 items-center">
                    <span class="inline-flex h-20 w-20 items-center justify-center rounded-full bg-orange-500">
                        <span class="text-xl font-bold leading-none text-white">83</span>
                    </span>
                    <h3 class="mt-6 text-sm font-medium text-gray-900">Supplier Score</h3>

                </div>
            </div>
        </div>

        <div role="list" class="p-4 mt-3 grid grid-cols-1 gap-5 sm:grid-cols-2 sm:gap-6 lg:grid-cols-3">
            <SupplierScore title="Responsiveness" score="71.3" bgColor="bg-orange-500" />
            <SupplierScore title="Delivery" score="87.1" bgColor="bg-green-500" />
            <SupplierScore title="Quality" score="91.9" bgColor="bg-green-500" />
        </div>
    </PortalLayout>
</template>



<style scoped>

</style>
