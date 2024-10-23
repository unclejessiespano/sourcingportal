<script setup>
import { ChatBubbleLeftEllipsisIcon, TagIcon, UserCircleIcon } from '@heroicons/vue/20/solid'
import moment from 'moment'
import Avatar from "@/Components/Avatar.vue"
const props = defineProps(['meetingItems'])
const activity = [
    {
        id: 1,
        type: 'comment',
        person: { name: 'Eduardo Benz', href: '#' },
        imageUrl:
            'https://images.unsplash.com/photo-1520785643438-5bf77931f493?ixlib=rb-=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=8&w=256&h=256&q=80',
        comment:
            'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Tincidunt nunc ipsum tempor purus vitae id. Morbi in vestibulum nec varius. Et diam cursus quis sed purus nam. ',
        date: '6d ago',
    },
    {
        id: 2,
        type: 'assignment',
        person: { name: 'Hilary Mahy', href: '#' },
        assigned: { name: 'Kristin Watson', href: '#' },
        date: '2d ago',
    },
    {
        id: 3,
        type: 'tags',
        person: { name: 'Hilary Mahy', href: '#' },
        tags: [
            { name: 'Bug', href: '#', color: 'fill-red-500' },
            { name: 'Accessibility', href: '#', color: 'fill-indigo-500' },
        ],
        date: '6h ago',
    },
    {
        id: 4,
        type: 'comment',
        person: { name: 'Jason Meyers', href: '#' },
        imageUrl:
            'https://images.unsplash.com/photo-1531427186611-ecfd6d936c79?ixlib=rb-=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=8&w=256&h=256&q=80',
        comment:
            'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Tincidunt nunc ipsum tempor purus vitae id. Morbi in vestibulum nec varius. Et diam cursus quis sed purus nam. Scelerisque amet elit non sit ut tincidunt condimentum. Nisl ultrices eu venenatis diam.',
        date: '2h ago',
    },
]
</script>

<template>
    <div class="flow-root">
        <ul role="list" class="-mb-8">
            <li v-for="(item, index) in meetingItems" :key="item.id">
                <div class="relative pb-8">
                    <span v-if="index !== meetingItems.length - 1" class="absolute left-5 top-5 -ml-px h-full w-0.5 bg-gray-200" aria-hidden="true" />
                    <div class="relative flex items-start space-x-3">
                        <div class="relative">
                            <Avatar v-if="item.user" :name="item.user.name" />
                            <Avatar v-else name="Unknown" />
                            <span class="absolute -bottom-0.5 -right-1 rounded-tl bg-white px-0.5 py-px">
                                <ChatBubbleLeftEllipsisIcon class="h-5 w-5 text-gray-400" aria-hidden="true" />
                            </span>
                        </div>
                        <div class="min-w-0 flex-1">
                            <div>
                                <div class="text-sm" v-if="item.user">{{ item.user.name }}</div>
                                <div class="text-sm" v-else>Unknown</div>
                                <p class="mt-0.5 text-sm text-gray-500">Commented {{ moment(item.created_at).format('LLL') }}</p>
                            </div>
                            <div class="mt-2 text-sm text-gray-700">
                                <p>{{ item.item }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </li>
        </ul>
    </div>
</template>

<style scoped>

</style>
