<script setup>
    import PortalLayout from "@/Layouts/PortalLayout.vue";
    import MeetingTable from "@/Pages/Meetings/Partials/MeetingTable.vue";

    const props = defineProps(['meetings'])
</script>

<template>
    <PortalLayout title="Meetings">
        <MeetingTable :meetings="meetings" />
    </PortalLayout>
</template>

<style scoped>

</style>
