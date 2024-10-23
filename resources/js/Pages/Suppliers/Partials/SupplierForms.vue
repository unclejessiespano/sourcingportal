<script setup>
    import SupplierFormAbout from "@/Pages/Suppliers/Partials/SupplierFormAbout.vue";
    import SupplierFormPlant from "@/Pages/Suppliers/Partials/SupplierFormPlant.vue";
    import SupplierFormContacts from "@/Pages/Suppliers/Partials/SupplierFormContacts.vue";
    import AlertSuccess from "@/Components/Alerts/Success.vue";
    const props = defineProps(['supplier']);
</script>

<template>
    <div class="space-y-10 divide-y divide-gray-900/10">
        <div v-if="$page.props.flash.success">
            <AlertSuccess :message="$page.props.flash.success" />
        </div>
        <SupplierFormAbout :supplier="supplier" />

        <SupplierFormPlant :supplier="supplier" />

        <SupplierFormContacts :supplier="supplier" />
    </div>
</template>

<style scoped>

</style>
