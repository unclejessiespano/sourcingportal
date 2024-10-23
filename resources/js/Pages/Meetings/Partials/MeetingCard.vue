<script setup>
import {reactive, onMounted} from "vue";
import {router} from "@inertiajs/vue3";
const props = defineProps(['meeting_id', 'item', 'meetingItems'])
let form = reactive({
    meeting_id:props.meeting_id,
    type:props.item.type,
    type_id:props.item.id,
    comment: null,
    input:[]
})

import { BarsArrowUpIcon, UsersIcon, TrophyIcon, PlusCircleIcon } from '@heroicons/vue/20/solid'
import MeetingItems from "@/Pages/Meetings/Partials/MeetingItems.vue";
function submitForm(){
    console.log(form);
    router.post('/meeting/add/input', form, {
        preserveScroll:true,
        preserveState:false
    })
}
onMounted(() => {
    form.input[props.item.id] = null;
})
</script>

<template>
    <div class="divide-y divide-gray-200 overflow-hidden rounded-lg bg-white shadow mb-10">
        <div class="px-4 py-5 sm:px-6">
            <h3 class="text-base font-semibold leading-6 text-gray-900">{{item.icon}} {{item.type}}</h3>
            <p class="mt-2 max-w-4xl text-sm text-gray-500">{{item.description}}</p>


        </div>
        <div class="px-4 py-5 sm:p-6">
            <MeetingItems :meetingItems="meetingItems[item.id]" />
        </div>
        <div class="px-4 py-4 sm:px-6">
            <div>
                <form @submit.prevent="submitForm">
                    <div class="mt-2 flex rounded-md shadow-sm">

                            <div class="relative flex flex-grow items-stretch focus-within:z-10">
                                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-3">
                                    {{item.icon}}
                                </div>
                                <input type="input" v-model="form.input[item.id]" name="achievement" id="achievement" class="block w-full rounded-none rounded-l-md border-0 py-1.5 pl-10 text-gray-900 ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 sm:text-sm sm:leading-6" :placeholder="item.placeholder" />
                            </div>
                            <button :data-type_id="item.id" type="submit" class="bg-indigo-500 relative -ml-px inline-flex items-center gap-x-1.5 rounded-r-md px-3 py-2 text-sm font-semibold text-white ring-1 ring-inset ring-gray-300 hover:bg-indigo-600">
                                <PlusCircleIcon class="-ml-0.5 h-5 w-5 text-white" aria-hidden="true" />
                                Add
                            </button>
                    </div>

                    <div v-if="$page.props.errors.input" class="mt-2 text-sm text-red-600">{{ $page.props.errors.input[5] }}</div>

                </form>
            </div>
        </div>
    </div>
</template>

<style scoped>

</style>
