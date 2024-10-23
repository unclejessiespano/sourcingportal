<script setup>

import PortalLayout from "@/Layouts/PortalLayout.vue";
import ScoreTable from "@/Pages/Admin/Suppliers/Partials/ScoreTable.vue";
const props = defineProps(['supplier', 'scores'])
</script>


<template>
    <PortalLayout :title="supplier.name">
        <template v-slot:header_button>
            <a href="/admin/supplier/scores" class="rounded-md bg-indigo-600 px-3.5 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Back</a>
        </template>
        <ScoreTable :scores="scores" />
    </PortalLayout>
</template>

<style scoped>

</style>
