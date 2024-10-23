<script setup>

import PortalLayout from "@/Layouts/PortalLayout.vue";
import UploadImage from "@/Pages/Parts/Partials/UploadImage.vue";
import AddComponent from "@/Pages/Parts/Partials/AddComponent.vue";
const props = defineProps(['part'])
import { StarIcon, BuildingOfficeIcon, PlusIcon } from '@heroicons/vue/20/solid'
import { Tab, TabGroup, TabList, TabPanel, TabPanels } from '@headlessui/vue'
let USDollar = new Intl.NumberFormat('en-US',{style:'currency', currency:'USD'});


const license = {
    href: '#',
    summary:
        'For personal and professional use. You cannot resell or redistribute these icons in their original or modified state.',
    content: `
    <h4>Overview</h4>

    <p>For personal and professional use. You cannot resell or redistribute these icons in their original or modified state.</p>

    <ul role="list">
    <li>You\'re allowed to use the icons in unlimited projects.</li>
    <li>Attribution is not required to use the icons.</li>
    </ul>

    <h4>What you can do with it</h4>

    <ul role="list">
    <li>Use them freely in your personal and professional work.</li>
    <li>Make them your own. Change the colors to suit your project or brand.</li>
    </ul>

    <h4>What you can\'t do with it</h4>

    <ul role="list">
    <li>Don\'t be greedy. Selling or distributing these icons in their original or modified state is prohibited.</li>
    <li>Don\'t be evil. These icons cannot be used on websites or applications that promote illegal or immoral beliefs or activities.</li>
    </ul>
  `,
}
const components = [
    {
        part_number:null,
        part:'Stainless Steel Sheet Roll',
        description:'Sheet Roll. Size: 50x50',
        image:'/images/stainless-steel-sheet-roll-500x500.webp'
    },
    {
        part_number:'GSW-666-3001200',
        part:'Stainless Steel Ring',
        description:'12 300# SPIRAL WOUND GASKET 316 STAINLESS STEEL INNER RING, 316 STAINLESS STEEL WINDING, FLEXIBLE GRAPHITE FILLER, 316 STAINLESS STEEL OUTER RING',
        image:'/images/placeholder.svg'
    }
]
const people = [
    {
        name: 'Leslie Alexander',
        email: 'leslie.alexander@example.com',
        imageUrl:
            'https://images.unsplash.com/photo-1494790108377-be9c29b29330?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80',
    },
    {
        name: 'Michael Foster',
        email: 'michael.foster@example.com',
        imageUrl:
            'https://images.unsplash.com/photo-1519244703995-f4e0f30006d5?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80',
    },
    {
        name: 'Dries Vincent',
        email: 'dries.vincent@example.com',
        imageUrl:
            'https://images.unsplash.com/photo-1506794778202-cad84cf45f1d?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80',
    },
    {
        name: 'Lindsay Walton',
        email: 'lindsay.walton@example.com',
        imageUrl:
            'https://images.unsplash.com/photo-1517841905240-472988babdf9?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80',
    },
    {
        name: 'Courtney Henry',
        email: 'courtney.henry@example.com',
        imageUrl:
            'https://images.unsplash.com/photo-1438761681033-6461ffad8d80?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80',
    },
    {
        name: 'Tom Cook',
        email: 'tom.cook@example.com',
        imageUrl:
            'https://images.unsplash.com/photo-1472099645785-5658abf4ff4e?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80',
    },
]
</script>

