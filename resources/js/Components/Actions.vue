<script setup>

import {Link} from "@inertiajs/vue3";
import {currentRoute} from "@/Hooks/helpers.js";
defineProps({
    data: Object
})
</script>

<template>
    <div class="flex gap-4">
        <Link :href="route(currentRoute('edit'), data.value.id)"
              class="btn btn-primary">
            Edit
        </Link>
        <Link :href="route(currentRoute('destroy'), data.value.id)" as="button"
              class="btn btn-danger"
              method="delete">
            Delete
        </Link>
    </div>
</template>

<style scoped>

</style>
