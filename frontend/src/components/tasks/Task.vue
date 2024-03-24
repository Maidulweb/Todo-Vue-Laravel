<script setup>
import TaskAction from "./TaskAction.vue";
import { computed, ref } from "vue";

const props = defineProps({
  task: Object,
});

const isEdit = ref(false);

const editingTask = ref(props.task.name);

const emit = defineEmits(["updated", "completed", "removed"]);

const completedClass = computed(() =>
  props.task.is_completed ? "completed" : ""
);

const vFocus = {
  mounted: (e) => e.focus(),
};

const updateTask = (e) => {
  const updatedTask = { ...props.task, name: e.target.value };
  isEdit.value = false;
  emit("updated", updatedTask);
};

const undo = () => {
  isEdit.value = false;
  editingTask.value = props.task.name;
};

const markTaskAsCompleted = () => {
  const updatedTask = { ...props.task, is_completed: !props.task.is_completed };
  emit("completed", updatedTask);
};

const removeTask = () => {
  if (confirm("Are you sure!!!")) {
    emit("removed", props.task);
  }
};
</script>
<template>
  <li class="pt-3">
    <div
      class="task flex justify-between items-center border border-gray-400 rounded relative p-4"
    >
      <div class="flex space-x-2 w-full" @dblclick="isEdit = true">
        <input
          type="checkbox"
          :class="completedClass"
          :checked="task.is_completed"
          @change="markTaskAsCompleted"
        />

        <input
          v-if="isEdit"
          class="w-full border border-gray-300"
          type="text"
          v-model="editingTask"
          @keyup.esc="undo"
          v-focus
          @keyup.enter="updateTask"
        />
        <p v-else :class="completedClass">{{ task.name }}</p>
      </div>
      <!-- <p>{{ item.created_at }}</p> -->
      <TaskAction @edit="isEdit = true" @remove="removeTask" v-show="!isEdit" />
    </div>
  </li>
</template>

<style>
.completed {
  color: green;
  font-weight: 900;
}
</style>
