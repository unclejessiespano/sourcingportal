<script setup>
import PortalLayout from "@/Layouts/PortalLayout.vue";
import Table from "@/Pages/Ingestions/Partials/Table.vue";
const props = defineProps(['ingestions'])
</script>

<template>
    <PortalLayout title="Ingestions">
        <Table :ingestions="ingestions" />
    </PortalLayout>
</template>

<style scoped>

</style>
