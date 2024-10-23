<script setup>
import { defineProps, defineEmits } from 'vue';
import KanbanCard from "@/Components/Kanban/KanbanCard.vue"
const props = defineProps({
    status: String,
    cards: Array,
    key:String,
    taskcomments:Object
});
const emit = defineEmits(['moveCard']);
const drop = event => {
    const cardId = event.dataTransfer.getData('text/plain');
    emit('moveCard', parseInt(cardId, 10), props.status);
};
</script>

<template>
    <div
        class="kanban-column bg-white shadow rounded p-4 flex-1 mx-2"
        @dragover.prevent
        @drop="drop($event)"
    >
        <h2 class="font-bold mb-2">{{ status }}</h2>
        <KanbanCard
            v-for="card in cards"
            :key="card.id"
            :card="card"
            :taskcomments="taskcomments[card.id]"
        ></KanbanCard>
    </div>
</template>

<style scoped>

</style>
