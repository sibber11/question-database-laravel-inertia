<script setup>
import {Link} from "@inertiajs/vue3";

const props = defineProps({
    meta: Object
})

</script>

<template>
    <div class="flex gap-4">
        <div v-for="link in meta.links">
            <Link v-if="link.url" :href="link.url" class="btn btn-primary" v-html="link.label"/>
            <span v-else class="btn btn-primary cursor-not-allowed" v-html="link.label"/>
        </div>
    </div>
</template>

<style scoped>

</style>
