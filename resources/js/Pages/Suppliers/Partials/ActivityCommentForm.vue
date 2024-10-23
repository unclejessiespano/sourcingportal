<script setup>
import {router, useForm} from "@inertiajs/vue3";

const props = defineProps(['supplier_id', 'line'])
const form = useForm({
    id: (props.line) ? props.line.id : null,
    supplier_id:props.supplier_id,
    po_id:(props.line) ? props.line.po_id : null,
    sku_id:(props.line) ? props.line.sku_id : null,
    line:(props.line) ? props.line.line : null,
    identifier:(props.line) ? props.line.identifier : null,
    comment:null,
});
function submitForm(){
    router.post('/addComment', form, {
        preserveScroll:true,
        preserveState:false,
        onSuccess:()=> open=false
    })
}
</script>

<template>

    <div class="mt-6 flex gap-x-3 mb-10">
        <img src="https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80" alt="" class="h-6 w-6 flex-none rounded-full bg-gray-50" />
        <form @submit.prevent="submitForm" class="relative flex-auto">
            <div class="overflow-hidden rounded-lg pb-12 shadow-sm ring-1 ring-inset ring-gray-300 focus-within:ring-2 focus-within:ring-indigo-600">
                <label for="comment" class="sr-only">Add your comment</label>
                <textarea rows="2" v-model="form.comment" name="comment" id="comment" class="block w-full resize-none border-0 bg-transparent py-1.5 text-gray-900 placeholder:text-gray-400 focus:ring-0 sm:text-sm sm:leading-6" placeholder="Add your comment..." />

            </div>

            <div class="absolute inset-x-0 bottom-0 flex justify-between py-2 pl-3 pr-2">
                <div class="flex items-center space-x-5">
                    <div v-if="$page.props.errors.comment" class="mt-2 text-sm text-red-600">{{ $page.props.errors.comment }}</div>
                </div>
                <button type="submit" class="rounded-md bg-white px-2.5 py-1.5 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50">Comment</button>
            </div>

        </form>

    </div>
</template>

<style scoped>

</style>
