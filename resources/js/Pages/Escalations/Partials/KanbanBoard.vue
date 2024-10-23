<script>
import dragula from 'dragula'
export default{
        props:{
            stages: ['on-hold', 'in-progress', 'needs-review', 'approved'],
            blocks: [
                {
                    id: 1,
                    status: 'on-hold',
                    title: 'Test',
                },
            ],
        }
}
</script>

<template>
    <kanban-board :stages="stages" :blocks="blocks"></kanban-board>
</template>

<style scoped>

</style>
