<script setup>

import performSort, {sortable} from "@/Hooks/useSort.js";
import Vue3TableLite from "vue3-table-lite";
import SearchInput from "@/Components/SearchInput.vue";
import Actions from "@/Components/Actions.vue";
import Pagination from "@/Components/Pagination.vue";
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import {usePage} from "@inertiajs/vue3";

const props = defineProps({
    columns: Array,
})
const models = usePage().props.models;
</script>

<template>
    <AuthenticatedLayout>
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
    </AuthenticatedLayout>
</template>
