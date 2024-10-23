<script setup>
    import SuppliersGridCondensed from "@/Pages/Suppliers/Partials/SuppliersGridCondensed.vue";
    import moment from 'moment';
    const props = defineProps(['order'])
</script>

<template>

    <div class="-mx-4 px-4 py-8 shadow-sm ring-1 ring-gray-900/5 sm:mx-0 sm:rounded-lg sm:px-8 sm:pb-14 lg:col-span-2 lg:row-span-2 lg:row-end-2 xl:px-16 xl:pb-20 xl:pt-16">
        <h2 class="text-base font-semibold leading-6 text-gray-900">{{order.PO}}</h2>
        <dl class="mt-6 grid grid-cols-1 text-sm leading-6 sm:grid-cols-2">
            <div class="sm:pr-4">
                <dt class="inline text-gray-500">Issued on</dt>
                {{ ' ' }}
                <dd class="inline text-gray-700"><time order.document_date :datetime="order.document_date">{{moment(order.document_date).format('LL')}}</time></dd>
            </div>
            <div class="mt-2 sm:mt-0 sm:pl-4">&nbsp;</div>
            <div class="mt-6 border-t border-gray-900/5 pt-6 sm:pr-4">
                <dt class="font-semibold text-gray-900">From</dt>
                <dd class="mt-2 text-gray-500"><span class="font-medium text-gray-900"><a :href="'/supplier/'+order.supplier.slug">{{order.supplier.name}}</a></span><template v-if="order.supplier.shippinglocation"><br />7363 Cynthia Pass<br />Toronto, ON N3Y 4H8</template></dd>
            </div>
            <div class="mt-8 sm:mt-6 sm:border-t sm:border-gray-900/5 sm:pl-4 sm:pt-6">
                <dt class="font-semibold text-gray-900">To</dt>
                <dd class="mt-2 text-gray-500">
                    <template v-if="order.plant">
                        <span class="font-medium text-gray-900">{{order.plant.plant}}</span><br />{{order.plant.address}}<br />{{order.plant.city}}, {{order.plant.state}} {{order.plant.zip}}
                    </template>
                </dd>
            </div>
        </dl>

        <SuppliersGridCondensed return_to_route="line.show" po="true" :showViewButton="false" :lines="order.lines" :lineActivities="lineActivities"></SuppliersGridCondensed>



    </div>
</template>

<style scoped>

</style>
