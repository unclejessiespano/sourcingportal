<script setup>

import PortalLayout from "@/Layouts/PortalLayout.vue";
const props = defineProps(['order'])
</script>

<template>
    <PortalLayout title="Order">
        {{order}}
    </PortalLayout>
</template>

<style scoped>

</style>
