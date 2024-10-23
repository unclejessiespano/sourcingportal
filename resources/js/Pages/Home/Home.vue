<script setup>
import HomeLayout from "@/Layouts/HomeLayout.vue"
import PortalLayout from "@/Layouts/PortalLayout.vue"
import Hero from "@/Pages/Home/Partials/Hero.vue"
import Feature from "@/Pages/Home/Partials/Feature.vue"
import Feature3Buckets from "@/Pages/Home/Partials/Feature3Buckets.vue";
import Feature6Buckets from "@/Pages/Home/Partials/Feature6Buckets.vue"
import Footer from "@/Pages/Home/Partials/Footer.vue";
</script>

<template>
    <HomeLayout>
        <Hero />

        <Feature6Buckets />
        <Feature />
        <Footer />
    </HomeLayout>

</template>

<style scoped>

</style>
