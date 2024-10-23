<script setup>
import moment from 'moment'
import {reactive} from "vue";
import {router} from "@inertiajs/vue3";
const people = [
    { name: 'Lindsay Walton', title: 'Front-end Developer', email: 'lindsay.walton@example.com', role: 'Member' },
    // More people...
]
const props = defineProps(['ingestions'])
let form = reactive({
    ingestion_id:null
})
function undoIngestion(event){
    form.ingestion_id = event.target.dataset.ingestion_id;
    router.post('/undoIngestion', form, {
        preserveScroll:true,
        preserveState:false
    })
}
</script>
<template>
    <div class="px-4 sm:px-6 lg:px-8">
        <div class="-mx-4 mt-8 sm:-mx-0">
            <table class="min-w-full divide-y divide-gray-300">
                <thead>
                <tr>
                    <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-0">File</th>
                    <th scope="col" class="hidden px-3 py-3.5 text-left text-sm font-semibold text-gray-900 sm:table-cell">Date</th>
                    <th scope="col" class="hidden px-3 py-3.5 text-left text-sm font-semibold text-gray-900 lg:table-cell">Lines</th>
                    <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Commit %</th>
                    <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Late %</th>
                    <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-0">
                        <span class="sr-only">Undo</span>
                    </th>
                </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 bg-white">
                <tr v-for="ingestion in ingestions" :key="ingestion.id">
                    <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-0">{{ ingestion.filename }}</td>
                    <td class="hidden whitespace-nowrap px-3 py-4 text-sm text-gray-500 sm:table-cell">{{ moment(ingestion.created_at).format('MMM Do, YYYY') }} <small>{{moment(ingestion.created_at).format('HH:mm a')}}</small></td>
                    <td class="hidden whitespace-nowrap px-3 py-4 text-sm text-gray-500 lg:table-cell">{{ingestion.lines.length}}</td>
                    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ingestion.commit_percent}}%</td>
                    <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ingestion.percentageLateLines}}%</td>
                    <td class="whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-0">
                        <a href="#" @click="undoIngestion" :data-ingestion_id="ingestion.id" class="text-indigo-600 hover:text-indigo-900">Undo</a>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>


