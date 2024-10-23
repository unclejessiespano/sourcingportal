<script setup>
import ScoreBadge from "@/Pages/Suppliers/Partials/ScoreBadge.vue";
const props = defineProps(['metrics'])
const locations = [
    {
        name: 'Edinburgh',
        people: [
            { name: 'Lindsay Walton', title: 'Front-end Developer', email: 'lindsay.walton@example.com', role: 'Member' },
            { name: 'Courtney Henry', title: 'Designer', email: 'courtney.henry@example.com', role: 'Admin' },
        ],
    },
    // More people...
]
function getColorClass(x, highscore){
    let badge_class = null

    if(highscore==100){
        if(x >=80){
            badge_class = "bg-green-500"
        }
        else if(x <76 && x >=60) {
            badge_class = "bg-amber-500"
        }
        else{
            badge_class = "bg-red-500"
        }
    }
    else{
        if(x <=20){
            badge_class = "bg-green-500"
        }
        else if(x <80 && x >20) {
            badge_class = "bg-amber-500"
        }
        else{
            badge_class = "bg-red-500"
        }
    }



    badge_class = badge_class+" text-white whitespace-nowrap px-3 py-4 text-sm text-center"
    console.log(x+" "+badge_class)
    return badge_class
}
</script>

<template>
    <div class="px-4 sm:px-6 lg:px-8">

        <div class="mt-8 flow-root">
            <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                    <table class="min-w-full">
                        <thead class="bg-white">
                        <tr>
                            <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-3"><span class="sr-only">Supplier</span></th>
                            <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900 text-center">Lines</th>
                            <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900 text-center">Commits</th>
                            <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900 text-center">Missed Commits</th>
                            <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900 text-center">Late</th>
                            <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900 text-center">Avg. Commit Gap</th>
                            <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900 text-center">% Committed</th>
                            <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900 text-center">% Past Due</th>
                            <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900 text-center">% Missed Commit</th>
                        </tr>
                        </thead>
                        <tbody class="bg-white">
                        <template v-for="(type, teammember) in metrics" :key="teammember.name">
                            <tr class="border-t border-gray-200">
                                <th scope="colgroup" class="bg-gray-50 py-2 pl-4 pr-3 text-left text-lg font-semibold text-gray-900 sm:pl-3">{{ teammember }}</th>
                                <th scope="colgroup" class="bg-gray-50 py-2 pl-4 pr-3 text-center text-lg font-semibold text-gray-900 sm:pl-3">{{ type.totals.count }}</th>
                                <th scope="colgroup" class="bg-gray-50 py-2 pl-4 pr-3 text-center text-lg font-semibold text-gray-900 sm:pl-3">{{ type.totals.commit_dates }}</th>
                                <th scope="colgroup" class="bg-gray-50 py-2 pl-4 pr-3 text-center text-lg font-semibold text-gray-900 sm:pl-3">{{ type.totals.late_commits }}</th>
                                <th scope="colgroup" class="bg-gray-50 py-2 pl-4 pr-3 text-center text-lg font-semibold text-gray-900 sm:pl-3">{{ type.totals.late_lines }}</th>
                                <th scope="colgroup" class="bg-gray-50 py-2 pl-4 pr-3 text-center text-lg font-semibold text-gray-900 sm:pl-3">{{ type.totals.due_commit_span }}</th>
                                <th scope="colgroup" class="bg-gray-50 py-2 pl-4 pr-3 text-center text-lg font-semibold text-gray-900 sm:pl-3">{{ type.totals.percent_commit }}%</th>
                                <th scope="colgroup" class="bg-gray-50 py-2 pl-4 pr-3 text-center text-lg font-semibold text-gray-900 sm:pl-3">{{ type.totals.percent_late }}%</th>
                                <th scope="colgroup" class="bg-gray-50 py-2 pl-4 pr-3 text-center text-lg font-semibold text-gray-900 sm:pl-3">{{ type.totals.percent_latecommit }}%</th>
                            </tr>
                            <template v-if="1==1">
                            <tr v-for="(metrics, supplier) in type.data" :class="[supplier === 0 ? 'border-gray-300' : 'border-gray-200', 'border-t collapse-content']">
                                <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 pl-6">
                                    <ScoreBadge :score="metrics.supplier_score" />
                                    <a class="ml-4" :href="'/supplier/'+metrics.supplier_slug">{{supplier}}</a>
                                </td>
                                <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500 text-center">{{metrics.count}}</td>
                                <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500 text-center">{{metrics.commit_dates}}</td>
                                <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500 text-center">{{metrics.late_commits}}</td>
                                <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500 text-center">{{metrics.late_lines}}</td>
                                <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500 text-center">{{metrics.due_commit_span}}</td>
                                <td :class="getColorClass(metrics.percent_commit, 100)">{{metrics.percent_commit}}%</td>
                                <td :class="getColorClass(metrics.percent_late, 0)">{{metrics.percent_late}}%</td>
                                <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500 text-center">{{metrics.percent_latecommit}}%</td>
                            </tr>
                            </template>
                        </template>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</template>

<style scoped>

</style>
