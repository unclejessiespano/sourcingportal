<script setup>
import { EllipsisVerticalIcon, ChevronUpIcon } from '@heroicons/vue/20/solid'
import { Disclosure, DisclosureButton, DisclosurePanel } from '@headlessui/vue'
import ScoreFeed from "@/Pages/Suppliers/Partials/ScoreFeed.vue";

const props = defineProps(['title', 'bgColor', 'score'])
const projects = [
    { name: 'Graph API', initials: 'GA', href: '#', members: 16, bgColor: 'bg-pink-600' },
    { name: 'Component Design', initials: 'CD', href: '#', members: 12, bgColor: 'bg-purple-600' },
    { name: 'Templates', initials: 'T', href: '#', members: 16, bgColor: 'bg-yellow-500' },
    { name: 'React Components', initials: 'RC', href: '#', members: 8, bgColor: 'bg-green-500' },
]
</script>
<template>
    <Disclosure v-slot="{ open }">
    <div class="col-span-1 flex rounded-md shadow-sm">
        <div :class="[bgColor, 'flex w-16 flex-shrink-0 items-center justify-center rounded-l-md text-sm font-medium text-white']">{{ score }}</div>
        <div class="flex flex-1 items-center justify-between truncate rounded-r-md border-b border-r border-t border-gray-200 bg-white">
            <div class="flex-1 truncate px-4 py-2 text-sm">
                <a class="font-medium text-gray-900 hover:text-gray-600">{{ title }}</a>
                <!--<p class="text-gray-500">Members</p>-->
            </div>
            <div class="flex-shrink-0 pr-2">
                <DisclosureButton
                    class="inline-flex h-8 w-8 items-center justify-center rounded-full bg-transparent bg-white text-gray-400 hover:text-gray-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2"
                >
                    <span class="sr-only">Open options</span>
                    <EllipsisVerticalIcon class="h-5 w-5" aria-hidden="true" />
                </DisclosureButton>
            </div>
        </div>
    </div>
        <DisclosurePanel>
            <ScoreFeed></ScoreFeed>

        </DisclosurePanel>
    </Disclosure>
</template>

