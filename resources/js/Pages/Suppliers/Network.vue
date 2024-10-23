<script setup>

import SupplierTabs from "@/Pages/Suppliers/Partials/SupplierTabs.vue";
import SubtierSuppliers from "@/Pages/Suppliers/Partials/SubtierSuppliers.vue";
import PortalLayout from "@/Layouts/PortalLayout.vue";
import AddSupplierModal from "@/Pages/Suppliers/Partials/AddSupplierModal.vue";
const notificationMethods = [
    { id: 'yes', title: 'Yes' },
    { id: 'no', title: 'No' },
]
const props = defineProps(['supplier', 'network'])
</script>

<template>
    <PortalLayout :title="supplier.name" :score="supplier.score">
        <AddSupplierModal></AddSupplierModal>
        <SupplierTabs :supplier="supplier" active="Network"></SupplierTabs>
        <SubtierSuppliers :supplier="supplier" :network="network"></SubtierSuppliers>

        <!--
        <div class="flex pb-5">
            <div class="basis-1/2">
                <label class="text-base font-semibold text-gray-900 sm:items-center">Have you received this PO?</label>
            </div>
            <div class="basis-1/2">
                <fieldset class="">
                    <legend class="sr-only">Notification method</legend>
                    <div class="sm:flex sm:items-center sm:space-x-10 sm:space-y-0">
                        <div v-for="notificationMethod in notificationMethods" :key="notificationMethod.id" class="flex items-center">
                            <input :id="notificationMethod.id" name="notification-method" type="radio" :checked="notificationMethod.id === 'email'" class="h-4 w-4 border-gray-300 text-indigo-600 focus:ring-indigo-600" />
                            <label :for="notificationMethod.id" class="ml-3 block text-sm font-medium leading-6 text-gray-900">{{ notificationMethod.title }}</label>
                        </div>
                    </div>
                </fieldset>
            </div>
        </div>
        <div class="flex pb-5">
            <div class="basis-1/2">
                <label class="text-base font-semibold text-gray-900 sm:items-center">Can you handle this volume?</label>
            </div>
            <div class="basis-1/2">
                <fieldset class="">
                    <legend class="sr-only">Notification method</legend>
                    <div class="sm:flex sm:items-center sm:space-x-10 sm:space-y-0">
                        <div v-for="notificationMethod in notificationMethods" :key="notificationMethod.id" class="flex items-center">
                            <input :id="notificationMethod.id" name="notification-method" type="radio" :checked="notificationMethod.id === 'email'" class="h-4 w-4 border-gray-300 text-indigo-600 focus:ring-indigo-600" />
                            <label :for="notificationMethod.id" class="ml-3 block text-sm font-medium leading-6 text-gray-900">{{ notificationMethod.title }}</label>
                        </div>
                    </div>
                </fieldset>
            </div>
        </div>
        <div class="flex pb-5">
            <div class="basis-1/2">
                <label class="text-base font-semibold text-gray-900 sm:items-center">Are there any outstanding invoices that would prevent you from shipping this order?</label>
            </div>
            <div class="basis-1/2">
                <fieldset class="">
                    <legend class="sr-only">Notification method</legend>
                    <div class="sm:flex sm:items-center sm:space-x-10 sm:space-y-0">
                        <div v-for="notificationMethod in notificationMethods" :key="notificationMethod.id" class="flex items-center">
                            <input :id="notificationMethod.id" name="notification-method" type="radio" :checked="notificationMethod.id === 'email'" class="h-4 w-4 border-gray-300 text-indigo-600 focus:ring-indigo-600" />
                            <label :for="notificationMethod.id" class="ml-3 block text-sm font-medium leading-6 text-gray-900">{{ notificationMethod.title }}</label>
                        </div>
                    </div>
                </fieldset>
            </div>
        </div>
        <div class="flex pb-5">
            <div class="basis-1/2">
                <label class="text-base font-semibold text-gray-900 sm:items-center">Do you have any staffing/resourcing issues that would prevent you from shipping this order?</label>
            </div>
            <div class="basis-1/2">
                <fieldset class="">
                    <legend class="sr-only">Notification method</legend>
                    <div class="sm:flex sm:items-center sm:space-x-10 sm:space-y-0">
                        <div v-for="notificationMethod in notificationMethods" :key="notificationMethod.id" class="flex items-center">
                            <input :id="notificationMethod.id" name="notification-method" type="radio" :checked="notificationMethod.id === 'email'" class="h-4 w-4 border-gray-300 text-indigo-600 focus:ring-indigo-600" />
                            <label :for="notificationMethod.id" class="ml-3 block text-sm font-medium leading-6 text-gray-900">{{ notificationMethod.title }}</label>
                        </div>
                    </div>
                </fieldset>
            </div>
        </div>
        <div class="flex pb-5">
            <div class="basis-1/2">
                <label class="text-base font-semibold text-gray-900 sm:items-center">Is there anything that could potentially affect your ability to ship this order by the requested date?</label>
            </div>
            <div class="basis-1/2">
                <fieldset class="">
                    <legend class="sr-only">Notification method</legend>
                    <div class="sm:flex sm:items-center sm:space-x-10 sm:space-y-0">
                        <div v-for="notificationMethod in notificationMethods" :key="notificationMethod.id" class="flex items-center">
                            <input :id="notificationMethod.id" name="notification-method" type="radio" :checked="notificationMethod.id === 'email'" class="h-4 w-4 border-gray-300 text-indigo-600 focus:ring-indigo-600" />
                            <label :for="notificationMethod.id" class="ml-3 block text-sm font-medium leading-6 text-gray-900">{{ notificationMethod.title }}</label>
                        </div>
                    </div>
                </fieldset>
            </div>
        </div>
        -->
    </PortalLayout>
</template>

<style scoped>

</style>
