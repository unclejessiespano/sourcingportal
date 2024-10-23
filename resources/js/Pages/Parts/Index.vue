<script setup>
    import PortalLayout from "@/Layouts/PortalLayout.vue"
    import PartsTable from "@/Pages/Parts/Partials/PartsTable.vue"
    const props = defineProps(['parts'])
</script>

<template>
    <PortalLayout title="Parts">
        <template #header_button>
            <button type="button" class="ml-3 inline-flex items-center rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-700 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Export</button>
        </template>
        <PartsTable :parts="parts" />
    </PortalLayout>
</template>

<style scoped>

</style>
