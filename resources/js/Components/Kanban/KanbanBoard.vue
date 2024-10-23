<script setup>
import { reactive, ref } from 'vue';
import {router} from "@inertiajs/vue3";
import KanbanColumn from "@/Components/Kanban/KanbanColumn.vue"
import AddTaskButton from "@/Components/Kanban/AddTaskButton.vue"
import TaskModal from "@/Components/Kanban/TaskModal.vue"
const props = defineProps(['tasks', 'columns', 'taskcomments'])
const cards = ref([
    { id: 1, title: 'Task 1', status: 'To Do' },
    // Add more cards with various statuses
]);
const columnStatuses = ['To Do', 'Doing', 'Blocked', 'Done'];
const moveCard = (cardId, newStatus) => {
console.log(cardId);
    const card = cards.value.find(card => card.id === cardId);
    let form = reactive({
        card_id: cardId,
        status: newStatus
    })
    router.post('/updateTaskStatus', form, {
        preserveScroll:true,
        preserveState:true
    })
    if (card) {

    }

};

const showModal = ref(false)
const addNewTask = (taskName) => {
    const newTask = {
        id: Date.now(),
        title: taskName,
        status: 'New',
    };
    cards.value.push(newTask);
    showModal.value = false;
};
</script>

<template>

    <TaskModal :show="showModal" @update:show="showModal = $event" @add-task="addNewTask" />
    <div class="flex justify-end py-10">
        <AddTaskButton @openModal="showModal = true" />
    </div>
    <div class="flex justify-around p-5 bg-gray-100 min-h-screen">
        <KanbanColumn
            v-for="status in columns"
            :key="status.id"
            :status="status.column"
            :cards="tasks.filter(task => task.taskcolumn_id === status.id)"
            :taskcomments="taskcomments"
            @moveCard="moveCard"
        ></KanbanColumn>
    </div>
</template>

<style scoped>

</style>
