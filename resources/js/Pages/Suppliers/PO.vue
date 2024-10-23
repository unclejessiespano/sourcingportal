<script setup>
import PortalLayout from "@/Layouts/PortalLayout.vue";
import SupplierTabs from "@/Pages/Suppliers/Partials/SupplierTabs.vue";
import POFeed from "@/Pages/Suppliers/Partials/POFeed.vue";
import PO from "@/Pages/Orders/Partials/PO.vue";
const props = defineProps(['order', 'lines', 'lineActivities', 'activity', 'supplier'])

</script>
<template>
    <PortalLayout :title="order.PO" subtitle="Ferguson">

        <template name="subhead">
            <div class="mt-1 flex flex-col sm:mt-0 sm:flex-row sm:flex-wrap sm:space-x-6">
                <div class="mt-2 flex items-center text-sm text-gray-500">
                    <BriefcaseIcon class="mr-1.5 h-5 w-5 flex-shrink-0 text-gray-400" aria-hidden="true" />
                    Full-time
                </div>
                <div class="mt-2 flex items-center text-sm text-gray-500">
                    <MapPinIcon class="mr-1.5 h-5 w-5 flex-shrink-0 text-gray-400" aria-hidden="true" />
                    Remote
                </div>
                <div class="mt-2 flex items-center text-sm text-gray-500">
                    <CurrencyDollarIcon class="mr-1.5 h-5 w-5 flex-shrink-0 text-gray-400" aria-hidden="true" />
                    $120k &ndash; $140k
                </div>
                <div class="mt-2 flex items-center text-sm text-gray-500">
                    <CalendarIcon class="mr-1.5 h-5 w-5 flex-shrink-0 text-gray-400" aria-hidden="true" />
                    Closing on January 9, 2020
                </div>
            </div>
        </template>

        <PO :order="order" />


        <div class="my-4 divide-y divide-gray-200 rounded-lg bg-white shadow">
            <div class="px-4 py-5 sm:px-6 bg-gray-100">
                <h3 class="text-1xl font-bold leading-tight tracking-tight text-gray-400">Activity</h3>
            </div>
            <div class="px-4 py-5 sm:p-6">
                <POFeed :activity="activity" :type="PO" :supplier="supplier" :lines="lines" :order="order"></POFeed>
            </div>
        </div>
    </PortalLayout>
</template>



<style scoped>

</style>
