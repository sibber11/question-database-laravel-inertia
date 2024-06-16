<script setup>

import performSort, {sortable} from "@/Hooks/useSort.js";
import Vue3TableLite from "vue3-table-lite";
import SearchInput from "@/Components/SearchInput.vue";
import Actions from "@/Components/Actions.vue";
import Pagination from "@/Components/Pagination.vue";

const props = defineProps({
    models: Object,
    columns: Array,
})
</script>

<template>
    <SearchInput/>
    <Vue3TableLite
        :columns="columns"
        :rows="models.data"
        :sortable="sortable()"
        has-checkbox
        is-hide-paging is-slot-mode
        @do-search="performSort">
        <template v-slot:actions="data">
            <Actions :data="data"/>
        </template>
    </Vue3TableLite>
    <Pagination :meta="models.meta"/>
</template>
