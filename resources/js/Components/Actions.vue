<script setup>

import {Link} from "@inertiajs/vue3";
import {currentRoute} from "@/Hooks/helpers.js";

defineProps({
  data: Object,
  view: Boolean,
})
</script>

<template>
  <div class="flex flex-wrap gap-1 md:gap-2 justify-end">
    <Link v-if="view" :href="route(currentRoute('show'), data.value.id)"
          class="text-blue-600 p-0.5 rounded border border-blue-600">
      <svg height="20" viewBox="0 0 256 256" width="20" xmlns="http://www.w3.org/2000/svg">
        <path d="M247.31 124.76c-.35-.79-8.82-19.58-27.65-38.41C194.57 61.26 162.88 48 128 48S61.43 61.26 36.34 86.35C17.51 105.18 9 124 8.69 124.76a8 8 0 0 0 0 6.5c.35.79 8.82 19.57 27.65 38.4C61.43 194.74 93.12 208 128 208s66.57-13.26 91.66-38.34c18.83-18.83 27.3-37.61 27.65-38.4a8 8 0 0 0 0-6.5M128 192c-30.78 0-57.67-11.19-79.93-33.25A133.5 133.5 0 0 1 25 128a133.3 133.3 0 0 1 23.07-30.75C70.33 75.19 97.22 64 128 64s57.67 11.19 79.93 33.25A133.5 133.5 0 0 1 231.05 128c-7.21 13.46-38.62 64-103.05 64m0-112a48 48 0 1 0 48 48a48.05 48.05 0 0 0-48-48m0 80a32 32 0 1 1 32-32a32 32 0 0 1-32 32"
              fill="currentColor"/>
      </svg>
    </Link>
    <Link :href="route(currentRoute('edit'), data.value.id)"
          class="text-gray-900 p-0.5 rounded border border-gray-900">
      <svg height="20" viewBox="0 0 24 24" width="20" xmlns="http://www.w3.org/2000/svg">
        <path d="m16.862 4.487l1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
              stroke-width="1.5"/>
      </svg>
    </Link>
    <Link :href="route(currentRoute('destroy'), data.value.id)" as="button"
          class="text-red-600 p-0.5 rounded border border-red-600"
          method="delete">
      <svg height="20" viewBox="0 0 256 256" width="20" xmlns="http://www.w3.org/2000/svg">
        <path d="M216 48h-40v-8a24 24 0 0 0-24-24h-48a24 24 0 0 0-24 24v8H40a8 8 0 0 0 0 16h8v144a16 16 0 0 0 16 16h128a16 16 0 0 0 16-16V64h8a8 8 0 0 0 0-16M96 40a8 8 0 0 1 8-8h48a8 8 0 0 1 8 8v8H96Zm96 168H64V64h128Zm-80-104v64a8 8 0 0 1-16 0v-64a8 8 0 0 1 16 0m48 0v64a8 8 0 0 1-16 0v-64a8 8 0 0 1 16 0"
              fill="currentColor"/>
      </svg>
    </Link>
  </div>
</template>

<style scoped>

</style>
