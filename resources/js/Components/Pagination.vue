<script setup>
import {Link} from "@inertiajs/vue3";

const props = defineProps({
    meta: Object
})

</script>

<template>
    <div class="flex gap-4 py-4">
        <div v-for="link in meta.links">
            <Link :href="link.url" v-html="link.label" class="btn btn-primary"/>
        </div>
    </div>
</template>

<style scoped>

</style>
