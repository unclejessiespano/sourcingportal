<script setup>

import NegativeTouchpointTable from "@/Pages/Escalations/Partials/NegativeTouchpointTable.vue";
import PortalLayout from "@/Layouts/PortalLayout.vue";
import EscalatedSupplierInfo from "@/Pages/Escalations/Partials/EscalatedSupplierInfo.vue";

import { BuildingOfficeIcon, LinkIcon, UserIcon } from '@heroicons/vue/20/solid';
import ScoreBadge from "@/Pages/Suppliers/Partials/ScoreBadge.vue";
import EscalationSkuTable from "@/Pages/Escalations/Partials/EscalationSkuTable.vue";
import KanbanBoard from "@/Components/Kanban/KanbanBoard.vue";
const props = defineProps(['tasks', 'taskcomments', 'line','escalation', 'summary', 'supplier_score', 'negative_touchpoints', 'identifier', 'taskcolumns']);

</script>

<template>
    <PortalLayout :title="'Escalation - '+escalation.id">
        <div class="bg-white py-24 sm:py-12">
            <div class="flex mx-auto max-w-7xl px-6 lg:px-8 items-center">
                <div class="mx-auto max-w-2xl lg:mx-0">
                    <h1 class="text-2xl font-bold tracking-tight text-gray-900 sm:text-5xl">{{identifier}}</h1>
                    <h2 class="text-2xl font-bold tracking-tight text-gray-300 sm:text-3xl">Escalation #{{escalation.id}}</h2>
                    <p class="mt-6 text-lg leading-8 text-gray-600">{{summary}}</p>
                </div>
                <div class="px-12">
                    <EscalatedSupplierInfo :supplier="escalation.supplier" :supplier_score="supplier_score" />
                </div>
            </div>
        </div>
        <NegativeTouchpointTable :escalation="escalation" :touchpoints="negative_touchpoints" :line="line" />
        <div class="py-10">
            <KanbanBoard :tasks="tasks" :columns="taskcolumns" :taskcomments="taskcomments" />
        </div>
    </PortalLayout>
</template>

<style scoped>

</style>
