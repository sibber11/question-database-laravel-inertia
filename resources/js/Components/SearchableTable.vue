<script setup>

import SearchInput from "@/Components/SearchInput.vue";
import Actions from "@/Components/Actions.vue";
import Pagination from "@/Components/Pagination.vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import {usePage} from "@inertiajs/vue3";
import {computed} from "vue";
import LiteTable from "@/Components/LiteTable.vue";

const props = defineProps({
  columns: Array,
  view: Boolean,
})
const models = computed(() => usePage().props.models);
</script>

<template>
  <AuthenticatedLayout create>
    <template #buttons>
      <slot v-if="$slots.buttons" name="buttons"/>
    </template>
    <div class="my-4">
      <Pagination :meta="models.meta"/>
    </div>
    <div class="flex flex-wrap justify-between items-center mb-4">
      <SearchInput/>
      <slot></slot>
    </div>
    <LiteTable :columns="columns" :rows="models.data"
    >
      <template #actions="data">
        <Actions :data="data" :view="view"/>
      </template>
      <template v-for="(_,slot) in $slots" v-slot:[slot]="{value}">
        <slot v-if="slot != 'default'" :name="slot" :value="value"/>
      </template>
    </LiteTable>
    <Pagination :meta="models.meta"/>
  </AuthenticatedLayout>
</template>
