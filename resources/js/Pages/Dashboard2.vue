<script setup>
import { ref } from 'vue'
import { Dialog, DialogPanel, Menu, MenuButton, MenuItem, MenuItems } from '@headlessui/vue'
import {
    ArrowDownCircleIcon,
    ArrowPathIcon,
    ArrowUpCircleIcon,
    Bars3Icon,
    EllipsisHorizontalIcon,
    PlusSmallIcon,
    CheckCircleIcon, ExclamationCircleIcon, FlagIcon
} from '@heroicons/vue/20/solid'
import { BellIcon, XMarkIcon } from '@heroicons/vue/24/outline'
import PortalLayout from "@/Layouts/PortalLayout.vue";
const navigation = [
    { name: 'Home', href: '#' },
    { name: 'Invoices', href: '#' },
    { name: 'Clients', href: '#' },
    { name: 'Expenses', href: '#' },
]
const secondaryNavigation = [
    { name: 'Last 7 days', href: '#', current: true },
    { name: 'Last 30 days', href: '#', current: false },
    { name: 'All-time', href: '#', current: false },
]
const stats = [
    { name: 'PO Value', value: '$405,091.00', change: '+4.75%', changeType: 'positive' },
    { name: 'Delinquent PO Value', value: '$12,787.00', change: '+54.02%', changeType: 'negative' },
    { name: '% Past Due', value: '34%', change: '-1.39%', changeType: 'positive' },
    { name: 'Average Days Past Due', value: '43', change: '+3.18%', changeType: 'negative' },
]
const statuses = {
    Paid: 'text-green-700 bg-green-50 ring-green-600/20',
    Withdraw: 'text-gray-600 bg-gray-50 ring-gray-500/10',
    Overdue: 'text-red-700 bg-red-50 ring-red-600/10',
}
const suppliers = [
    {
        date: 'Attention',
        color_class:'bg-red-300',
        text_color_class:'text-red-500',
        dateTime: '2023-03-22',
        transactions: [
            {
                id: 1,
                invoiceNumber: '00012',
                href: '#',
                amount: 'Ferguson',
                tax: '$500.00',
                status: 'Escalation',
                client: 'Linda Hagon',
                description: 'Website redesign',
                icon: FlagIcon,
                name: 'Linda Hagon',
                email: 'linda.hagon@corbus.com',
                image:'https://images.unsplash.com/photo-1517841905240-472988babdf9?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80',

            },
            {
                id: 2,
                invoiceNumber: '00011',
                href: '#',
                amount: 'Essentra Components',
                status: 'Non-responsive',
                client: 'Tom Cook',
                description: 'Salary',
                icon: FlagIcon,
                name: 'Linda Hagon',
                email: 'linda.hagon@corbus.com',
                image:'https://images.unsplash.com/photo-1517841905240-472988babdf9?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80',

            },
            {
                id: 3,
                invoiceNumber: '00009',
                href: '#',
                amount: 'Wayne Motors',
                tax: '$130.00',
                status: 'Late',
                client: 'Tuple',
                description: 'Logo design',
                icon: FlagIcon,
                name: 'Kathleen Brannigan',
                email: 'kathleen.brannigan@corbus.com',
                image:'https://images.unsplash.com/photo-1438761681033-6461ffad8d80?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80',

            },
        ],
    },
    {
        date: 'Performing',
        color_class:'bg-green-300',
        text_color_class:'text-green-500',
        dateTime: '2023-03-21',
        transactions: [
            {
                id: 4,
                invoiceNumber: '00010',
                href: '#',
                amount: 'AK Steel',
                tax: '$900.00',
                status: '',
                client: 'SavvyCal',
                description: 'Website redesign',
                icon: CheckCircleIcon,
                name: 'Linda Hagon',
                email: 'linda.hagon@corbus.com',
                image:'https://images.unsplash.com/photo-1517841905240-472988babdf9?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80',

            },
        ],
    },
    {
        date: 'Under Performing',
        color_class:'bg-orange-300',
        text_color_class:'text-orange-500',
        dateTime: '2023-03-21',
        transactions: [
            {
                id: 4,
                invoiceNumber: '00010',
                href: '#',
                amount: 'Magis',
                tax: '$900.00',
                status: '',
                client: 'SavvyCal',
                description: 'Website redesign',
                icon: ExclamationCircleIcon,
                name: 'Andrew Foster',
                email: 'andrew.foster@corbus.com',
                image:'https://images.unsplash.com/photo-1519244703995-f4e0f30006d5?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80',

            },
        ],
    },
]
const days = [
    {
        date: 'Attention',
        dateTime: '2023-03-22',
        transactions: [
            {
                id: 1,
                invoiceNumber: '00012',
                href: '#',
                amount: '$7,600.00 USD',
                tax: '$500.00',
                status: 'Paid',
                client: 'Reform',
                description: 'Website redesign',
                icon: ArrowUpCircleIcon,
            },
            {
                id: 2,
                invoiceNumber: '00011',
                href: '#',
                amount: '$10,000.00 USD',
                status: 'Withdraw',
                client: 'Tom Cook',
                description: 'Salary',
                icon: ArrowDownCircleIcon,
            },
            {
                id: 3,
                invoiceNumber: '00009',
                href: '#',
                amount: '$2,000.00 USD',
                tax: '$130.00',
                status: 'Overdue',
                client: 'Tuple',
                description: 'Logo design',
                icon: ArrowPathIcon,
            },
        ],
    },
    {
        date: 'Yesterday',
        dateTime: '2023-03-21',
        transactions: [
            {
                id: 4,
                invoiceNumber: '00010',
                href: '#',
                amount: '$14,000.00 USD',
                tax: '$900.00',
                status: 'Paid',
                client: 'SavvyCal',
                description: 'Website redesign',
                icon: ArrowUpCircleIcon,
            },
        ],
    },
]
const clients = [
    {
        id: 1,
        name: 'AK Steel',
        imageUrl: 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTY9PlPezDYLHyp0eYGh79MXAKkumT2xaNHiKvnzKMgQg&s',
        lastInvoice: { date: 'October 23, 2023', dateTime: '2022-12-13', amount: '$2,000.00', status: '', PO:'0540000434', SKU:'F9948', Line:'1' },
    },
    {
        id: 2,
        name: 'AK Steel',
        imageUrl: 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTY9PlPezDYLHyp0eYGh79MXAKkumT2xaNHiKvnzKMgQg&s',
        lastInvoice: { date: 'October 23, 2023', dateTime: '2023-01-22', amount: '$14,000.00', status: '', PO:'0540000434', SKU:'F9955', Line:'2' },
    },
    {
        id: 3,
        name: 'Magis',
        imageUrl: 'https://tailwindui.com/img/logos/48x48/tuple.svg',
        lastInvoice: { date: 'November 5, 2023', dateTime: '2023-01-23', amount: '$7,600.00', status: '', PO:'0540000242', SKU:'F9948', Line:'1' },
    },
]

