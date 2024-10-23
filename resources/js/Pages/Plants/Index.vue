<script setup>
    import SuppliersGrid from "@/Pages/Suppliers/Partials/SuppliersGrid.vue";
    import PortalLayout from "@/Layouts/PortalLayout.vue";
    import { GoogleMap, Marker } from "vue3-google-map";
    import AddPlant from "@/Pages/Plants/Partials/AddPlant.vue";
    const props = defineProps(['plants'])

</script>

<template>
    <PortalLayout title="Plants">

        <div class="mx-auto flex w-full max-w-7xl items-start gap-x-8 px-4 py-10 sm:px-6 lg:px-8">
            <aside class="sticky top-8 hidden w-60 shrink-0 lg:block">
                <div class="grid grid-cols-1 gap-2 sm:grid-cols-1">
                    <div v-for="(plant, index) in plants" :key="plant.id" class="relative flex items-center space-x-3 rounded-lg border border-gray-300 bg-white px-4 py-4 shadow-sm focus-within:ring-2 focus-within:ring-indigo-500 focus-within:ring-offset-2 hover:border-gray-400">
                        <div class="min-w-0 flex-1">
                            <a href="#" class="focus:outline-none">
                                <span class="absolute inset-0" aria-hidden="true" />
                                <p class="text-sm font-medium text-gray-900">{{index}} {{ plant.plant }}</p>
                                <p class="truncate text-xs text-gray-500">{{ plant.address }}<br />{{plant.city}}, {{plant.state}} {{plant.zip}}<br />{{plant.country}}</p>
                            </a>
                        </div>
                    </div>
                </div>
                <AddPlant />
            </aside>

            <main class="flex-1 bg-gray-300">
                <GoogleMap v-if="plants[0]" api-key="" style="width: 100%; height: 500px" :center="plants[0].marker.position" :zoom="12">
                    <Marker v-for="(plant, index) in plants" :options="plant.marker" />
                    <!--
                    <Marker :options="center" />
                    -->
                </GoogleMap>
                <div v-else>Doesn't look like there are any plants.</div>
            </main>
        </div>
    </PortalLayout>
</template>

<style scoped>

</style>
