<script setup>
    import PortalLayout from "@/Layouts/PortalLayout.vue";
    import TouchpointsTable from "@/Pages/Admin/Touchpoints/Partials/TouchpointsTable.vue";
    const props = defineProps(['touchpoints'])
</script>

<template>
    <PortalLayout title="Touchpoints">

        <TouchpointsTable :touchpoints="touchpoints" />
    </PortalLayout>
</template>

<style scoped>

</style>
