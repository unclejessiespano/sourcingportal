<script setup>

import PortalLayout from "@/Layouts/PortalLayout.vue";
import TouchpointDisplay from "@/Pages/Admin/Touchpoints/Partials/TouchpointDisplay.vue";
const props = defineProps(['touchpoint'])
</script>

<template>
    <PortalLayout :title="touchpoint.touchpoint">
        <TouchpointDisplay :touchpoint="touchpoint" />
        <div class="mt-10">
            <a href="/admin/touchpoints" class="rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Back to touchpoints</a>
        </div>
    </PortalLayout>
</template>

<style scoped>

</style>
