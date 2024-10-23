<script setup>

import ScoreBadge from "@/Pages/Suppliers/Partials/ScoreBadge.vue";
import {BuildingOfficeIcon, LinkIcon, UserIcon} from "@heroicons/vue/20/solid/index.js";
const props = defineProps(['supplier', 'supplier_score'])
</script>

<template>
    <div class="lg:col-start-3 lg:row-end-1">
        <h2 class="sr-only">Summary</h2>
        <div class="rounded-lg bg-gray-50 shadow-sm ring-1 ring-gray-900/5">
            <dl class="flex flex-wrap">
                <div class="flex-auto pl-6 pt-6">
                    <dt class="text-sm font-semibold leading-6 text-gray-900">Supplier</dt>
                    <dd class="mt-1 text-base font-semibold leading-6 text-gray-900"><a :href="'/supplier/'+supplier.slug">{{supplier.name}}</a></dd>
                </div>
                <div class="flex-none self-end px-6 pt-4">
                    <dt class="sr-only">Status</dt>
                    <dd class=" px-2 py-1">
                        <ScoreBadge :score="supplier_score" />
                    </dd>
                </div>
                <div v-if="supplier.shippinglocation" class="mt-6 flex w-full flex-none gap-x-4 border-t border-gray-900/5 px-6 pt-6">
                    <dt class="flex-none">
                        <span class="sr-only">Address</span>
                        <BuildingOfficeIcon class="h-6 w-5 text-gray-400" aria-hidden="true" />
                    </dt>
                    <dd class="text-sm font-medium leading-6 text-gray-900">{{supplier.shippinglocation.address}}<br />{{supplier.shippinglocation.city}}, {{supplier.shippinglocation.state}} {{supplier.shippinglocation.zip}}<br />{{supplier.shippinglocation.country}}</dd>
                </div>
                <div v-if="supplier.url" class="mt-4 flex w-full flex-none gap-x-4 px-6">
                    <dt class="flex-none">
                        <span class="sr-only">URL</span>
                        <LinkIcon class="h-6 w-5 text-gray-400" aria-hidden="true" />
                    </dt>
                    <dd class="text-sm leading-6 text-gray-500">
                        <time datetime="2023-01-31"><a :href="supplier.url">{{supplier.url}}</a></time>
                    </dd>
                </div>
                <template v-if="supplier.contacts">
                    <div v-for="contact in supplier.contacts" class="mt-4 flex w-full flex-none gap-x-4 px-6">
                        <dt class="flex-none">
                            <span class="sr-only">Contact</span>
                            <UserIcon class="h-6 w-5 text-gray-400" aria-hidden="true" />
                        </dt>
                        <dd class="text-sm leading-6 text-gray-500">{{contact.name}}<br />{{contact.email}}<br />{{contact.phone}}</dd>
                    </div>
                </template>

            </dl>
            <div class="mt-6 border-t border-gray-900/5 px-6 py-6">
                <a :href="'/supplier/'+supplier.slug" class="text-sm font-semibold leading-6 text-gray-900">View Supplier <span aria-hidden="true">&rarr;</span></a>
            </div>
        </div>
    </div>
</template>

<style scoped>

</style>
