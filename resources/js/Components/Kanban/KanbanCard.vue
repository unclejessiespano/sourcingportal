<script setup>
import { ChatBubbleLeftEllipsisIcon, TagIcon, UserCircleIcon } from '@heroicons/vue/20/solid'


import {defineProps, onMounted, reactive, ref} from 'vue';
import {Dialog, DialogPanel, TransitionChild, TransitionRoot} from "@headlessui/vue";

import AddTaskCommentForm from "@/Pages/Escalations/Partials/AddTaskCommentForm.vue";
import Avatar from "@/Components/Avatar.vue";
import moment from 'moment';
const props = defineProps({
    card: Object,
    taskcomments:Object
});
const open = ref(false)
const dragStart = (event, card) => {
    event.dataTransfer.setData('text/plain', card.id);
};

</script>

<template>

    <TransitionRoot as="template" :show="open" :card="card">
        <Dialog as="div" class="relative z-10" @close="open = false">
            <TransitionChild as="template" enter="ease-out duration-300" enter-from="opacity-0" enter-to="opacity-100" leave="ease-in duration-200" leave-from="opacity-100" leave-to="opacity-0">
                <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" />
            </TransitionChild>

            <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
                <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                    <TransitionChild as="template" enter="ease-out duration-300" enter-from="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" enter-to="opacity-100 translate-y-0 sm:scale-100" leave="ease-in duration-200" leave-from="opacity-100 translate-y-0 sm:scale-100" leave-to="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
                        <DialogPanel class="relative transform overflow-hidden rounded-lg bg-white px-4 pb-4 pt-5 text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-sm sm:p-6">
                            <div>
                                <h1 class="text-2xl font-bold tracking-tight text-gray-900 sm:text-2xl">{{card.task}}</h1>
                                <div class="relative my-3">
                                    <div class="absolute inset-0 flex items-center" aria-hidden="true">
                                        <div class="w-full border-t border-gray-300" />
                                    </div>
                                </div>
                                <div class="flow-root mt-10">
                                    <ul role="list" class="-mb-8">
                                        <li v-for="(comment, index) in taskcomments" :key="comment.id">
                                            <div class="relative pb-8">
                                                <span v-if="index !== taskcomments.length - 1" class="absolute left-5 top-5 -ml-px h-full w-0.5 bg-gray-200" aria-hidden="true" />
                                                <div class="relative flex items-start space-x-3">
                                                    <div class="relative">
                                                        <Avatar :name="comment.user.name" />
                                                        <span class="absolute -bottom-0.5 -right-1 rounded-tl bg-white px-0.5 py-px">
                                                              <ChatBubbleLeftEllipsisIcon class="h-5 w-5 text-gray-400" aria-hidden="true" />
                                                            </span>
                                                    </div>
                                                    <div class="min-w-0 flex-1">
                                                        <div>
                                                            <div class="text-sm font-medium text-gray-900">{{ comment.user.name }}</div>
                                                            <p class="mt-0.5 text-xs text-gray-500">Commented {{ moment(comment.created_at).format('LL') }}</p>
                                                        </div>
                                                        <div class="mt-2 text-sm text-gray-700">
                                                            <p>{{ comment.comment }}</p>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>

                                        </li>
                                    </ul>
                                </div>
                                <div class="mt-10">
                                    <AddTaskCommentForm :card="card" />
                                </div>
                            </div>
                        </DialogPanel>
                    </TransitionChild>
                </div>
            </div>
        </Dialog>
    </TransitionRoot>
    <div
        class="kanban-card bg-gray-100 rounded shadow p-3 mb-2 cursor-pointer"
        draggable="true"
        @dragstart="dragStart($event, card)"
        @click="open=true"
    >

        <div class="flex justify-end mb-4">
            <div class="text-xs">{{taskcomments.length}} Comments</div>
        </div>
        {{ card.task }}
    </div>
</template>

<style scoped>

</style>
