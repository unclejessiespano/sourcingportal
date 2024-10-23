<script setup>
import moment from 'moment'
const people = [
    { name: 'Lindsay Walton', title: 'Front-end Developer', email: 'lindsay.walton@example.com', role: 'Member' },
    // More people...
]
const props = defineProps(["scores"])
</script>

<template>

    <div class="px-4 sm:px-6 lg:px-8">

        <div class="mt-8 flow-root">
            <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                    <table class="min-w-full divide-y divide-gray-300">
                        <thead>
                        <tr>
                            <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-3">ID</th>
                            <th scope="col" class="px-3 py-3.5 text-center text-sm font-semibold text-gray-900">Ingestion ID</th>
                            <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Date</th>
                            <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Touchpoint</th>
                            <th scope="col" class="px-3 py-3.5 text-center text-sm font-semibold text-gray-900">Current Score</th>
                            <th scope="col" class="px-3 py-3.5 text-center text-sm font-semibold text-gray-900">Points</th>
                            <th scope="col" class="px-3 py-3.5 text-center text-sm font-semibold text-gray-900">New Score</th>

                        </tr>
                        </thead>
                        <tbody class="bg-white">
                        <tr v-for="score in scores" :key="score.id" class="even:bg-gray-50">
                            <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-3">{{ score.id }}</td>
                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500 text-center">{{ score.ingestion_id }}</td>
                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ moment(score.created_at).format("MMMM Do YYYY") }}<small class="block">{{moment(score.created_at).format("h:mm a")}}</small></td>
                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ score.touchpoint }}</td>
                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500 text-center">{{score.previous_score}}</td>
                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500 text-center">{{ score.value }}</td>
                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500 text-center">{{score.updated_score}}</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped>

</style>
