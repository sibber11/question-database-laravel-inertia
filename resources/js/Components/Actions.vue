<script setup>

import {Link} from "@inertiajs/vue3";
import {currentRoute} from "@/Hooks/helpers.js";

defineProps({
  data: Object,
  view: Boolean,
})
</script>

<template>
  <div class="flex gap-4">
    <Link v-if="view" :href="route(currentRoute('show'), data.value.id)"
          class="btn btn-secondary">
      v
    </Link>
    <Link :href="route(currentRoute('edit'), data.value.id)"
          class="btn btn-primary">
      e
    </Link>
    <Link :href="route(currentRoute('destroy'), data.value.id)" as="button"
          class="btn btn-danger"
          method="delete">
      d
    </Link>
  </div>
</template>

<style scoped>

</style>
