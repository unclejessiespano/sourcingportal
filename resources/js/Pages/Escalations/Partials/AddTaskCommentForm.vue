<script setup>
import {reactive} from "vue";
import {router} from "@inertiajs/vue3";
const props = defineProps(['card'])
let form = reactive({
    task_id: props.card.id,
    comment: null
})

function submitForm(){
    console.log(form);
    router.post('/addTaskComment', form, {
        preserveScroll:true,
        preserveState:false
    })
}
</script>

<template>
    <form @submit.prevent="submitForm">
        <div class="space-y-12">
            <div class="border-b border-gray-900/10 pb-12">

                <div class="mt-10 grid grid-cols-6 gap-x-6 gap-y-8 sm:grid-cols-2">

                    <div class="col-span-full">
                        <label for="about" class="block text-sm font-medium leading-6 text-gray-900">Comment</label>
                        <div class="mt-2">
                            <textarea v-model="form.comment" id="comment" name="comment" rows="3" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6" />
                        </div>
                        <div v-if="$page.props.errors.comment" class="mt-2 text-sm text-red-600">{{ $page.props.errors.comment }}</div>
                    </div>


                </div>
            </div>
        </div>

        <div class="mt-6 flex items-center justify-end gap-x-6">
            <button type="button" class="text-sm font-semibold leading-6 text-gray-900">Cancel</button>
            <button type="submit" class="rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Add Comment</button>
        </div>
    </form>
</template>

<style scoped>

</style>
