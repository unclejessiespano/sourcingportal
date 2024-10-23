<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import PortalLayout from "@/Layouts/PortalLayout.vue";
import LinesCommits from '@/Components/Charts/LinesCommits.vue'
import GChart from "@/Components/Charts/GChart.vue"
import Gauge from "@/Components/Charts/Gauge.vue";
import Orgchart from "@/Components/Charts/OrgChart.vue"
import TeamMetrics from "@/Pages/Dashboard/Partials/TeamMetrics.vue"
import { Head } from '@inertiajs/vue3';
import BarChartSupplierPastDue from "@/Components/Charts/BarChartSupplierPastDue.vue";

const props = defineProps(['teamStats', 'sankeySupplyChain', 'supplyChainTree', 'sankeyLineStats', 'commitPercentage', 'latePercentage', 'supplierPastDue'])
</script>

<template>
    <Head title="Dashboard" />

    <PortalLayout title="Dashboard">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Dashboard</h2>
        </template>

        <div class="py-12">
            <TeamMetrics :metrics="teamStats" />
            <template v-if="1==1">
                <div class="flex gap-5">
                    <Gauge :data="commitPercentage" type="positive" />
                    <Gauge :data="latePercentage" type="negative" />
                </div>
            </template>
            <BarChartSupplierPastDue :data="supplierPastDue" />
            <div class="divide-y divide-gray-200 overflow-hidden rounded-lg bg-white shadow mb-5">
                <div class="px-4 py-5 sm:px-6">
                    <p class="my-2 text-xl font-bold tracking-tight text-gray-900 sm:text-2xl">Suppliers</p>
                </div>
                <div class="px-0 py-5">
                    <GChart :supplychain="sankeySupplyChain" />
                </div>
                <div class="px-4 py-4 sm:px-6">
                    <!-- Content goes here -->
                    <!-- We use less vertical padding on card footers at all sizes than on headers or body sections -->
                </div>
            </div>

            <div v-if="1==2" class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <p class="my-2 text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">Lines to commits</p>
                    <GChart :supplychain="sankeyLineStats" />
                </div>
            </div>
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <Orgchart :root="GE" :data="supplyChainTree" />
                </div>
            </div>
            <LinesCommits />
        </div>
    </PortalLayout>
</template>
