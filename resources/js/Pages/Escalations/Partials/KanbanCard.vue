<script setup>
const props = defineProps(['data'])
function markDone(){
    this.$emit('done', this.data);
}
</script>

<template>
    <div class="cc-card">
        <h3>{{data.title}}</h3>
        <p>
            {{data.description}}
        </p>
        <button v-if="!data.done" class="cc-btn" @click="markDone()">
            Mark Done
        </button>
    </div>
</template>

<style scoped>

</style>
