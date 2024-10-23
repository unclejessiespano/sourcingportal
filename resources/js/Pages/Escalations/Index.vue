<script setup>

import PortalLayout from "@/Layouts/PortalLayout.vue";
import EscalationTable from "@/Pages/Escalations/Partials/EscalationTable.vue";
import EscalationStats from "@/Pages/Escalations/Partials/EscalationStats.vue";
const props = defineProps(['escalations', 'escalations_stats'])
</script>

<template>
    <PortalLayout title="Escalations">
        <EscalationStats :escalations="escalations" :escalations_stats="escalations_stats" />
        <EscalationTable :escalations="escalations" />
    </PortalLayout>
</template>

<style scoped>

</style>
