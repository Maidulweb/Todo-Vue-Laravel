<script setup>
import Task from "./Task.vue";
defineProps({
  tasks: Array,
  show: {
    type: Boolean,
    default: true,
  },
});
</script>
<template>
  <ul v-if="tasks.length && show">
    <Task
      v-for="task in tasks"
      :key="task.id"
      :task="task"
      @updated="$emit('updated', $event)"
      @completed="$emit('completed', $event)"
      @removed="$emit('removed', $event)"
    />
  </ul>
</template>
