<script setup>
const props = defineProps(['attendee'])
</script>

<template>
    <div class="relative flex items-start py-4">
        <div class="mr-3 flex h-6 items-center">
            <input :id="attendee.id" :name="attendee.name" type="checkbox" class="h-4 w-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-600" />
        </div>
        <div class="min-w-0 flex-1 text-sm leading-6">
            <label class="select-none font-medium text-gray-900">{{ attendee.name }}</label>
        </div>

    </div>
</template>

<style scoped>

</style>
