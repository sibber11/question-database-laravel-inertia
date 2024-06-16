<script setup>

import useSearch from "@/Hooks/useSearch.js";

const searchValue = useSearch();

defineOptions({
    inheritAttrs:false
})
</script>

<template>
    <div class="py-4">
        <input
            v-bind="$attrs"
            placeholder="search"
            ref="input"
            v-model="searchValue"
            class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded shadow-sm"
        />
    </div>
</template>

<style scoped>

</style>
