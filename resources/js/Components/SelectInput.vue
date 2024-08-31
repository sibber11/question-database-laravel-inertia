<script setup>
import {ref} from 'vue';

const model = defineModel({
  required: true,
});

const input = ref(null);

defineProps({
  options: [Array, Object],
  placeholder: {
    type: String,
    default: 'Select option'
  }
})

</script>

<template>
  <select
    ref="input"
    v-model="model"
    class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-60"
  >
    <template v-if="options">
      <option value="">{{placeholder}}</option>
      <option v-for="model in options" :value="model.id">
        {{ model.label }}
      </option>
    </template>
    <slot v-else></slot>
  </select>
</template>
