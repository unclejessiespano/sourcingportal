<script setup>
import { BuildingOfficeIcon, LinkIcon, UserIcon } from '@heroicons/vue/20/solid';
import PortalLayout from "@/Layouts/PortalLayout.vue";
import ScoreBadge from "@/Pages/Suppliers/Partials/ScoreBadge.vue";
import EscalatedSupplierInfo from "@/Pages/Escalations/Partials/EscalatedSupplierInfo.vue";
import EscalationSkuTable from "@/Pages/Escalations/Partials/EscalationSkuTable.vue";
import NegativeTouchpointTable from "@/Pages/Escalations/Partials/NegativeTouchpointTable.vue";
const props = defineProps(['escalation', 'summary', 'supplier_score', 'negative_touchpoints']);
</script>

<template>
    <PortalLayout :title="'Escalation - '+escalation.id">

        <div class="bg-white py-24 sm:py-32">
            <div class="flex mx-auto max-w-7xl px-6 lg:px-8 items-center">
                <div class="mx-auto max-w-2xl lg:mx-0">
                    <h1 class="text-4xl font-bold tracking-tight text-gray-900 sm:text-6xl">Escalation #{{escalation.id}}</h1>
                    <h2 class="text-xl font-bold tracking-tight text-gray-500 sm:text-2xl mt-3">{{escalation.name}}</h2>

                    <div class="relative">
                        <div class="absolute inset-0 flex items-center" aria-hidden="true">
                            <div class="w-full border-t border-gray-300" />
                        </div>
                    </div>

                    <p class="mt-6 text-lg leading-8 text-gray-600">{{summary}}</p>
                </div>
                <div class="px-12">
                    <EscalatedSupplierInfo :supplier="escalation" :supplier_score="supplier_score" />
                </div>
            </div>
        </div>
        <div>
            <NegativeTouchpointTable :escalation="escalation" :touchpoints="negative_touchpoints" />
        </div>

    </PortalLayout>
</template>

<style scoped>

</style>
