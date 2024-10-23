<script setup>
import { ref } from 'vue'
import moment from 'moment'
import {useForm, router} from "@inertiajs/vue3";
import { CheckCircleIcon,SignalIcon,
    TruckIcon,
    ClockIcon,
    ExclamationCircleIcon, ChatBubbleLeftIcon, CalendarIcon } from '@heroicons/vue/24/solid'
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
    ExclamationTriangleIcon,
    BoltIcon,

} from '@heroicons/vue/20/solid'
import { Listbox, ListboxButton, ListboxLabel, ListboxOption, ListboxOptions } from '@headlessui/vue'
import Accordion from 'primevue/accordion';
import AccordionTab from 'primevue/accordiontab';
import ActivityCommentForm from '@/Pages/Suppliers/Partials/ActivityCommentForm.vue';
const props = defineProps(['supplier', 'activity', 'line', 'lines'])
const activity = (props.line) ? props.activity.activity : props.activity
const activity2 = [
    { id: 1, type: 'emailed', person: { name: 'Linda Hagon' }, date: '7d ago', dateTime: '2023-01-23T10:32' },
    { id: 2, type: 'called', person: { name: 'Linda Hagon' }, date: '6d ago', dateTime: '2023-01-23T11:03' },
    { id: 3, type: 'called', person: { name: 'Linda Hagon' }, date: '6d ago', dateTime: '2023-01-23T11:24' },
    {
        id: 4,
        type: 'commented',
        person: {
            name: 'Chelsea Hagon',
            imageUrl:
                'https://images.unsplash.com/photo-1550525811-e5869dd03032?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80',
        },
        comment: 'Called supplier, they reassured me the line would be shipped by October 5th',
        date: '3d ago',
        dateTime: '2023-01-23T15:56',
    },
    { id: 5, type: 'commented', person: { name: 'Chelsea Hagon',imageUrl:'https://images.unsplash.com/photo-1550525811-e5869dd03032?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80', }, comment:'Called supplier as I didn\'t receive any tracking information by October 5th', date: '2d ago', dateTime: '2023-01-24T09:12' },
    { id: 6, type: 'paid', person: { name: 'Alex Curren' }, date: '1d ago', dateTime: '2023-01-24T09:20' },
]
const moods = [
    { name: 'Emailed Supplier', value: 'emailed', icon: FireIcon, iconColor: 'text-white', bgColor: 'bg-red-500' },
    { name: 'Called Supplier', value: 'called', icon: FireIcon, iconColor: 'text-white', bgColor: 'bg-red-500' },
    { name: 'Requested Commit', value: 'reqested_commit', icon: FireIcon, iconColor: 'text-white', bgColor: 'bg-red-500' },
    { name: 'Excited', value: 'excited', icon: FireIcon, iconColor: 'text-white', bgColor: 'bg-red-500' },
    { name: 'Loved', value: 'loved', icon: HeartIcon, iconColor: 'text-white', bgColor: 'bg-pink-400' },
    { name: 'Happy', value: 'happy', icon: FaceSmileIcon, iconColor: 'text-white', bgColor: 'bg-green-400' },
    { name: 'Sad', value: 'sad', icon: FaceFrownIcon, iconColor: 'text-white', bgColor: 'bg-yellow-400' },
    { name: 'Thumbsy', value: 'thumbsy', icon: HandThumbUpIcon, iconColor: 'text-white', bgColor: 'bg-blue-500' },
    { name: 'I feel nothing', value: null, icon: XMarkIcon, iconColor: 'text-gray-400', bgColor: 'bg-transparent' },
    { name: 'Called Supplier', value: 'called', icon: FireIcon, iconColor: 'text-white', bgColor: 'bg-red-500' },
    { name: 'Requested Commit', value: 'reqested_commit', icon: FireIcon, iconColor: 'text-white', bgColor: 'bg-red-500' },
    { name: 'Excited', value: 'excited', icon: FireIcon, iconColor: 'text-white', bgColor: 'bg-red-500' },
    { name: 'Loved', value: 'loved', icon: HeartIcon, iconColor: 'text-white', bgColor: 'bg-pink-400' },
    { name: 'Happy', value: 'happy', icon: FaceSmileIcon, iconColor: 'text-white', bgColor: 'bg-green-400' },
    { name: 'Sad', value: 'sad', icon: FaceFrownIcon, iconColor: 'text-white', bgColor: 'bg-yellow-400' },
    { name: 'Thumbsy', value: 'thumbsy', icon: HandThumbUpIcon, iconColor: 'text-white', bgColor: 'bg-blue-500' },
    { name: 'I feel nothing', value: null, icon: XMarkIcon, iconColor: 'text-gray-400', bgColor: 'bg-transparent' },
]
const supplier_id = (props.supplier) ? props.supplier.id : props.line.order.supplier_id

