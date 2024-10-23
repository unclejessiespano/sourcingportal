<script setup>

import AddTouchpointForm from "@/Pages/Admin/Touchpoints/Partials/AddTouchpointForm.vue";
import AddUserForm from "@/Pages/Users/Partials/AddUserForm.vue";
import PortalLayout from "@/Layouts/PortalLayout.vue";
const props = defineProps(['roles', 'suppliers'])
</script>

<template>
    <PortalLayout title="Create User">
        <AddUserForm :roles="roles" :suppliers="suppliers" />
    </PortalLayout>
</template>

<style scoped>

</style>
