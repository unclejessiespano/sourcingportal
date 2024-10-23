<script setup>

import PortalLayout from "@/Layouts/PortalLayout.vue";
import EditTouchpointForm from "@/Pages/Admin/Touchpoints/Partials/EditTouchpointForm.vue";
const props = defineProps(['touchpoint', 'errors'])
</script>

<template>
    <PortalLayout :title="touchpoint.touchpoint">
        <EditTouchpointForm :touchpoint="touchpoint" />
    </PortalLayout>
</template>

<style scoped>

</style>
