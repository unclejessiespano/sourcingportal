<script setup>
import {onMounted, reactive} from "vue";
import {router} from "@inertiajs/vue3";
import moment from 'moment-timezone';
const people = [
    { name: 'Lindsay Walton', title: 'Front-end Developer', email: 'lindsay.walton@example.com', role: 'Member' },
    // More people...
]
const shipments2 = [
    { date:'05/01/2022', qty_shipped:2, qty_remaining:15, carrier:'', tracking:''},
    { date:'07/05/2022', qty_shipped:5, qty_remaining:10, carrier:'FedEx', tracking:'40012345678'}
]
const props = defineProps(['shipments', 'tracking_info'])
let form = reactive({
    shipments:props.shipments
})
onMounted(() => {
    //get tracking information
    /*
    router.post('/getTracking', form, {
        preserveScroll:true,
        preserveState:true
    })
     */
})
</script>

<template>
    <div class="my-4 divide-y divide-gray-200 rounded-lg bg-white shadow">
        <div class="px-4 py-5 sm:px-6 bg-gray-100">
            <h3 class="text-1xl font-bold leading-tight tracking-tight text-gray-400">Shipments</h3>
        </div>
        <div class="px-4 py-5 sm:p-6">
            <table class="min-w-full divide-y divide-gray-300">
                <thead>
                <tr class="divide-x divide-gray-200">
                    <th scope="col" class="py-3.5 pl-4 pr-4 text-left text-sm font-semibold text-gray-900 sm:pl-0">Date</th>
                    <th scope="col" class="px-4 py-3.5 text-left text-sm font-semibold text-gray-900">Carrier</th>
                    <th scope="col" class="px-4 py-3.5 text-left text-sm font-semibold text-gray-900">Shipped</th>
                    <th scope="col" class="px-4 py-3.5 text-left text-sm font-semibold text-gray-900">Remaining</th>
                </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 bg-white">
                <tr v-for="shipment in shipments" :key="shipment.date_shipped" class="divide-x divide-gray-200">
                    <td class="whitespace-nowrap py-4 pl-4 pr-4 text-sm font-medium text-gray-900 sm:pl-0">{{ shipment.date_shipped }}</td>
                    <td class="whitespace-nowrap py-4 pl-4 pr-4 text-sm font-medium text-gray-900">
                        <span class="block font-medium">{{ shipment.carrier }}</span>
                        <a href="#">{{shipment.tracking_code}}</a>
                    </td>
                    <td class="whitespace-nowrap p-4 text-sm text-gray-500 text-center">{{ shipment.qty_shipped }}</td>
                    <td class="whitespace-nowrap p-4 text-sm text-gray-500 text-center">{{ shipment.qty_remaining }}</td>
                </tr>
                <tr>
                    <td class="py-4 pl-4 pr-4 text-sm font-medium text-gray-900 sm:pl-0" colspan="4">



                        <template v-for="(trackinginfo, index) in tracking_info">
                            <template v-for="(shipment, shipment_index) in trackinginfo.trackResponse.shipment">
                                <template v-for="(shipment_package, package_index) in shipment.package">
                                    <div>{{shipment_package.trackingNumber}}</div>
                                    <ul role="list" class="space-y-6">
                                        <li v-for="(activity, activityItemIdx) in shipment_package.activity" :key="activityItemIdx" class="relative flex gap-x-4">
                                            <div :class="[activityItemIdx === shipment_package.activity.length - 1 ? 'h-6' : '-bottom-6', 'absolute left-0 top-0 flex w-6 justify-center']">
                                                <div class="w-px bg-gray-200" />
                                            </div>

                                            <div class="relative flex h-6 w-6 flex-none items-center justify-center bg-white">
                                                <div class="h-1.5 w-1.5 rounded-full bg-gray-100 ring-1 ring-gray-300" />
                                            </div>
                                            <p class="flex-auto py-0.5 text-xs leading-5 text-gray-500">
                                                <span v-if="activity.location.address" class="font-medium text-gray-900">{{activity.location.address.city}}, {{activity.location.address.country}}</span> {{activity.status.description}}
                                            </p>
                                            <time :datetime="activity.gmtDate+' '+activity.gmtTime" class="flex-none py-0.5 text-xs leading-5 text-gray-500">{{activity.gmtDate}} {{activity.gmtTime}}</time>

                                        </li>
                                    </ul>

                                </template>
                            </template>
                        </template>
                    </td>
                </tr>

                </tbody>
            </table>
        </div>
    </div>

</template>

<style scoped>

</style>
