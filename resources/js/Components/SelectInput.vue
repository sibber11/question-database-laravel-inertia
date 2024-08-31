<script setup>

const model = defineModel({
  required: true,
});

const props = defineProps({
  options: [Array, Object],
  placeholder: {
    type: String,
    default: 'Select option'
  }
})

</script>

<template>
  <select
    v-model="model"
    class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm w-60"
  >
    <template v-if="options">
      <option value="">{{placeholder}}</option>
      <option v-for="item in options" :value="item.id">
        {{ item.label }}
      </option>
    </template>
    <slot v-else></slot>
  </select>
</template>
