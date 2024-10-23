<script setup>
import { ref } from 'vue'
import { Switch } from '@headlessui/vue'
import { CheckCircleIcon, ExclamationCircleIcon, FlagIcon } from '@heroicons/vue/20/solid'
const people = [
    {
        name: 'Linda Hagon',
        title: 'Front-end Developer',
        department: 'Optimization',
        email: 'linda.hagon@corbus.com',
        role: 'Member',
        image:'https://images.unsplash.com/photo-1517841905240-472988babdf9?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80',
        contact_1:false,
        contact_2:false,
        supplier_reply:false,
        supplier:'Ferguson',
        supplier_contact:'john.anderton@ferguson.com',
        open_lines:4,
        attention:false,
        escalation:false
    },
    {
        name: 'Linda Hagon',
        title: 'Front-end Developer',
        department: 'Optimization',
        email: 'linda.hagon@corbus.com',
        role: 'Member',
        image:'https://images.unsplash.com/photo-1517841905240-472988babdf9?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80',
        contact_1:true,
        contact_2:false,
        supplier_reply:true,
        supplier:'AK Steel',
        supplier_contact:'mary.rider@aksteel.com',
        open_lines:32,
        attention:true,
        escalation:true
    },
    {
        name: 'Linda Hagon',
        title: 'Front-end Developer',
        department: 'Optimization',
        email: 'linda.hagon@corbus.com',
        role: 'Member',
        image:'https://images.unsplash.com/photo-1517841905240-472988babdf9?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80',
        contact_1:true,
        contact_2:false,
        supplier_reply:true,
        supplier:'Essentra Components',
        supplier_contact:'gavin.smith@essentracomponents.com',
        open_lines:12,
        attention:true,
        escalation:false
    },
    // More people...
]
</script>
<template>
    <div class="px-4 sm:px-6 lg:px-8">
        <div class="mt-8 flow-root">
            <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                    <table class="min-w-full divide-y divide-gray-300">
                        <thead>
                        <tr>
                            <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-0">Name</th>
                            <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Supplier</th>
                            <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Open Lines</th>
                            <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">1st Contact</th>
                            <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">2nd Contact</th>
                            <th scope="col" class="px-3 py-3.5 text-center text-sm font-semibold text-gray-900">Reply?</th>
                            <th scope="col" class="px-3 py-3.5 text-center text-sm font-semibold text-gray-900">Attention</th>
                            <th scope="col" class="px-3 py-3.5 text-center text-sm font-semibold text-gray-900">Escalation</th>

                        </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200 bg-white">
                        <tr v-for="person in people" :key="person.email">
                            <td class="whitespace-nowrap py-5 pl-4 pr-3 text-sm sm:pl-0">
                                <div class="flex items-center">
                                    <div class="h-11 w-11 flex-shrink-0">
                                        <img class="h-11 w-11 rounded-full" :src="person.image" alt="" />
                                    </div>
                                    <div class="ml-4">
                                        <div class="font-medium text-gray-900">{{ person.name }}</div>
                                        <div class="mt-1 text-gray-500">{{ person.email }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="whitespace-nowrap px-3 py-5 text-sm text-gray-500">
                                <div class="text-gray-900">{{ person.supplier }}</div>
                                <div class="mt-1 text-gray-500">{{ person.supplier_contact }}</div>
                            </td>
                            <td class="whitespace-nowrap px-3 py-5 text-sm text-gray-500">
                                <span class="inline-flex items-center rounded-full bg-blue-50 px-1.5 py-0.5 text-xs font-medium text-blue-700 ring-1 ring-inset ring-blue-700/10">{{person.open_lines}}</span>
                            </td>
                            <td class="whitespace-nowrap px-3 py-5 text-sm text-gray-500">
                                <Switch v-model="person.contact_1" class="group relative inline-flex h-5 w-10 flex-shrink-0 cursor-pointer items-center justify-center rounded-full focus:outline-none focus:ring-2 focus:ring-indigo-600 focus:ring-offset-2">
                                    <span class="sr-only">Use setting</span>
                                    <span aria-hidden="true" class="pointer-events-none absolute h-full w-full rounded-md bg-white" />
                                    <span aria-hidden="true" :class="[person.contact_1 ? 'bg-indigo-600' : 'bg-gray-200', 'pointer-events-none absolute mx-auto h-4 w-9 rounded-full transition-colors duration-200 ease-in-out']" />
                                    <span aria-hidden="true" :class="[person.contact_1 ? 'translate-x-5' : 'translate-x-0', 'pointer-events-none absolute left-0 inline-block h-5 w-5 transform rounded-full border border-gray-200 bg-white shadow ring-0 transition-transform duration-200 ease-in-out']" />
                                </Switch>
                            </td>
                            <td class="whitespace-nowrap px-3 py-5 text-sm text-gray-500">
                                <Switch v-model="person.contact_2" class="group relative inline-flex h-5 w-10 flex-shrink-0 cursor-pointer items-center justify-center rounded-full focus:outline-none focus:ring-2 focus:ring-indigo-600 focus:ring-offset-2">
                                    <span class="sr-only">Use setting</span>
                                    <span aria-hidden="true" class="pointer-events-none absolute h-full w-full rounded-md bg-white" />
                                    <span aria-hidden="true" :class="[person.contact_2 ? 'bg-indigo-600' : 'bg-gray-200', 'pointer-events-none absolute mx-auto h-4 w-9 rounded-full transition-colors duration-200 ease-in-out']" />
                                    <span aria-hidden="true" :class="[person.contact_2 ? 'translate-x-5' : 'translate-x-0', 'pointer-events-none absolute left-0 inline-block h-5 w-5 transform rounded-full border border-gray-200 bg-white shadow ring-0 transition-transform duration-200 ease-in-out']" />
                                </Switch>
                            </td>
                            <td class="whitespace-nowrap px-3 py-5 text-sm text-gray-500 text-center"><CheckCircleIcon v-if="person.supplier_reply" class="-ml-0.5 h-5 w-5 text-green-600" aria-hidden="true" /></td>
                            <td class="whitespace-nowrap px-3 py-5 text-sm text-gray-500 text-center"><ExclamationCircleIcon v-if="person.attention" class="-ml-0.5 h-5 w-5 text-orange-400" aria-hidden="true" /></td>
                            <td class="whitespace-nowrap px-3 py-5 text-sm text-gray-500 text-center"><FlagIcon v-if="person.escalation" class="-ml-0.5 h-5 w-5 text-red-600" aria-hidden="true" /></td>

                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</template>