const form = useForm({
    id: (props.line) ? props.line.id : null,
    supplier_id:supplier_id,
    po_id:(props.line) ? props.line.po_id : null,
    sku_id:(props.line) ? props.line.sku_id : null,
    line:(props.line) ? props.line.line : null,
    identifier:(props.line) ? props.line.identifier : null,
    comment:null
});
const selected = ref(moods[5])


</script>
<template>

    <template v-if="line">

        <ul role="list" class="space-y-6">
            <template v-for="(activityItem, activityItemIdx) in line.activity" :key="activityItem.id">

                <li v-if="activityItem.touchpoint.code !=='supadd'" class="relative flex gap-x-4">
                    <div :class="[activityItemIdx === line.activity.length - 1 ? 'h-6' : '-bottom-6', 'absolute left-0 top-0 flex w-6 justify-center']">
                        <div class="w-px bg-gray-200" />
                    </div>
                    <template v-if="activityItem.comment">
                        <div class="relative flex h-6 w-6 flex-none items-center justify-center bg-white">
                            <ChatBubbleLeftIcon class="h-6 w-6 text-blue-500" aria-hidden="true" />
                        </div>
                        <div class="flex-auto rounded-md p-3 ring-1 ring-inset ring-gray-200">
                            <div class="flex justify-between gap-x-4">
                                <div class="py-0.5 text-xs leading-5 text-gray-500">
                                    <span class="font-medium text-gray-900">{{activityItem.comment.user.name}}</span> commented
                                </div>
                                <time :datetime="activityItem.comment.created_at" class="flex-none py-0.5 text-xs leading-5 text-gray-500">{{ moment(activityItem.comment.created_at).format("MMMM Do YYYY, h:mm:ss a") }}</time>
                            </div>
                            <p class="text-sm leading-6 text-gray-500" v-html="activityItem.comment.comment"></p>
                        </div>
                    </template>

                    <template v-else>

                        <template v-if="activityItem.activity">
                            <template v-for="item in activityItem.activity">
                                <div v-if="item.touchpoint.lineactivity" class="relative flex h-6 w-6 flex-none items-center justify-center bg-white">
                                    <SignalIcon v-if="item.touchpoint.lineactivity.icon === 'SignalIcon'" class="h-6 w-6 text-blue-500" aria-hidden="true" />
                                    <TruckIcon v-else-if="item.touchpoint.lineactivity.icon === 'TruckIcon'" class="h-6 w-6 text-green-500" aria-hidden="true" />
                                    <ClockIcon v-else-if="item.touchpoint.lineactivity.icon === 'ClockIcon'" class="h-6 w-6 text-amber-500" aria-hidden="true" />
                                    <ExclamationCircleIcon v-else-if="item.touchpoint.lineactivity.icon === 'ExclamationCircleIcon'" class="h-6 w-6 text-red-500" aria-hidden="true" />
                                    <ExclamationCircleIcon v-else-if="item.touchpoint.code === 'commit'" class="h-6 w-6 text-red-500" aria-hidden="true" />
                                    <div v-else class="h-1.5 w-1.5 rounded-full bg-gray-100 ring-1 ring-gray-300" />
                                </div>

                                <p class="flex-auto py-0.5 text-xs leading-5 text-gray-500">
                                    <span v-if="item.user" class="font-medium text-gray-900">{{item.user.name}}</span> {{item.touchpoint.touchpoint}}. {{item.touchpoint.value}}
                                </p>
                                <time :datetime="item.created_at" class="flex-none py-0.5 text-xs leading-5 text-gray-500">{{ moment(item.created_at).format("MMMM Do YYYY, h:mm:ss a") }}</time>
                            </template>
                            x
                        </template>
                        <template v-else>
                            <div class="relative flex h-6 w-6 flex-none items-center justify-center bg-white">
                                <template v-if="activityItem.touchpoint.lineactivity">
                                    <SignalIcon v-if="activityItem.touchpoint.lineactivity.icon === 'SignalIcon'" class="h-6 w-6 text-blue-500" aria-hidden="true" />
                                    <TruckIcon v-else-if="activityItem.touchpoint.lineactivity.icon === 'TruckIcon'" class="h-6 w-6 text-green-500" aria-hidden="true" />
                                    <ClockIcon v-else-if="activityItem.touchpoint.lineactivity.icon === 'ClockIcon'" class="h-6 w-6 text-amber-500" aria-hidden="true" />
                                    <ExclamationCircleIcon v-else-if="activityItem.touchpoint.lineactivity.icon === 'ExclamationCircleIcon'" class="h-6 w-6 text-red-500" aria-hidden="true" />

                                    <div v-else class="h-1.5 w-1.5 rounded-full bg-gray-100 ring-1 ring-gray-300" />
                                </template>
                                <template v-else-if="activityItem.touchpoint.code === 'commit'">
                                    <CalendarIcon  class="h-6 w-6 text-red-500" aria-hidden="true" />
                                </template>
                            </div>

                            <div class="flex-auto py-0.5 text-xs leading-5 text-gray-500">
                                <p>

                                    <span v-if="activityItem.shipment">oo{{activityItem.shipment.qty_shipped}}</span>
                                    {{activityItem.touchpoint.touchpoint}}. {{activityItem.touchpoint.value}}
                                </p>
                                <div v-if="activityItem.notes" class="flex pt-5">
                                    <div class="relative flex h-6 w-6 flex-none items-center justify-center bg-white pr-1">
                                        <ChatBubbleLeftIcon class="h-6 w-6 text-blue-500" aria-hidden="true" />
                                    </div>
                                    <div class="flex-auto rounded-md p-3 ring-1 ring-inset ring-gray-200">
                                        <p class="text-xs leading-6 text-gray-500">{{ activityItem.notes }}</p>
                                    </div>
                                </div>

                            </div>

                            <time :datetime="activityItem.created_at" class="items-center flex-none py-0.5 text-xs leading-5 text-gray-500 text-right"><span v-if="activityItem.user" class="text-xs font-medium text-gray-900">{{activityItem.user.name}}</span><br /> {{ moment(activityItem.created_at).format("MMMM Do YYYY, h:mm:ss a") }}</time>

                        </template>


                    </template>
                </li>
            </template>
        </ul>
        <ActivityCommentForm :supplier_id="supplier_id" :line="line" />
    </template>
    <template v-else>
        <Accordion :activeIndex="0" expandIcon="pi pi-plus" collapseIcon="pi pi-minus">

                <AccordionTab v-for="activityItem in lines">
                    <template #header>
                        <div class="relative isolate flex  gap-x-6 overflow-hidden bg-gray-900 border-b-2 px-6 py-2.5 sm:px-3.5 sm:before:flex-1">

                            <div class="flex flex-wrap gap-x-4 gap-y-2">
                                <p class="text-sm leading-6 text-white">
                                    <strong class="font-semibold">{{activityItem.identifier}}</strong>
                                </p>
                            </div>
                            <div class="flex flex-1 justify-end"></div>
                        </div>
                    </template>
                    <ul role="list" class="space-y-6 py-10">

                        <template v-for="(item, index) in activityItem.activity" :key="item.id">
                            <li class="relative flex gap-x-4" v-if="item.touchpoint.code !='supadd'">
                                <div :class="[index === activity.length - 1 ? 'h-6' : '-bottom-6', 'absolute left-0 top-0 flex w-6 justify-center']">
                                    <div class="w-px bg-gray-200" />
                                </div>
                                <template v-if="item.comment">
                                    <div class="relative flex h-6 w-6 flex-none items-center justify-center bg-white">
                                        <ChatBubbleLeftIcon class="h-6 w-6 text-blue-500" aria-hidden="true" />
                                    </div>
                                    <div class="flex-auto rounded-md p-3 ring-1 ring-inset ring-gray-200">
                                        <div class="flex justify-between gap-x-4">
                                            <div class="py-0.5 text-xs leading-5 text-gray-500">
                                                <span class="font-medium text-gray-900">name</span> commented
                                            </div>
                                            <time :datetime="item.comment.created_at" class="flex-none py-0.5 text-xs leading-5 text-gray-500">{{ moment(item.comment.created_at).format("MMMM Do YYYY, h:mm:ss a") }}</time>
                                        </div>
                                        <p class="text-sm leading-6 text-gray-500">{{ item.comment.comment }}</p>
                                    </div>

                                </template>
                                <template v-else>

                                    <div v-if="item.touchpoint.lineactivity" class="relative flex h-6 w-6 flex-none items-center justify-center bg-white">
                                        <SignalIcon v-if="item.touchpoint.lineactivity.icon === 'SignalIcon'" class="h-6 w-6 text-blue-500" aria-hidden="true" />
                                        <TruckIcon v-else-if="item.touchpoint.lineactivity.icon === 'TruckIcon'" class="h-6 w-6 text-green-500" aria-hidden="true" />
                                        <ClockIcon v-else-if="item.touchpoint.lineactivity.icon === 'ClockIcon'" class="h-6 w-6 text-amber-500" aria-hidden="true" />
                                        <ExclamationCircleIcon v-else-if="item.touchpoint.lineactivity.icon === 'ExclamationCircleIcon'" class="h-6 w-6 text-red-500" aria-hidden="true" />
                                        <ExclamationTriangleIcon v-else-if="item.touchpoint.lineactivity.icon === 'ExclamationTriangleIcon'" class="h-6 w-6 text-red-500" aria-hidden="true" />
                                        <div v-else class="h-1.5 w-1.5 rounded-full bg-gray-100 ring-1 ring-gray-300" />
                                    </div>

                                    <p class="flex-auto py-0.5 text-xs leading-5 text-gray-500">
                                        <span v-if="item.user" class="font-medium text-gray-900">{{item.user.name}}</span> {{item.touchpoint.touchpoint}}. <span v-if="item.shipment">{{item.shipment.qty_shipped}} pieces shipped.</span> {{item.touchpoint.value}}
                                    </p>
                                    <time :datetime="item.created_at" class="flex-none py-0.5 text-xs leading-5 text-gray-500">{{ moment(item.created_at).format("MMMM Do YYYY, h:mm:ss a") }}</time>
                                </template>
                            </li>
                        </template>


                    </ul>

                    <!-- New comment form -->
                    <ActivityCommentForm :supplier_id="supplier.id" :line="line" />

                </AccordionTab>

        </Accordion>

        <!--
        <div class="border-b border-gray-200 pt-10 pb-5 mb-5">
                    <h3 class="text-base font-semibold leading-6 text-gray-900">{{activityItem.identifier}}</h3>
                </div>

                -->

    </template>


</template>

