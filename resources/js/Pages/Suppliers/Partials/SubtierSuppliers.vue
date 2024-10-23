<script setup>
import { ref } from "vue";
import OrganizationChart from "primevue/organizationchart";
import { Dialog, DialogPanel, DialogTitle, TransitionChild, TransitionRoot } from '@headlessui/vue'


import { CheckIcon } from '@heroicons/vue/24/outline'
import AddSupplierForm from '@/Pages/Suppliers/Partials/AddSupplierForm.vue'
const open = ref(false)
const props = defineProps(['supplier', 'network'])
const data = ref({
    label: props.supplier.name,
    id:props.supplier.id,
    children: props.network
});

</script>

<template>
    <TransitionRoot as="template" :show="open">
        <Dialog as="div" class="relative z-10" @close="open = false">
            <TransitionChild as="template" enter="ease-out duration-300" enter-from="opacity-0" enter-to="opacity-100" leave="ease-in duration-200" leave-from="opacity-100" leave-to="opacity-0">
                <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity" />
            </TransitionChild>

            <div class="fixed inset-0 z-10 w-screen overflow-y-auto">
                <div class="flex min-h-full items-end justify-center p-4 text-center sm:items-center sm:p-0">
                    <TransitionChild as="template" enter="ease-out duration-300" enter-from="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" enter-to="opacity-100 translate-y-0 sm:scale-100" leave="ease-in duration-200" leave-from="opacity-100 translate-y-0 sm:scale-100" leave-to="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
                        <DialogPanel class="relative transform overflow-hidden rounded-lg bg-white px-4 pb-4 pt-5 text-left shadow-xl transition-all sm:my-8 sm:w-full sm:max-w-sm sm:p-6">
                            <div>
                                <AddSupplierForm :supplier="supplier"></AddSupplierForm>
                            </div>
                        </DialogPanel>
                    </TransitionChild>
                </div>
            </div>
        </Dialog>
    </TransitionRoot>

    <OrganizationChart :value="data">
        <template #default="slotProps">
            <button @click="open = true" v-if="slotProps.node.type=='button'" type="button" class="rounded bg-indigo-600 px-2 py-1 text-xs font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Add Supplier</button>
            <span v-else><a :href="'/supplier/'+slotProps.node.slug">{{ slotProps.node.label }}</a></span>
        </template>
    </OrganizationChart>
</template>

<style scoped>
</style>
