<script setup>

import PortalLayout from "@/Layouts/PortalLayout.vue";
import FinishedPartsGrid from "@/Pages/FinishedParts/Partials/FinishedPartsGrid.vue";
import AddFinishedGoodForm from "@/Pages/FinishedParts/AddFinishedGoodForm.vue";
const props = defineProps(['finishedparts'])
</script>

<template>
    <PortalLayout title="Finished Parts">
        <template v-slot:header_button><AddFinishedGoodForm /></template>
        <FinishedPartsGrid :finishedparts="finishedparts" />
    </PortalLayout>
</template>

<style scoped>

</style>
