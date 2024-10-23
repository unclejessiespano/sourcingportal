<script setup>
    import {ref, onMounted} from 'vue'
    const props = defineProps(['score'])
    const badgecontainer = ref()
    let badge_class = null
    onMounted(() => {
        if(props.score){
            if(props.score >=80){
                badge_class = "bg-green-500"
            }
            else if(props.score <76 && props.score >=60) {
                badge_class = "bg-amber-500"
            }
            else{
                badge_class = "bg-red-500"
            }

            badge_class = badge_class+" inline-flex h-10 w-10 items-center justify-center rounded-full"
            badgecontainer.value.className = badge_class
        }

    })
</script>

<template>
    <span v-if="score" ref="badgecontainer" :class="badge_class">
        <span class="text-md font-medium leading-none text-white">
            {{score}}
        </span>
    </span>
</template>

<style scoped>

</style>
