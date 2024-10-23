<script setup>
    import {ref, onMounted} from 'vue'
    const open_items = ref()
    const closed_items = ref()
import {
    Dialog,
    DialogPanel,
    Listbox,
    ListboxButton,
    ListboxLabel,
    ListboxOption,
    ListboxOptions,
    Menu,
    MenuButton,
    MenuItem,
    MenuItems,
} from '@headlessui/vue'
import {
    Bars3Icon,
    CalendarDaysIcon,
    CreditCardIcon,
    EllipsisVerticalIcon,
    FaceFrownIcon,
    FaceSmileIcon,
    FireIcon,
    HandThumbUpIcon,
    HeartIcon,
    PaperClipIcon,
    UserCircleIcon,
    XMarkIcon as XMarkIconMini,
} from '@heroicons/vue/20/solid'
import { BellIcon, XMarkIcon as XMarkIconOutline } from '@heroicons/vue/24/outline'
import { CheckCircleIcon, CalendarIcon } from '@heroicons/vue/24/solid'
import PortalLayout from "@/Layouts/PortalLayout.vue";
import MeetingTable from "@/Pages/Meetings/Partials/MeetingTable.vue";
import AgendaItems from "@/Pages/Meetings/Partials/AgendaItems.vue";
import MeetingCard from "@/Pages/Meetings/Partials/MeetingCard.vue";
import Attendee from "@/Pages/Meetings/Partials/Attendee.vue";
import EscalatedSupplierInfo from "@/Pages/Escalations/Partials/EscalatedSupplierInfo.vue";
import moment from "moment/moment.js";
const props = defineProps(['attendees', 'meeting', 'meetingItems', 'agendaItems', 'agendaStats', 'meetingItemTypes'])



const navigation = [
    { name: 'Home', href: '#' },
    { name: 'Invoices', href: '#' },
    { name: 'Clients', href: '#' },
    { name: 'Expenses', href: '#' },
]

const activity = [
    { id: 1, type: 'created', person: { name: 'Chelsea Hagon' }, date: '7d ago', dateTime: '2023-01-23T10:32' },
    { id: 2, type: 'edited', person: { name: 'Chelsea Hagon' }, date: '6d ago', dateTime: '2023-01-23T11:03' },
    { id: 3, type: 'sent', person: { name: 'Chelsea Hagon' }, date: '6d ago', dateTime: '2023-01-23T11:24' },
    {
        id: 4,
        type: 'commented',
        person: {
            name: 'Chelsea Hagon',
            imageUrl:
                'https://images.unsplash.com/photo-1550525811-e5869dd03032?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80',
        },
        comment: 'Called client, they reassured me the invoice would be paid by the 25th.',
        date: '3d ago',
        dateTime: '2023-01-23T15:56',
    },
    { id: 5, type: 'viewed', person: { name: 'Alex Curren' }, date: '2d ago', dateTime: '2023-01-24T09:12' },
    { id: 6, type: 'paid', person: { name: 'Alex Curren' }, date: '1d ago', dateTime: '2023-01-24T09:20' },
]
const moods = [
    { name: 'Excited', value: 'excited', icon: FireIcon, iconColor: 'text-white', bgColor: 'bg-red-500' },
    { name: 'Loved', value: 'loved', icon: HeartIcon, iconColor: 'text-white', bgColor: 'bg-pink-400' },
    { name: 'Happy', value: 'happy', icon: FaceSmileIcon, iconColor: 'text-white', bgColor: 'bg-green-400' },
    { name: 'Sad', value: 'sad', icon: FaceFrownIcon, iconColor: 'text-white', bgColor: 'bg-yellow-400' },
    { name: 'Thumbsy', value: 'thumbsy', icon: HandThumbUpIcon, iconColor: 'text-white', bgColor: 'bg-blue-500' },
    { name: 'I feel nothing', value: null, icon: XMarkIconMini, iconColor: 'text-gray-400', bgColor: 'bg-transparent' },
]

const mobileMenuOpen = ref(false)
const selected = ref(moods[5])
let open_items_array = [];
let closed_items_array = [];
onMounted(() => {

    Object.keys(props.agendaItems).forEach(key=>{
        const item = props.agendaItems[key];
        Object.keys(item).forEach(key=>{
            if(item[key].complete=='n'){
                open_items_array.push(item[key]);

            }
            else{
                closed_items_array.push(item[key]);
            }
        });

    })

    open_items.value=open_items_array;
    closed_items.value=closed_items_array;
})
function generateWeekDates(){
    var now = moment();
    var monday = moment(now.clone().weekday(1)).format('MMM Do, YYYY');
    var friday = moment(now.clone().weekday(5)).format('MMM Do, YYYY');
    return monday+" - "+friday;
}
</script>

<template>
    <PortalLayout :title="meeting.name">
        <div class="flex pb-16">
            <div class="basis-2/3 mr-5">
                <dl class="grid grid-cols-1 gap-5">
                    <div class="relative overflow-hidden rounded-lg bg-white px-4 pt-5 shadow sm:px-6 sm:pt-6">
                        <dt>
                            <div class="absolute rounded-md bg-indigo-500 p-3">
                                <CalendarIcon class="h-6 w-6 text-white" />
                            </div>
                            <p class="ml-16 truncate text-sm font-medium text-gray-500">Week</p>
                        </dt>
                        <dd class="ml-16 flex items-baseline pb-6 sm:pb-7">
                            <p class="text-xl font-semibold text-gray-900" v-html="generateWeekDates()"></p>
                        </dd>

                        <fieldset class="pb-10">
                            <legend class="text-base font-semibold leading-6 text-gray-900">Attendees</legend>
                            <div class="mt-4 divide-y divide-gray-200 border-b border-t border-gray-200">
                                <Attendee v-for="attendee in attendees" :key="attendee.id" :attendee="attendee" />
                            </div>
                        </fieldset>
                    </div>
                </dl>

            </div>
            <div class="basis-1/3">
                <EscalatedSupplierInfo :supplier="meeting.supplier" />
            </div>
        </div>
        <div class="flex">
            <div class="basis-1/2 pr-5">
                <MeetingCard v-for="meetingItemType in meetingItemTypes" :meetingItems="meetingItems" :meeting_id="meeting.id" :item="meetingItemType"  />
            </div>
            <div class="basis-1/2 pl-5">
                <AgendaItems :agendaItems="agendaItems" :agendaStats="agendaStats" />
            </div>
        </div>


    </PortalLayout>
</template>

<style scoped>

</style>
