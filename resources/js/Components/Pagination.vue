<script setup>
import {Link} from "@inertiajs/vue3";

const props = defineProps({
  meta: Object
})

</script>

<template>
  <div class="flex gap-4">
    <div v-for="link in meta.links">
      <Link v-if="link.url" :href="link.url" class="btn btn-primary" :class="{active: link.active}" preserve-scroll v-html="link.label"/>
      <span v-else class="btn cursor-not-allowed text-black border rounded bg-slate-300" v-html="link.label"/>
    </div>
  </div>
</template>

<style scoped>
.active{
  @apply text-black bg-white border-black;
}
</style>