<template>
    <PortalLayout :title="part.sku+' - '+part.short_text">
        <div class="bg-white">
            <div class="mx-auto px-4 py-6 sm:px-6 sm:py-14 lg:max-w-7xl lg:px-8">
                <!-- Product -->
                <div class="lg:grid lg:grid-cols-7 lg:grid-rows-1 lg:gap-x-8 lg:gap-y-10 xl:gap-x-16">
                    <!-- Product image -->
                    <div class="lg:col-span-4 lg:row-end-1">
                        <div class="aspect-h-3 aspect-w-4 overflow-hidden rounded-lg bg-gray-100">
                            <UploadImage :part="part" :image="part.image" />
                        </div>
                    </div>

                    <!-- Product details -->
                    <div class="mx-auto mt-14 max-w-2xl sm:mt-16 lg:col-span-3 lg:row-span-2 lg:row-end-2 lg:mt-0 lg:max-w-none">
                        <div class="flex flex-col-reverse">
                            <div class="mt-4">
                                <h1 class="text-2xl font-bold tracking-tight text-gray-900 sm:text-3xl">{{ part.sku }}</h1>

                                <h2 id="information-heading" class="sr-only">Product information</h2>

                            </div>

                        </div>

                        <p class="mt-6 text-gray-500">{{ part.short_text }}</p>



                        <div class="mt-10 border-t border-gray-200 pt-10">
                            <h3 class="text-sm font-medium text-gray-900">Supplier</h3>
                            <div class="flex items-center mt-4">
                                <div class="mr-4 flex-shrink-0">
                                    <BuildingOfficeIcon class="h-10 w-10 text-gray-500" aria-hidden="true" />
                                </div>
                                <div>
                                    <h4 class="text-lg font-bold"><a :href="route('supplier.show', [part.lines[0].supplier.slug])">{{part.lines[0].supplier.name}}</a></h4>
                                </div>
                            </div>
                        </div>

                        <div class="mt-10 border-t border-gray-200 pt-10">
                            <h3 class="text-sm font-medium text-gray-900">Lines</h3>

                            <div class="-mx-4 mt-10 ring-1 ring-gray-300 sm:mx-0 sm:rounded-lg">
                                <table class="min-w-full divide-y divide-gray-300">
                                    <thead>
                                    <tr>
                                        <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6">PO</th>
                                        <th scope="col" class="hidden px-3 py-3.5 text-center text-sm font-semibold text-gray-900 lg:table-cell">Line</th>
                                        <th scope="col" class="hidden px-3 py-3.5 text-left text-sm font-semibold text-gray-900 lg:table-cell">QTY</th>
                                        <th scope="col" class="hidden px-3 py-3.5 text-left text-sm font-semibold text-gray-900 lg:table-cell">Value</th>
                                        <th scope="col" class="hidden px-3 py-3.5 text-left text-sm font-semibold text-gray-900 lg:table-cell">Status</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr v-for="(line, index) in part.lines" :key="line.id">
                                        <td :class="[index === 0 ? '' : 'border-t border-transparent', 'relative py-4 pl-4 pr-3 text-sm sm:pl-6']">
                                            <div class="font-medium text-gray-900">
                                                {{ line.order.PO }}
                                            </div>
                                            <div v-if="index !== 0" class="absolute -top-px left-6 right-0 h-px bg-gray-200" />
                                        </td>
                                        <td :class="[index === 0 ? '' : 'border-t border-gray-200', 'hidden px-3 py-3.5 text-sm text-gray-500 lg:table-cell text-center']">{{ line.line }}</td>
                                        <td :class="[index === 0 ? '' : 'border-t border-gray-200', 'hidden px-3 py-3.5 text-sm text-gray-500 lg:table-cell']">{{ line.qty }}</td>
                                        <td :class="[index === 0 ? '' : 'border-t border-gray-200', 'hidden px-3 py-3.5 text-sm text-gray-500 lg:table-cell']">{{ USDollar.format(line.net_price) }}</td>
                                        <td :class="[index === 0 ? '' : 'border-t border-gray-200', 'hidden px-3 py-3.5 text-sm text-gray-500 lg:table-cell']">
                                            <span class="inline-flex items-center rounded-md bg-red-50 px-2 py-1 text-xs font-medium text-red-700 ring-1 ring-inset ring-red-600/20">Late</span>
                                        </td>

                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>


                    </div>

                    <div class="mx-auto mt-16 w-full max-w-2xl lg:col-span-4 lg:mt-0 lg:max-w-none">
                        <AddComponent />
                        <ul role="list" class="divide-y divide-gray-100">
                            <li v-for="component in components" :key="component.part_number" class="flex gap-x-4 py-5">
                                <img class="h-12 w-12 flex-none rounded-full bg-gray-50" :src="component.image" alt="" />
                                <div class="min-w-0">
                                    <p class="text-sm font-semibold leading-6 text-gray-900">{{ component.part }} <span v-if="component.part_number">- {{component.part_number}}</span></p>
                                    <p class="mt-1 truncate text-xs leading-5 text-gray-500">{{ component.description }}</p>
                                </div>
                            </li>
                        </ul>

                    </div>
                </div>
            </div>
        </div>
    </PortalLayout>
</template>

<style scoped>

</style>