const mobileMenuOpen = ref(false)
</script>
<template>
    <PortalLayout>
        <main>
        <div class="relative isolate overflow-hidden pt-16">
            <!-- Secondary navigation -->
            <header class="pb-4 pt-6 sm:pb-6">
                <div class="mx-auto flex max-w-7xl flex-wrap items-center gap-6 px-4 sm:flex-nowrap sm:px-6 lg:px-8">
                    <h1 class="text-base font-semibold leading-7 text-gray-900">Open Orders</h1>
                    <div class="order-last flex w-full gap-x-8 text-sm font-semibold leading-6 sm:order-none sm:w-auto sm:border-l sm:border-gray-200 sm:pl-6 sm:leading-7">
                        <a v-for="item in secondaryNavigation" :key="item.name" :href="item.href" :class="item.current ? 'text-indigo-600' : 'text-gray-700'">{{ item.name }}</a>
                    </div>
                </div>
            </header>

            <!-- Stats -->
            <div class="border-b border-b-gray-900/10 lg:border-t lg:border-t-gray-900/5">
                <dl class="mx-auto grid max-w-7xl grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 lg:px-2 xl:px-0">
                    <div v-for="(stat, statIdx) in stats" :key="stat.name" :class="[statIdx % 2 === 1 ? 'sm:border-l' : statIdx === 2 ? 'lg:border-l' : '', 'flex items-baseline flex-wrap justify-between gap-y-2 gap-x-4 border-t border-gray-900/5 px-4 py-10 sm:px-6 lg:border-t-0 xl:px-8']">
                        <dt class="text-sm font-medium leading-6 text-gray-500">{{ stat.name }}</dt>
                        <dd :class="[stat.changeType === 'negative' ? 'text-rose-600' : 'text-gray-700', 'text-xs font-medium']">{{ stat.change }}</dd>
                        <dd class="w-full flex-none text-3xl font-medium leading-10 tracking-tight text-gray-900">{{ stat.value }}</dd>
                    </div>
                </dl>
            </div>

            <div class="absolute left-0 top-full -z-10 mt-96 origin-top-left translate-y-40 -rotate-90 transform-gpu opacity-20 blur-3xl sm:left-1/2 sm:-ml-96 sm:-mt-10 sm:translate-y-0 sm:rotate-0 sm:transform-gpu sm:opacity-50" aria-hidden="true">
                <div class="aspect-[1154/678] w-[72.125rem] bg-gradient-to-br from-[#FF80B5] to-[#9089FC]" style="clip-path: polygon(100% 38.5%, 82.6% 100%, 60.2% 37.7%, 52.4% 32.1%, 47.5% 41.8%, 45.2% 65.6%, 27.5% 23.4%, 0.1% 35.3%, 17.9% 0%, 27.7% 23.4%, 76.2% 2.5%, 74.2% 56%, 100% 38.5%)" />
            </div>
        </div>

        <div class="space-y-16 py-16 xl:space-y-20">
            <!-- Recent activity table -->
            <div>
                <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                    <h2 class="mx-auto max-w-2xl text-base font-semibold leading-6 text-gray-900 lg:mx-0 lg:max-w-none">Supplier activity</h2>
                </div>
                <div class="mt-6 overflow-hidden border-t border-gray-100">
                    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                        <div class="mx-auto max-w-2xl lg:mx-0 lg:max-w-none">
                            <table class="w-full text-left">
                                <thead class="sr-only">
                                <tr>
                                    <th>Amount</th>
                                    <th class="hidden sm:table-cell">Client</th>
                                    <th>More details</th>
                                </tr>
                                </thead>
                                <tbody>
                                <template v-for="day in suppliers" :key="day.dateTime">
                                    <tr :class="[day.color_class, 'text-sm leading-6']">
                                        <th scope="colgroup" colspan="3" class="relative isolate py-2 font-semibold">
                                            <time :datetime="day.dateTime">{{ day.date }}</time>
                                            <div :class="[day.color_class, 'absolute inset-y-0 right-full -z-10 w-screen border-b border-gray-200 bg-gray-50']" />
                                            <div :class="[day.color_class, 'absolute inset-y-0 left-0 -z-10 w-screen border-b border-gray-200 bg-gray-50']" />
                                        </th>
                                    </tr>
                                    <tr v-for="transaction in day.transactions" :key="transaction.id">
                                        <td class="relative py-2 pr-6">
                                            <div class="flex gap-x-6">
                                                <component :is="transaction.icon" :class="[day.text_color_class, 'hidden h-6 w-5 flex-none sm:block']" aria-hidden="true" />

                                                <div class="flex-auto">
                                                    <div class="flex items-start gap-x-3">
                                                        <div class="text-sm font-medium leading-6 text-gray-900">{{ transaction.amount }}</div>
                                                        <div v-if="transaction.status" :class="[statuses[transaction.status], day.color_class, 'rounded-md py-1 px-2 text-xs font-medium ring-1 ring-inset']">{{ transaction.status }}</div>
                                                    </div>
                                                    <div v-if="transaction.tax" class="mt-1 text-xs leading-5 text-gray-500">{{ transaction.tax }} tax</div>
                                                </div>
                                            </div>
                                            <div class="absolute bottom-0 right-full h-px w-screen bg-gray-100" />
                                            <div class="absolute bottom-0 left-0 h-px w-screen bg-gray-100" />
                                        </td>
                                        <td class="hidden py-2 pr-6 sm:table-cell">
                                            <div class="flex items-center">
                                                <div class="h-11 w-11 flex-shrink-0">
                                                    <img class="h-8 w-8 rounded-full" :src="transaction.image" alt="" />
                                                </div>
                                                <div class="ml-1">
                                                    <div class="text-sm font-medium text-gray-900">{{ transaction.name }}</div>
                                                    <div class="text-sm mt-1 text-gray-500">{{ transaction.email }}</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="py-2 text-right">
                                            <div class="flex justify-end">
                                                <button type="button" class="rounded bg-indigo-600 px-2 py-1 text-xs font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">View</button>
                                            </div>
                                        </td>
                                    </tr>
                                </template>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent client list-->
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="mx-auto max-w-2xl lg:mx-0 lg:max-w-none">
                    <div class="flex items-center justify-between">
                        <h2 class="text-base font-semibold leading-7 text-gray-900">Upcoming Commits</h2>
                        <a href="#" class="text-sm font-semibold leading-6 text-indigo-600 hover:text-indigo-500">View all<span class="sr-only">, clients</span></a>
                    </div>
                    <ul role="list" class="mt-6 grid grid-cols-1 gap-x-6 gap-y-8 lg:grid-cols-3 xl:gap-x-8">
                        <li v-for="client in clients" :key="client.id" class="overflow-hidden rounded-xl border border-gray-200">
                            <div class="flex items-center gap-x-4 border-b border-gray-900/5 bg-gray-50 p-6">
                                <img :src="client.imageUrl" :alt="client.name" class="h-12 w-12 flex-none rounded-lg bg-white object-cover ring-1 ring-gray-900/10" />
                                <div class="text-sm font-medium leading-6 text-gray-900">{{ client.name }}</div>
                                <Menu as="div" class="relative ml-auto">
                                    <MenuButton class="-m-2.5 block p-2.5 text-gray-400 hover:text-gray-500">
                                        <span class="sr-only">Open options</span>
                                        <EllipsisHorizontalIcon class="h-5 w-5" aria-hidden="true" />
                                    </MenuButton>
                                    <transition enter-active-class="transition ease-out duration-100" enter-from-class="transform opacity-0 scale-95" enter-to-class="transform opacity-100 scale-100" leave-active-class="transition ease-in duration-75" leave-from-class="transform opacity-100 scale-100" leave-to-class="transform opacity-0 scale-95">
                                        <MenuItems class="absolute right-0 z-10 mt-0.5 w-32 origin-top-right rounded-md bg-white py-2 shadow-lg ring-1 ring-gray-900/5 focus:outline-none">
                                            <MenuItem v-slot="{ active }">
                                                <a href="#" :class="[active ? 'bg-gray-50' : '', 'block px-3 py-1 text-sm leading-6 text-gray-900']"
                                                >View<span class="sr-only">, {{ client.name }}</span></a
                                                >
                                            </MenuItem>
                                            <MenuItem v-slot="{ active }">
                                                <a href="#" :class="[active ? 'bg-gray-50' : '', 'block px-3 py-1 text-sm leading-6 text-gray-900']"
                                                >Edit<span class="sr-only">, {{ client.name }}</span></a
                                                >
                                            </MenuItem>
                                        </MenuItems>
                                    </transition>
                                </Menu>
                            </div>
                            <dl class="-my-3 divide-y divide-gray-100 px-6 py-4 text-sm leading-6">
                                <div class="flex justify-between gap-x-4 py-3">
                                    <dt class="text-gray-500">Commit Date</dt>
                                    <dd class="text-gray-700">
                                        <time :datetime="client.lastInvoice.dateTime">{{ client.lastInvoice.date }}</time>
                                    </dd>
                                </div>
                                <div class="flex justify-between gap-x-4 py-3">
                                    <dt class="text-gray-500">Item</dt>
                                    <dd class="flex items-start gap-x-2">
                                        <div class="font-medium text-gray-900">{{ client.lastInvoice.PO }}-{{ client.lastInvoice.SKU }}-{{ client.lastInvoice.Line }}</div>
                                    </dd>
                                </div>

                                <div class="flex justify-between gap-x-4 py-3">
                                    <dt class="text-gray-500">Amount</dt>
                                    <dd class="flex items-start gap-x-2">
                                        <div class="font-medium text-gray-900">{{ client.lastInvoice.amount }}</div>
                                        <div v-if="client.lastInvoice.status" :class="[statuses[client.lastInvoice.status], 'rounded-md py-1 px-2 text-xs font-medium ring-1 ring-inset']">{{ client.lastInvoice.status }}</div>
                                    </dd>
                                </div>
                            </dl>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </main>
    </PortalLayout>
</template>


