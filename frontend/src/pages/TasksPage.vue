<script setup>
import { computed, onMounted, ref } from "vue";
import {
  allTask,
  completeTask,
  createTask,
  deleteTask,
  updateTask,
} from "../http/task-api";
import Tasks from "../components/tasks/Tasks.vue";
import NewTasks from "../components/tasks/NewTasks.vue";

const tasks = ref([]);

onMounted(async () => {
  const { data } = await allTask();
  tasks.value = data.data;
});

const uncompletedTasks = computed(() =>
  tasks.value.filter((task) => !task.is_completed)
);

const completedTasks = computed(() =>
  tasks.value.filter((task) => task.is_completed)
);

const showToggleCompleteTaskBtn = computed(
  () => uncompletedTasks.value.length > 0 && completedTasks.value.length > 0
);

const showCompletedTaskisVisible = computed(
  () => uncompletedTasks.value.length === 0 || completedTasks.value.length > 0
);
const showCompletedTask = ref(false);

const handledAddedTask = async (newTask) => {
  const { data: createdTask } = await createTask(newTask);
  tasks.value.unshift(createdTask.data);
};

const handleUpdatedTask = async (task) => {
  const { data: updatedTask } = await updateTask(task.id, {
    name: task.name,
  });
  const currentTask = tasks.value.find((item) => item.id === task.id);
  currentTask.name = updatedTask.data.name;
};

const handleCompleted = async (task) => {
  const { data: updatedTask } = await completeTask(task.id, {
    is_completed: task.is_completed,
  });
  const currentTask = tasks.value.find((item) => item.id === task.id);
  currentTask.is_completed = updatedTask.data.is_completed;
};
const handleRemoved = async (task) => {
  await deleteTask(task.id);
  const index = tasks.value.findIndex((item) => item.id === task.id);
  tasks.value.splice(index, 1);
};
</script>
<template>
  <div class="py-8">
    <div class="max-w-lg mx-auto">
      <div class="flex items-center space-x-2">
        <NewTasks @added="handledAddedTask" />
      </div>
      <div class="pt-3">
        <Tasks
          :tasks="uncompletedTasks"
          @updated="handleUpdatedTask"
          @completed="handleCompleted"
          @removed="handleRemoved"
        />
        <div
          class="flex items-center justify-center space-x-4 pt-6 pb-3"
          v-show="showToggleCompleteTaskBtn"
        >
          <button
            class="py-1 px-4 rounded border border-gray-300 font-bold"
            @click="showCompletedTask = !showCompletedTask"
          >
            <span v-if="!showCompletedTask">Show</span>
            <span v-else>Hide</span>
          </button>
        </div>
        <Tasks
          :tasks="completedTasks"
          :show="showCompletedTaskisVisible && showCompletedTask"
          @updated="handleUpdatedTask"
          @completed="handleCompleted"
          @removed="handleRemoved"
        />
      </div>
    </div>
  </div>
</template>
