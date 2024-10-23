<script setup>
import { defineComponent, h } from 'vue'
import moment from 'moment'
const navigation = {
    main: [
        { name: 'Privacy', href: 'privacy' },
    ],
    social: [

    ],
}
</script>

<template>
    <footer class="bg-white">
        <div class="mx-auto max-w-7xl overflow-hidden px-6 py-20 sm:py-24 lg:px-8">
            <nav class="-mb-6 columns-2 sm:flex sm:justify-center sm:space-x-12" aria-label="Footer">
                <div v-for="item in navigation.main" :key="item.name" class="pb-6">
                    <a :href="item.href" class="text-sm leading-6 text-gray-600 hover:text-gray-900">{{ item.name }}</a>
                </div>
            </nav>
            <div class="mt-10 flex justify-center space-x-10">
                <a v-for="item in navigation.social" :key="item.name" :href="item.href" class="text-gray-400 hover:text-gray-500">
                    <span class="sr-only">{{ item.name }}</span>
                    <component :is="item.icon" class="h-6 w-6" aria-hidden="true" />
                </a>
            </div>
            <p class="mt-10 text-center text-xs leading-5 text-gray-500">&copy; {{ moment().format('Y') }} Corbus, LLC. All rights reserved.</p>
        </div>
    </footer>
</template>

<style scoped>

</style>
