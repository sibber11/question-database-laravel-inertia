<script setup>
import {useFilter} from "@/Hooks/useFilter";
import {ref, watch} from "vue";
import Checkbox from "@/Components/Checkbox.vue";


const props = defineProps({
  field: String,
})

const {performFilter} = useFilter(props.field);

const model = ref(false);

watch(model, (value) => {
  if (value) {
    performFilter({value: true})
  } else {
    performFilter({value: null})
  }
})
</script>

<template>
  <label class="flex items-center gap-2">
    <span>Has Due: </span>
    <Checkbox v-model="model"/>
  </label>
</template>
