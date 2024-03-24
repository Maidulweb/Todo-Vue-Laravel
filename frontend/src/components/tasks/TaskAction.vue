<script setup>
import IconEdit from "../icons/IconEdit.vue";
import IconDelete from "../icons/IconDelete.vue";

const emit = defineEmits(["edit", "remove"]);
</script>
<template>
  <div
    class="absolute right-4 items-center edit-delete bg-gray-200 border-gray-300 border py-2 px-4 rounded"
  >
    <div class="flex space-x-2">
      <button class="text-green-400 font-medium" @click="emit('edit')">
        <IconEdit />
      </button>
      <button class="text-red-400 font-medium" @click="emit('remove')">
        <IconDelete />
      </button>
    </div>
  </div>
</template>
<style>
.task:hover .edit-delete {
  display: block;
}
.edit-delete {
  display: none;
}
</style>
