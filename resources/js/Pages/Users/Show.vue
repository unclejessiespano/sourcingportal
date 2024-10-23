<script setup>
    import PortalLayout from "@/Layouts/PortalLayout.vue";
    import EditUserForm from "@/Pages/Users/Partials/EditUserForm.vue";
    import {router} from "@inertiajs/vue3";
    import {reactive} from "vue";
    const props = defineProps(['user', 'roles', 'suppliers', 'assigned_suppliers', 'users_for_team', 'assigned_users'])
    let form = reactive({
        user:props.user,
        role:null
    })
    function submitForm(){
        console.log(form);
        router.post('/admin/user/updaterole', form, {
            preserveScroll:true,
            preserveState:true
        })
    }
</script>

<template>
    <PortalLayout :title="user.name">
        <EditUserForm :user="user" :roles="roles" :suppliers="suppliers" :assigned_suppliers="assigned_suppliers" :users_for_team="users_for_team" :assigned_users="assigned_users" />
    </PortalLayout>
</template>

<style scoped>

</style>
