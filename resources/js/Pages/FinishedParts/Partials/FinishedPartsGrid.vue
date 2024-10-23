<script setup>

const props = defineProps(['finishedparts'])
</script>

<template>
    <ul role="list" class="grid grid-cols-2 gap-x-4 gap-y-8 sm:grid-cols-3 sm:gap-x-6 lg:grid-cols-4 xl:gap-x-8">
        <li v-for="finishedpart in finishedparts" :key="finishedpart.id" class="relative">
            <a :href="'/finishedparts/'+finishedpart.id">
            <div class="group aspect-h-7 aspect-w-10 block w-full overflow-hidden rounded-lg bg-gray-100 focus-within:ring-2 focus-within:ring-indigo-500 focus-within:ring-offset-2 focus-within:ring-offset-gray-100">
                <img :src="finishedpart.image" alt="" class="pointer-events-none object-cover group-hover:opacity-75" />
                <button type="button" class="absolute inset-0 focus:outline-none">
                    <span class="sr-only">View details for {{ finishedpart.name }}</span>
                </button>
            </div>
            <p class="pointer-events-none mt-2 block truncate text-sm font-medium text-gray-900"><a :href="'/finishedparts/'+finishedpart.id">{{ finishedpart.name }}</a></p>
            <p class="pointer-events-none block text-sm font-medium text-gray-500">{{ finishedpart.description }}</p>
            </a>
        </li>
    </ul>
</template>

<style scoped>

</style>
