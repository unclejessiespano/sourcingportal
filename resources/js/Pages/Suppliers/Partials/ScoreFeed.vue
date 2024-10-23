<script setup>
import { ref } from 'vue'
import { CheckCircleIcon } from '@heroicons/vue/24/solid'
import {
    FaceFrownIcon,
    FaceSmileIcon,
    FireIcon,
    HandThumbUpIcon,
    HeartIcon,
    PaperClipIcon,
    XMarkIcon,
    EnvelopeIcon,
    PhoneIcon,
    ExclamationTriangleIcon
} from '@heroicons/vue/20/solid'
import { Listbox, ListboxButton, ListboxLabel, ListboxOption, ListboxOptions } from '@headlessui/vue'

const activity = [
    { id: 1, type: 'emailed', activity:'emailed the supplier', person: { name: 'Linda Hagon' }, date: '7d ago', dateTime: '2023-01-23T10:32' },
    { id: 2, type: 'called', activity:'called the supplier', person: { name: 'Linda Hagon' }, date: '6d ago', dateTime: '2023-01-23T11:03' },
    { id: 3, type: 'called', activity:'called the supplier', person: { name: 'Linda Hagon' }, date: '6d ago', dateTime: '2023-01-23T11:24' },
    { id: 6, type: 'replied', activity:'replied to Corbus', person: { name: 'Alex Curren' }, date: '1d ago', dateTime: '2023-01-24T09:20' },
]
const moods = [
    { name: 'Excited', value: 'excited', icon: FireIcon, iconColor: 'text-white', bgColor: 'bg-red-500' },
    { name: 'Loved', value: 'loved', icon: HeartIcon, iconColor: 'text-white', bgColor: 'bg-pink-400' },
    { name: 'Happy', value: 'happy', icon: FaceSmileIcon, iconColor: 'text-white', bgColor: 'bg-green-400' },
    { name: 'Sad', value: 'sad', icon: FaceFrownIcon, iconColor: 'text-white', bgColor: 'bg-yellow-400' },
    { name: 'Thumbsy', value: 'thumbsy', icon: HandThumbUpIcon, iconColor: 'text-white', bgColor: 'bg-blue-500' },
    { name: 'I feel nothing', value: null, icon: XMarkIcon, iconColor: 'text-gray-400', bgColor: 'bg-transparent' },
]

const selected = ref(moods[5])
</script>
<template>
    <ul role="list" class="space-y-6">
        <li v-for="(activityItem, activityItemIdx) in activity" :key="activityItem.id" class="relative flex gap-x-4">
            <div :class="[activityItemIdx === activity.length - 1 ? 'h-6' : '-bottom-6', 'absolute left-0 top-0 flex w-6 justify-center']">
                <div class="w-px bg-gray-200" />
            </div>
            <template v-if="activityItem.type === 'commented'">
                <img :src="activityItem.person.imageUrl" alt="" class="relative mt-3 h-6 w-6 flex-none rounded-full bg-gray-50" />
                <div class="flex-auto rounded-md p-3 ring-1 ring-inset ring-gray-200">
                    <div class="flex justify-between gap-x-4">
                        <div class="py-0.5 text-xs leading-5 text-gray-500">
                            <span class="font-medium text-gray-900">{{ activityItem.person.name }}</span> commented
                        </div>
                        <time :datetime="activityItem.dateTime" class="flex-none py-0.5 text-xs leading-5 text-gray-500">{{ activityItem.date }}</time>
                    </div>
                    <p class="text-sm leading-6 text-gray-500">{{ activityItem.comment }}</p>
                </div>
            </template>
            <template v-else>
                <div class="relative flex h-6 w-6 flex-none items-center justify-center bg-white">
                    <CheckCircleIcon v-if="activityItem.type === 'replied'" class="h-6 w-6 text-indigo-600" aria-hidden="true" />
                    <EnvelopeIcon v-else-if="activityItem.type === 'emailed'" class="h-6 w-6 text-indigo-600" aria-hidden="true" />

                    <PhoneIcon v-else-if="activityItem.type === 'called'" class="h-6 w-6 text-indigo-600" aria-hidden="true" />
                    <div v-else class="h-1.5 w-1.5 rounded-full bg-gray-100 ring-1 ring-gray-300" />
                </div>
                <p class="flex-auto py-0.5 text-xs leading-5 text-gray-500">
                    <span class="font-medium text-gray-900">{{ activityItem.person.name }}</span> {{ activityItem.activity }}.
                </p>
                <time :datetime="activityItem.dateTime" class="flex-none py-0.5 text-xs leading-5 text-gray-500">{{ activityItem.date }}</time>
            </template>
        </li>
    </ul>
</template>

