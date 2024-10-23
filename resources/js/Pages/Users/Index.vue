<script setup>

import PortalLayout from "@/Layouts/PortalLayout.vue";
import UserList from "@/Pages/Users/Partials/UserList.vue";
const props = defineProps(['users'])
</script>

<template>
    <PortalLayout title="Users">
        <UserList :users="users" />
    </PortalLayout>
</template>

<style scoped>

</style>
