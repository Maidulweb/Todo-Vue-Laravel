<script setup>
import { reactive } from "vue";

const newTask = reactive({
  name: "",
  is_completed: false,
});

const emit = defineEmits(["added"]);

const addNewTask = (e) => {
  if (e.target.value.trim()) {
    newTask.name = e.target.value;
    e.target.value = "";
    emit("added", newTask);
  }
};
</script>
<template>
  <input
    class="w-full py-4 px-2 border border-gray-400 rounded"
    type="text"
    placeholder="+ Add a task"
    @keydown.enter="addNewTask"
  />
</template>
